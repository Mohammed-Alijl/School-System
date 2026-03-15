<?php

namespace App\Services;

use App\Models\Currency;
use App\Models\Receipt;
use App\Models\Student;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ReceiptService
{
    /**
     * Get the base query for fetching receipts with necessary relationships and filters.
     */
    public function getReceiptsQuery(array $filters): Builder
    {
        $query = Receipt::with(['student', 'academicYear', 'currency', 'paymentGateway']);

        return $this->applyFilters($query, $filters);
    }

    /**
     * Generate the DataTable response for the given query, including custom columns and formatting.
     */
    public function datatable(Builder $query)
    {
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('student', fn($row) => '<strong>' . e($row->student->name) . '</strong>')
            ->addColumn('payment_method', fn($row) => '<span class="badge badge-info">' . e($row->paymentGateway->name) . '</span>')
            ->addColumn(
                'amount',
                fn($row) =>
                '<span class="text-success fw-bold">' . number_format($row->paid_amount, 2) . ' ' . $row->currency_code . '</span><br>' .
                    '<small class="text-muted">' . __('admin.finance.receipt.fields.base_amount') . ': $' . number_format($row->base_amount, 2) . '</small>'
            )
            ->addColumn('date', fn($row) => '<small class="text-muted">' . $row->date->format('Y-m-d') . '</small>')
            ->addColumn('actions', fn($row) => $this->renderActionsColumn($row))
            ->rawColumns(['student', 'payment_method', 'amount', 'date', 'actions'])
            ->make(true);
    }

    /**
     * create receipts and corresponding student account entries in a single transaction.
     */
    public function createReceipt(array $data): Receipt
    {
        return DB::transaction(function () use ($data) {
            $student = Student::findOrFail($data['student_id']);
            $currency = Currency::where('code', $data['currency_code'])->firstOrFail();

            $baseAmount = $this->calculateBaseAmount($data['paid_amount'], $currency->exchange_rate);

            $receipt = Receipt::create(
                $this->buildReceiptPayload($student, $data, $currency->exchange_rate, $baseAmount)
            );

            $receipt->studentAccount()->create(
                $this->buildStudentAccountPayload($student, $baseAmount, $data)
            );

            return $receipt;
        });
    }

    /**
     * delete the receipt and its associated student account entry in a single transaction.
     */
    public function deleteReceipt(Receipt $receipt): bool
    {
        return DB::transaction(function () use ($receipt) {
            $this->deleteStudentAccount($receipt);

            return $receipt->delete();
        });
    }

    /**
     * Get The Required Data
     */
    public function getLookups(): array
    {
        return [
            'academic_years'   => \App\Models\AcademicYear::select('id', 'name')->get(),
            'payment_gateways' => \App\Models\PaymentGateway::where('status', true)->select('id', 'name')->get(),
            'currencies'       => \App\Models\Currency::select('code', 'name', 'is_default')->get(),
        ];
    }

    /**
     * convert the paid amount to the base currency using the exchange rate at the time of payment.
     */
    private function calculateBaseAmount(float $paidAmount, float $exchangeRate): float
    {
        return round($paidAmount / $exchangeRate, 2);
    }

    /**
     * construct the payload for creating a receipt, including all necessary fields and relationships.
     */
    private function buildReceiptPayload(Student $student, array $data, float $exchangeRate, float $baseAmount): array
    {
        return [
            'student_id'         => $student->id,
            'academic_year_id'   => $data['academic_year_id'],
            'payment_gateway_id' => $data['payment_gateway_id'],
            'paid_amount'        => $data['paid_amount'],
            'currency_code'      => $data['currency_code'],
            'exchange_rate'      => $exchangeRate,
            'base_amount'        => $baseAmount,
            'transaction_id'     => $data['transaction_id'] ?? null,
            'date'               => $data['date'] ?? now()->toDateString(),
            'description'        => $data['description'] ?? 'Receipt for student ' . $student->name,
        ];
    }

    /**
     * construct the payload for creating a student account entry, including all necessary fields.
     */
    private function buildStudentAccountPayload(Student $student, float $baseAmount, array $data): array
    {
        return [
            'student_id'  => $student->id,
            'debit'       => 0.00,
            'credit'      => $baseAmount,
            'date'        => $data['date'] ?? now()->toDateString(),
            'description' => 'Receipt for student ' . $student->name . ' - Transaction ID: ' . ($data['transaction_id'] ?? 'Cash Payment'),
        ];
    }

    /**
     * delete the associated student account entry.
     */
    private function deleteStudentAccount(Receipt $receipt): void
    {
        if ($receipt->studentAccount) {
            $receipt->studentAccount()->delete();
        }
    }

    /**
     * apply filters to the query
     */
    private function applyFilters(Builder $query, array $filters): Builder
    {
        $query->when(!empty($filters['student_id']), fn($q) => $q->where('student_id', $filters['student_id']));
        $query->when(!empty($filters['payment_gateway_id']), fn($q) => $q->where('payment_gateway_id', $filters['payment_gateway_id']));

        return $query->latest();
    }

    /**
     * render the actions column for the receipt table
     */
    private function renderActionsColumn(Receipt $receipt): string
    {
        return view('admin.finance.receipts.partials.actions', ['receipt' => $receipt])->render();
    }
}

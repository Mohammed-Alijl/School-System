<?php

namespace App\Services;

use App\Models\Guardian;
use App\Models\Nationality;
use App\Models\TypeBlood;
use App\Models\Religion;
use Illuminate\Support\Arr;

class GuardianService
{
    /**
     * Get all guardians with relationships if needed
     */
    public function getAll()
    {
        return Guardian::latest()->get();
    }

    /**
     * Helper to get all lookups needed for the forms
     */
    public function getLookups()
    {
        return [
            'nationalities' => Nationality::all(),
            'blood_types'   => TypeBlood::all(),
            'religions'     => Religion::all(),
        ];
    }

    public function store(array $data)
    {
        return Guardian::create($data);
    }

    public function update($guardian, array $data)
    {
        if (empty($data['password'])) {
            $data = Arr::except($data, ['password']);
        }

        $guardian->update($data);
        return $guardian;
    }

    public function delete($guardian)
    {
        if($guardian->delete())
            return true;
        else
            throw new \Exception(__('admin.guardians.messages.failed.delete'));
    }

    public function archive()
    {
        return Guardian::onlyTrashed()->latest()->get();
    }

    public function restore($id)
    {
        $guardian = Guardian::withTrashed()->find($id);

        if (!$guardian) {
            throw new \Exception(__('admin.guardians.messages.failed.restore'));
        }

        $guardian->restore();
        return true;
    }

    public function forceDelete($id)
    {
        $guardian = Guardian::withTrashed()->find($id);

        if (!$guardian) {
            throw new \Exception(__('admin.guardians.messages.failed.delete'));
        }

        if ($guardian->forceDelete())
            return true;
        else
            throw new \Exception(__('admin.guardians.messages.failed.delete'));
    }
}

<?php

namespace App\Services;

use App\Models\Grade;

class GradeService
{
    /**
     * get all grades
     */
    public function getAll()
    {
        return Grade::all()->sortBy('sort_order');
    }

    /**
     * get all grades with classrooms
     */
    public function getAllWithClassrooms ()
    {
        return Grade::with('classrooms')->get()->sortBy('sort_order');
    }


    /**
     * get all active grades
     */
    public function getActive()
    {
        return Grade::active()->get();
    }

    public function store(array $data)
    {
        $grade = Grade::create($data);

        return $grade;
    }

    public function update($grade, array $data)
    {
        $grade->update($data);
        return $grade;
    }

    public function delete($grade)
    {
        if ($grade->classrooms->count())
            throw new \Exception(__('admin.grades.messages.failed.delete'));

        $grade->delete();
        return true;
    }
}

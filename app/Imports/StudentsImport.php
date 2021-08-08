<?php

namespace App\Imports;

use App\Group;
use App\Role;
use App\Student;
use App\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $group = Group::latest()->first();
        $student = new Student();
        $student->student_number = $row['student_number'];
        $student->group_id = $group->id;
        $student->save();
        $student->user()->create([
            'name' => $row['name'],
            'email' => $row['email']
        ]);

        $s = Role::where('slug','student')->first();
        $u = User::where('userable_id',$student->id)->first();
        $u->roles()->attach($s);

        return $student;
    }
}

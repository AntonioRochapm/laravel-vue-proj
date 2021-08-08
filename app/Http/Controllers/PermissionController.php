<?php

namespace App\Http\Controllers;

use App\Role;
use App\Teacher;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PermissionController extends Controller
{
    public function Permission(){
        $admin_role = new Role();
        $admin_role->slug = 'administrator';
        $admin_role->name = 'Access Admin Tools';
        $admin_role->save();

        $teacher_role = new Role();
        $teacher_role->slug = 'teacher';
        $teacher_role->name = 'Teacher Side';
        $teacher_role->save();

        $student_role = new Role();
        $student_role->slug = 'student';
        $student_role->name = 'Student Side';
        $student_role->save();

        $teacher = new Teacher(['is_admin'=>1]);
        $teacher->save();
        $teacher->user()->create(['name'=>'atec','password'=>Hash::make('atec123'),'email'=>'atec@atec']);
        $u = User::where('id',1)->first();
        $u->roles()->attach($admin_role);
        $u->roles()->attach($teacher_role);
        $u->roles()->attach($student_role);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showStudentLoginForm()
    {
        return view('auth.studentlogin');
    }

    public function showStaffLoginForm()
    {
        return view('auth.stafflogin');
    }

    public function showStudentRegisterForm()
    {
        return view('auth.studentregister');
    }

    public function showStaffRegisterForm()
    {
        return view('auth.staffregister');
    }

    public function home()
    {
        return view('auth.home');
    }

    public function studenthome()
    {
        return view('auth.studenthome');
    }

    public function staffhome()
    {
        return view('auth.staffhome');
    }

}

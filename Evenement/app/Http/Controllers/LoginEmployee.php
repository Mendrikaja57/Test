<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class LoginEmployee extends Controller
{
    public function connexion( Request $request){
        $mail = $request->input('mail');
        $password = $request->input('password');

        $user = Employee::where('email', $mail)->where('motdepasse', $password)->get();

        if($user == '[]'){
            return view('loginEmploye');
        }else{
            return view('index');
        }
    }
}

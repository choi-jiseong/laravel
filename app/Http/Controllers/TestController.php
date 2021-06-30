<?php

namespace App\Http\Controllers;  //패키지 느낌

use Illuminate\Http\Request;  //import 느낌

class TestController extends Controller
{
    public function index() {
        $name = "일지매";
        $age = 23;
        return view('test.show', compact('name', 'age'));
    }
}

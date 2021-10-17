<?php

namespace App\Api\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ToDoController
{
    public function index(Request $request)
    {
        return User::all();
    }
}

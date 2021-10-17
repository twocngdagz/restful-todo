<?php

namespace App\Api\Controllers;

use App\Models\User;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;
use Illuminate\Validation\ValidationException;

class AuthController
{
    public function login(Request $request)
    {
        $loader = new FileLoader(new Filesystem, 'lang');
        $translator = new Translator($loader, 'en');
        $validation = new Factory($translator, new Container);

        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $messages = [
            'required' => 'The :attribute field is required.',
            'email' => 'The :attribute field is not valid.'
        ];

        $validator = $validation->make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $user = User::where('email', $request->email)->first();
        Manager
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $_SESSION['user'] = $user;

        return $user;
    }
}

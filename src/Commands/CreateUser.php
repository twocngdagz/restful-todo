<?php

namespace App\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateUser extends Command
{
    protected $signature = "user:create";

    protected $description = "Create User";

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $name = $this->ask('Enter Name');
        $email = $this->ask('Enter email');
        $password = $this->secret('Enter password');
        $password_confirmation = $this->secret('Confirm password');

        $validation = app('validation');
        $hash = app('hash');

        $validator = $validation->make(
            compact('name', 'email', 'password', 'password_confirmation'),
            [
                'name' => 'required',
                'email' => 'email',
                'password' => 'required|confirmed',
            ],
            [
                'required' => 'The :attribute field is required.',
                'email' => 'The :attribute field is not valid.',
                'confirmed' => 'The :attribute does not match',
            ]
        );

        if (! $validator->fails()) {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => $hash->make($password)
            ]);

            if ($user) {
                return $this->info('User create successfully.');
            }
        }

        foreach ($validator->errors()->all() as $message) {
            $this->error($message);
        }
    }
}

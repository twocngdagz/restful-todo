<?php

namespace App\Api\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class ToDoController
{
    public function all()
    {
        return Task::all();
    }

    public function index()
    {
        return Task::currentUser()->get();
    }

    public function show(int $id)
    {
        try {
            return Task::currentUser()->whereId($id)->get();
        } catch (\Throwable $e) {
            return [
                'errors' => [
                    'status' => 404,
                    'detail' => $e->getMessage()
                ]
            ];
        }
    }

    public function create(Request $request)
    {
        $validation = app('validation');

        $rules = [
            'description' => 'required',
            'is_done' => 'required|boolean',
        ];

        $messages = [
            'required' => 'The :attribute field is required.',
            'boolean' => 'The :attribute field is not boolean.'
        ];

        $validator = $validation->make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $validator->errors();
        }

        try {
            return Task::create([
                'description' => $request->input('description'),
                'is_done' => $request->input('is_done'),
                'user_id' => $_SESSION['user']->id,
            ]);
        } catch (\Throwable $e) {
            return [
                'errors' => [
                    'status' => 500,
                    'detail' => $e->getMessage()
                ]
            ];
        }

    }

    public function update(Request $request, int $id)
    {
        $validation = app('validation');

        $rules = [
            'description' => 'required',
            'is_done' => 'required|boolean',
        ];
        $messages = [
            'required' => 'The :attribute field is required.',
            'boolean' => 'The :attribute field is not boolean.'
        ];

        $validator = $validation->make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $validator->errors();
        }

        try {
            $task = Task::findOrFail($id);
            $task->description = $request->input('description');
            $task->is_done = $request->input('is_done');
            $task->save();

            return $task;
        } catch (\Throwable $e) {
            return [
                'errors' => [
                    'status' => 404,
                    'detail' => $e->getMessage()
                ]
            ];
        }
    }

    public function destroy(int $id)
    {
        try {
            $task = Task::findOrFail($id);
            return $task->delete();
        } catch (\Throwable $e) {
            return [
                'errors' => [
                    'status' => 404,
                    'detail' => $e->getMessage()
                ]
            ];
        }
    }
}

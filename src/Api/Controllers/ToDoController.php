<?php

namespace App\Api\Controllers;

use App\Models\Task;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;

class ToDoController
{
    public function index(Request $request)
    {
        return Task::paginate(10);
    }

    public function show(int $id)
    {
        try {
            return Task::findOrFail($id);
        } catch (\Throwable $e) {
            return new Response([
                'errors' => [
                    'status' => 404,
                    'detail' => $e->getMessage()
                ]
            ]);
        }
    }

    public function create(Request $request)
    {
        $loader = new FileLoader(new Filesystem, 'lang');
        $translator = new Translator($loader, 'en');
        $validation = new Factory($translator, new Container);

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
            Task::create([
                'description' => $request->input('description'),
                'is_done' => $request->input('is_done'),
            ]);
        } catch (\Throwable $e) {
            return new Response([
                'errors' => [
                    'status' => 500,
                    'detail' => $e->getMessage()
                ]
            ]);
        }

    }

    public function update(Request $request, int $id)
    {
        $loader = new FileLoader(new Filesystem, 'lang');
        $translator = new Translator($loader, 'en');
        $validation = new Factory($translator, new Container);

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
            return new Response([
                'errors' => [
                    'status' => 404,
                    'detail' => $e->getMessage()
                ]
            ]);
        }
    }

    public function destroy(int $id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->delete();
        } catch (\Throwable $e) {
            return new Response([
                'errors' => [
                    'status' => 404,
                    'detail' => $e->getMessage()
                ]
            ]);
        }
    }
}

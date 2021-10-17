<?php

namespace App\Api\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ToDoController
{
    public function index(Request $request)
    {
        return Task::all();
    }

    public function show(Request $request, int $id)
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

    }

    public function update(Request $request, Task $todo)
    {

    }

    public function destroy(Request $reqeust)
    {

    }
}

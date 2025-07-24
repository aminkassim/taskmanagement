<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function getLisTask(Request $request)
    {
        return Task::all();
    }

    public function addTask(Request $request)
    {
        $input = $request->all();

        // Optional: Validate input first
        $validator = Validator::make($request->all(), [
          'title' => 'required|string|max:255',
          'description' => 'nullable|string',
          'status' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
          return response()->json([
            'errors' => $validator->errors(),
         ], Response::HTTP_UNPROCESSABLE_ENTITY); // 422
        } 

        // Create and save task
        $task = Task::create([
         'title' => $input['title'],
         'description' => $input['description'],
         'status' => $input['status']
        ]);

        // Return response with 201 Created
        return response()->json([
          'message' => 'Task created successfully.',
          'task' => $task,
        ], Response::HTTP_CREATED); // 201
    }

    public function updateTask(Request $request, $id)
    {        
        $task = Task::find($id);

        if (!$task) {
          return response()->json(['message' => 'Task not found'], Response::HTTP_NOT_FOUND);
        }

        $task->update($request->only(['title', 'description', 'status']));

        return response()->json([
          'message' => 'Task updated successfully.',
          'task' => $task,
        ], Response::HTTP_OK);

    }

    public function deleteTask($id)
    {        
        $task = Task::find($id);

        if (!$task) {
          return response()->json(['message' => 'Task not found'], Response::HTTP_NOT_FOUND);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully'], Response::HTTP_OK);

    }


}

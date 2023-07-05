<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
   public function index()
   {
       $tasks = Task::all();

       return response()->json($tasks);
   }

   public function show($id)
   {
       $task = Task::find($id);

       if ($task) {
           return response()->json($task);
       } else {
           return response()->json(['error' => 'Tarefa não encontrada'], 404);
       }
   }

   public function store(Request $request)
   {
       $request->validate([
           'title' => 'required',
           'description' => 'required',
       ]);

       $task = new Task;
       $task->title = $request->input('title');
       $task->description = $request->input('description');
       $task->status = $request->input('status', false);
       $task->save();

       return response()->json($task, 201);
   }

   public function update(Request $request, $id)
   {
       $task = Task::find($id);

       if ($task) {
           $request->validate([
               'title' => 'required',
               'description' => 'required',
           ]);

           $task->title = $request->input('title');
           $task->description = $request->input('description');
           $task->status = $request->input('status', $task->status);
           $task->save();

           return response()->json($task);
       } else {
           return response()->json(['error' => 'Tarefa não encontrada'], 404);
       }
   }

   public function destroy($id)
   {
       $task = Task::find($id);

       if ($task) {
           $task->delete();

           return response()->json(['message' => 'Tarefa excluída com sucesso']);
       } else {
           return response()->json(['error' => 'Tarefa não encontrada'], 404);
       }
   }
}
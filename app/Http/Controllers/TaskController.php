<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{public function index(Request $request)
{
    // 1. Filter berdasarkan user login
    $query = Task::where('user_id', auth()->id());

    // 2. Fitur search (optional)
    if ($request->search) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    // 3. Gunakan pagination (TANPA get())
    $tasks = $query->paginate(5);

    // 4. Response
    return response()->json([
        'success' => true,
        'message' => 'List task berhasil',
        'data' => $tasks
    ]);


}

    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|max:255',
        'description' => 'nullable'
    ]);

    $task = Task::create([
        'title' => $validated['title'],
        'description' => $validated['description'],
        'user_id' => auth()->id()
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Task berhasil dibuat',
        'data' => $task
    ]);

}

   public function show($id)
{
    $task = Task::where('user_id', auth()->id())->find($id);

    if (!$task) {
        return response()->json([
            'success' => false,
            'message' => 'Task tidak ditemukan'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'data' => $task
    ]);
}

    public function update(Request $request, $id)
{
    $task = Task::where('user_id', auth()->id())->find($id);

    if (!$task) {
        return response()->json([
            'success' => false,
            'message' => 'Task tidak ditemukan'
        ], 404);
    }

    $validated = $request->validate([
        'title' => 'required|max:255',
        'description' => 'nullable'
    ]);

    $task->update($validated);

    return response()->json([
        'success' => true,
        'message' => 'Task berhasil diupdate',
        'data' => $task
    ]);
}

    public function destroy($id)
{
    $task = Task::where('user_id', auth()->id())->find($id);

    if (!$task) {
        return response()->json([
            'success' => false,
            'message' => 'Task tidak ditemukan'
        ], 404);
    }

    $task->delete();

    return response()->json([
        'success' => true,
        'message' => 'Task berhasil dihapus'
    ]);
}
}
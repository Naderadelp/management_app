<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskManagmentRequest;
use App\Http\Requests\UpdateTaskManagmentRequest;
use App\Models\TaskManagment;

class TaskManagmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $taskManagments = TaskManagment::where('user_id', auth()->id())->paginate(20);
        return view('task.index', compact('taskManagments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('task.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskManagmentRequest $request)
    {
        $task = TaskManagment::create([
            ...$request->validated(),
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('task-managments.index')
            ->with('success', 'Task created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskManagment $taskManagment)
    {
        return view('task.view', compact('taskManagment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskManagment $taskManagment)
    {
        return view('task.edit', compact('taskManagment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskManagmentRequest $request, TaskManagment $taskManagment)
    {
        $taskManagment->update($request->validated());

        return redirect()->route('task-managments.index')
            ->with('success', 'Task updated successfully!');
    }

    /**
     */
    public function destroy(TaskManagment $taskManagment)
    {
        $taskManagment->delete();

        return redirect()->route('task-managments.index')
            ->with('success', 'Task deleted successfully!');
    }
}

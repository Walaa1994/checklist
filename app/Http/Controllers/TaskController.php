<?php

namespace App\Http\Controllers;

use App\Checklist;
use App\Http\Requests\StoreTask;
use App\Http\Requests\UpdateTask;
use App\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function getTasks(Request $request){
        $checklist_id =$request->input("checklist_id");
        $tasks = Checklist::find($checklist_id)->tasks()->get();
        return $tasks;
    }

    public function getUncompletedTasks(Request $request){
        $checklist_id =$request->input("checklist_id");
        $tasks = Checklist::find($checklist_id)->uncompletedTasks()->get();
        return $tasks;
    }

    public function endTask(Request $request){
        $task_id =$request->input("task_id");
        Task::find($task_id)->Update(['status' => 1,'end_date' => Carbon::now()]);
        return response()->json(['success'=>'Task ended successfully.']);
    }

    public function activateTask(Request $request){
        $task_id =$request->input("task_id");
        Task::find($task_id)->Update(['status' => 0,'end_date' => null]);
        return response()->json(['success'=>'Task activated successfully.']);
    }

    public function index($checklist_id){
        $showChart = true;
        return view('tasks.index',compact('checklist_id','showChart'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTask $request){

        Task::Create( ['checklist_id' =>$request->checklist_id, 'name' => $request->name, 'description' => $request->description,'status' => 0,'start_date' =>$request->start_date, 'estimate_date' =>$request->estimate_date,'created_by' => Auth::id()]);

        return response()->json(['success'=>'Task created successfully.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task){

        return response()->json($task);
    }

    /**
     * Update an existing resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTask $request, Task $task){

        $this->authorize('update', $task);

        Task::find($request->task_id)->Update(['name' => $request->name, 'description' => $request->description,'start_date' =>$request->start_date, 'estimate_date' =>$request->estimate_date,'updated_by' => Auth::id()]);

        return response()->json(['success'=>'Task updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();

        return response()->json(['success'=>'Task deleted successfully.']);
    }
}

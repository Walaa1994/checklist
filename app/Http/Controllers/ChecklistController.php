<?php

namespace App\Http\Controllers;

use App\Checklist;
use App\Http\Requests\StoreChecklist;
use App\Http\Requests\UpdateChecklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;

class ChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

        if ($request->ajax()) {
            $data = Checklist::latest()->with('user')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editChecklist">Edit</a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteChecklist">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('checklists.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreChecklist $request){

        Checklist::Create(['name' => $request->name, 'description' => $request->description, 'created_by' => Auth::user()->id]);

        return response()->json(['success'=>'Checklist created successfully.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Checklist  $checklist
     * @return \Illuminate\Http\Response
     */
    public function edit(Checklist $checklist){

        return response()->json($checklist);
    }

    /**
     * Update an existing resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateChecklist $request, Checklist $checklist){

        $this->authorize('update', $checklist);

        $checklist->update(['name' => $request->name, 'description' => $request->description,'updated_by' => Auth::user()->id]);

        return response()->json(['success'=>'Checklist updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Checklist  $checklist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Checklist $checklist)
    {
        $this->authorize('delete', $checklist);
        $checklist->delete();

        return response()->json(['success'=>'Checklist deleted successfully.']);
    }

    public function getChartInfo(Request $request){
        $checklist_id= $request->input("checklist_id");
        $percentage = 0;
        $totalTasksCount = Checklist::find($checklist_id)->tasks()->count();
        $completedTasksCount = Checklist::find($checklist_id)->completedTasks()->count();
        if($totalTasksCount != 0){
            $percentage = intval(($completedTasksCount / $totalTasksCount) * 100);
        }
        return response()->json(['percentage'=> $percentage,'totalTasksCount'=>$totalTasksCount,'completedTasksCount' => $completedTasksCount]);
    }

    public function getChecklists (){
        $checklists = Auth::user()->checklists;
        return response()->json(['checklists'=> $checklists]);
    }
}

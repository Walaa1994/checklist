<?php

namespace App\Http\Controllers;

use App\Checklist;
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
    public function store(Request $request){

        if($request->checklist_id){
            Checklist::where('id', $request->checklist_id)->update(['name' => $request->name, 'description' => $request->description,'updated_by' => Auth::user()->id]);
        }else{
            Checklist::Create(['name' => $request->name, 'description' => $request->description, 'created_by' => Auth::user()->id]);
        }

        return response()->json(['success'=>'Checklist saved successfully.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Checklist  $checklist
     * @return \Illuminate\Http\Response
     */
    public function edit($id){

        $checklist = Checklist::find($id);
        return response()->json($checklist);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Checklist  $checklist
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Checklist::find($id)->delete();

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
        $checklists = Checklist::all();
        return response()->json(['checklists'=> $checklists]);
    }
}

@extends('_layouts/layout')
@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('css/toggle-switch.css')}}">
@endsection
@section('content')
    <!-- Rounded switch -->
    <div style="display: flex;align-items: center;float: right;">
        <label>Show Completed</label>
        <label class="switch">
            <input type="checkbox" id="show_completed" onclick="showCompleted(this)" checked>
            <span class="slider round"></span>
        </label>
    </div>
    <br><br>
    <!-- TO DO List -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="ion ion-clipboard mr-1"></i>
                Task List
            </h3>

            <div class="card-tools">
                <ul class="pagination pagination-sm">
                    <li class="page-item"><a href="#" class="page-link">&laquo;</a></li>
                    <li class="page-item"><a href="#" class="page-link">1</a></li>
                    <li class="page-item"><a href="#" class="page-link">2</a></li>
                    <li class="page-item"><a href="#" class="page-link">3</a></li>
                    <li class="page-item"><a href="#" class="page-link">&raquo;</a></li>
                </ul>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <ul class="todo-list" data-widget="todo-list" id="taskUL">

            </ul>
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
            <button id="createNewTask" type="button" class="btn btn-success float-right"><i class="fas fa-plus"></i> {{ Lang::get('tasks.add-new-task') }}</button>
        </div>
    </div>


    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="TaskForm" name="TaskForm" class="form-horizontal">
                        <input type="hidden" name="task_id" id="task_id">
                        <input type="hidden" name="checklist_id" id="checklist_id" value="{{$checklist_id}}">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">{{ Lang::get('tasks.name') }}</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">{{ Lang::get('tasks.description') }}</label>
                            <div class="col-sm-12">
                                <textarea id="description" name="description" required="" placeholder="Enter descriptions" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">{{ Lang::get('tasks.start-date') }}</label>
                            <div class="col-sm-12">
                                <input type="date" id="start_date" name="start_date" class="form-control" value="" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">{{ Lang::get('tasks.end-estimate-date') }}</label>
                            <div class="col-sm-12">
                                <input type="date" id="estimate_date" name="estimate_date" class="form-control" value="" required>
                            </div>
                        </div>

                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
{{--    @include('JS.JStask')--}}
<script src="{{asset('js/pages/task.js')}}"></script>
@endsection

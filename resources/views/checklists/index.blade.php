@extends('_layouts/layout')

@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="ion ion-clipboard mr-1"></i>
                {{ Lang::get('checklists.checklist') }} Datatable
            </h3>
        </div>
        <div class="card-body">
            <a class="btn btn-success" href="javascript:void(0)" id="createNewChecklist">{{ Lang::get('checklists.create-new-checklist') }}</a>
            <br>
            <br>
            <table class="table table-bordered data-table">
                <thead>
                <tr>
                    <th>No</th>
                    <th>{{ Lang::get('checklists.name') }}</th>
                    <th>{{ Lang::get('checklists.description') }}</th>
                    <th>{{ Lang::get('checklists.createdby') }}</th>
                    <th>{{ Lang::get('checklists.createdat') }}</th>
                    <th width="280px">{{ Lang::get('checklists.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

        </div>
    </div>
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="ChecklistForm" name="ChecklistForm" class="form-horizontal">
                        <input type="hidden" name="checklist_id" id="checklist_id">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">{{ Lang::get('checklists.name') }}</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">{{ Lang::get('checklists.description') }}</label>
                            <div class="col-sm-12">
                                <textarea id="description" name="description" required="" placeholder="Enter descriptions" class="form-control"></textarea>
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
{{--@include('JS.JSchecklist')--}}
<script src="{{asset('js/pages/checklist.js')}}"></script>
{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
@endsection

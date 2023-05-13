$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: route('checklists.index'),
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'description', name: 'description'},
            {data: 'user.name', name: 'createdby'},
            {data: 'created_at', name: 'createda'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $('#createNewChecklist').click(function () {
        $('#saveBtn').val("create-checklist");
        $('#checklist_id').val('');
        $('#ChecklistForm').trigger("reset");
        $('#modelHeading').html("Create New Checklist");
        $('#ajaxModel').modal('show');
    });

    $('body').on('click', '.editChecklist', function () {
        var checklist_id = $(this).data('id');
        $.get(route('checklists.index') +'/' + checklist_id +'/edit', function (data) {
            $('#modelHeading').html("Edit Checklist");
            $('#saveBtn').val("edit-checklist");
            $('#ajaxModel').modal('show');
            $('#checklist_id').val(data.id);
            $('#name').val(data.name);
            $('#description').val(data.description);
        })
    });

    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
        let btnVal = e.target.value;
        let type,url;
        //check save button if create or update
        if(btnVal == "create-checklist"){
            type = 'POST';
            url = route('checklists.store');
        }else{
            let checklist_id = $('#checklist_id').val();
            type = 'PUT';
            url = route('checklists.update',checklist_id);
        }

        $.ajax({
            data: $('#ChecklistForm').serialize(),
            url: url,
            type: type,
            dataType: 'json',
            success: function (data) {
                $('#ChecklistForm').trigger("reset");
                $('#ajaxModel').modal('hide');
                table.draw();
                getChecklists();
                toastr.success(data.success);
                $('#saveBtn').html('Save Changes');
            },
            error: function (data) {
                let response = JSON.parse(data.responseText)
                if(data.status == 403){
                    toastr.error(response.message);
                }else{
                    $.each( response.errors, function( key, value) {
                        toastr.error(value[0]);
                    });
                }

                $('#saveBtn').html('Save Changes');
            }
        });
    });

    $('body').on('click', '.deleteChecklist', function () {

        var checklist_id = $(this).data("id");
        var r = confirm("Are You sure want to delete !");

        if(r == true){
            $.ajax({
                type: "DELETE",
                url: route('checklists.store')+'/'+checklist_id,
                success: function (data) {
                    table.draw();
                    getChecklists();
                    toastr.success(data.success);
                },
                error: function (data) {
                    let response = JSON.parse(data.responseText)
                    toastr.error(response.message);
                }
            });
        }

    });

});


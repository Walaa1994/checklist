var checklist_id = $('#checklist_id').val();

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

getTasks();
updateChart();

function getTasks() {
    $.ajax({
        type: "POST",
        url: '/getTasks',
        data: {
            "checklist_id": checklist_id,
        },
        success: function (response) {
            $("#taskUL").html("");
            $.each(response, function(index, value) {
                var element ="";
                if(value['end_date']){
                    element +=' <li class="done">\n' +
                        '                    <!-- checkbox -->\n' +
                        '                    <div  class="icheck-primary d-inline ml-2">\n' +
                        '<input onclick="taskCheck(this,'+value['id']+')" type="checkbox"  name="todo1" id="todoCheck1" checked>';
                }else {
                    element +=' <li>\n' +
                        '                    <!-- checkbox -->\n' +
                        '                    <div  class="icheck-primary d-inline ml-2">\n' +
                        '<input onclick="taskCheck(this,'+value['id']+')" type="checkbox"  name="todo1" id="todoCheck1">';
                }
                element += '                    </div>\n' +
                    '                    <!-- todo text -->\n' +
                    '                    <span class="text">'+value['name']+'</span>\n';
                if(value['end_date']){
                    element += '                    <!-- Emphasis label -->\n' +
                        '                    <small class="badge badge-danger"><i class="far fa-clock"></i> '+value['end_date']+'</small>';
                }
                element += '                    <!-- General tools such as edit or delete-->\n' +
                    '                    <div class="tools">\n' +
                    '                        <i data-original-title="Edit" data-id="'+value['id']+'" class="fas fa-edit editTask"></i>\n' +
                    '                        <i data-original-title="Delete" data-id="'+value['id']+'" class="fas fa-trash deleteTask"></i>\n' +
                    '                    </div>\n' +
                    '                </li>';
                $("#taskUL").append(element);
            });
        },
    });
}

function taskCheck(element,task_id) {
    if(element.checked) {
        $.ajax({
            type: "POST",
            url: '/endTask',
            data: {
                "task_id": task_id,
            },
            success: function (response) {
                toastr.success(response.success);
                getTasks();
                updateChart()
            },
            error: function (data) {
                toastr.error("There is something error");
                console.log('Error:', data);
            }
        });
    }
    else {
        $.ajax({
            type: "POST",
            url: '/activateTask',
            data: {
                "task_id": task_id,
            },
            success: function (response) {
                toastr.success(response.success);
                getTasks();
                updateChart()
            },
            error: function (data) {
                toastr.error("There is something error");
                console.log('Error:', data);
            }
        });
    }
}

function updateChart(){
    $.ajax({
        type: "POST",
        url: '/getChartInfo',
        data: {
            "checklist_id": checklist_id,
        },
        success: function (response) {
            var newValue = response.percentage;
            $('.chart').data('easyPieChart').update(newValue);
            $('span', $('.chart')).text(newValue);
            $('#totalTasks').text(response.totalTasksCount);
            $('#completedTasks').text(response.completedTasksCount);
        }
    });
}

function showCompleted(element){
    if(element.checked) {
        getTasks();
    }else{
        getUncompletedTasks()
    }
}

function getUncompletedTasks(){
    $.ajax({
        type: "POST",
        url: '/getUncompletedTasks',
        data: {
            "checklist_id": checklist_id,
        },
        success: function (response) {
            $("#taskUL").html("");
            $.each(response, function(index, value) {
                var element =' <li>\n' +
                    '                    <!-- checkbox -->\n' +
                    '                    <div  class="icheck-primary d-inline ml-2">\n' +
                    '                      <input onclick="taskCheck(this,'+value['id']+')" type="checkbox"  name="todo1" id="todoCheck1">'+
                    '                      <label for="todoCheck1"></label>\n' +
                    '                    </div>\n' +
                    '                    <!-- todo text -->\n' +
                    '                    <span class="text">'+value['name']+'</span>\n' +
                    '                    <!-- General tools such as edit or delete-->\n' +
                    '                    <div class="tools">\n' +
                    '                        <i data-original-title="Edit" data-id="'+value['id']+'" class="fas fa-edit editTask"></i>\n' +
                    '                        <i data-original-title="Delete" data-id="'+value['id']+'" class="fas fa-trash deleteTask"></i>\n' +
                    '                    </div>\n' +
                    '                </li>';
                $("#taskUL").append(element);
            })
        },
    });
}

$('#createNewTask').click(function () {
    $('#saveBtn').val("create-task");
    $('#task_id').val('');
    $('#TaskForm').trigger("reset");
    $('#modelHeading').html("Create New Task");
    $('#ajaxModel').modal('show');
});

$('body').on('click', '.editTask', function () {
    var task_id = $(this).data('id');
    $.get(route('tasks.index') +'/' + task_id +'/edit', function (data) {
        $('#modelHeading').html("Edit Task");
        $('#saveBtn').val("edit-Task");
        $('#ajaxModel').modal('show');
        $('#task_id').val(data.id);
        $('#name').val(data.name);
        $('#description').val(data.description);
        $('#start_date').val(data.start_date);
        $('#estimate_date').val(data.estimate_date);
    })
});

$('#saveBtn').click(function (e) {
    e.preventDefault();
    $(this).html('Sending..');

    $.ajax({
        data: $('#TaskForm').serialize(),
        url: route('tasks.store'),
        type: "POST",
        dataType: 'json',
        success: function (data) {

            $('#TaskForm').trigger("reset");
            $('#ajaxModel').modal('hide');
            getTasks();
            updateChart();
            toastr.success(data.success);

        },
        error: function (data) {
            console.log('Error:', data);
            toastr.error("Please fill all the fields");
            $('#saveBtn').html('Save Changes');
        }
    });
});

$('body').on('click', '.deleteTask', function () {

    var task_id = $(this).data("id");
    var r = confirm("Are You sure want to delete !");

    if(r == true){
        $.ajax({
            type: "DELETE",
            url: route('tasks.store')+'/'+task_id,
            success: function (data) {
                toastr.success(data.success);
                getTasks();
                updateChart()
            },
            error: function (data) {
                toastr.error("There is something error");
                console.log('Error:', data);
            }
        });
    }
});


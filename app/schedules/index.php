<section class="py-4">
    <div class="container">
        <h3 class="fw-bolder text-center">Schedule List</h3>
        <center>
            <hr class="bg-primary w-25 opacity-100">
        </center>
        <table class="table table-striped table-bordered dt-init">
            <colgroup>
                <col width="5%">
                <col width="20%">
                <col width="20%">
                <col width="30%">
                <col width="10%">
                <col width="10%">
            </colgroup>
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Start Date</th>
                    <th class="text-center">Medicine</th>
                    <th class="text-center">Schedule</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</section>
<noscript id="action-btn-clone">
<div class="dropdown">
<button class="btn btn-primary btn-sm bg-gradient rounded-0 mb-0" type="button" id="" data-bs-toggle="dropdown" aria-expanded="false">
    Action <span class="material-icons">keyboard_arrow_down</span>
</button>
    <ul class="dropdown-menu" aria-labelledby="">
        <li><a class="dropdown-item view_data w-100 d-flex align-items-center" href="javascript:void(0)"><span class="material-icons me-2">wysiwyg</span> View</a></li>
        <li><a class="dropdown-item edit_data w-100 d-flex align-items-center" href="javascript:void(0)"><span class="material-icons me-2">edit</span> Edit</a></li>
        <li><a class="dropdown-item delete_data w-100 d-flex align-items-center" href="javascript:void(0)"><span class="material-icons me-2">delete</span> Delete</a></li>
    </ul>
</div>
</noscript>
<script>
    $(function(){
        $('.dt-init').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url:"../classes/Master.php?f=dt_schedules",
                method:"POST"
            },
            columns: [{
                    data: 'no',
                    className: 'py-1 px-2 text-center',
                    width:"5%"
                },
                {
                    data: 'date_start',
                    className: 'py-1 px-2',
                    width:"15%"
                },
                {
                    className: 'py-1 px-2', 
                    render:function(data, type, row, meta){
                        return '<p class="m-0 text-truncate w-100">'+((row.medicine_name))+'...</p>';
                        },
                    width:"20%"
                },
                {
                    className: 'py-1 px-2',
                    render:function(data, type, row, meta){
                        return '<p class="m-0 text-truncate w-100">'+((row.day))+'...</p>';
                        },
                    width:"30%"
                },
                {
                    className: 'py-1 px-2 text-center',
                    render:function(data, type, row, meta){
                        if(row.status == 1)
                            return '<span class="badge bg-primary bg-gradient px-3 rounded-pill">Active</span>';
                        else
                            return '<span class="badge bg-secondary bg-gradient px-3 rounded-pill">Inactive</span>';
                    },
                    width:"15%"
                },
                {
                    data: null,
                    orderable: false,
                    className: 'text-center py-1 px-2',
                    render: function(data, type, row, meta) {
                        var el = $('<div>')
                        el.append($($('noscript#action-btn-clone').html()).clone())
                        el.attr('id','dropdown'+row.id)
                        el.find('.dropdown-menu').attr('aria-labelledby','dropdown'+row.id)
                        el.find('.edit_data,.delete_data,.view_data').attr('data-id',row.id).attr('data-name',row.location)
                        el.find('.edit_data').attr("href","./?page=schedules/manage_schedule&id="+row.id)
                        el.find('.view_data').attr("href","./?page=schedules/view_details&id="+row.id)
                        
                        return el.html();
                        
                    },
                    width:"10%"
                }
            ],
            columnDefs: [{
                orderable: false,
                targets: [2,5]
            }],
            initComplete: function(settings, json) {
                $('table td, table th').addClass('px-2 py-1 align-middle')
            },
            drawCallback: function(settings) {
                $('table td, table th').addClass('px-2 py-1 align-middle')
                $('.delete_data').click(function(){
                    _conf("Are you sure to delete <b>"+$(this).attr('data-name')+"</b> from list?","delete_schedule",[$(this).attr('data-id')])
                })
            },
            language:{
                oPaginate: {
                    sNext: '<i class="fa fa-angle-right"></i>',
                    sPrevious: '<i class="fa fa-angle-left"></i>',
                    sFirst: '<i class="fa fa-step-backward"></i>',
                    sLast: '<i class="fa fa-step-forward"></i>'
                }
            }
        })
    })
    function delete_schedule($id){
        start_loader();
        var _this = $(this)
        $('.err-msg').remove();
        var el = $('<div>')
        el.addClass("alert alert-danger err-msg")
        el.hide()
        $.ajax({
            url: '../classes/Master.php?f=delete_schedule',
            method: 'POST',
            data: {
                id: $id
            },
            dataType: 'json',
            error: err => {
                console.log(err)
                el.text('An error occurred.')
                el.show('slow')
                end_loader()
            },
            success: function(resp) {
                if (resp.status == 'success') {
                    location.reload()
                } else if (!!resp.msg) {
                    el.text('An error occurred.')
                    el.show('slow')
                } else {
                    el.text('An error occurred.')
                    el.show('slow')
                }
                end_loader()
            }
        })
    }
</script>
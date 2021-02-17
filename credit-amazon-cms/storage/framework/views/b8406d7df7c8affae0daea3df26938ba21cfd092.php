<?php $__env->startSection('content'); ?>
    


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <?php ($innerstatuses = \App\Models\InnerStatus::whereIn('id', \Config::get('techplus.approvedstatuses'))->get()); ?>
                            <select style="max-width: 150px;" id="inner-status-filter" class="form-control">
                                <option value="0"></option>
                                <?php $__currentLoopData = $innerstatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ins): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($ins->id); ?>"><?php echo e($ins->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select> 
                            <button type="button" class="btn btn-danger waves-effect text-left" id="inner_status_filter_button">გაფილტვრა</button>

                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <table id="Call_table"  class=" table table-hover table-striped table-bordered full-color-table full-dark-table hover-table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>თარიღი</th>
                                <th>სახელი/გვარი</th>
                                <th>ტელეფონის ნომერი</th>
                                <th>შენიშვნა</th>
                                <th>ფასი</th>
                                <th>შიდა სტატუსი</th>
                            </tr>
                        </thead>
                        <tbody id="Call_table_body">

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>თარიღი</th>
                                <th>სახელი/გვარი</th>
                                <th>ტელეფონის ნომერი</th>
                                <th>შენიშვნა</th>
                                <th>ფასი</th>
                                <th>შიდა სტატუსი</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade bs-example-modal-lg" id="View_Modal"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                            
    </div>



<script>
    window.loadTableUrl = '<?php echo e(route('techplus.loadcalls')); ?>'
    $(document).ready(function(){
        create_calls_table();
        $('#inner_status_filter_button').click(function(){
            inner_status = $('#inner-status-filter').val();
            if(inner_status > 0) {
                updateTableWithStatus(inner_status);
            }
        });
    });

    updateTableWithStatus = function(status_id) {
        tableurl = window.loadTableUrl + '?i=2&inner_status='+status_id;
        create_calls_table({url: tableurl});
    }

    function create_calls_table(data = {url: window.loadTableUrl}) {
        $('#Call_table_body').empty();
        $('#Call_table tbody').off( 'click', 'tr');
        $('#Call_table').DataTable().destroy();
        
        table = $('#Call_table').DataTable({
            destroy: true,                
            buttons: [{
                    text: 'განაცხადების წამოღება',
                    action: function () {
                        get_request_from_another_sites(function(){
                            create_calls_table({ url: window.loadTableUrl });
                        });
                    }
                },{
                    text: 'გაახლება',
                    action: function () {
                        create_calls_table({url: window.loadTableUrl});
                    }
                },{
                    text: 'არ იღებს',
                    action: function () {
                        updateTableWithStatus(15);
                    }
                }
            ],    
            dom: 'Bfrtip',
            displayLength: 20,
            ajax: data.url,
            "aaSorting": [
                [0, "desc" ]
            ],
            columns: [
                { 
                    "data":  {
                        _: function(val){
                            if(val.priority > 0) {
                                return `<span class="priority" >${val.id}</span>`;
                            } else {
                                return val.id;
                            }
                        },
                        "sort": "priority"
                    },
                },
                { "data": "date" },             // თარიღი
                { "data": function(value){
                    return value.people.name ;
                } },                            // სახელი / გვარი
                { "data": "people.number" },    // ტელეფონის ნომერი
                { "data": function(value){
                    if(value.text) {
                        return value.text.slice(0, 30) + '...';
                    }
                } },                            // შენიშვნა
                { "data": "price" },            // ფასი
                { "data":  function(value){
                    if(value.inner_status == 'undefined' || value.inner_status == null){
                        return 'არ აქვს';
                    }
                    else if(value.inner_status.length < 1) {
                        return 'არ აქვს';   
                    } else {
                        return value.inner_status[0].name;   
                    }
                } },                            // შიდა სტატუსი
            ],
            rowCallback: function(row, data, index) {
                if(!data.is_locked){
                    $(row).addClass('color')
                }
            }
        });

        
        $('#Call_table tbody').on('click', 'tr', function () {
            var data = table.row( this ).data();
            showOrder(data.id);
        });
        return ;
    }




    
    get_request_from_another_sites = function(callback){
        $.ajax({
            type: "GET",
            url: "/techplus/getrequestsfromsites",
            success: function (response) {
                if(callback) {
                    callback(response);
                }
            }
        });
    }





    function showOrder(order_id){
        var showOrderUrl = '<?php echo e(route('operator.showOrder', ['order_id' => '__EXAMPLE__'])); ?>'.replace('__EXAMPLE__', order_id);
        $.ajax({
            type: "GET",
            url: showOrderUrl,
            success: function (response) {
                $('#open_modal_button').css('display', 'inline-block ');
                $('#View_Modal').html(response);
                $('#View_Modal').modal('toggle');
            }
        });
    }
</script>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>
    <script src="/assets/node_modules/sweetalert/sweetalert.min.js"></script>
    <script type="text/javascript" src="/assets/node_modules/multiselect/js/jquery.multi-select.js"></script>
    <link href="/assets/node_modules/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
    <link href="/assets/node_modules/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <script src="/assets/node_modules/toast-master/js/jquery.toast.js"></script>
    <link href="/assets/node_modules/toast-master/css/jquery.toast.css" rel="stylesheet">
    <link href="/assets/node_modules/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">
    <script src="/assets/node_modules/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>

    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
    <script src="/assets/node_modules/toast-master/js/jquery.toast.js"></script> 
    <link href="/assets/node_modules/toast-master/css/jquery.toast.css" rel="stylesheet">

    <style>
        .thead, .sorting, .sorting_asc, .sorting_desc{
            background: var(--table-th-color-bg) !important;
        }

        tbody tr {
            cursor: zoom-in !important;
        }
        
        .priority { background-color: red; }
    </style>

    <script>
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.techplus', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
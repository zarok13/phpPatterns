<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-body">
            <div class="pull-right">
                <form action="" id="filter_form">
                    <input type="hidden" name="s" value="s" />
                    ID
                    <input type="text" class="form-control" name="request_id"  style="width: 150px">
                    თარიღი - დან
                    <input type="date" style="width: 150px" class="form-control" name="date_from" />
                    თარიღი - მდე
                    <input type="date" style="width: 150px" class="form-control" name="date_to" />
                    <a href="#" class="btn btn-success" onclick="refreshTable()">გაფილტვრა</a>
                </form>
            </div>
            <div class="pull-left">
                <button class="btn btn-success" id="add_request">დამატება</button>
                <button class="btn btn-danger" id="items_not_added">შესაყვანი ნივთები</button>
                <button class="btn btn-info" style="display: none" id="add_items_to_request">ნივთების შეტანა</button>
                <a href="/techplus/buypage"    class="btn btn-success">საყიდელია ნივთები</a>
                <select id="supplierSelect">
                    <option value="" selected></option>
                    <?php ($suppliers  = \App\Models\Supplier::orderBy('name')->get()); ?>
                    <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($s->id); ?>"><?php echo e($s->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="clear"></div>
            
            <table id="requests_table" class="table table-hover table-striped full-color-table full-dark-table hover-table">
                <thead class="not">
                    <tr>
                        <th>#</th>
                        <th>თარიღი</th>
                        <th>სახელი/გვარი</th>
                        <th>პირადი ნომერი</th>
                        <th>ნომერი</th>
                        <th>მისამართი</th>
                        <th>სტატუსი</th>
                        <th>კომენტარი</th>
                        <th>ჩარიცხვა</th>
                        <th>გადახდის მეთოდი</th>
                    </tr>
                </thead>

                <tbody>
                </tbody>    
            </table>
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg" data-backdrop="static" id="create_request_modal" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">            
        <div class="modal-dialog modal-lg"  style="max-width: 80%; min-width: 80% !important">
            <div class="modal-content">
                <div class="modal-header">
                    <h6>ჩგდ-ს დამატება</h6>
                    <button type="button" class="close" id="close_request_x" data-dismiss="modal" >×</button>
                </div>

                <div class="modal-body" id="create_request_body" >
                    <?php echo $__env->make('techplus.requests.create_request', ['edit_links' => true,], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div> 

            </div>
        </div>        
    </div>

    <div class="modal fade bs-example-modal-lg" id="View_Modal"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">

    </div>

    <div id="modal-contents">
     
    </div>




    <script>
        var supplier_pay = ['ჩასარიცხი','ჩარიცხული'];
        var rs_status = ['ჩასარიცხი','ჩარიცხული'];
        var pay_status = ['ჩასარიცხი','ჩარიცხული'];
        var cred_pay = ['ჩასარიცხი','ჩარიცხული'];
        var pay_method = { 
            0: '', 
            1: 'TBC ბანკი', 
            2: 'საქართველო', 
            3: 'ლიბერთი ბანკი', 
            4: 'კრედო ბანკი', 
            5: 'Crystal', 
            6: 'VTB ბანკი', 
            99: 'ადილზე გადახდა', 
            100: 'ბარათით გადახდა',
            101: 'საბანკო გადარიცხვა'
        };
        
        // var pay_method = ['', 'თიბისი','საქართველო', 'ლიბერთი', 'კრედო', 'კრისტალი', 'VTB ბანკ', 'ადგილზე გადახდა', 'ბარათით გადახდა'];
        var courier = ['ჩარიცხული', 'ჩასარიცხი'];
        var crystal_signature = ['ხელმოწერილი', 'ხელმოსაწერი'];
        var requestTableUrl = '<?php echo e(route("techplus.loadRequests", ["quantity"=>500])); ?>' + '?ass=2';

        refreshTable = function(){
            var url = requestTableUrl + $('#filter_form').serialize();
            updateRequestsTable({url: url});
        }

        $(document).ready(function(){
            /**
            * ცხრილის შექმნა
            */
            updateRequestsTable({url: requestTableUrl});
            
            
            $('#add_request').on('click', function(){
                return $('#create_request_modal').modal('toggle');
            })

            $('#supplierSelect').on('change', function(){
                var supplierId = $(this).val();
                var url = requestTableUrl + '&supplier_id=' + supplierId;
                updateRequestsTable({url:url});
                return;
            });

            $('#filter_called').on('click', function(){
                var url = requestTableUrl + '&only_not_called=' + 1;
                updateRequestsTable({url:url});
                return; 
            });

            $('#items_not_added').on('click', function(){
                var url = requestTableUrl + '&items_added=' + 1;
                updateRequestsTable({url:url, items_added: true});
                $('#add_items_to_request').css('display', 'inline-block');
                return; 
            });

            $('#add_items_to_request').on('click', function(){
                var audio = new Audio('/geniosi.mp3');
                var ids = [];
                requests_table.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
                    var data = this.data();
                    // console.log($('tr[role="row"]'));
                    ids.push(data.request_id);
                } );
                if(ids.length < 1) {return alert('არცერთი განაცხადი არ მოიძებნა');}
                $(this).prop('disabled', true);
                $.ajax({
                    url: '<?php echo e(route('techplus.assign_items')); ?>',
                    type: 'POST',
                    data: {id: 1, request_ids: ids},
                    success: function(data) {
                        <?php if (\Entrust::hasRole(['SUPER_ADMIN'])) : ?>
                        // audio.play();
                        <?php endif; // Entrust::hasRole ?>
                        setTimeout(function(){
                            document.location.reload()
                        }, 3000)
                    },
                    error: function(e, r, o) {
                        console.log(e, r, o);
                    }
                })
                
            });

            $('#address_not_filled').on('click', function(){
                var url = requestTableUrl + '&address_not_filled=' + 1;
                updateRequestsTable({url:url});
                return; 
            });
            
        });
        


        function showOrder(order_id){
            $.ajax({
                type: "GET",
                url: "/techplus/showrequest/"+order_id+'/',
                success: function (response) {
                    $('#open_modal_button').css('display', 'inline-block ');
                    $('#View_Modal').html(response);
                    $('#View_Modal').modal('toggle');

                    $('#modal-contents').html('');
                    $("#modals-here").appendTo('#modal-contents');
                }
            });
        }


        
        

        updateRequestsTable = function(data = {url: window.techplustableurl }){
            window.techplustableurl = data.url;

            if(data.items_added) {
                window.items_added = true;
            } else {
                window.items_added = false;
            }

            window.requests_table =  $('#requests_table').DataTable({
                destroy: true,                
                dom: 'Bfrtip',
                scrollX: true,
                paging:true,
                displayLength: 100,
                order: [[0, 'desc']],
                ajax: data.url,
                columns: [
                    { "data": function(val){
                        return `<span class="${val.request.color && 'id-color-' + val.request.color}"> ${val.request_id} <span>`;
                    } },  // #
                    { "data": function(value){
                        return value.created_at.split(' ')[0];
                    } },  // # თარიღი
                    { "data": function(value){
                        if(!value.request.user_info) return;
                        return value.request.user_info.name + ' ' + value.request.user_info.lastname;
                    } },  // # სახელი/გვარი
                    { "data": function(value){
                        if(!value.request.user_info) return;
                        return value.request.user_info.personal_id;
                    } },  // # პირადი ნომერი
                    { "data": function(value){
                        return value.number;
                    } },  // # ტელეფონის ნომერი
                    { "data": function(value){
                        if(!value.request.user_info) return;
                        return value.request.user_info.address;
                    } },  // # მისამართი
                    { "data": function(value){
                        if(!value.request.inner_status[0]) return;
                        return value.request.inner_status[0].name;
                    } },  // # სტატუსიო
                    // { "data": function(value){
                    //     return rs_status[value.rs_status];
                    // } },  // # rs. სტატუსიო
                    { "data": function(value){
                        if(value.text){
                            if(value.text.length > 20) {
                                return value.text.substring(0,20);
                            }
                        }
                        return value.text;
                    } },  // # კომენტარი
                    // { "data": function(value){
                    //     return supplier_pay[value.supplier_pay];
                    // } },  // # მომწოდებლის ჩარიცხვა
                    { "data": function(value){
                        if(value.request.calculated){
                            return pay_status[value.request.calculated.pay_status];
                        } else {
                            return pay_status[value.pay_status];
                        }
                    } },  // # ჩარიცხვა
                    { "data": function(value){
                        return pay_method[value.pay_method];
                    } },  // # გადახდის მეთოდი
                    // { "data": function(value){
                    //     return courier[value.courier];
                    // } },  // # საკურიერო
                    // { "data": function(value){
                    //     return crystal_signature[value.crystal_signature];
                    // } },  // # მომწოდებელი
                ]
            });


            $('#requests_table tbody').off('click');
            $('#requests_table tbody').on('click', 'tr', function () {
                var data = window.requests_table.row( this ).data();
                console.log('removved');
                
                showOrder(data.request_id);
            });
        }
    </script>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('scripts'); ?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script type="text/javascript" src="/assets/node_modules/multiselect/js/jquery.multi-select.js"></script>
    <link href="/assets/node_modules/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
    <link href="/assets/node_modules/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <script src="/assets/node_modules/toast-master/js/jquery.toast.js"></script> 
    <link href="/assets/node_modules/toast-master/css/jquery.toast.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedcolumns/3.2.6/css/fixedColumns.dataTables.min.css">

    <script src="//cdn.datatables.net/plug-ins/1.10.19/api/sum().js"></script>
    <style>
        .thead, .sorting, .sorting_asc, .sorting_desc{
            background: var(--table-th-color-bg) !important;
        }
        tbody tr {
            cursor: zoom-in !important;
        }
        /* thead tr {
            visibility: collapse;
        } */
        .dataTables_scrollBody table thead tr {
            visibility: collapse;
        } .even {
            background: #f1f1f1;
        }
        
        .odd {
            background: #c3c3c3;
        }

        .even:hover,
        .odd:hover {
            background: #cacaca !important;
        }
        .container-fluid {
            padding-bottom: 100px;
        }
    </style>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.techplus', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
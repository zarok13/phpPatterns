<?php $__env->startSection('scripts'); ?>
    <script src="/assets/node_modules/sweetalert/sweetalert.min.js"></script>
    <script type="text/javascript" src="/assets/node_modules/multiselect/js/jquery.multi-select.js"></script>
    <link href="/assets/node_modules/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
    <link href="/assets/node_modules/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <script src="/assets/node_modules/toast-master/js/jquery.toast.js"></script>
    <link href="/assets/node_modules/toast-master/css/jquery.toast.css" rel="stylesheet">
    <style>
        .thead, .sorting, .sorting_asc, .sorting_desc{
            background: var(--table-th-color-bg) !important;
        }
        tbody tr {
            cursor: zoom-in !important;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="m-10" id="search_div">
        <form id="search_form" onsubmit="searchFormSubmited(event)">
            <input type="hidden" name="i" value="1">
            <input type="hidden" class="form-control" name="buy_date" >

            <div class="row">
                <div class="col-md-2">
                    <input type="text" class="form-control" name="request_id" id="request_id" placeholder="ID">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="name" id="name" placeholder="სახელი">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="lastname" id="lastname" placeholder="გვარი">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="personal_id" id="personal_id" placeholder="პირადი ნომერი">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="number" id="number" placeholder="ტელეფონის ნომერი">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="text" id="text" placeholder="შენიშვნა">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-3">
                    <input type="text" class="form-control" name="people_name" id="name" placeholder="სახელი/გვარი (რეგისტრაციის)">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="people_number" id="number" placeholder="ტელეფონის ნომერი (რეგისტრაციის)">
                </div>
                <?php if (\Entrust::can('search-by-status')) : ?>
                <div class="col-md-2">
                    <select class="form-control"  name="inner_status" id="inner_status_select_search">
                        <option>სტატუსი</option>

                        <?php $__currentLoopData = $data['innerstatuses']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($inner->id); ?>"><?php echo e($inner->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <?php endif; // Entrust::can ?>
                <div class="col-md-2">
                    <select class="form-control"  name="credo_client" id="credo_client">
                        <option>კრედოს კლიენტი</option>
                        <option value="1">კი</option>
                        <option value="0">არა</option>
                    </select>
                </div>
            </div>
            
            <div class="row mt-2">
                <div class="col-md-11">
                    <button class="btn btn-success" id="search_button" type="submit" >ძებნა</button>
                    <?php if (\Entrust::hasRole(['SIGNATURE_OPERATOR', 'SUPER_ADMIN', 'MANAGER'])) : ?>
                        <a href="#" class="btn btn-danger" onclick="
                            event.preventDefault();
                            $(`[name='buy_date']`).val('<?php echo e(date('Y-m-d')); ?>')
                            $(this).closest('form').submit();
                            $(`[name='buy_date']`).val('')
                        " style="color:#fff;"> დღევანდელი საყიდელია</a>
                        <a href="#" class="btn btn-danger" style="color:#fff;" onclick="
                            event.preventDefault();
                            $(`[name='buy_date']`).val('<?php echo e(now()->subDays(1)->format('Y-m-d')); ?>')
                            $(this).closest('form').submit();
                            $(`[name='buy_date']`).val('')
                        " > გუშინდელი საყიდელია</a>
                    <?php endif; // Entrust::hasRole ?>
                    <button class="btn btn-info" style="display: none" id="open_modal_button" onclick="$('#View_Modal').modal('toggle');">ბოლო განცხადების გახსნა</button>
                </div>
            </div>
        </form>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
               
                    <table id="search_table" class=" table table-hover table-striped table-bordered full-color-table full-dark-table hover-table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>თარიღი</th>
                                <th>სახელი/გვარი</th>
                                <th>ტელეფონის ნომერი</th>
                                <th>შენიშვნა</th>
                                <th>შიდა სტატუსი</th>
                                <th>გამომწერი</th>
                                <th>პირადი ნომერი</th>
                                <th>კრედოს კლიენტი</th>
                            </tr>
                        </thead>
                        
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>თარიღი</th>
                                <th>სახელი/გვარი</th>
                                <th>ტელეფონის ნომერი</th>
                                <th>შენიშვნა</th>
                                <th>შიდა სტატუსი</th>
                                <th>გამომწერი</th>
                                <th>პირადი ნომერი</th>
                                <th>კრედოს კლიენტი</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>


    <div class="modal fade bs-example-modal-lg" id="View_Modal"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;"></div>

    <script>
        
        var search_table = 0;
        var search_url = '/searchsubmit';

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

        $(document).ready(function() {
            <?php if(!Auth::user()->hasRole('OPERATOR')): ?>
            // makeSearchTable();
            <?php endif; ?>

            
            
        });
        
        function searchFormSubmited(e) {
            e.preventDefault();
            var form = $(e.target);
            var params = form.serialize();
            search_url = '/searchsubmit?' + params
            makeSearchTable();
        }


        function makeSearchTable(){
            window.search_table =  $('#search_table').DataTable({
                destroy: true,                
                dom: 'Bfrtip',
                buttons: [],
                displayLength: 20,
                ajax: search_url,
                columns: [
                    { "data": null, 
                    "render": function(val){
                        return `<span class="${val.color && 'id-color-' + val.color}"> ${val.id} <span>`;
                    } },  // #
                    { "data": "date" }, // თარიღი
                    { "data": "people.name" }, // სახელი /გვარი
                    { "data": "people.number" }, // ტელეფონის ნომერი
                    { "data": function(value) {
                        <?php if(\Auth::user()->hasRole(['SUPER_ADMIN', 'SIGNATURE_OPERATOR'])): ?>
                        return value.text ? value.text.slice(0,30) + '...' : '';
                        <?php endif; ?>
                        return '';
                    } }, // შენიშვნა
                    { "data":  function(value){
                        if(value.inner_status == 'undefined' || value.inner_status == null){
                            return 'არ აქვს';
                        }
                        else if(value.inner_status.length < 1) {
                            return 'არ აქვს';   
                        } else {
                            if(value.user_info == null){
                                return value.inner_status[0].name;
                            } else { 
                                return value.inner_status[0].name +' '+value.user_info.signature_date;
                            }
                        }
                    } }, // შიდა სტატუსი

                    { "data": function(value){
                        if(value.user_info == 'undefined' || value.user_info == null){
                            return '-';
                        }
                        else return value.user_info.name + ' ' + value.user_info.lastname;
                    } }, //გამომწერი
                    { "data": function(value){
                        if(value.user_info == 'undefined' || value.user_info == null){
                            return '-';
                        }
                        else return value.user_info.personal_id;
                    } }, 
                    { "data": 'credo_client' }, 
                ],
                initComplete: function(){
                    $('#search_table tbody').off('click', 'tr');
                    $('#search_table tbody').off('click');
                    $('#search_table tbody').on('click', 'tr', function () {
                        var data = window.search_table.row( this ).data();
                        showOrder(data.id);
                    });
                }
            });
        }
    </script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
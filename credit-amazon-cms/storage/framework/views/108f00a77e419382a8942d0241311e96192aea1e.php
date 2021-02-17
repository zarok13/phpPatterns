<?php 
    $pay_methods = config('techplus.pay_methods');
?>


<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="" method="GET">
                    <input type="hidden" name="i" value="1">
                    <div class="row">
                        <div class="col-md-2">
                            <label>დან - </label>
                            <input class="form-control" type="date" name="date_from" value="<?php echo e($date_from); ?>">
                        </div>
                        <div class="col-md-2">
                            <label>- მდე</label>
                            <input class="form-control" type="date" name="date_to" value="<?php echo e($date_to); ?>">
                        </div>

                        <div class="col-md-2">
                            <button class="btn btn-success mt-3">ფილტრი</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">  
        <div class="row">
            <div class="col-md-12">
                <table class="table" id="unipay_table">
                    <thead >
                        <tr>
                            <th>ID</th>
                            <th>ტრანზაქციის თარიღი</th>
                            <th>Unipay ID</th>
                            <th>ტრანზაქციის სტატუსი</th>
                            <th>განაცხადის თარიღი</th>
                            <th>განაცხადის სტატუსი</th>
                            <th>გადახდის მეთოდი</th>
                            <th>აქტიური</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td onclick="showOrder(<?php echo e($d->request_id); ?>)"><?php echo e($d->request_id); ?></td>
                                <td><?php echo e(isset($d->unipay_date) ? $d->unipay_date : '-'); ?></td>
                                <td><?php echo e(isset($d->hash) ? $d->hash : '-'); ?></td>
                                <td><?php echo e(isset($d->unipay_status) ? $d->unipay_status : '-'); ?></td>
                                <td><?php echo e($d->techplus_date ? $d->techplus_date : $d->request->created_at); ?></td>
                                <td><?php echo e(isset($d->request->innerStatus[0]) ? $d->request->innerStatus[0]->name : '-'); ?></td>
                                <td><?php echo e(isset($pay_methods[$d->pay_method]) ? $pay_methods[$d->pay_method] : '-'); ?></td>
                                <td><label class="label label-<?php echo e($d->disabled !== 0 ? 'danger' : 'success'); ?>"><?php echo e($d->disabled !== 0 ? 'არა' : 'კი'); ?></label></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot>
                        
                    </tfoot>  
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-example-modal-lg" id="View_Modal"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;"></div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#unipay_table').DataTable({
            pageLength: 300,
        })
    });

    function showOrder(order_id){
        $.ajax({
            type: "GET",
            url: "/techplus/showrequest/"+order_id+'/',
            success: function (response) {
                $('#open_modal_button').css('display', 'inline-block ');
                $('#View_Modal').html(response);
                $('#View_Modal').modal('toggle');

                
                html = $("#modals-here").html();
                $('body').append(html);
                $("#modals-here").remove();
            }
        });
    }
</script>

<style type="text/css">
    .col-md-12 {
        margin-bottom: 0 !important;
    }
</style>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('scripts'); ?>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js"></script>
    

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link href="https://cdn.datatables.net/select/1.2.7/css/select.dataTables.min.css" rel="stylesheet" type="text/css" />
    

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css" rel="stylesheet" type="text/css">
    <script src="/assets/node_modules/toast-master/js/jquery.toast.js"></script> 
    <link href="/assets/node_modules/toast-master/css/jquery.toast.css" rel="stylesheet">

    <style>
        .thead, .sorting, .sorting_asc, .sorting_desc{
            background: var(--table-th-color-bg) !important;
        }
        tbody tr {
            cursor: zoom-in !important;
        }
        table.dataTable thead .sorting_asc:after {
            display: none;
        }
        /* thead tr {
            visibility: collapse;
        } */
        .dataTables_scrollBody table thead tr {
            visibility: collapse;
        }
        .rowCheckbox {
            width: 20px;
            height: 20px;
        }

        .even {
            background: #f1f1f1;
        }
        
        .odd {
            background: #c3c3c3;
        }

        .even:hover,
        .odd:hover {
            background: #cacaca !important;
        }
        
        .rowCheckbox {
            width: 17px;
            height: 16px;
        }
        .highlight {
            background-color:yellowgreen !important;
            
        }
        .hidden:not(.highlight) {
            display: none;
        }
        body {
            font-size: 13px !important
        }
        .small-text {
            min-width: 100px;
            font-size: 11px !important;
            word-break: break-all;
            display: block;
        }
        .buttons-columnVisibility.active {
            background-color: #528042 !important
        }
    </style>

    <?php echo $__env->make('techplus.buypage.multipleeditmodal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.techplus', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
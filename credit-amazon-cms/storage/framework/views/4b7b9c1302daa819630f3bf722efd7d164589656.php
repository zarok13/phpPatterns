<?php ($isAdmin = false); ?>

<?php if (\Entrust::hasRole(['SUPER_ADMIN'])) : ?>
    <?php ($isAdmin = true); ?>
<?php endif; // Entrust::hasRole ?>

<?php $__env->startSection('scripts'); ?>
    <script src="/assets/node_modules/sweetalert/sweetalert.min.js"></script>
    <script type="text/javascript" src="/assets/node_modules/multiselect/js/jquery.multi-select.js"></script>
    <link href="/assets/node_modules/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
    <link href="/assets/node_modules/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <script src="/assets/node_modules/toast-master/js/jquery.toast.js"></script>
    <script src="//cdn.datatables.net/plug-ins/1.10.19/api/sum().js"></script>
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

    <div class="row">
        <div class="col-md-12" >
            <div class="card">
                <div class="card-header">
                    <form method="get" action='#' id="filterform">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-12" style="margin: 0">
                                <div class="form-group">
                                    <input type="date" class="form-control col-lg-2" name="date_from" 
                                        value="<?php echo e(isset($request->date_from) ? $request->date_from : \Carbon\Carbon::now()->subDay(104)->format('Y-m-d')); ?>">
                                    <input type="date" class="form-control col-lg-2" name="date_to" 
                                        value="<?php echo e(isset($request->date_to) ? $request->date_to : \Carbon\Carbon::now()->subDay(104)->format('Y-m-d')); ?>">

                                    <button class="btn btn-success" id="filterbutton">გაფილტვრა</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="list-group">
                                <a href="javascript:void(0)" class="list-group-item">საყიდელია ნივთები დღეს <span class="pull-right" id="buy_item_count_creditamazon_today"></span> </a>
                                <a href="javascript:void(0)" class="list-group-item">საყიდელია ნივთები გუშინ <span class="pull-right" id="buy_item_count_creditamazon_yesterday"></span> </a>
                                <a href="javascript:void(0)" class="list-group-item">საყიდელია ნივთები ტექპლიუსზე დღეს <span class="pull-right" id="buy_item_count_techplus_today"></span> </a>
                                <a href="javascript:void(0)" class="list-group-item">საყიდელია ნივთები ტექპლიუსზე გუშინ <span class="pull-right" id="buy_item_count_techplus_yesterday"></span> </a>
                            </div>    
                        </div>
                    </div>
                </div>


            </div>
        </div>

    </div>



    <script>
        var actionroute  = '<?php echo e(route('reports.other.actions')); ?>';

        $(document).ready(function(){
            window.from_date = $('input[name="date_from"]').val()
            window.to_date = $('input[name="date_to"]').val()
            getbuyitemsreportcreditamazon();
            getbuyitemsreportechplus();
        })

        /*buy_item_count_creditamazon_today
        buy_item_count_creditamazon_yesterday
        buy_item_count_techplus_today
        buy_item_count_techplus_yesterday*/
        
        getbuyitemsreportcreditamazon = function(){
            getReport('buy_item_count_creditamazon_today', function(data){
                $('#buy_item_count_creditamazon_today').html(data.data);
            });

            getReport('buy_item_count_creditamazon_yesterday', function(data){
                $('#buy_item_count_creditamazon_yesterday').html(data.data);
            });
        }


        getbuyitemsreportechplus = function(){
            
            getReport('buy_item_count_techplus_today', function(data){
                $('#buy_item_count_techplus_today').html(data.data);
            });

            getReport('buy_item_count_techplus_yesterday', function(data){
                $('#buy_item_count_techplus_yesterday').html(data.data);
            });

        }


        getReport = function(action, callback = null, data = {from_date: window.from_date, to_date: window.to_date} ){
            window.loader = false;

            $.ajax({
                url: actionroute,
                data: {i:1, action: action, ...data},
                success: function(d){
                    if(callback && d.success) {
                        callback(d);
                    }
                }
            });

            window.loader = true;
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->startSection('content'); ?>

    <div class="card" >
        <div class="card-header" >
            
            <form method="get" action="<?php echo e(route('techplus.reports.byitems')); ?>" id="filterform">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-md-12" style="margin: 0">
                        <div class="form-group">
                            <input type="date" class="form-control col-lg-2" name="date_from" 
                                value="<?php echo e(isset($request->date_from) ? $request->date_from : \Carbon\Carbon::now()->subDay(1)->format('Y-m-d')); ?>">
                            <input type="date" class="form-control col-lg-2" name="date_to" 
                                value="<?php echo e(isset($request->date_to) ? $request->date_to : \Carbon\Carbon::now()->format('Y-m-d')); ?>">
                        </div>
                    </div>
                </div>

                <div class="col-md-12" style="margin: 0">
                                      
                    <div class="btn-group" id="inner_statuses_div" data-toggle="buttons" data-visible="0" style="column-count: 4;">
                        <?php ($statuses = \Config::get('techplus.item_statuses')); ?>

                        <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $is): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php ($key = $key+1); ?>
                            <label class="statuslabel btn btn-info inner_status_label">
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" class="custom-control-input inner_status" name="item_statuses[]" value="<?php echo e($key); ?>" >
                                    <label class="custom-control-label" style="cursor: pointer" ><?php echo e($is); ?></label>
                                </div>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12" style="margin: 0">
                        <button class="btn btn-success" id="filterbutton" style="margin-top: 15px;">გაფილტვრა</button>
                    </div>
                </div>
            </form>

        </div>


        <div class="card-body">

            <div class="row">
                <div class="col-md-12" style="margin: 0">
                    <table class="table" id="items_table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>ნივთის სახელი</th>
                                <th>რაოდენობა</th>
                                <th>საიტი</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>

    
    
    

    <script>
    
        var loadUrl = '<?php echo e(route('techplus.reports.byitems.load')); ?>';
        var filterUrl = loadUrl;

        $(document).ready(function(){
            createItemsTable();


            $('#filterbutton').click(function(e){
                e.preventDefault();
                var query = $('#filterform').serialize();
                filterUrl = loadUrl + '?' + query;

                createItemsTable({url: filterUrl});
            })
            
        });


        createItemsTable = function(data = {url: loadUrl}) {
            window.items_table =  $('#items_table').DataTable({
                destroy: true,                
                dom: 'Bfrtip',
                displayLength: 50,
                ajax: data.url,
                columns: [
                    { "data": "id" },  // id
                    { 
                        "data": null, 
                        "render": function(value){
                            return `<a target="_blank" href="${value.site == 'combo.ge' ? 'https://' : 'http://'}${value.site}/index.php?route=product/product&product_id=${value.item_id}"> ${value.name} </a>`; 
                        } 
                    },  // დასახელება
                    { "data": "count" },  // რაოდენობა
                    { "data": "site" },  // საიტი
                ],
                'initComplete': function (){}
            });
        }
    </script>
<?php $__env->stopSection(); ?>







<?php $__env->startSection('scripts'); ?>
	<style>
		.card {border-radius: 5px !important;}
		.expense-table tr td {vertical-align: middle;text-align: center}
		.badge {float: right;font-size: 20px;}
        .container-fluid {padding-bottom: 50px;}
        .form-group {margin-bottom: 10px}
        .showOrder {display: block;width: 100%;height: 100%;cursor: pointer;color: black;transition: 0.2s background-color ease-in-out;}
        .showOrder:hover {background-color: black;color: white;font-weight: bold;}
        .pn:hover span {display: none !important;}
        .pn:hover #copy-button {display: block !important;}
        .copy { display: none; }
        small { font-size: 100% ;}
        .userinfo:not(.selected) {display: none !important}
        .cityli {margin: 0 !important}
        #inner_statuses_switch {cursor: pointer}
        .inner_status_label {width: 100%;margin-bottom: 2px;text-align: left;}
    </style>
    <script src="/assets/node_modules/toast-master/js/jquery.toast.js"></script>
    <script src="/assets/node_modules/raphael/raphael-min.js"></script>
    <script src="/assets/node_modules/morrisjs/morris.js"></script>
    <link href="/assets/node_modules/toast-master/css/jquery.toast.css" rel="stylesheet">
    <link href="/assets/node_modules/morrisjs/morris.css" rel="stylesheet">
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.techplus', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
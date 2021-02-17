<?php $__env->startSection('content'); ?>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-12" style="margin: 0">
                    <div class="form-group">
                        <button class="btn btn-outline-dark" id="add_supplier">მომწოდებლის დამატება</button>
                    </div>

                    <div class="btn-group" data-toggle="buttons">

                    </div>                    
                </div>
            </div>
        </div>
        <div class="card-body"> 
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>სახელი</th>
                        <th>ტელეფონი</th>
                        <th>საკონტაქტო პირი</th>
                        <th>ანგ. ნომერი</th>
                        <th>მისამართი</th>
                        <th>ბუღალტერი</th>
                        <th>იურდ. დასახელება</th>
                        <th>ს/კ</th>
                        <th>?</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $sp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                        <tr id="sup-tr-<?php echo e($sp->id); ?>" class="sp_tr" <?php echo $sp->deleted ? 'style="background: #ca9f9f"' :''; ?>>
                            <td id="id-<?php echo e($sp->id); ?>"><?php echo e($sp->id); ?></td>
                            <td class="sp_name<?php echo e($sp->deleted ? $sp->deleted :''); ?>" data-id="<?php echo e($sp->id); ?>"> <?php echo e($sp->name); ?> </td>
                            <td class="sp_number"> <?php echo e($sp->number); ?> </td>
                            <td class="sp_person"> <?php echo e($sp->person); ?> </td>
                            <td class="sp_bank_account"> <?php echo e($sp->bank_account); ?> </td>
                            <td class="sp_address"> <?php echo e($sp->address); ?> </td>
                            <td class="sp_accountant"> <?php echo e($sp->accountant); ?><?php echo e($sp->accountant_number ? ' / ' . $sp->accountant_number : ''); ?></td>
                            <td class="sp_real_name"> <?php echo e($sp->real_name); ?> </td>
                            <td class="sp_code"> <?php echo e($sp->code); ?> </td>
                            <td> 
                                <i class="fa fa-pencil edit" data-id="<?php echo e($sp->id); ?>"></i> 
                                <i class="fa fa-trash delete" <?php echo $sp->deleted ? 'style="display: none"' :''; ?> data-id="<?php echo e($sp->id); ?>"></i> 
                                <i class="fa fa-recycle restore" style="display: <?php echo !$sp->deleted ? 'none' :'inline-block'; ?>" data-id="<?php echo e($sp->id); ?>"></i> 
                                <?php if (\Entrust::hasRole('SUPER_ADMIN')) : ?>
                                <i class="fa fa-trash deleteforever" data-id="<?php echo e($sp->id); ?>" style="color: #c7c7c7" >
                                <?php endif; // Entrust::hasRole ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        var actionurl = '<?php echo e(route('techplus.suppliers.crud')); ?>';
        var pageurl = '<?php echo e(route('techplus.suppliers.page')); ?>';




        $(document).ready(function(){

            $('.sp_name').click(function(){
                var id  = $(this).data('id');
                return window.open(pageurl + '?s='+id+'&supplier=' + id);
            });



            $('#add_supplier').on('click', function(){
                $.ajax({
                    url: actionurl,
                    type: 'post',
                    data: { i:1, action: 'create' },
                    success: function(response){
                        $('#supplier_modal').html(response);
                        $('#supplier_modal').modal("toggle");
                    }
                });
            }); 
            
            
            $('.edit').on('click', function(){
                var id = $(this).data('id');
                $.ajax({
                    url: actionurl,
                    type: 'post',
                    data: { i:1, action: 'edit', id: id },
                    success: function(response){
                        $('#supplier_modal').html(response);
                        $('#supplier_modal').modal("toggle");
                    }
                });
            });
            
            $('.deleteforever').on('click', function(){

                if(!confirm('დარწმუნებული ხართ რომ გსურთ ამ მომწოდებლის წაშლა?')) return;
                if(!confirm('დაადასტურეთ კიდევ ერთხელ')) return;

                var id = $(this).data('id');
                $.ajax({
                    url: actionurl,
                    type: 'post',
                    data: { i:1, action: 'deleteforever', id: id},
                    success: function(response){
                        document.location.reload();
                    }
                });
            });
            
            $('.delete').on('click', function(){
                var id = $(this).data('id');
                
                $.ajax({
                    url: actionurl,
                    type: 'post',
                    data: { i:1, action: 'delete', id: id },
                    success: function(response){
                        document.location.reload();
                    }
                });
            });
            $('.restore').on('click', function(){
            
                var id = $(this).data('id');
                $.ajax({
                    url: actionurl,
                    type: 'post',
                    data: { i:1, action: 'restore', id: id },
                    success: function(response){
                        document.location.reload();
                    }
                });
            });
        });
    </script>
    
    <div class="modal fade bs-example-modal-lg" id="View_Modal"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;"></div>


    <div id="supplier_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;"></div>
    <div id="supplier_info_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;"></div>


    
<?php $__env->stopSection(); ?>



<?php $__env->startSection('scripts'); ?>
	<style>
		.card {
			border-radius: 5px !important;
		}
		.expense-table tr td {
			vertical-align: middle;
			text-align: center
		}
		.badge {
			float: right;
			font-size: 20px;
		}
        .container-fluid {
            padding-bottom: 50px;
        }
        .form-group {
            margin-bottom: 10px
        }
        .showOrder {
            display: block;
            width: 100%;
            height: 100%;
            cursor: pointer;
            color: black;
            transition: 0.2s background-color ease-in-out;
        }
        .showOrder:hover {
            background-color: black;
            color: white;
            font-weight: bold;
        }

        .pn:hover span {
            display: none !important;
        }
        .pn:hover #copy-button {
            display: block !important;
        }
        .fa.delete {
            color: red;
        }
        .fa {
            margin-left: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .sp_name:hover {
            cursor: pointer;
            background: #c9c9c9
        }
    </style>
    <script src="/assets/node_modules/toast-master/js/jquery.toast.js"></script>
    <link href="/assets/node_modules/toast-master/css/jquery.toast.css" rel="stylesheet">
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.techplus', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
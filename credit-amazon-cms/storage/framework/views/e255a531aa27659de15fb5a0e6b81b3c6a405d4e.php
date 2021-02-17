<?php $__env->startSection('breadcumb', 'სტატუსები'); ?>
<?php $__env->startSection('scripts'); ?>
    <script src="/assets/node_modules/sweetalert/sweetalert.min.js"></script>
    <script type="text/javascript" src="/assets/node_modules/multiselect/js/jquery.multi-select.js"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('styles'); ?>
    <link href="/assets/node_modules/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
    <link href="/assets/node_modules/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    
    <?php if($errors->any()): ?>
        <div class="col-4">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="alert alert-danger alert-rounded"><i class="fa fa-exclamation-triangle"></i>
                    <?php echo e($error); ?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-6">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>სახელი</th>
                        <th>ოპერატორისთვის</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($data['innerStatuses']) > 0): ?>
                        <?php $__currentLoopData = $data['innerStatuses']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $innerstatus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($innerstatus->id); ?></td>
                                <td><?php echo e($innerstatus->name); ?></td>
                                <td><?php echo e($innerstatus->for_operator?'კი':'არა'); ?></td>
                                <td>
                                    <a href="javascript:void(0)" onclick="event.preventDefault(); edit_innerstatus(<?php echo e($innerstatus->id); ?>)" data-toggle="tooltip" data-original-title="ჩასწორება"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                    <a href="javascript:void(0)" onclick="event.preventDefault(); delete_innerstatus(<?php echo e($innerstatus->id); ?>)" data-toggle="tooltip" data-original-title="წაშლა"> <i class="fa fa-close text-danger"></i> </a>
                                    <form action="<?php echo e(route('admin.innerstatus.destroy', ['id'=>$innerstatus->id])); ?>" method="POST" id="delete-form-<?php echo e($innerstatus->id); ?>" style="display: none;">
                                        <?php echo e(csrf_field()); ?>

                                        <?php echo e(method_field('DELETE')); ?>

                                        <input type="hidden" value="<?php echo e($innerstatus->id); ?>" name="id">
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <script>
                            function edit_innerstatus($id) {
                                $.ajax({
                                    type: "GET",
                                    url: "/admin/innerstatus/"+$id+'/edit',
                                    data: $id,
                                    success: function (response) {
                                        $('#edit_innerstatus_modal').html(response);
                                        $(function () {
                                            $('#edit_innerstatus_modal').modal('toggle');
                                        });
                                    }
                                });
                            }
                            function delete_innerstatus($id) {
                                swal({   
                                    title: "წაშლა",   
                                    text: "დარწმუნებული ხართ რომ გსურთ ამ სტატუსის წაშლა?",   
                                    type: "warning",   
                                    showCancelButton: true,   
                                    confirmButtonColor: "#DD6B55",   
                                    confirmButtonText: "დიახ!",   
                                    cancelButtonText: "არა!",   
                                    closeOnConfirm: false,   
                                    closeOnCancel: true 
                                }, function(isConfirm){   
                                    if (isConfirm) {     
                                        document.getElementById('delete-form-'+$id).submit();
                                        swal("წაშლილია", "წარმატებით წაიშალა", "success");  
                                    } else {     
                                        swal("Cancelled", "Your imaginary file is safe :)", "error");   
                                    } 
                                });
                            }
                        </script>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="button-group">
                <button type="button" class="btn waves-effect waves-light btn-rounded btn-secondary" data-toggle="modal" data-target="#create_innerstatus_modal">დამატება</button>
            </div>
        </div>

        
        <div id="edit_innerstatus_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        </div>


        <div id="create_innerstatus_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">შიდა სტატუსის დამატება</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="col-lg-12">
                            <form method="POST" action="<?php echo e(route('admin.innerstatus.store')); ?>">
                                <?php echo e(csrf_field()); ?>


                                <div class="form-group">
                                    <label for="name">სახელი</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-user-o"></i></span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="სახელი" required="" name="name">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="name">ავსებს თუ არა ოპერატორი</label>
                                    <div class="input-group mb-3">
                                        <select name="for_operator" class="form-control" >
                                            <option value="0" >არა</option>
                                            <option value="1" >კი</option>
                                        </select>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">დამატება</button>
                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">დახურვა</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
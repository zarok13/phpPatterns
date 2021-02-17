<?php ($isOperator = true); ?>

<?php if (\Entrust::hasRole(['SUPER_ADMIN', 'MANAGER'])) : ?>
<?php ($isOperator = false); ?>
<?php endif; // Entrust::hasRole ?>

<div class="tab-pane p-20" id="comments" role="tabpanel">
    <div class="row">
        <div class="col-md-6">
            <ul class="list-group" id="user_comments">
                <?php $__currentLoopData = $order->comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="list-group-item">
                    <h6 class="mt-0 mb-1"><?php echo e($comment->user->name); ?> | <strong><?php echo e($comment->created_at); ?></strong></h6> 
                    <code><?php echo e($comment->text); ?></code>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <div class="col-md-6">
            <ul class="list-group" id="user_comments">
                <?php $__currentLoopData = $order->opens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $op): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="list-group-item">
                        <h6 class="mt-0 mb-1"><?php echo e($op->user->name); ?> | <strong><?php echo e($op->created_at); ?></strong></h6> 
                        <code>განაცხადის გახსნა</code>
                    </li>
                    <?php if($op->time_opened): ?>
                        <li class="list-group-item">
                            <h6 class="mt-0 mb-1"><?php echo e($op->user->name); ?> | <strong><?php echo e($op->updated_at); ?></strong></h6> 
                            <code>განაცხადის დახურვა. <?php if(!$isOperator): ?> დრო: <?php echo e(gmdate('i:s', $op->time_opened)); ?> <?php endif; ?></code>
                        </li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
    <div class="form-group">
        <label for="text"></label>
        <input type="hidden" name="requesti_id" id="request_id" value="<?php echo e($order->id); ?>">
        <textarea name="text" placeholder="შეიყვანეთ კომენტარი" id="text" class="form-control"  rows="3"></textarea>
        <button onclick="save_comment()" class="btn waves-effect text-left" >დამატება</button>
    </div>
</div>


<script>
    function save_comment(){
        $.ajax({
            type: "POST",
            url: "<?php echo e(route('operator.comment.store')); ?>",
            data: { text:$('#text').val(), request_id: $('#request_id_input').val()},
            success: function (response) {
                $('#preloader').css('display', 'none');
                $('#user_comments').append(
                    response.html
                );
            }
        });
    }
</script>

<style type="text/css">
    strong {
        font-weight: bold;
    }
</style>
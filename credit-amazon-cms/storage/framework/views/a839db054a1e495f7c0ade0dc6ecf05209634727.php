<div class="row" style="margin-top: 15px;">
    <div class="col-md-3" >
        <div class="form-group">
            <input type="text"  placeholder="შეხსენების ტექსტი" class="form-control" data-request_id="<?php echo e($id); ?>" id="notification_text">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <input type="text" value="<?php echo e(now()->format('Y-m-d H:i:s')); ?>" class="form-control" data-request_id="<?php echo e($id); ?>" id="notification_date">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <a href="#" class="btn btn-success " onclick="saveNotification()">შეხსენება</a>
        </div>
    </div>
</div>

<?php if(isset($notifications) && count($notifications)): ?>
<table class="table color-bordered-table dark-bordered-table" style="margin-top: 10px;">
    <thead>
        <tr>
            <th>თარიღი</th>
            <th>ოპერატორი</th>
            <th>შეხსენების თარიღი</th>
            <th>გაუქმება</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($notif->created_at); ?></td>
            <td><?php echo e($notif->user ? $notif->user->name : ''); ?></td>
            <td><?php echo e($notif->notification_time); ?></td>
            <td>
                <?php if(Auth::user()->hasRole(['SUPER_ADMIN', 'MANAGER']) || $notif->user_id == Auth::user()->id): ?>
                    <button 
                        class="btn btn-success btn-xs"
                        <?php if($notif->seen): ?> 
                        disabled="true"
                        <?php endif; ?>
                        onclick="remove_notification(<?php echo e($notif->request_id); ?>, <?php echo e($notif->user ? $notif->user->id : 'null'); ?>); $(event.target).attr('disabled', true)" >
                        გაუქმება
                    </button>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php endif; ?>



<script>
    saveNotification = function(){
        var input = $('#notification_date');
        var date = input.val();
        var text = $('#notification_text').val();
        var request_id = input.data('request_id');
        $.ajax({
            url: '<?php echo e(route('operator.savenotification')); ?>',
            type: 'POST',
            data: { i: 1, date: date, request_id: request_id, text: text},
            success: function(data){
                window.notification = true;
                console.log(data);
                if(data.success){
                    swal('შეხსენება შენახულია.');
                }
            }
        });
    }

    remove_notification = function(request_id, user_id){
        $.ajax({
            url: '<?php echo e(route('operator.removenotification')); ?>',
            type: 'POST',
            data: { i: 1, request_id: request_id, user_id: user_id},
            success: function(data){
                console.log(data);
            }
        });
    }
</script>
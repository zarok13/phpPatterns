<h4>სხვა შეკვეთები</h4>
<table class="table color-bordered-table dark-bordered-table">
    <thead>
        <tr>
            <th>#</th>
            <th>ნომერი</th>
            <th>სტატუსი</th>
            <th>თარიღი</th>
            <th>ნიკნეიმი</th>
            <th>ლინკები ssdsd</th>
        </tr>
    </thead>
    <tbody >
        <?php ($already_called = false); ?>
        <form action="#" id="merge_form" >
            <?php if(isset($data['old_requests'])): ?>
                
                <?php $__currentLoopData = $data['old_requests']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $oldrequest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                    <tr <?php echo ($oldrequest->id == $order->id)?'style="background-color: grey"':''; ?> >
                        <?php ($day_count  = \Carbon\Carbon::now()->diffInDays($oldrequest->date)); ?>
                        <td> <input name="merged[]" type="checkbox" value="<?php echo e($oldrequest->id); ?>" > </td>
                        <td><span 
                            
                            <?php if($oldrequest->id != $order->id && Auth::user()->hasRole(['OPERATOR', 'TECHPLUS_OPERATOR']) && $day_count <= 1 && $oldrequest->inner_status_id == 0): ?>
                                <?php (\App\Models\CreditAmazon\Request::where('id', $oldrequest->id)->update(['deleted' => 7])); ?>
                            <?php endif; ?>

                            <?php if($day_count < 7 && $oldrequest->id != $order->id): ?>
                            
                            <?php endif; ?>
                            
                            ><?php echo e($oldrequest->id); ?></span>
                            <?php if($day_count < 7 && $oldrequest->id != $order->id): ?>
                                
                                <input type="hidden" name="destroy_this[]" class="destroy_this" value="<?php echo e($oldrequest->id); ?>">
                            <?php endif; ?>                                                           
                        </td>
                        <td>
                            <?php if((int)$oldrequest->inner_status_id != 0 && (int)$oldrequest->inner_status_id != 999): ?>
                                <?php echo e(\App\Models\InnerStatus::find($oldrequest->inner_status_id)->name); ?>

                            <?php else: ?> 
                                არ აქვს
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($day_count); ?> დღის წინ </td>
                        <td><?php echo e($oldrequest->nickname); ?></td>
                        <td>
                            <?php ($urls = json_decode($oldrequest->url)); ?>
                            <?php if(count($urls) > 0): ?>
                                <?php $__currentLoopData = $urls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo $url; ?>" target="_blank">ლინკი | </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    
                    <?php if($day_count == 0 && $oldrequest->inner_status_id ): ?>
                        <?php ($already_called = $oldrequest->id); ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </form>
    </tbody>
</table>
<button id="merge" class="btn btn-success">გაერთიანება</button>


<?php if($already_called): ?>
<?php
    $log = \App\Models\CreditAmazon\Log::where('request_id', $already_called)->with('user')->first();
    $user = null;
    if($log && $log->user) {
        $user = $log->user->name; 
    }
?>

<?php if(! Auth::user()->hasRole(['SUPER_ADMIN']) && Auth::user()->id != $log->user_id): ?>
<script>
    swal('ამ ნომერთან დღეს უკვე იმუშავა ოპერატორმა - <?php echo e($user); ?>');
</script>
<?php endif; ?>

<?php endif; ?>
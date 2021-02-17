<?php $additionalurls = \App\Models\RequestUrl::where('request_id', $id)->first(); ?> 

<div class="col-md-12 noMargin" style="padding: 0;">
    <h4 class="card-title"><?php echo e($additionalurls ? 'ძველი ' : ''); ?>ლინკები</h4>
    <div class="list-group" style="display: block">
        <?php $__currentLoopData = $urls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="list-group-item"> 
            <a target="_blank" href="<?php echo !str_contains($link, '?') ? $link . '?ct=1' : $link . '&ct=1'; ?>"><?php echo e($link); ?></a>
            <?php if (\Entrust::can(['add_link_to_items'])) : ?>
            <button class="badge badge-info ml-auto add_link" style="cursor: pointer"><i class="fa fa-pencil"></i></button>
            <?php endif; // Entrust::can ?>
        </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <?php if (\Entrust::hasRole(['SUPER_ADMIN'])) : ?>
        
    <?php endif; // Entrust::hasRole ?>

</div>

<?php if($additionalurls): ?>
<div class="col-md-12 noMargin" style="padding: 0;">
    <h4 class="card-title">ჩანაცვლებული ლინკები</h4>
    <div class="list-group" id="edited-link-block" style="display: block">
        <?php $__currentLoopData = $additionalurls->url; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="list-group-item"> 
            <a target="_blank" href="<?php echo url($link, ['ct' => 1]); ?>"><?php echo e($link); ?></a>
            <?php if (\Entrust::can(['add_link_to_items'])) : ?>
            <button class="badge badge-info ml-auto add_link" style="cursor: pointer"><i class="fa fa-pencil"></i></button>
            <?php endif; // Entrust::can ?>
        </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php endif; ?>


<script>
    $(document).ready(function(){
        $('.add_link').off('click');
        $('.add_link').on('click', function(){
            var request_id = $('#request_id_input').val();
            $.ajax({
                url: '<?php echo e(route('operator.request.editurlmodal', ['id' => $id])); ?>',
                type: 'get',
                data: { w:1, request_id: request_id },
                success: function(data){
                    console.log(data);
                    $('body').append(data);
                    $('#edit_url_modal').modal('toggle');
                }
            });
        });
    });
</script>
<div class="row">

    <div class="col-md-6 col-sm-12">
        <table class="table">
            <tr><td>დასახელება:</td> <td> <div class="label label-table label-success"><?php echo e($item->name); ?></div></td></tr>
            <tr><td>ასაღები ფასი:</td> <td> <div class="label label-table label-success"><?php echo e($item->get_price); ?></div></td></tr>
            <tr><td>გასაყიდი ფასი:</td> <td> <div class="label label-table label-success"><?php echo e($item->sell_price); ?></div></td></tr>
        </table>

        
    </div>

    <div class="col-md-6 col-sm-12">
        
        <?php if(count($setitems) > 0): ?>
            <table class="table" id="setitemstable">
                <thead>
                    <tr>
                        <th>სახელი</th> 
                        <th>ასაღები ფასი</th>
                        <th>გასაყიდი ფასი</th>
                        <th>?</th>
                    </tr>
                </thead>
                <?php $__currentLoopData = $setitems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $si): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="setitemrow" id="setitemrow-<?php echo e($si->id); ?>" data-id="<?php echo e($si->id); ?>">
                        <th class="itemname" data-id="<?php echo e($si->id); ?>"><?php echo e($si->name); ?></th>
                        <th><?php echo e($si->get_price); ?></th>
                        <th><?php echo e($si->sell_price); ?></th>
                        <th class="deleteitemcol" data-id="<?php echo e($si->id); ?>">წაშლა</th>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </table>
        <?php else: ?>
            <table class="table" ><thead><tr><td>მოცემული ნივთი არ არის სეტი</td></tr></thead></table>
        <?php endif; ?>

        <button class="btn btn-default" id="add_items_to_set">ნივთის დამატება</button>
        
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.itemname').click(function(e){
            var itemid =  $(this).data('id');
            editItemModal(itemid);
        })

        $('.setitemrow .deleteitemcol').click(function(){
            var itemid =  $(this).data('id');
            if(confirm('დარწმუნებული ხართ რომ გსურთ ამ ნივთის წაშლა სეტიდან?')){
                getWithAjax(itemmodalurl, {partial: 'deleteitemfromset', set_id: selected_item_id, delete_item_id: itemid}, function(resp){
                    if(resp.success) {
                        alert('ნივთი წარმატებით წაიშალა სეტიდან');
                    }
                });
            }
        });


        $("#add_items_to_set").click(function(){
            getWithAjax(itemmodalurl, {partial: 'additemstoset'}, function(resp){
                $('#add_items_to_set_modal').html(resp).modal('toggle');
            });
        });
    })

</script>


<style>
    thead {
        background: #bbbbbb
    }

    .setitemrow:hover {
        background: #bbbbbb;
        cursor: pointer;
    }
    .deleteitemcol:hover {
        background: red;
        cursor: pointer;
    }
</style>
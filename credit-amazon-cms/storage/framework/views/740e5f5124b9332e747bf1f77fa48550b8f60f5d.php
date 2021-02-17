<?php $__env->startSection('content'); ?>

<?php echo $__env->make('stocks.stocksmenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="card">
    <div class="card-header">

        <form actions="" method="get">
            <input type="hidden" name="search" value="true">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>ID</label>
                        <input type="text" name="request_id" value="<?php echo e(request('request_id', null)); ?>" class="form-control">
                    </div>
                </div> 
                <div class="col-md-2">
                    <div class="form-group">
                        <label>სახელი</label>
                        <input type="text" name="name" value="<?php echo e(request('name', null)); ?>" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>გვარი</label>
                        <input type="text" name="lastname" value="<?php echo e(request('lastname', null)); ?>" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>პირადი ნომერი</label>
                        <input type="number" name="personal_id" value="<?php echo e(request('personal_id', null)); ?>" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>ტელეფონის ნომერი</label>
                        <input type="number" name="phone_number" value="<?php echo e(request('phone_number', null)); ?>" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mt-2">
                    <button type="submit" class="btn btn-success">ძებნა</button>
                </div>
            </div>
        </form>
    </div>




    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <th>ID</th>
                        <th>ჩგდს ნომერი</th>
                        <th>თარიღი</th>
                        <th>სახელი</th>
                        <th>შენიშვნა</th>
                        <th>პირადი ნომერი</th>
                        <th>ნივთი</th>
                        <th>ასაღები ფასი</th>
                        <th>გასაყიდი ფასი</th>
                        <th>რაოდენობა</th>
                        <th>სტატუსი</th>
                        <th>რს სტატუსი</th>
                        <th>სტატუსის შეცვლის გარეშე</th>
                        <th>გადაცვლა</th>
                        <th>წუნდებული/?</th>
                        <th>ყველა</th>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr <?php echo $product['returned'] ? 'style="background: red"' : ''; ?>>
                                <td><?php echo e($product['request_id']); ?></td>
                                <td><?php echo e($product['cgd_number']); ?></td>
                                <td><?php echo e($product['date']); ?></td>
                                <td><?php echo e($product['user_name']); ?></td>
                                <td><?php echo e($product['text']); ?></td>
                                <td><?php echo e($product['user_pn']); ?></td>
                                <td><?php echo e($product['name']); ?></td>
                                <td><?php echo e($product['get_price']); ?></td>
                                <td><?php echo e($product['sell_price']); ?></td>
                                <td><?php echo e($product['quantity']); ?></td>
                                <td><?php echo e(isset($statuses[$product['status']-1]) ? $statuses[$product['status']-1] : '-'); ?></td>
                                <td><?php echo e($product['rs_status'] ? 'კი' : 'არა'); ?></td>
                                <td>
                                    <input type="checkbox" onchange="$('#returnitem_<?php echo e($product['id']); ?>').attr('data-no_status', $(event.target).prop('checked'))">
                                </td>
                                <td>
                                    <input type="checkbox" onchange="$('#returnitem_<?php echo e($product['id']); ?>').attr('data-change', $(event.target).prop('checked'))">
                                </td>
                                <td>
                                    <input type="checkbox" onchange="$('#returnitem_<?php echo e($product['id']); ?>').attr('data-defective', $(event.target).prop('checked'))">
                                    <button id="returnitem_<?php echo e($product['id']); ?>" data-request_id="<?php echo e($product['request_id']); ?>" data-no_status="0" data-product_id="<?php echo e($product['id']); ?>" data-defective="0" data-change="0" class="btn btn-xs btn-warning" onclick="returnItem(<?php echo e($product['id']); ?>, event)">დაბრუნება</button>
                                </td>
                                <td>
                                    <button data-request_id="<?php echo e($product['request_id']); ?>" class="btn btn-xs btn-warning all" onclick="returnAllItem(event)">ყველა</button>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
    function returnItem(id, e){
        var defective = $(e.target).data('defective')
        var change = $(e.target).data('change')
        var no_status = $(e.target).data('no_status')
        $.ajax({
            url: '<?php echo e(route('stock.return.item')); ?>',
            data: {i: 1, id: id, defective: defective, change: change, no_status: no_status},
            type: 'POST',
        }).done(function(data){
            $(e.target).attr('disabled', true)
            $(e.target).closest('tr').css({background: 'red'})
        });
    }

    function returnAllItem(e){
        var el = $(e.target)
        var request_id = el.data('request_id')
        var all_items = $(`button[data-request_id="${request_id}"]:not(.all)`)
        
        for(var i=0; i<all_items.length; i++){
            var it = $(all_items[i])
            it.click();
        }
    }
</script>
<?php $__env->stopPush(); ?>


<?php $__env->startPush('styles'); ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.newapp', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
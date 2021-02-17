<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-4 col-xs-12">

        <div class="col-xs-12">
            <table class="table table-hover table-striped table-bordered full-color-table full-dark-table hover-table">
                <tr>
                    <th>რაოდენობა</th>
                    <th>საერთო ფასი</th>
                    <th>გაყიდვების რეითი</th>
                    <th>საშუალო მარჟა</th>
                </tr>
                    <tr>
                        <?php if(!empty($data->withAll) && !empty($data->sellPrice)): ?>
                        <td><?php echo e($data->count); ?></td>
                        <td><?php echo e(round($data->sellPrice)); ?> ლ.</td>
                        <td><?php echo e(round(($data->count / $data->withAll) * 100)); ?> %</td>
                        <td><?php echo e(round(($data->profitPrice / $data->sellPrice) * 100)); ?> %</td>
                        <?php endif; ?>
                    </tr>

            </table>
        </div>
        <div class="col-xs-12">
            <form action="" method="get" style="margin: 20px 0px;">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <input type="date" name="from" id="from">
                    <label for="from">საიდან</label>
                </div>
                <div class="form-group">
                    <input type="date" name="to" id="from">
                    <label for="to">სანამდე</label>
                </div>
                <br>
                <button type="submit" class="btn btn-success">ნახვა</button>
            </form>
        </div>
    </div>
    <div class="col-5">
        <div class="col-xs-12">
        <table class="table table-hover table-striped table-bordered full-color-table full-dark-table hover-table">
            <tr>
                <th>თარიღი</th>
                <th>რაოდენობა</th>
                <th>საერთო ფასი</th>
                <th>გაყიდვების რეითი</th>
                <th>საშუალო მარჟა</th>
            </tr>
                <?php $__currentLoopData = $dataByMonth; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <?php if(!empty($item->withAll) && !empty($item->sellPrice)): ?>
                        <td><?php echo e($item->month); ?></td>
                        <td><?php echo e($item->count); ?></td>
                        <td><?php echo e(round($item->sellPrice)); ?> ლ.</td>
                        <td><?php echo e(round(($item->count / $item->withAll) * 100)); ?> %</td>
                        <td><?php echo e(round(($item->profitPrice / $item->sellPrice) * 100)); ?> %</td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
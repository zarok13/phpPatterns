<?php $__currentLoopData = $product_suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
    <td><?php echo e($s->supplier_name); ?></td>
    <td><?php echo e($s->quantity); ?></td>
    <td><?php echo e($s->defective); ?></td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
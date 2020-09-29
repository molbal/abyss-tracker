<div class="card card-body border-0 shadow-sm">
    <h5 class="font-weight-bold mb-2"><?php echo e($title); ?></h5>
    <table class="table table-striped table-sm m-0 table-hover table-responsive-sm">
        <tr>
            <th>&nbsp;</th>
            <th>Duration</th>
            <th>Abyss type</th>
            <th>Abyss tier</th>
            <th class="text-right">Loot value</th>
            <th class="text-right">Submitted</th>
            <th> &nbsp;</th>
        </tr>
        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $__env->startComponent("components.runs.row", ["item" => $item]); ?> <?php if (isset($__componentOriginalaed723563dcd8a3a44659a384dc19df7ead9bf88)): ?>
<?php $component = $__componentOriginalaed723563dcd8a3a44659a384dc19df7ead9bf88; ?>
<?php unset($__componentOriginalaed723563dcd8a3a44659a384dc19df7ead9bf88); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>
</div>
<div class="card-footer">
    <?php echo $items->links(); ?>

</div>
<?php /**PATH C:\Users\molbal\Documents\JetBrains\abyss-tracker\resources\views/components/runs/list.blade.php ENDPATH**/ ?>

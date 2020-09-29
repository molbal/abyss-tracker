<table class="table table-sm table-responsive-md fit-results">
    <tr>
        <td>&nbsp;</td>
        <td class="text-muted text-left">Name</td>
        <td class="text-muted text-right">Total DPS</td>
        <td class="text-muted text-right">Total rep</td>
        <td class="text-muted text-right">Total ehp</td>
        <td class="text-muted text-right">Max speed</td>
        <td class="text-muted text-right">Total cost</td>
        <td class="text-muted text-right">Runs count</td>
    </tr>
    <?php $__empty_1 = true; $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php $__env->startComponent("components.fits.filter.result-row", ["row" => $row, "admin" => (isset($admin) && $admin==true)]); ?><?php if (isset($__componentOriginal6249636dcfbf7db5a7855ef2ed6b506535273f66)): ?>
<?php $component = $__componentOriginal6249636dcfbf7db5a7855ef2ed6b506535273f66; ?>
<?php unset($__componentOriginal6249636dcfbf7db5a7855ef2ed6b506535273f66); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
            <td colspan="8" class="text-center py-2">No results<br><small><a href="<?php echo e(route("fit_new")); ?>" target="_blank">Upload a new fit</a></small></td>
        </tr>
    <?php endif; ?>
</table>
<?php /**PATH C:\Users\molbal\Documents\JetBrains\abyss-tracker\resources\views/components/fits/filter/result-list.blade.php ENDPATH**/ ?>
<?php if($public): ?>
    <?php echo e($slot); ?>

    <?php else: ?>
<div class="card card-body border-0 shadow-sm mt-3">
    <span class="py-3 text-italic"><img width="<?php echo e($icon_size ?? 32); ?>" height="<?php echo e($icon_size ?? 32); ?>" src="https://img.icons8.com/cotton/<?php echo e($icon_size ?? 32); ?>/000000/delete-shield.png"/> <strong><?php echo e($title); ?></strong> is hidden.</span>
</div>
<?php endif; ?>
<?php /**PATH C:\Users\molbal\Documents\JetBrains\abyss-tracker\resources\views/components/restricted.blade.php ENDPATH**/ ?>
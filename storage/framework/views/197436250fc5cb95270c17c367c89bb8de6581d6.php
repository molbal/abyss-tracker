<tr class="action-hover-only">
    <td>
        <?php echo $item->SHIP_NAME ? "<img src='".\App\Http\Controllers\ThemeController::getShipSizeIconPath($item->HULL_SIZE)."' style='width:20px;height:20px;' alt='Ship class icon'>" : ''; ?>

        <?php echo $item->SURVIVED ? '' : '<img src="/dead.png" data-toggle="tooltip" title="Run failed, ship and capsule lost"/>'; ?>

    </td>
    <td>
        <?php if($item->SHIP_ID === null): ?>
            <em class="font-italic text-black-50 ">Unknown</em>
        <?php else: ?>
            <img src="https://imageserver.eveonline.com/Type/<?php echo e($item->SHIP_ID); ?>_32.png" class="rounded-circle shadow-sm" style="border: 1px solid #fff" height="24px" width="24px" alt="">&nbsp;
            <a class="text-dark" href="<?php echo e(route("search.do", ["ship_id" => $item->SHIP_ID])); ?>"><?php echo e($item->SHIP_NAME); ?></a>
        <?php endif; ?>
    </td>
    <td><img src="types/<?php echo e($item->TYPE); ?>.png" style="width:16px;height:16px;" alt=""> <a class="text-dark" href="<?php echo e(route("search.do", ["type" => $item->TYPE])); ?>"><?php echo e($item->TYPE); ?></a></td>
    <td><img src="tiers/<?php echo e($item->TIER); ?>.png" style="width:16px;height:16px;" alt=""> <a class="text-dark" href="<?php echo e(route("search.do", ["tier" => $item->TIER])); ?>"><?php echo e($item->TIER); ?></a></td>
    <td class="text-right"><?php echo e(number_format($item->LOOT_ISK, 0, " ",",")); ?> ISK</td>
    <td class="text-right">

        <?php if($item->RUNTIME_SECONDS == 0): ?>
            <em class="font-italic text-black-50 ">Unknown</em>
        <?php else: ?>
            <?php echo e(\App\Http\Controllers\TimeHelper::formatSecondsToMMSS($item->RUNTIME_SECONDS ?? 0)); ?>

        <?php endif; ?>
    </td>
    <td class="td-action"><a href="<?php echo e(route("view_single", ["id" => $item->ID])); ?>"
                             title="Open"><img
                src="https://img.icons8.com/small/16/<?php echo e(App\Http\Controllers\ThemeController::getThemedIconColor()); ?>/view-file.png"></a>
    </td>
</tr>
<?php /**PATH C:\Users\molbal\Documents\JetBrains\abyss-tracker\resources\views/components/runs/row-homepage.blade.php ENDPATH**/ ?>
<tr class="action-hover-only">
    <td>
        <?php echo $item->SURVIVED ? '' : '<img src="/dead.png" data-toggle="tooltip" title="Run railed, ship and capsule lost"/>'; ?>

    </td>
    <?php if($item->RUNTIME_SECONDS): ?>
        <td><?php echo e(sprintf("%02d", floor($item->RUNTIME_SECONDS/60))); ?>:<?php echo e(sprintf("%02d", $item->RUNTIME_SECONDS%60)); ?></td>
    <?php else: ?>
        <td class="font-italic">Unknown runtime</td>
    <?php endif; ?>
    <td><img src="types/<?php echo e($item->TYPE); ?>.png" style="width:16px;height:16px;" alt=""> <a class="text-dark" href="<?php echo e(route("search.do", ["type" => $item->TYPE])); ?>"><?php echo e($item->TYPE); ?></a></td>
    <td><img src="tiers/<?php echo e($item->TIER); ?>.png" style="width:16px;height:16px;" alt=""> <a class="text-dark" href="<?php echo e(route("search.do", ["tier" => $item->TIER])); ?>"><?php echo e($item->TIER); ?></a></td>
    <td class="text-right"><?php echo e(number_format($item->LOOT_ISK, 0, " ",",")); ?> ISK</td>
    <td class="text-right"><?php echo e(date("Y-m-d H:i:s", strtotime($item->CREATED_AT))); ?></td>
    <td class="td-action"><a href="<?php echo e(route("view_single", ["id" => $item->ID])); ?>"
                             title="Open"><img
                src="https://img.icons8.com/small/16/<?php echo e(App\Http\Controllers\ThemeController::getThemedIconColor()); ?>/view-file.png"></a>
    </td>
</tr>
<?php /**PATH C:\Users\molbal\Documents\JetBrains\abyss-tracker\resources\views/components/runs/row.blade.php ENDPATH**/ ?>

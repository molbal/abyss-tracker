<tr>
    <td>
        <a href="<?php echo e(route("profile.index", ["id" => $item->CHAR_ID])); ?>" class="<?php echo e(session()->get("login_id") == $item->CHAR_ID ? "text-danger" : "text-dark"); ?>">
            <img src="https://images.evetech.net/characters/<?php echo e($item->CHAR_ID); ?>/portrait?size=32" alt="" style="width: 24px; height: 24px; border: 1px solid white" class="rounded-circle shadow-sm">
            &nbsp;<?php echo e($item->NAME); ?>

        </a></td>
    <td class="text-right" <?php if($item->COUNT==420||$item->COUNT==69): ?> data-toggle="tooltip" title="Nice"  <?php endif; ?>><?php echo e($item->COUNT); ?> runs</td>
</tr>
<?php /**PATH C:\Users\molbal\Documents\JetBrains\abyss-tracker\resources\views/components/leaderboard_char.blade.php ENDPATH**/ ?>
<div class="leaderboard-first mb-2">
    <img src="https://images.evetech.net/characters/<?php echo e($item->CHAR_ID); ?>/portrait?size=128" alt="" style="" class="rounded-circle shadow-sm portrait">
    <img src="https://img.icons8.com/material-sharp/96/<?php echo e(\App\Http\Controllers\ThemeController::getThemedIconColor()); ?>/crown.png" class="crown"/>

        <p class="lead mb-0"><a href="<?php echo e(route("profile.index", ["id" => $item->CHAR_ID])); ?>" class="<?php echo e(session()->get("login_id") == $item->CHAR_ID ? "text-danger" : "text-dark"); ?>"><?php echo e($item->NAME); ?></a></p>
        <span class="d-block" <?php if($item->COUNT==420||$item->COUNT==69): ?> data-toggle="tooltip" title="Nice"  <?php endif; ?>><?php echo e($item->COUNT); ?> runs</span>

</div>
<?php /**PATH C:\Users\molbal\Documents\JetBrains\abyss-tracker\resources\views/components/leaderboard_top.blade.php ENDPATH**/ ?>
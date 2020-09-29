<?php $__env->startSection("browser-title", "Most used ships"); ?>
<?php $__env->startSection("content"); ?>
    <div class="d-flex justify-content-between align-items-start mt-5">
        <h4 class="font-weight-bold"><img src="<?php echo e(\App\Http\Controllers\ThemeController::getShipSizeIconPath('cruiser')); ?>" alt="Cruiser icon" class="titleicon">Most used cruiser
            size ships</h4>
    </div>
    <div class="row mt-3">
        <div class="col-md-6 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <div class="graph-container h-400px"><?php echo $cruiser_chart->container(); ?></div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Most used <?php echo e(count($query_cruiser)); ?> cruiser size ships</h5>
                <table class="table table-sm table-responsive-sm mb-0">
                    <tr>
                        <th class="text-dark font-weight-bold" colspan="2">Ship name</th>
                        <th class="text-dark font-weight-bold">Ship class</th>
                        <th class="text-dark font-weight-bold text-right">Use count</th>
                    </tr>
                    <?php $__currentLoopData = $query_cruiser; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ship): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="text-center"><img src="https://imageserver.eveonline.com/Type/<?php echo e($ship->SHIP_ID); ?>_32.png" class="rounded-circle shadow-sm"
                                                         style="border: 1px solid #fff; width: 24px; height: 24px" alt=""></td>
                            <td><a href="<?php echo e(route("ship_single", ["id" => $ship->SHIP_ID])); ?>" class="text-dark" data-toggle="tooltip"
                                   title="Open <?php echo e($ship->NAME); ?> summary"><?php echo e($ship->NAME); ?></a></td>
                            <td><a href="<?php echo e(route("fit.search", ["SHIP_GROUP" => $ship->GROUP ?? "unknown group"])); ?>" class="text-dark" data-toggle="tooltip"
                                   title="Show <?php echo e($ship->GROUP ?? "unknown group"); ?> fits"><?php echo e($ship->GROUP ?? "unknown group"); ?></a></td>
                            <td class="text-right"><?php echo e($ship->RUNS); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </table>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-start mt-5">
        <h4 class="font-weight-bold"><img src="<?php echo e(\App\Http\Controllers\ThemeController::getShipSizeIconPath('destroyer')); ?>" alt="Cruiser icon" class="titleicon">Most used destroyer
            size ships</h4>
    </div>
    <div class="row mt-3">
        <div class="col-md-6 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <div class="graph-container h-400px"><?php echo $destroyer_chart->container(); ?></div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Most used <?php echo e(count($query_destroyer)); ?> destroyer size ships</h5>
                <table class="table table-sm table-responsive-sm mb-0">
                    <tr>
                        <th class="text-dark font-weight-bold" colspan="2">Ship name</th>
                        <th class="text-dark font-weight-bold">Ship class</th>
                        <th class="text-dark font-weight-bold text-right">Use count</th>
                    </tr>
                    <?php $__currentLoopData = $query_destroyer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ship): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="text-center"><img src="https://imageserver.eveonline.com/Type/<?php echo e($ship->SHIP_ID); ?>_32.png" class="rounded-circle shadow-sm"
                                                         style="border: 1px solid #fff; width: 24px; height: 24px" alt=""></td>
                            <td><a href="<?php echo e(route("ship_single", ["id" => $ship->SHIP_ID])); ?>" class="text-dark" data-toggle="tooltip"
                                   title="Open <?php echo e($ship->NAME); ?> summary"><?php echo e($ship->NAME); ?></a></td>
                            <td><a href="<?php echo e(route("fit.search", ["SHIP_GROUP" => $ship->GROUP ?? "unknown group"])); ?>" class="text-dark" data-toggle="tooltip"
                                   title="Show <?php echo e($ship->GROUP ?? "unknown group"); ?> fits"><?php echo e($ship->GROUP ?? "unknown group"); ?></a></td>
                            <td class="text-right"><?php echo e($ship->RUNS); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </table>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-start mt-5">
        <h4 class="font-weight-bold"><img src="<?php echo e(\App\Http\Controllers\ThemeController::getShipSizeIconPath('frigate')); ?>" alt="Cruiser icon" class="titleicon">Most used frigate
            size ships</h4>
    </div>
    <div class="row mt-3">
        <div class="col-md-6 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Most used frigates</h5>
                <div class="graph-container h-400px"><?php echo $frigate_chart->container(); ?></div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Most used <?php echo e(count($query_frigate)); ?> frigate size ships</h5>
                <table class="table table-sm table-responsive-sm">
                    <tr>
                        <th class="text-dark font-weight-bold" colspan="2">Ship name</th>
                        <th class="text-dark font-weight-bold">Ship class</th>
                        <th class="text-dark font-weight-bold text-right">Use count</th>
                    </tr>
                    <?php $__currentLoopData = $query_frigate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ship): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="text-center"><img src="https://imageserver.eveonline.com/Type/<?php echo e($ship->SHIP_ID); ?>_32.png" class="rounded-circle shadow-sm"
                                                         style="border: 1px solid #fff; width: 24px; height: 24px" alt=""></td>
                            <td><a href="<?php echo e(route("ship_single", ["id" => $ship->SHIP_ID])); ?>" class="text-dark" data-toggle="tooltip"
                                   title="Open <?php echo e($ship->NAME); ?> summary"><?php echo e($ship->NAME); ?></a></td>
                            <td><a href="<?php echo e(route("fit.search", ["SHIP_GROUP" => $ship->GROUP ?? "unknown group"])); ?>" class="text-dark" data-toggle="tooltip"
                                   title="Show <?php echo e($ship->GROUP ?? "unknown group"); ?> fits"><?php echo e($ship->GROUP ?? "unknown group"); ?></a></td>
                            <td class="text-right"><?php echo e($ship->RUNS); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("scripts"); ?>
    <?php echo $cruiser_chart->script(); ?>

    <?php echo $frigate_chart->script(); ?>

    <?php echo $destroyer_chart->script(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make("layout.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\molbal\Documents\JetBrains\abyss-tracker\resources\views/ships.blade.php ENDPATH**/ ?>
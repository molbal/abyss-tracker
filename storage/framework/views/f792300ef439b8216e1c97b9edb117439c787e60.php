<?php $__env->startSection("browser-title", "$name"); ?>
<?php $__env->startSection("content"); ?>
    <div class="row mt-3">
        <div class="col-sm-12 col-md-12">
            <div id="banner" class="shadow-sm w-100">
                <img src="https://images.evetech.net/types/<?php echo e($id); ?>/render?size=256" class="rounded-circle shadow-sm" style="width: 128px; height:128px">
                <h4 class="font-weight-bold"><?php echo e($name); ?>

                </h4>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12 col-sm-12">
            <div class="btn-group float-right" style="position: relative; top: -76px; margin-right: 6px; margin-bottom: -76px">
                <a href="<?php echo e(route("fit.search", ["SHIP_ID" => $id])); ?>"  class="btn btn-secondary">Show fits</a>
                <a href="<?php echo e(route("search.do", ["ship_id" => $id])); ?>"  class="btn btn-secondary">Show all runs</a>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Popularity over the last 3 months <small class="float-right">This graph shows the percentage of Abyss runs using/day using a <?php echo e($name); ?></small></h5>
                <?php echo $pop_chart->container(); ?>

            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Ship usage by tier</h5>
                <?php echo $pop_tiers->container(); ?>

            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Ship usage by weather</h5>
                <?php echo $pop_types->container(); ?>

            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-xs-12 col-sm-8">
        <?php $__env->startComponent("components.runs.list", ['title' => "Last $name runs", 'items' => $items]); ?> <?php if (isset($__componentOriginal04b139426854f4998ac33e8f1486fcc3084fd202)): ?>
<?php $component = $__componentOriginal04b139426854f4998ac33e8f1486fcc3084fd202; ?>
<?php unset($__componentOriginal04b139426854f4998ac33e8f1486fcc3084fd202); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
        </div>

        <div class="col-xs-12 col-sm-4">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Death reasons</h5>
                <?php echo $death_chart->container(); ?>

            </div>
            <div class="card card-body border-0 shadow-sm mt-3">
                <h5 class="font-weight-bold mb-2">Looting strategy</h5>
                <?php echo $loot_chart->container(); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("scripts"); ?>
    <?php echo $pop_chart->script(); ?>

    <?php echo $pop_tiers->script(); ?>

    <?php echo $pop_types->script(); ?>

    <?php echo $death_chart->script(); ?>

    <?php echo $loot_chart->script(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make("layout.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\molbal\Documents\JetBrains\abyss-tracker\resources\views/ship.blade.php ENDPATH**/ ?>
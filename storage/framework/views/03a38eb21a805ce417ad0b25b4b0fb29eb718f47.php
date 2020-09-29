
<?php $__env->startSection("browser-title", "Home"); ?>
<?php $__env->startSection("content"); ?>
    <div class="d-flex justify-content-between align-items-start mt-5">
        <h4 class="font-weight-bold">Welcome to Veetor's Abyss Loot Tracker</h4>
        <p>Home of <?php echo e($abyss_num); ?> saved runs (<?php echo e($today_num); ?> new today)</p>
    </div>

    <div class="row mt-3">
        <div class="col-xs-12 col-sm-12 col-md-8 row">


            
            <div class="col-xs-12 col-md-6">
                <div class="card card-body border-0 shadow-sm p-0 mb-3">
                    <img src="<?php echo e(asset('home/1.5.5.jpg')); ?>" alt="1.5.5 released" class="w-100 rounded-top shadow-sm" style="min-height: 170px;">
                    <div class="p-3 text-center">
                        <a href="<?php echo e(route('changelog')); ?>" class="font-weight-bold h5 text-dark">Abyss Tracker updated to 1.5.5</a>
                        <p class="mb-0">See changes and new features</p>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6">
                <div class="card card-body border-0 shadow-sm p-0 mb-3">
                    <img src="<?php echo e(asset('home/alliance-open.jpg')); ?>" alt="Alliance Open" class="w-100 rounded-top shadow-sm" style="min-height: 170px;">
                    <div class="p-3 text-center">
                        <a href="https://open.eve-nt.uk" target="_blank" class="font-weight-bold h5 text-dark">EVE-NT Alliance Open</a>
                        <p class="mb-0">We made our own Alliance Tournament with 200000+ PLEX in the prizes</p>
                    </div>
                </div>
            </div>
            


            

            <div class="col-md-12 col-sm-12">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="tab-head-distribution" data-toggle="tab" href="#tab-distribution" role="tab" aria-controls="home" aria-selected="true">Loot values</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="tab-head-activity" data-toggle="tab" href="#tab-activity" role="tab" aria-controls="profile" aria-selected="false">Abyss activity (daily)</a>
                    </li>
                </ul>
                <div class="card card-body border-0 shadow-sm top-left-no-round">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="tab-distribution" role="tabpanel" aria-labelledby="tab-head-distribution">
                            <div class="graph-container h-400px">
                                <?php echo $lootDistributionCruiser->container();; ?>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-activity" role="tabpanel" aria-labelledby="tab-head-activity">
                            <div class="graph-container h-400px">
                                <?php echo $daily_add_chart->container();; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        <div class="col-xs-12 col-sm-12 col-md-4">
            <div class="card card-body border-0 shadow-sm pb-2">
                <div class="donor">
                    <img src="https://images.evetech.net/characters/<?php echo e($ingame_last->CHAR_ID); ?>/portrait?size=128"  class="portrait rounded-circle shadow-sm" alt="">
                    <p class="h5 font-weight-bold mb-0 mt-2"><?php echo e($ingame_last->NAME); ?></p>
                    <span style="font-size: 0.7rem" class="text-uppercase">Donated <?php echo e(number_format($ingame_last->AMOUNT, 0, ",", " ")); ?> ISK <?php echo e(\App\Http\Controllers\TimeHelper::timeElapsedString($ingame_last->DATE)); ?></span>
                    <?php if(trim($ingame_last->REASON) != ""): ?>
                        <blockquote class="donation">&bdquo;<?php echo e($ingame_last->REASON); ?>&ldquo;</blockquote>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-footer shadow-sm">
                <a href="<?php echo e(route("donors.index")); ?>" class="text-dark" target="_blank"><img class="tinyicon mr-1" src="https://img.icons8.com/material-sharp/24/<?php echo e(App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)); ?>/receive-cash.png">Donate ingame</a>
            </div>

            <div class="mt-3 card card-body border-0 shadow-sm pb-2">
                <div class="donor">
                    <span>Last Patreon donor</span>
                    <p class="h4 font-weight-bold mb-0"><?php echo e($patreon_last->name); ?> (<?php echo e($patreon_last->monthly_donation); ?> €/m)</p>
                    <span style="font-size: 0.7rem" class="text-uppercase">joined <?php echo e(\App\Http\Controllers\TimeHelper::timeElapsedString($patreon_last->joined)); ?></span>
                </div>
            </div>
            <div class="card-footer shadow-sm">
                <a href="https://patreon.com/veetor" class="text-dark" target="_blank"><img class="tinyicon mr-1" src="https://img.icons8.com/material-sharp/24/<?php echo e(App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)); ?>/patreon.png">Support us on Patreon</a>
            </div>


            <div class="mt-3 card card-body border-0 shadow-sm text-center">
                <h4 class="font-weight-bold"><img class="smallicon bringupper mr-1" src="https://img.icons8.com/small/32/<?php echo e(App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)); ?>/info.png"/> Overview pages</h4>

                <table class="ml-auto mr-auto">
                <?php for($i = 1; $i <=5; $i++): ?>
                    <tr cellpadding="1">
                        <td><a href="<?php echo e(route('infopage.tier',['tier' => $i])); ?>" class="text-dark"><img class="smallicon" src="<?php echo e(asset("tiers/{$i}.png")); ?>" alt=""></a></td>
                        <td class="text-left"><a href="<?php echo e(route('infopage.tier',['tier' => $i])); ?>" class="text-dark"><?php echo app('translator')->get('tiers.'.$i); ?> difficulty overview</a></td>
                    </tr>
                <?php endfor; ?>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-start mt-5">
        <h4 class="font-weight-bold">Active contributors</h4>
        <a class="text-dark"
           href="<?php echo e(route("leaderboard.index")); ?>">
            <img src="https://img.icons8.com/small/24/<?php echo e(App\Http\Controllers\ThemeController::getThemedNavBarIconColor("leaderboard.index" == Route::currentRouteName())); ?>/trophy.png" class="tinyicon bringupper mr-1">Leaderboard</a>
    </div>
    <div class="row mt-4">
        <div class="col-md-4 col-sm-12">
            <div class="d-flex justify-content-between">
                <h5 class="font-weight-bold mb-2">Top 10</h5>
                <small>(last 90 days)</small>
            </div>
            <div class="card card-body border-0 shadow-sm leaderboard">
                <?php if(count($leaderboard_90)>0): ?>
                    <?php $__env->startComponent("components.leaderboard_top", ['item' => $leaderboard_90[0]]); ?><?php if (isset($__componentOriginalbc84e38f8957a8ceccb1848cec64279c617eacfc)): ?>
<?php $component = $__componentOriginalbc84e38f8957a8ceccb1848cec64279c617eacfc; ?>
<?php unset($__componentOriginalbc84e38f8957a8ceccb1848cec64279c617eacfc); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
                <?php endif; ?>
                <table class="table table-sm table-responsive-sm mb-0">
                    <thead>
                    <?php $__empty_1 = true; $__currentLoopData = $leaderboard_90; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php if($i ==0): ?> <?php continue; ?> <?php endif; ?>
                        <?php $__env->startComponent("components.leaderboard_char", ['item' => $l]); ?> <?php if (isset($__componentOriginal3a9b754cd250200ca0f3769785a5ef96be14d96c)): ?>
<?php $component = $__componentOriginal3a9b754cd250200ca0f3769785a5ef96be14d96c; ?>
<?php unset($__componentOriginal3a9b754cd250200ca0f3769785a5ef96be14d96c); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="2"><p class="text-center py-3">Noone here yet!</p></td>
                        </tr>
                    <?php endif; ?>
                    </thead>
                </table>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="d-flex justify-content-between">
                <h5 class="font-weight-bold mb-2">Top 10</h5>
                <small>(last 30 days)</small>
            </div>
            <div class="card card-body border-0 shadow-sm leaderboard">
                <?php if(count($leaderboard_30)>0): ?>
                    <?php $__env->startComponent("components.leaderboard_top", ['item' => $leaderboard_30[0]]); ?><?php if (isset($__componentOriginalbc84e38f8957a8ceccb1848cec64279c617eacfc)): ?>
<?php $component = $__componentOriginalbc84e38f8957a8ceccb1848cec64279c617eacfc; ?>
<?php unset($__componentOriginalbc84e38f8957a8ceccb1848cec64279c617eacfc); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
                <?php endif; ?>
                <table class="table table-sm table-responsive-sm mb-0">
                    <thead>
                    <?php $__empty_1 = true; $__currentLoopData = $leaderboard_30; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php if($i ==0): ?> <?php continue; ?> <?php endif; ?>
                        <?php $__env->startComponent("components.leaderboard_char", ['item' => $l]); ?><?php if (isset($__componentOriginal3a9b754cd250200ca0f3769785a5ef96be14d96c)): ?>
<?php $component = $__componentOriginal3a9b754cd250200ca0f3769785a5ef96be14d96c; ?>
<?php unset($__componentOriginal3a9b754cd250200ca0f3769785a5ef96be14d96c); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="2"><p class="text-center py-3">Noone here yet!</p></td>
                        </tr>
                    <?php endif; ?>
                    </thead>
                </table>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="d-flex justify-content-between">
                <h5 class="font-weight-bold mb-2">Top 10</h5>
                <small>(last 7 days)</small>
            </div>
            <div class="card card-body border-0 shadow-sm leaderboard">
                <?php if(count($leaderboard_07)>0): ?>
                    <?php $__env->startComponent("components.leaderboard_top", ['item' => $leaderboard_07[0]]); ?><?php if (isset($__componentOriginalbc84e38f8957a8ceccb1848cec64279c617eacfc)): ?>
<?php $component = $__componentOriginalbc84e38f8957a8ceccb1848cec64279c617eacfc; ?>
<?php unset($__componentOriginalbc84e38f8957a8ceccb1848cec64279c617eacfc); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
                <?php endif; ?>
                <table class="table table-sm table-responsive-sm mb-0">
                    <thead>
                    <?php $__empty_1 = true; $__currentLoopData = $leaderboard_07; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php if($i ==0): ?> <?php continue; ?> <?php endif; ?>
                        <?php $__env->startComponent("components.leaderboard_char", ['item' => $l]); ?><?php if (isset($__componentOriginal3a9b754cd250200ca0f3769785a5ef96be14d96c)): ?>
<?php $component = $__componentOriginal3a9b754cd250200ca0f3769785a5ef96be14d96c; ?>
<?php unset($__componentOriginal3a9b754cd250200ca0f3769785a5ef96be14d96c); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="2"><p class="text-center py-3">Noone here yet!</p></td>
                        </tr>
                    <?php endif; ?>
                    </thead>
                </table>
            </div>
        </div>
    </div>







    <div class="d-flex justify-content-between align-items-start mt-5">
        <h4 class="font-weight-bold">Ship fits for the Abyss</h4>
        <a class="text-dark"
           href="<?php echo e(route("fit.index")); ?>">
            <img src="https://img.icons8.com/small/24/<?php echo e(App\Http\Controllers\ThemeController::getThemedNavBarIconColor("leaderboard.index" == Route::currentRouteName())); ?>/job.png" class="tinyicon bringupper mr-1">All fits</a>
    </div>

<div class="row mt-3">
    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="card card-body border-0 shadow-sm">
            <h5 class="font-weight-bold mb-2">Most popular hulls</h5>
            <div class="graph-container h-300px">
                <?php echo $popularShipsGraph->container();; ?>

            </div>
        </div>
        <div class="card card-body border-0 shadow-sm mt-3">
            <h5 class="font-weight-bold mb-2">Most popular classes</h5>
            <div class="graph-container h-300px">
                <?php echo $popularClassesGraph->container();; ?>

            </div>
        </div>
    </div>
    <div class="col-md-9 col-sm-12 col-xs-12">
        <ul class="nav nav-tabs" id="fits-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="tab-head-fits-popular" data-toggle="tab" href="#tab-fits-popular" role="tab" aria-controls="home" aria-selected="true">Most popular fits</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="tab-head-fits-new" data-toggle="tab" href="#tab-fits-new" role="tab" aria-controls="profile" aria-selected="false">Newest fits</a>
            </li>
        </ul>
        <div class="card card-body border-0 shadow-sm top-left-no-round">
            <div class="tab-content" id="fits-tab-content">
                <div class="tab-pane fade show active" id="tab-fits-popular" role="tabpanel" aria-labelledby="tab-head-distribution">
                    <?php $__env->startComponent("components.fits.filter.result-list", ["results" => $popularFits]); ?><?php if (isset($__componentOriginalf73353f45790c6624a0f12e26102db942f470667)): ?>
<?php $component = $__componentOriginalf73353f45790c6624a0f12e26102db942f470667; ?>
<?php unset($__componentOriginalf73353f45790c6624a0f12e26102db942f470667); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
                    <div class="">
                        <a class="text-dark" href="<?php echo e(route("fit.search", ['ORDER_BY' => 'RUNS_COUNT', 'DIRECTION' => 'DESC'])); ?>"><img class="tinyicon mr-1" src="https://img.icons8.com/small/24/<?php echo e(App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)); ?>/job.png">View more popular fits</a>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-fits-new" role="tabpanel" aria-labelledby="tab-head-activity">
                    <?php $__env->startComponent("components.fits.filter.result-list", ["results" => $newFits]); ?><?php if (isset($__componentOriginalf73353f45790c6624a0f12e26102db942f470667)): ?>
<?php $component = $__componentOriginalf73353f45790c6624a0f12e26102db942f470667; ?>
<?php unset($__componentOriginalf73353f45790c6624a0f12e26102db942f470667); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
                    <div class="">
                        <a class="text-dark" href="<?php echo e(route("fit.search", ['ORDER_BY' => 'Submitted', 'ORDER_BY_ORDER' => 'ASC'])); ?>"><img class="tinyicon mr-1" src="https://img.icons8.com/small/24/<?php echo e(App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)); ?>/job.png">View more new fits</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>







    <div class="d-flex justify-content-between align-items-start mt-5">
        <h4 class="font-weight-bold">Last added submissions</h4>
        <a class="text-dark"
           href="<?php echo e(route("runs")); ?>">
            <img src="https://img.icons8.com/small/24/<?php echo e(App\Http\Controllers\ThemeController::getThemedNavBarIconColor("leaderboard.index" == Route::currentRouteName())); ?>/database.png" class="tinyicon bringupper mr-1">All runs</a>
    </div>
    <div class="row mt-3">
        <div class="col-xs-12 col-sm-8">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Last submitted runs</h5>
                <table class="table table-striped table-sm m-0 table-hover table-responsive-sm">
                    <tr>
                        <th>&nbsp;</th>
                        <th>Ship name</th>
                        <th>Abyss type</th>
                        <th>Abyss tier</th>
                        <th class="text-right">Loot value</th>
                        <th class="text-right" colspan="2">Duration</th>
                    </tr>
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $__env->startComponent("components.runs.row-homepage", ['item' => $item]); ?> <?php if (isset($__componentOriginal32e41092611697183b55ca13b9c8901583fc7c81)): ?>
<?php $component = $__componentOriginal32e41092611697183b55ca13b9c8901583fc7c81; ?>
<?php unset($__componentOriginal32e41092611697183b55ca13b9c8901583fc7c81); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </table>
            </div>
            <div class="card-footer">
                <a class="text-dark" href="<?php echo e(route("runs")); ?>"><img class="tinyicon mr-1" src="https://img.icons8.com/small/24/<?php echo e(App\Http\Controllers\ThemeController::getThemedNavBarIconColor("leaderboard.index" == Route::currentRouteName())); ?>/database.png">View all runs</a>
            </div>
        </div>
        <div class="col-xs-12 col-sm-4">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Most frequent drops</h5>
                <?php $__currentLoopData = $drops; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $drop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="d-flex justify-content-start">
                        <img src="https://imageserver.eveonline.com/Type/<?php echo e($drop->ITEM_ID); ?>_32.png"
                             style="width: 32px;height: 32px;" class="mr-2" alt="">
                        <div class="text-left">
                            <span class="font-weight-bold"><a class="text-dark"
                                    href="<?php echo e(route("item_single", ["item_id" => $drop->ITEM_ID])); ?>"><?php echo e($drop->NAME); ?></a></span><br>
                            <small><?php echo e(number_format($drop->PRICE_BUY, 0, ",", " ")); ?> ISK
                                - <?php echo e(number_format($drop->PRICE_SELL, 0, ",", " ")); ?> ISK</small><br>
                            <small><?php echo e(round(min(1,$drop->DROP_CHANCE)*100,2)); ?>% drop chance</small><br>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="card-footer">
                <a class="text-dark" href="<?php echo e(route("item_all")); ?>"><img class="tinyicon mr-1" src="https://img.icons8.com/material-sharp/24/<?php echo e(App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)); ?>/empty-box.png">View drop table</a>
            </div>
        </div>
    </div>


























    <div class="row">
        <div class="col-md-12 col-sm-12 mt-3">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">What is this site?</h5>
                <p class="text-justify">Welcome,<br>
                    This is a website to track and compare your Abyss runs, how much your loot is worth, and what kind of
                    filaments are popular.
                    <br>
                    If you also add your Abyssal deadspace runs we will have a better idea on how much loot spawns in
                    Abyssal sites (which is really hectic).</p>
                <p>Cheers, <br>
                    <img src="https://images.evetech.net/characters/93940047/portrait?size=32" alt=""
                         class="rounded-circle shadow-sm"> Veetor Nara
                </p>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection("styles"); ?>
    <style>

    </style>
    <?php $__env->stopSection(); ?>

<?php $__env->startSection("scripts"); ?>

    <?php echo $popularShipsGraph->script();; ?>

    <?php echo $popularClassesGraph->script();; ?>


    <?php echo $lootDistributionCruiser->script();; ?>

    <?php echo $daily_add_chart->script();; ?>

    <script type="text/javascript">

        $('#tab-head-distribution').on('shown.bs.tab', function (e) {window.<?php echo e($lootDistributionCruiser->id); ?>.resize();});
        $('#tab-head-activity').on('shown.bs.tab', function (e) {window.<?php echo e($daily_add_chart->id); ?>.resize();});
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("layout.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\molbal\Documents\JetBrains\abyss-tracker\resources\views/welcome.blade.php ENDPATH**/ ?>
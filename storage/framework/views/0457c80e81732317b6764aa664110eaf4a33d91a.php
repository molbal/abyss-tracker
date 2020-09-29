
<?php $__env->startSection("browser-title", "My stats (".session()->get("login_name").")"); ?>
<?php $__env->startSection("content"); ?>

    <div class="d-flex justify-content-between align-items-start mb-4 mt-5">
        <h4 class="font-weight-bold"><img
                src="https://images.evetech.net/characters/<?php echo e(session()->get("login_id")); ?>/portrait?size=64" alt=""
                class="rounded-circle shadow-sm"> Stats for <?php echo e(session()->get("login_name")); ?></h4>
    </div>


    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="card card-body shadow-sm border-0">
                <div class="row">
                    <img src="https://img.icons8.com/dusk/64/000000/counter.png" class="pull-left ml-2" style="width:64px;height: 64px">
                    <div class="col">
                        <h2 class="font-weight-bold mb-0"><?php echo e($my_runs); ?></h2>
                        <small class="text-muted font-weight-bold">Runs so far</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card card-body shadow-sm border-0">
                <div class="row">
                    <img src="https://img.icons8.com/dusk/64/000000/average-2.png" class="pull-left ml-2" style="width:64px;height: 64px">
                    <div class="col">
                        <h2 class="font-weight-bold mb-0"><?php echo e(number_format($my_avg_loot/1000000, 2, ".", " ")); ?></h2>
                        <small class="text-muted font-weight-bold">Average loot (Million ISK)</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card card-body shadow-sm border-0">
                <div class="row">
                    <img src="https://img.icons8.com/dusk/64/000000/treasure-chest.png" class="pull-left ml-2" style="width:64px;height: 64px">
                    <div class="col">
                        <h2 class="font-weight-bold mb-0"><?php echo e(number_format($my_sum_loot/1000000, 0, ",", " ")); ?></h2>
                        <small class="text-muted font-weight-bold">Total loot (Million ISK)</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card card-body shadow-sm border-0">
                <div class="row">
                    <img src="https://img.icons8.com/dusk/64/000000/web-shield.png" class="pull-left ml-2" style="width:64px;height: 64px">
                    <div class="col">
                        <h2 class="font-weight-bold mb-0"><?php echo e(sprintf("%1.2f", $my_survival_ratio)); ?> %</h2>
                        <small class="text-muted font-weight-bold">Survival ratio</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card card-body border-0 shadow-sm my-4">
                <h5 class="font-weight-bold mb-2"><img src="https://img.icons8.com/cotton/32/000000/graph-report--v2.png" class="smallicon mr-1"/> Stats for the last 30 days</h5>
                <div class="graph-container h-400px">
                    <?php echo $personal_chart_loot->container();; ?>

                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-sm-9">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold"><img src="https://img.icons8.com/cotton/32/000000/calendar-27--v3.png" class="smallicon mr-1"/> Last 30 days</h5>
                <table class="table table-responsive-sm table-sm">
                    <tr>
                        <th>Day</th>
                        <th class="text-right font-weight-bold">Runs #</th>
                        <th class="text-right font-weight-bold">Avg loot</th>
                        <th class="text-right font-weight-bold">All loot</th>
                        <th class="text-right font-weight-bold">Efficiency</th>
                    </tr>
                    <?php $__empty_1 = true; $__currentLoopData = $activity_daily; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($data[0]->RUN_DATE); ?></td>
                            <td class="text-right"><?php echo e($data[0]->COUNT); ?></td>
                            <td class="text-right"><?php echo e(round($data[0]->AVG/1000000 ?? 0, 2)); ?><?php echo e($data[0]->AVG ? 'M' : ''); ?> ISK</td>
                            <td class="text-right"><?php echo e(round($data[0]->SUM/1000000 ?? 0, 2)); ?><?php echo e($data[0]->AVG ? 'M' : ''); ?> ISK</td>
                            <td class="text-right"><?php echo e(number_format($data[0]->IPH/1000000, 2, ","," ")); ?>M ISK/H</td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center">No data yet</td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold"><img src="https://img.icons8.com/cotton/32/000000/rocket.png" class="smallicon mr-1"/> Actions</h5>
                <ul style="list-style: none" class="p-0">
                    <li><a class="text-dark d-inline-block pb-1" href="<?php echo e(route("new")); ?>" ><img src="https://img.icons8.com/small/24/<?php echo e(App\Http\Controllers\ThemeController::getThemedIconColor()); ?>/new-by-copy.png" class="tinyicon mr-1"/>Add run</a></li>
                    <li><a class="text-dark d-inline-block pb-1" href="<?php echo e(route("fit_new")); ?>" ><img src="_icons/fit-new-<?php echo e(App\Http\Controllers\ThemeController::getThemedIconColor()); ?>.png" class="tinyicon mr-1">New fit</a></li>
                    <li><a class="text-dark d-inline-block pb-1" href="<?php echo e(route("runs_mine")); ?>" ><img src="https://img.icons8.com/small/24/<?php echo e(App\Http\Controllers\ThemeController::getThemedIconColor()); ?>/bulleted-list.png" class="tinyicon mr-1"/>My runs</a></li>
                    <li><a class="text-dark d-inline-block pb-1" href="<?php echo e(route("fit.mine")); ?>" ><img src="https://img.icons8.com/small/24/<?php echo e(App\Http\Controllers\ThemeController::getThemedIconColor()); ?>/scan-stock.png" class="tinyicon mr-1"/>My fits</a></li>
                    <li><a class="text-dark d-inline-block pb-1" href="<?php echo e(route("profile.index", ["id" => session()->get('login_id')])); ?>" ><img src="https://img.icons8.com/material-sharp/24/<?php echo e(App\Http\Controllers\ThemeController::getThemedIconColor()); ?>/head-profile.png" class="tinyicon mr-1"/>My public profile</a></li>
                </ul>
            </div>
            <?php $__env->startComponent("components.restricted", ["title" => "Loot query","public" => true]); ?>
                <div class="card card-body border-0 shadow-sm mt-3">
                    <h5 class="font-weight-bold mb-2">Show loot from date</h5>

                    <div class="input-group mb-3">
                        <input type="text" class="form-control daterange">

                        <div class="input-group-append">
                            <button type="button" id="loot_show" class="btn btn-outline-primary">Show</button>
                        </div>
                    </div>
                    <input type="hidden" id="datarangestart" name="from">
                    <input type="hidden" id="datarangestop" name="to">
                </div>
            <?php if (isset($__componentOriginal08c30ea3cc66e2ea5dd11d4784d24006ca5b2ea1)): ?>
<?php $component = $__componentOriginal08c30ea3cc66e2ea5dd11d4784d24006ca5b2ea1; ?>
<?php unset($__componentOriginal08c30ea3cc66e2ea5dd11d4784d24006ca5b2ea1); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group col-md-4">
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("scripts"); ?>
    <?php echo $personal_chart_loot->script();; ?>


    <script type="text/javascript">
        // When ready.
        $(function () {

            $("#loot_show").click(function () {
                var from = $("#datarangestart").val() ? $("#datarangestart").val() : "now";
                var to = $("#datarangestop").val() ? $("#datarangestop").val() : "now";

                window.location = '/char/<?php echo e(session()->get("login_id",0)); ?>/loot/'+from+"/"+to
            });

            $(".daterange").daterangepicker({
                "autoUpdateInput": false,
                "timePicker": false,
                "autoApply": true,
                "showCustomRangeLabel": true,
                "alwaysShowCalendars": true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, function (start, end, label) {
                $(".daterange").val(start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                $("#datarangestart").val(start.format("YYYY-MM-DD"));
                $("#datarangestop").val(end.format("YYYY-MM-DD"));
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("layout.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\molbal\Documents\JetBrains\abyss-tracker\resources\views/home_mine.blade.php ENDPATH**/ ?>
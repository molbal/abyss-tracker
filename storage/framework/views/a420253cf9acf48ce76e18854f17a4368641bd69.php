
<?php $__env->startSection("browser-title", "Fits"); ?>
<?php $__env->startSection("content"); ?>
    <div class="d-flex justify-content-between align-items-start mb-1 mt-5">
        <h4 class="font-weight-bold">Fits</h4>
        <a href="<?php echo e(route("fit_new")); ?>" class="btn btn-outline-secondary">Add new fit</a>
    </div>
    <div class="row mt-3">
        <div class="col-sm-3">
            <?php $__env->startComponent("components.collapse.collapsible-card", ["title" => "Displaying ".$results->count()." fits", 'show' => true, 'icon' => 'search']); ?>
                <p>With the following filters:</p>
                <?php $__empty_1 = true; $__currentLoopData = $filters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <span class="badge badge-secondary m-1 text-wrap" style="font-size: 0.9em"><?php echo e($filter); ?></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p>No filter applied</p>
                <?php endif; ?>
            <?php if (isset($__componentOriginalb242ec0b839716ad31e7fc8a986659f324cf0b11)): ?>
<?php $component = $__componentOriginalb242ec0b839716ad31e7fc8a986659f324cf0b11; ?>
<?php unset($__componentOriginalb242ec0b839716ad31e7fc8a986659f324cf0b11); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>

            <div class="card card-body border-0 shadow-sm mt-3 p-0">
                <a href="<?php echo e(route("fit.index")); ?>" class="btn btn-primary">New search</a>
            </div>

        </div>
        <div class="col-sm-9">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold">Result list</h5>
                <?php $__env->startComponent("components.fits.filter.result-list", ["results" => $results]); ?><?php if (isset($__componentOriginalf73353f45790c6624a0f12e26102db942f470667)): ?>
<?php $component = $__componentOriginalf73353f45790c6624a0f12e26102db942f470667; ?>
<?php unset($__componentOriginalf73353f45790c6624a0f12e26102db942f470667); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection("styles"); ?>
    <style>
        .tag-selector {
            font-size: 20px;
            font-weight: bold;
            text-decoration: none !important;
            border-radius: 100%;
            display: inline-block;
            width: 20px;
            height: 20px;
            cursor: pointer;
            border: 2px solid rgba(0, 0, 0, 0);
            text-align: center;
        }

        .card-header-icon {
            width: 24px;
            height: 24px;
            margin-right: 4px;
        }

        .tag-selector:hover {
            background: rgba(127, 127, 127, 0.5);
            border: 2px solid rgba(127, 127, 127, 0.5);
        }

        .tag-selector > span {
            position: relative;
            top: -6px;
        }

        .tag-selector.active {
            background: #e3342f;
            color: #fff;
            border: 2px solid #e3342f;
            border-radius: 100%;
        }

        table.table.table-sm td {
            border: 0 solid transparent;
        }

        .moveabitdown {
            position: relative;
            top: 3px
        }

        .moveabitup {
            position: relative;
            top: -3px
        }

        .vertical-align-top {
            vertical-align: top;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection("scripts"); ?>
    <script>
        function toggleTag(slot, value, ths) {
            var _this = $(ths);
            console.log(ths, _this);
            let input = $("#" + slot);
            var cv = input.val();

            _this.parent().find("span").removeClass("active");
            if (cv === "") {
                console.log("initial");
                input.val(value);
                _this.addClass('active');
            } else if (cv === value) {
                console.log("equals ", cv, value);
                input.val("");
                _this.removeClass('active');
            } else {
                console.log("different ", cv, value);
                input.val(value);
                _this.addClass('active');
            }
        }

        $(function () {
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("layout.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\molbal\Documents\JetBrains\abyss-tracker\resources\views/components/fits/results.blade.php ENDPATH**/ ?>
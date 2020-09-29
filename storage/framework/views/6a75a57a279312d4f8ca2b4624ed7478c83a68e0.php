<script <?php echo $chart->displayScriptAttributes(); ?>>
    function <?php echo e($chart->id); ?>_create(data) {
        <?php echo e($chart->id); ?>_rendered = true;
        document.getElementById("<?php echo e($chart->id); ?>_loader").style.display = 'none';
        window.<?php echo e($chart->id); ?> = echarts.init(document.getElementById("<?php echo e($chart->id); ?>"),'<?php echo e($chart->theme); ?>');
		window.<?php echo e($chart->id); ?>.setOption({
            series: data,
            <?php echo $chart->formatOptions(false, true); ?>

        });
    }
    <?php if($chart->api_url): ?>
    let <?php echo e($chart->id); ?>_refresh = function (url) {
        document.getElementById("<?php echo e($chart->id); ?>").style.display = 'none';
        document.getElementById("<?php echo e($chart->id); ?>_loader").style.display = 'flex';
        if (typeof url !== 'undefined') {
            <?php echo e($chart->id); ?>_api_url = url;
        }
        
        fetch(<?php echo e($chart->id); ?>_api_url)
            .then(data => data.json())
            .then(data => {
                document.getElementById("<?php echo e($chart->id); ?>_loader").style.display = 'none';
                document.getElementById("<?php echo e($chart->id); ?>").style.display = 'block';
                <?php echo e($chart->id); ?>.setOption({series: data});
            });
    };
    <?php endif; ?>
    <?php echo $__env->make('charts::init', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</script>
<?php /**PATH C:\Users\molbal\Documents\JetBrains\abyss-tracker\vendor\consoletvs\charts\src/Views/echarts/script.blade.php ENDPATH**/ ?>
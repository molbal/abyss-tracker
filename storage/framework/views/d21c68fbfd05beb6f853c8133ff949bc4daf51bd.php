<?php
    $currentRoute = Route::currentRouteName();
?>
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <a class="navbar-brand" href="<?php echo e(route("home")); ?>" data-toggle="tooltip" title="Homepage"><img src="/icon.png" alt=""> <?php echo e(config("app.name")); ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">




            <li class="nav-item">
                <a class="nav-link <?php echo e("search.index" == $currentRoute || "search.do" == $currentRoute ? "active" : ""); ?>"
                   href="<?php echo e(route("search.index")); ?>">
                    <img src="https://img.icons8.com/small/24/<?php echo e(App\Http\Controllers\ThemeController::getThemedNavBarIconColor("search.index" == $currentRoute || "search.index" == $currentRoute)); ?>/search.png">
                Search</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e("item_all" == $currentRoute ? "active" : ""); ?>"
                   href="<?php echo e(route("item_all")); ?>">
                    <img src="https://img.icons8.com/small/24/<?php echo e(App\Http\Controllers\ThemeController::getThemedNavBarIconColor("item_all" == $currentRoute)); ?>/empty-box.png"> Loot table</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e("leaderboard.index" == $currentRoute ? "active" : ""); ?>"
                   href="<?php echo e(route("leaderboard.index")); ?>">
                    <img src="https://img.icons8.com/small/24/<?php echo e(App\Http\Controllers\ThemeController::getThemedNavBarIconColor("leaderboard.index" == $currentRoute)); ?>/trophy.png"> Leaderboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e("ships_all" == $currentRoute ? "active" : ""); ?>"
                   href="<?php echo e(route("ships_all")); ?>">
                    <img src="https://img.icons8.com/small/24/<?php echo e(App\Http\Controllers\ThemeController::getThemedNavBarIconColor("ships_all" == $currentRoute)); ?>/rocket.png"> Ships</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e("fit.index" == $currentRoute ? "active" : ""); ?>"
                   href="<?php echo e(route("fit.index")); ?>">
                    <img src="https://img.icons8.com/small/24/<?php echo e(App\Http\Controllers\ThemeController::getThemedNavBarIconColor("fit.index" == $currentRoute)); ?>/job.png"> Fits</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e("tutorials.index" == $currentRoute ? "active" : ""); ?>"
                   href="<?php echo e(route("tutorials.index")); ?>">
                    <img src="https://img.icons8.com/small/24/<?php echo e(App\Http\Controllers\ThemeController::getThemedNavBarIconColor("tutorials.index" == $currentRoute)); ?>/signpost.png"> Tutorials</a>
            </li>
            <li class="nav-item dropdown <?php echo e("infopage.tier" == $currentRoute ? "active" : ""); ?>" style="list-style: none">
                <a href="#" class="nav-link dropdown-toggle" id="newsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="https://img.icons8.com/small/24/<?php echo e(App\Http\Controllers\ThemeController::getThemedNavBarIconColor("infopage.tier" == $currentRoute)); ?>/info.png"> Overview</a>
                </a>
                <div class="dropdown-menu shadow animate slideIn" aria-labelledby="newsDropdown">
                    <?php for($i=0;$i<=6;$i++): ?>
                    <a href="<?php echo e(route("infopage.tier", ['tier' => $i])); ?>" class="dropdown-item pl-2"><img class="tinyicon mr-1" src="https://img.icons8.com/small/24/<?php echo e(App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)); ?>/info.png"> <?php echo app('translator')->get("tiers.$i"); ?> <small class="bringupper">(Tier <?php echo e($i); ?>)</small></a>
                    <?php endfor; ?>
                </div>
            </li>
            <li class="nav-item dropdown" style="list-style: none">
                <a href="#" class="nav-link dropdown-toggle" id="newsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="https://img.icons8.com/ios/24/<?php echo e(App\Http\Controllers\ThemeController::getThemedNavBarIconColor("changelog" == $currentRoute)); ?>/medical-id.png"> Community <sup>(<?php echo e(config("tracker.version")); ?>)</sup></a>
                </a>
                <div class="dropdown-menu shadow animate slideIn" aria-labelledby="newsDropdown">
                    <a href="<?php echo e(route("changelog")); ?>" class="dropdown-item pl-2"><img class="tinyicon mr-1" src="https://img.icons8.com/ios/24/<?php echo e(App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)); ?>/financial-changes.png"> Changelog</a>
                    <a href="<?php echo e(route("donors.index")); ?>" class="dropdown-item pl-2"><img class="tinyicon mr-1" src="https://img.icons8.com/small/24/<?php echo e(App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)); ?>/like.png"> Donations</a>
                    <a href="<?php echo e(route('community.discord')); ?>" class="dropdown-item pl-2"><img class="tinyicon mr-1" src="https://img.icons8.com/material-sharp/24/<?php echo e(App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)); ?>/discord-logo.png"> Join Abyssal Lurkers</a>
                    <div class="dropdown-divider"></div>
                    <a href="https://github.com/molbal/abyss-tracker/issues" class="dropdown-item pl-2" target="_blank"><img class="tinyicon mr-1" src="https://img.icons8.com/small/24/<?php echo e(App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)); ?>/github.png"> Issue tracker</a>
                    <a href="https://patreon.com/veetor" class="dropdown-item pl-2" target="_blank"><img class="tinyicon mr-1" src="https://img.icons8.com/material-sharp/24/<?php echo e(App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)); ?>/patreon.png"> Patreon</a>
                    <a href="https://uptime.abyss.eve-nt.uk/" class="dropdown-item pl-2" target="_blank"><img class="tinyicon mr-1" src="https://img.icons8.com/material-sharp/24/<?php echo e(App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)); ?>/server-shutdown.png"> Uptime monitor</a>
                </div>
            </li>
        </ul>
            <form class="ml-auto">
            <?php if(session()->has("login_id")): ?>
                <li class="nav-item dropdown" style="list-style: none">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="https://images.evetech.net/characters/<?php echo e(session()->get("login_id")); ?>/portrait?size=32" alt="<?php echo e(session()->get('login_name')); ?>" class="rounded-circle shadow-sm" style="border:1px solid #fff;"> <?php echo e(session()->get('login_name')); ?></a>
                    <div class="dropdown-menu shadow animate slideIn" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item pl-2 <?php echo e("new" == $currentRoute ? "active text-dark" : ""); ?>" href="<?php echo e(route("new")); ?>" ><img src="https://img.icons8.com/small/24/<?php echo e(App\Http\Controllers\ThemeController::getThemedNavBarIconColor("new" == $currentRoute)); ?>/new-by-copy.png" class="tinyicon mr-1"/>Add run</a>
                        <a class="dropdown-item pl-2 <?php echo e("fit_new" == $currentRoute ? "active text-dark" : ""); ?>" href="<?php echo e(route("fit_new")); ?>" ><img src="_icons/fit-new-<?php echo e(App\Http\Controllers\ThemeController::getThemedNavBarIconColor("fit_new" == $currentRoute)); ?>.png" class="tinyicon mr-1">New fit</a>
                        <a class="dropdown-item pl-2 <?php echo e("runs_mine" == $currentRoute ? "active text-dark" : ""); ?>" href="<?php echo e(route("runs_mine")); ?>" ><img src="https://img.icons8.com/small/24/<?php echo e(App\Http\Controllers\ThemeController::getThemedNavBarIconColor("runs_mine" == $currentRoute)); ?>/bulleted-list.png" class="tinyicon mr-1"/>My home</a>
                        <a class="dropdown-item pl-2 <?php echo e("home_mine" == $currentRoute ? "active text-dark" : ""); ?>" href="<?php echo e(route("home_mine")); ?>" ><img src="https://img.icons8.com/small/24/<?php echo e(App\Http\Controllers\ThemeController::getThemedNavBarIconColor("home_mine" == $currentRoute)); ?>/positive-dynamic.png" class="tinyicon mr-1"/>My stats</a>
                        <a class="dropdown-item pl-2 <?php echo e("fit.mine" == $currentRoute ? "active text-dark" : ""); ?>" href="<?php echo e(route("fit.mine")); ?>" ><img src="https://img.icons8.com/small/24/<?php echo e(App\Http\Controllers\ThemeController::getThemedNavBarIconColor("fit.mine" == $currentRoute)); ?>/scan-stock.png" class="tinyicon mr-1"/>My fits</a>
                        <a class="dropdown-item pl-2 <?php echo e("profile.index" == $currentRoute ? "active text-dark" : ""); ?>" href="<?php echo e(route("profile.index", ["id" => session()->get('login_id')])); ?>" ><img src="https://img.icons8.com/material-sharp/24/<?php echo e(App\Http\Controllers\ThemeController::getThemedNavBarIconColor("profile.index" == $currentRoute)); ?>/head-profile.png" class="tinyicon mr-1"/>Public profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item pl-2 <?php echo e("settings.index" == $currentRoute ? "active text-dark" : ""); ?>" href="<?php echo e(route("settings.index")); ?>" ><img src="https://img.icons8.com/small/24/<?php echo e(App\Http\Controllers\ThemeController::getThemedNavBarIconColor("settings.index" == $currentRoute)); ?>/settings.png" class="tinyicon mr-1"/> Settings</a>
                        <a class="dropdown-item pl-2" href="<?php echo e(route("logout")); ?>#"><img src="https://img.icons8.com/small/24/<?php echo e(App\Http\Controllers\ThemeController::getThemedNavBarIconColor("changelog" == $currentRoute)); ?>/logout-rounded.png" class="tinyicon mr-1"/> Log out</a>
                    </div>
                </li>
            <?php else: ?>
                <a href="<?php echo e(route("auth-start")); ?>" class="my-sm-0"><img src="<?php echo e(asset("sso.png")); ?>" alt="Log in with EVE Online Single sign on" width="195" height="30"></a>
            <?php endif; ?>
        </form>
    </div>
</nav>
<?php /**PATH C:\Users\molbal\Documents\JetBrains\abyss-tracker\resources\views/layout/navbar.blade.php ENDPATH**/ ?>
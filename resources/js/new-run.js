function setProvingConduit() {
}

function setDeathReason() {
    var death = $("#SURVIVED").val();
    var dth = $(".death");
    switch (death) {
        case '0':
            dth.show();
            break;
        default:
            dth.hide();
            break;
    }
}

function advancedView() {
    $("#advanced-loot-view, #middot-1").removeClass("d-inline-block").hide();
    $(".adv").slideDown(115);
}

function switch_to_manual() {
    $("#timer_auto, #stop_stopwatch, .sw_status").hide();
    $("#timer_manual, #start_sw, #stopwatch_enabled").show();
}

function switch_to_auto() {
    $("#timer_auto, #stop_stopwatch").show();
    $("#timer_manual, #start_sw").hide();
}

function start_stopwatch() {
    switch_to_auto();
    $("#start_sw").hide();
    window.date1 = new Date();
    $("#timer_auto small").html("PREPARING...");

    $.ajax({
        method: "POST",
        url: window.start_stopwatch_url,
        data: {
            "_token":  window.csrf_token
        }
    }).done(function (msg) {
        check_status();
        window.stopwatch_interval = setInterval(check_status, 1500);
    }).fail(function (msg) {
        alert(msg.error)
    });
}

function requestNotification() {
    if ( typeof Notification !== "undefined" ) {
        Notification.requestPermission().then(function (permission) {
            if (permission === "denied") {
                Toastify({
                    text: "❌ You did not allow notifications.",
                    duration: 3000,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: 'center', // `left`, `center` or `right`
                }).showToast();
            }
            else {
                Toastify({
                    text: "✔ Browser notifications turned on.",
                    duration: 3000,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: 'center', // `left`, `center` or `right`
                }).showToast();
                $("#browser-notifications").hide();
            }
        });
    }
    else {
        Toastify({
            text: "Sorry, your browser does not support this. Please update to the latest Chrome or Firefox",
            duration: 3000,
            close: true,
            gravity: "top", // `top` or `bottom`
            position: 'center', // `left`, `center` or `right`
        }).showToast();
    }
}

window.previous_state = "starting";
function check_status() {

    $.ajax({
        method: "GET",
        url: window.check_status_url,
        data: {
            "_token": window.csrf_token
        }
    }).done(function (msg) {
        $("#timer_auto small").html(msg.status);
        var m = Math.floor(msg.seconds/60);
        var s = (msg.seconds%60);
        $("#timer_auto p").html((m < 10 ? "0" : "")+m+":"+(s<10 ? "0" : "") + s);
        $('#run_length_minute').val(m);
        $('#run_length_second').val(s);

        $(".sw_status").hide();
        $("."+msg.infodiv).show();
        if (msg.infodiv==='error') {
            stop_stopwatch();
            $("#start_sw").hide();
        }
        else if(msg.infodiv==='finished') {
            clearInterval(window.stopwatch_interval);
        }

        if (window.previous_state !== msg.infodiv) {
            window.previous_state = msg.infodiv;
            notify(msg.toast, msg.msg_icon)
        }
    });
}

function stop_stopwatch() {
    switch_to_manual();
    $("#start_sw").show();
    try {
        clearInterval(window.stopwatch_interval);
    }
    catch (ignored) {

    }


}

function notify(message, icon) {
    if ( typeof Notification !== "undefined" ) {
        if (Notification.permission === "granted") {
            var notification = new Notification('Abyss Tracker Stopwatch', { body: message, icon: icon });
            notification.onclick = () => {
                notification.close();
                window.parent.focus();
            }
        }
        else {
            Toastify({
                text: message,
                close: true,
                avatar: icon,
                gravity: "top", // `top` or `bottom`
                position: 'right', // `left`, `center` or `right`
            }).showToast();
        }
    }
    else {
        Toastify({
            text: message,
            close: true,
            avatar: icon,
            gravity: "top", // `top` or `bottom`
            position: 'right', // `left`, `center` or `right`
        }).showToast();
    }
}

// When ready.
$(function () {
    setProvingConduit();
    setDeathReason();
    $("#TIER").change(setProvingConduit);
    $("#SURVIVED").change(setDeathReason);
    $("#advanced-loot-view").click(advancedView);
    switch_to_manual();
    $("#stop_stopwatch").click(stop_stopwatch);
    $("#start_sw").click(start_stopwatch);
    var $form = $("form");
    $form.submit(function (e) {});
    $(".sw_status").hide();
    $("#stopwatch_enabled").show();
    $("#browser-notifications-enable").click(requestNotification);

    $("#vessel").select2({
        theme: 'bootstrap',
        width: '100%',
        ajax: {
            url: window.fit_newrun_select
        },
        templateResult: function(result) {
            if (result.id !== undefined) {
                return $('<div class="row">' +
                    '<div class="col-md-3"><img src="https://imageserver.eveonline.com/Type/'+result.SHIP_ID+'_32.png" alt="" class="tinyicon rounded-circle mr-1" style="border: 1px solid #fff">'+result.SHIP_NAME+'</div>' +
                    '<div class="col-md-3">'+result.SHIP_CLASS+'</div>' +
                    '<div class="col-md-5"><span class="">'+result.FIT_NAME+'</span>' +
                    '</div>');
            }
            else {
                return $(
                    '<div class="row">' +
                        '<div class="col-md-12"><span class="font-weight-bold text-uppercase">'+result.text+'</span></div>' +
                        '<div class="col-md-3 text-italic">Ship name</div>\n' +
                        '<div class="col-md-3 text-italic">Ship class</div>\n' +
                        '<div class="col-md-5 text-italic">Fit name</div>' +
                    '</div>');
            }
        }

    });


    $("#LOOT_DETAILED").change(function () {
        $("#loot_value").html("...");
        $.ajax({
            method: "POST",
            url: window.loot_detailed_url,
            data: {
                "_token":  window.csrf_token,
                "LOOT_DETAILED": $("#LOOT_DETAILED").val()
            }
        }).done(function (msg) {
            console.log(msg);
            sum = JSON.parse(msg);
            $("#loot_value").html(sum.formatted);
        });

    });

    if ( typeof Notification !== "undefined" ) {
        if (Notification.permission === "granted") {
            $("#browser-notifications").hide();
        }
    }
    else {
        $("#browser-notifications").hide();
    }


    if (window.start_stopwatch_) {
        start_stopwatch();
    }
    if (window.advanced_open) {
        $("#advanced-loot-view").click();
    }
});

/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/new-run.js":
/*!*********************************!*\
  !*** ./resources/js/new-run.js ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

function setProvingConduit() {}

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
      "_token": window.csrf_token
    }
  }).done(function (msg) {
    check_status();
    window.stopwatch_interval = setInterval(check_status, 1000);
  }).fail(function (msg) {
    alert(msg.error);
  });
}

function requestNotification() {
  if (typeof Notification !== "undefined") {
    Notification.requestPermission().then(function (permission) {
      if (permission === "denied") {
        Toastify({
          text: "❌ You did not allow notifications.",
          duration: 3000,
          close: true,
          gravity: "top",
          // `top` or `bottom`
          position: 'center' // `left`, `center` or `right`

        }).showToast();
      } else {
        Toastify({
          text: "✔ Browser notifications turned on.",
          duration: 3000,
          close: true,
          gravity: "top",
          // `top` or `bottom`
          position: 'center' // `left`, `center` or `right`

        }).showToast();
        $("#browser-notifications").hide();
      }
    });
  } else {
    Toastify({
      text: "Sorry, your browser does not support this. Please update to the latest Chrome or Firefox",
      duration: 3000,
      close: true,
      gravity: "top",
      // `top` or `bottom`
      position: 'center' // `left`, `center` or `right`

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
    var m = Math.floor(msg.seconds / 60);
    var s = msg.seconds % 60;
    $("#timer_auto p").html((m < 10 ? "0" : "") + m + ":" + (s < 10 ? "0" : "") + s);
    $('#run_length_minute').val(m);
    $('#run_length_second').val(s);
    $(".sw_status").hide();
    $("." + msg.infodiv).show();

    if (msg.infodiv === 'error') {
      stop_stopwatch();
      $("#start_sw").hide();
    } else if (msg.infodiv === 'finished') {
      clearInterval(window.stopwatch_interval);
    } else if (msg.infodiv === 'standby') {
      clearInterval(window.stopwatch_interval);

      if (window.already_started === false) {
        notify("The stopwatch stopped due to inactivity - if this happens within 10 seconds of starting the stopwatch it means the ESI API broke and you should authenticate in Settings again.", "stopwatch/ESIerror.png");
      }
    }

    if (window.previous_state !== msg.infodiv) {
      window.already_started = true;
      window.previous_state = msg.infodiv;
      notify(msg.toast, msg.msg_icon);
    }
  });
}

function stop_stopwatch() {
  switch_to_manual();
  $("#start_sw").show();

  try {
    clearInterval(window.stopwatch_interval);
  } catch (ignored) {}
}

function notify(message, icon) {
  console.log("Message: ", message, "icon: ", icon);

  if (message === "" || typeof message === "undefined") {
    return;
  }

  if (typeof Notification !== "undefined") {
    if (Notification.permission === "granted") {
      var notification = new Notification('Abyss Tracker Stopwatch', {
        body: message,
        icon: icon
      });

      notification.onclick = function () {
        notification.close();
        window.parent.focus();
      };
    } else {
      Toastify({
        text: message,
        close: true,
        avatar: icon,
        gravity: "top",
        // `top` or `bottom`
        position: 'right' // `left`, `center` or `right`

      }).showToast();
    }
  } else {
    Toastify({
      text: message,
      close: true,
      avatar: icon,
      gravity: "top",
      // `top` or `bottom`
      position: 'right' // `left`, `center` or `right`

    }).showToast();
  }
} // When ready.


window.already_started = false;
$(function () {
  setProvingConduit();
  setDeathReason();
  $("#TIER").change(setProvingConduit);
  $("#SURVIVED").change(setDeathReason);
  $("#advanced-loot-view").click(advancedView);
  switch_to_manual();
  $("#stop_stopwatch").click(stop_stopwatch);
  $("#start_sw, #start_sw_2").click(start_stopwatch);
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
    templateResult: function templateResult(result) {
      if (result.id !== undefined) {
        return $('<div class="row">' + '<div class="col-md-3">' + (result.SHIP_ID > 0 ? '<img src="https://imageserver.eveonline.com/Type/' + result.SHIP_ID + '_32.png" alt="" class="tinyicon rounded-circle mr-1" style="border: 1px solid #fff">' : '') + result.SHIP_NAME + '</div>' + '<div class="col-md-3">' + result.SHIP_CLASS + '</div>' + '<div class="col-md-5"><span class="">' + result.FIT_NAME + '</span>' + '</div>');
      } else {
        return $('<div class="row">' + '<div class="col-md-12"><span class="font-weight-bold text-uppercase">' + result.text + '</span></div>' + '<div class="col-md-3 text-italic">Ship name</div>\n' + '<div class="col-md-3 text-italic">Ship class</div>\n' + '<div class="col-md-5 text-italic">Fit name</div>' + '</div>');
      }
    }
  }).maximizeSelect2Height();
  $("#LOOT_DETAILED").change(function () {
    $("#loot_value").html("...");
    $.ajax({
      method: "POST",
      url: window.loot_detailed_url,
      data: {
        "_token": window.csrf_token,
        "LOOT_DETAILED": $("#LOOT_DETAILED").val()
      }
    }).done(function (msg) {
      console.log(msg);
      sum = JSON.parse(msg);
      $("#loot_value").html(sum.formatted);
    });
  });

  if (typeof Notification !== "undefined") {
    if (Notification.permission === "granted") {
      $("#browser-notifications").hide();
    }
  } else {
    $("#browser-notifications").hide();
  }

  if (window.start_stopwatch_) {
    start_stopwatch();
  }

  if (window.advanced_open_) {
    $("#advanced-loot-view").click();
  }

  $(".disable-all-on-click").click(function (e) {
    var pw = $(this).width();
    $(this).text('Working...');
    $(this).width(pw);
    setTimeout(function () {
      $(".disable-all-on-click").attr('type', 'button').addClass('disabled');
    }, 150);
  });
});

/***/ }),

/***/ 1:
/*!***************************************!*\
  !*** multi ./resources/js/new-run.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/molbal/PhpstormProjects/abyss-tracker/resources/js/new-run.js */"./resources/js/new-run.js");


/***/ })

/******/ });
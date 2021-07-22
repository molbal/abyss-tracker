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
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/fits.js":
/*!******************************!*\
  !*** ./resources/js/fits.js ***!
  \******************************/
/*! no static exports found */
/***/ (function(module, exports) {

function filterList() {
  var filters = $("form#filters").serializeArray();
  $("#doFilter").attr("disabled", "disabled").addClass("disabled");
  $.post(window.fit_search_ajax, filters, function (a) {
    $("#results").css("opacity", "0.01").html(a).animate({
      opacity: 1
    }, 250);
  }).fail(function () {
    Toastify({
      text: "Sorry, something went wrong while searching",
      duration: 10000,
      close: true,
      gravity: "top",
      // `top` or `bottom`
      position: 'center' // `left`, `center` or `right`

    }).showToast();
  }).always(function () {
    $("#doFilter").removeAttr("disabled").removeClass("disabled");
  });
}

;

function formatState(state) {
  var $state = $(state);
  return $state;
}

;

function toggleTag(slot, value, ths) {
  var _this = $(ths);

  console.log(ths, _this);
  var input = $("#" + slot);
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

;
$(function () {
  $("#doFilter").click(filterList);
  $(".select2-character").select2({
    theme: 'bootstrap',
    templateResult: function templateResult(state) {
      if (!state.id) {
        return state.text;
      }

      if (state.element.value.toLowerCase() === "0") {
        return $('<span class="text-center">' + state.text + '</span>');
      }

      var $state = $('<span><img style="width: 24px; height: 24px" src="https://images.evetech.net/characters/' + state.element.value.toLowerCase() + '/portrait?size=32" class="rounded-circle shadow-sm movealilbitup" /> ' + state.text + '</span>');
      return $state;
    },
    width: '100%'
  });
});

/***/ }),

/***/ 2:
/*!************************************!*\
  !*** multi ./resources/js/fits.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\Users\molbal\Documents\JetBrains\abyss-tracker\resources\js\fits.js */"./resources/js/fits.js");


/***/ })

/******/ });
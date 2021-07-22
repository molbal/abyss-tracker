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
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports) {

window.onunload = function () {
  console.log("unload");
};

$(function () {
  $('[data-toggle="tooltip"]').tooltip();
  $(".select2-default").select2({
    theme: 'bootstrap',
    width: '100%'
  }).maximizeSelect2Height();
  $(".select2-nosearch").select2({
    theme: 'bootstrap',
    minimumResultsForSearch: -1,
    width: '100%'
  }).maximizeSelect2Height();
  var buttonCommon = {};
  var buttonExcelCopy = {
    exportOptions: {
      format: {
        body: function body(data, row, column, node) {
          // Strip $ from salary column to make it numeric
          var regex = /^[0-9 ]{1,13} ISK$/;

          if (data.match(regex)) {
            replaced = data.match(/\d+/g).join("");
            console.log("Matched: ", data, " and ", replaced);
            return replaced;
          } else {
            var div = document.createElement("div");
            div.innerHTML = data;
            var text = div.textContent || div.innerText || "";
            return text;
          }
        }
      }
    }
  };
  $('.datatable').DataTable({
    paginate: false,
    dom: 'Bfrtip',
    buttons: [$.extend(true, {}, buttonCommon, {
      extend: 'copyHtml5'
    }), $.extend(true, {}, buttonExcelCopy, {
      extend: 'excelHtml5'
    }) // $.extend( true, {}, buttonCommon, {
    //     extend: 'pdfHtml5'
    // } )
    ]
  });
});

/***/ }),

/***/ "./resources/sass/animations.scss":
/*!****************************************!*\
  !*** ./resources/sass/animations.scss ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./resources/sass/app-dark.scss":
/*!**************************************!*\
  !*** ./resources/sass/app-dark.scss ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./resources/sass/fit-only.scss":
/*!**************************************!*\
  !*** ./resources/sass/fit-only.scss ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!************************************************************************************************************************************************************!*\
  !*** multi ./resources/js/app.js ./resources/sass/app.scss ./resources/sass/app-dark.scss ./resources/sass/fit-only.scss ./resources/sass/animations.scss ***!
  \************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! C:\Users\molbal\Documents\JetBrains\abyss-tracker\resources\js\app.js */"./resources/js/app.js");
__webpack_require__(/*! C:\Users\molbal\Documents\JetBrains\abyss-tracker\resources\sass\app.scss */"./resources/sass/app.scss");
__webpack_require__(/*! C:\Users\molbal\Documents\JetBrains\abyss-tracker\resources\sass\app-dark.scss */"./resources/sass/app-dark.scss");
__webpack_require__(/*! C:\Users\molbal\Documents\JetBrains\abyss-tracker\resources\sass\fit-only.scss */"./resources/sass/fit-only.scss");
module.exports = __webpack_require__(/*! C:\Users\molbal\Documents\JetBrains\abyss-tracker\resources\sass\animations.scss */"./resources/sass/animations.scss");


/***/ })

/******/ });
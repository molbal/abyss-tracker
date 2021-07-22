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
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/@algolia/autocomplete-core/dist/esm/checkOptions.js":
/*!**************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-core/dist/esm/checkOptions.js ***!
  \**************************************************************************/
/*! exports provided: checkOptions */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "checkOptions", function() { return checkOptions; });
/* harmony import */ var _algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @algolia/autocomplete-shared */ "./node_modules/@algolia/autocomplete-shared/dist/esm/index.js");

function checkOptions(options) {
   true ? Object(_algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_0__["warn"])(!options.debug, 'The `debug` option is meant for development debugging and should not be used in production.') : undefined;
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-core/dist/esm/createAutocomplete.js":
/*!********************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-core/dist/esm/createAutocomplete.js ***!
  \********************************************************************************/
/*! exports provided: createAutocomplete */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "createAutocomplete", function() { return createAutocomplete; });
/* harmony import */ var _checkOptions__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./checkOptions */ "./node_modules/@algolia/autocomplete-core/dist/esm/checkOptions.js");
/* harmony import */ var _createStore__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./createStore */ "./node_modules/@algolia/autocomplete-core/dist/esm/createStore.js");
/* harmony import */ var _getAutocompleteSetters__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./getAutocompleteSetters */ "./node_modules/@algolia/autocomplete-core/dist/esm/getAutocompleteSetters.js");
/* harmony import */ var _getDefaultProps__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./getDefaultProps */ "./node_modules/@algolia/autocomplete-core/dist/esm/getDefaultProps.js");
/* harmony import */ var _getPropGetters__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./getPropGetters */ "./node_modules/@algolia/autocomplete-core/dist/esm/getPropGetters.js");
/* harmony import */ var _onInput__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./onInput */ "./node_modules/@algolia/autocomplete-core/dist/esm/onInput.js");
/* harmony import */ var _stateReducer__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./stateReducer */ "./node_modules/@algolia/autocomplete-core/dist/esm/stateReducer.js");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }








function createAutocomplete(options) {
  Object(_checkOptions__WEBPACK_IMPORTED_MODULE_0__["checkOptions"])(options);
  var subscribers = [];
  var props = Object(_getDefaultProps__WEBPACK_IMPORTED_MODULE_3__["getDefaultProps"])(options, subscribers);
  var store = Object(_createStore__WEBPACK_IMPORTED_MODULE_1__["createStore"])(_stateReducer__WEBPACK_IMPORTED_MODULE_6__["stateReducer"], props, onStoreStateChange);
  var setters = Object(_getAutocompleteSetters__WEBPACK_IMPORTED_MODULE_2__["getAutocompleteSetters"])({
    store: store
  });
  var propGetters = Object(_getPropGetters__WEBPACK_IMPORTED_MODULE_4__["getPropGetters"])(_objectSpread({
    props: props,
    refresh: refresh,
    store: store
  }, setters));

  function onStoreStateChange(_ref) {
    var prevState = _ref.prevState,
        state = _ref.state;
    props.onStateChange(_objectSpread({
      prevState: prevState,
      state: state,
      refresh: refresh
    }, setters));
  }

  function refresh() {
    return Object(_onInput__WEBPACK_IMPORTED_MODULE_5__["onInput"])(_objectSpread({
      event: new Event('input'),
      nextState: {
        isOpen: store.getState().isOpen
      },
      props: props,
      query: store.getState().query,
      refresh: refresh,
      store: store
    }, setters));
  }

  props.plugins.forEach(function (plugin) {
    var _plugin$subscribe;

    return (_plugin$subscribe = plugin.subscribe) === null || _plugin$subscribe === void 0 ? void 0 : _plugin$subscribe.call(plugin, _objectSpread(_objectSpread({}, setters), {}, {
      refresh: refresh,
      onSelect: function onSelect(fn) {
        subscribers.push({
          onSelect: fn
        });
      },
      onActive: function onActive(fn) {
        subscribers.push({
          onActive: fn
        });
      }
    }));
  });
  return _objectSpread(_objectSpread({
    refresh: refresh
  }, propGetters), setters);
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-core/dist/esm/createStore.js":
/*!*************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-core/dist/esm/createStore.js ***!
  \*************************************************************************/
/*! exports provided: createStore */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "createStore", function() { return createStore; });
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function createStore(reducer, props, onStoreStateChange) {
  var state = props.initialState;
  return {
    getState: function getState() {
      return state;
    },
    dispatch: function dispatch(action, payload) {
      var prevState = _objectSpread({}, state);

      state = reducer(state, {
        type: action,
        props: props,
        payload: payload
      });
      onStoreStateChange({
        state: state,
        prevState: prevState
      });
    }
  };
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-core/dist/esm/getAutocompleteSetters.js":
/*!************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-core/dist/esm/getAutocompleteSetters.js ***!
  \************************************************************************************/
/*! exports provided: getAutocompleteSetters */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getAutocompleteSetters", function() { return getAutocompleteSetters; });
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./utils */ "./node_modules/@algolia/autocomplete-core/dist/esm/utils/index.js");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }


function getAutocompleteSetters(_ref) {
  var store = _ref.store;

  var setActiveItemId = function setActiveItemId(value) {
    store.dispatch('setActiveItemId', value);
  };

  var setQuery = function setQuery(value) {
    store.dispatch('setQuery', value);
  };

  var setCollections = function setCollections(rawValue) {
    var baseItemId = 0;
    var value = rawValue.map(function (collection) {
      return _objectSpread(_objectSpread({}, collection), {}, {
        // We flatten the stored items to support calling `getAlgoliaResults`
        // from the source itself.
        items: Object(_utils__WEBPACK_IMPORTED_MODULE_0__["flatten"])(collection.items).map(function (item) {
          return _objectSpread(_objectSpread({}, item), {}, {
            __autocomplete_id: baseItemId++
          });
        })
      });
    });
    store.dispatch('setCollections', value);
  };

  var setIsOpen = function setIsOpen(value) {
    store.dispatch('setIsOpen', value);
  };

  var setStatus = function setStatus(value) {
    store.dispatch('setStatus', value);
  };

  var setContext = function setContext(value) {
    store.dispatch('setContext', value);
  };

  return {
    setActiveItemId: setActiveItemId,
    setQuery: setQuery,
    setCollections: setCollections,
    setIsOpen: setIsOpen,
    setStatus: setStatus,
    setContext: setContext
  };
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-core/dist/esm/getCompletion.js":
/*!***************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-core/dist/esm/getCompletion.js ***!
  \***************************************************************************/
/*! exports provided: getCompletion */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getCompletion", function() { return getCompletion; });
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./utils */ "./node_modules/@algolia/autocomplete-core/dist/esm/utils/index.js");

function getCompletion(_ref) {
  var _getActiveItem;

  var state = _ref.state;

  if (state.isOpen === false || state.activeItemId === null) {
    return null;
  }

  return ((_getActiveItem = Object(_utils__WEBPACK_IMPORTED_MODULE_0__["getActiveItem"])(state)) === null || _getActiveItem === void 0 ? void 0 : _getActiveItem.itemInputValue) || null;
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-core/dist/esm/getDefaultProps.js":
/*!*****************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-core/dist/esm/getDefaultProps.js ***!
  \*****************************************************************************/
/*! exports provided: getDefaultProps */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getDefaultProps", function() { return getDefaultProps; });
/* harmony import */ var _algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @algolia/autocomplete-shared */ "./node_modules/@algolia/autocomplete-shared/dist/esm/index.js");
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./utils */ "./node_modules/@algolia/autocomplete-core/dist/esm/utils/index.js");
function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && Symbol.iterator in Object(iter)) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }



function getDefaultProps(props, pluginSubscribers) {
  var _props$id;

  /* eslint-disable no-restricted-globals */
  var environment = typeof window !== 'undefined' ? window : {};
  /* eslint-enable no-restricted-globals */

  var plugins = props.plugins || [];
  return _objectSpread(_objectSpread({
    debug: false,
    openOnFocus: false,
    placeholder: '',
    autoFocus: false,
    defaultActiveItemId: null,
    stallThreshold: 300,
    environment: environment,
    shouldPanelOpen: function shouldPanelOpen(_ref) {
      var state = _ref.state;
      return Object(_algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_0__["getItemsCount"])(state) > 0;
    }
  }, props), {}, {
    // Since `generateAutocompleteId` triggers a side effect (it increments
    // an internal counter), we don't want to execute it if unnecessary.
    id: (_props$id = props.id) !== null && _props$id !== void 0 ? _props$id : Object(_algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_0__["generateAutocompleteId"])(),
    plugins: plugins,
    // The following props need to be deeply defaulted.
    initialState: _objectSpread({
      activeItemId: null,
      query: '',
      completion: null,
      collections: [],
      isOpen: false,
      status: 'idle',
      context: {}
    }, props.initialState),
    onStateChange: function onStateChange(params) {
      var _props$onStateChange;

      (_props$onStateChange = props.onStateChange) === null || _props$onStateChange === void 0 ? void 0 : _props$onStateChange.call(props, params);
      plugins.forEach(function (x) {
        var _x$onStateChange;

        return (_x$onStateChange = x.onStateChange) === null || _x$onStateChange === void 0 ? void 0 : _x$onStateChange.call(x, params);
      });
    },
    onSubmit: function onSubmit(params) {
      var _props$onSubmit;

      (_props$onSubmit = props.onSubmit) === null || _props$onSubmit === void 0 ? void 0 : _props$onSubmit.call(props, params);
      plugins.forEach(function (x) {
        var _x$onSubmit;

        return (_x$onSubmit = x.onSubmit) === null || _x$onSubmit === void 0 ? void 0 : _x$onSubmit.call(x, params);
      });
    },
    onReset: function onReset(params) {
      var _props$onReset;

      (_props$onReset = props.onReset) === null || _props$onReset === void 0 ? void 0 : _props$onReset.call(props, params);
      plugins.forEach(function (x) {
        var _x$onReset;

        return (_x$onReset = x.onReset) === null || _x$onReset === void 0 ? void 0 : _x$onReset.call(x, params);
      });
    },
    getSources: function getSources(params) {
      return Promise.all([].concat(_toConsumableArray(plugins.map(function (plugin) {
        return plugin.getSources;
      })), [props.getSources]).filter(Boolean).map(function (getSources) {
        return Object(_utils__WEBPACK_IMPORTED_MODULE_1__["getNormalizedSources"])(getSources, params);
      })).then(function (nested) {
        return Object(_utils__WEBPACK_IMPORTED_MODULE_1__["flatten"])(nested);
      }).then(function (sources) {
        return sources.map(function (source) {
          return _objectSpread(_objectSpread({}, source), {}, {
            onSelect: function onSelect(params) {
              source.onSelect(params);
              pluginSubscribers.forEach(function (x) {
                var _x$onSelect;

                return (_x$onSelect = x.onSelect) === null || _x$onSelect === void 0 ? void 0 : _x$onSelect.call(x, params);
              });
            },
            onActive: function onActive(params) {
              source.onActive(params);
              pluginSubscribers.forEach(function (x) {
                var _x$onActive;

                return (_x$onActive = x.onActive) === null || _x$onActive === void 0 ? void 0 : _x$onActive.call(x, params);
              });
            }
          });
        });
      });
    },
    navigator: _objectSpread({
      navigate: function navigate(_ref2) {
        var itemUrl = _ref2.itemUrl;
        environment.location.assign(itemUrl);
      },
      navigateNewTab: function navigateNewTab(_ref3) {
        var itemUrl = _ref3.itemUrl;
        var windowReference = environment.open(itemUrl, '_blank', 'noopener');
        windowReference === null || windowReference === void 0 ? void 0 : windowReference.focus();
      },
      navigateNewWindow: function navigateNewWindow(_ref4) {
        var itemUrl = _ref4.itemUrl;
        environment.open(itemUrl, '_blank', 'noopener');
      }
    }, props.navigator)
  });
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-core/dist/esm/getPropGetters.js":
/*!****************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-core/dist/esm/getPropGetters.js ***!
  \****************************************************************************/
/*! exports provided: getPropGetters */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getPropGetters", function() { return getPropGetters; });
/* harmony import */ var _onInput__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./onInput */ "./node_modules/@algolia/autocomplete-core/dist/esm/onInput.js");
/* harmony import */ var _onKeyDown__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./onKeyDown */ "./node_modules/@algolia/autocomplete-core/dist/esm/onKeyDown.js");
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./utils */ "./node_modules/@algolia/autocomplete-core/dist/esm/utils/index.js");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _objectWithoutProperties(source, excluded) { if (source == null) return {}; var target = _objectWithoutPropertiesLoose(source, excluded); var key, i; if (Object.getOwnPropertySymbols) { var sourceSymbolKeys = Object.getOwnPropertySymbols(source); for (i = 0; i < sourceSymbolKeys.length; i++) { key = sourceSymbolKeys[i]; if (excluded.indexOf(key) >= 0) continue; if (!Object.prototype.propertyIsEnumerable.call(source, key)) continue; target[key] = source[key]; } } return target; }

function _objectWithoutPropertiesLoose(source, excluded) { if (source == null) return {}; var target = {}; var sourceKeys = Object.keys(source); var key, i; for (i = 0; i < sourceKeys.length; i++) { key = sourceKeys[i]; if (excluded.indexOf(key) >= 0) continue; target[key] = source[key]; } return target; }




function getPropGetters(_ref) {
  var props = _ref.props,
      refresh = _ref.refresh,
      store = _ref.store,
      setters = _objectWithoutProperties(_ref, ["props", "refresh", "store"]);

  var getEnvironmentProps = function getEnvironmentProps(providedProps) {
    var inputElement = providedProps.inputElement,
        formElement = providedProps.formElement,
        panelElement = providedProps.panelElement,
        rest = _objectWithoutProperties(providedProps, ["inputElement", "formElement", "panelElement"]);

    return _objectSpread({
      // On touch devices, we do not rely on the native `blur` event of the
      // input to close the panel, but rather on a custom `touchstart` event
      // outside of the autocomplete elements.
      // This ensures a working experience on mobile because we blur the input
      // on touch devices when the user starts scrolling (`touchmove`).
      onTouchStart: function onTouchStart(event) {
        if (store.getState().isOpen === false || event.target === inputElement) {
          return;
        } // @TODO: support cases where there are multiple Autocomplete instances.
        // Right now, a second instance makes this computation return false.


        var isTargetWithinAutocomplete = [formElement, panelElement].some(function (contextNode) {
          return Object(_utils__WEBPACK_IMPORTED_MODULE_2__["isOrContainsNode"])(contextNode, event.target) || Object(_utils__WEBPACK_IMPORTED_MODULE_2__["isOrContainsNode"])(contextNode, props.environment.document.activeElement);
        });

        if (isTargetWithinAutocomplete === false) {
          store.dispatch('blur', null);
        }
      },
      // When scrolling on touch devices (mobiles, tablets, etc.), we want to
      // mimic the native platform behavior where the input is blurred to
      // hide the virtual keyboard. This gives more vertical space to
      // discover all the suggestions showing up in the panel.
      onTouchMove: function onTouchMove(event) {
        if (store.getState().isOpen === false || inputElement !== props.environment.document.activeElement || event.target === inputElement) {
          return;
        }

        inputElement.blur();
      }
    }, rest);
  };

  var getRootProps = function getRootProps(rest) {
    return _objectSpread({
      role: 'combobox',
      'aria-expanded': store.getState().isOpen,
      'aria-haspopup': 'listbox',
      'aria-owns': store.getState().isOpen ? "".concat(props.id, "-list") : undefined,
      'aria-labelledby': "".concat(props.id, "-label")
    }, rest);
  };

  var getFormProps = function getFormProps(providedProps) {
    var inputElement = providedProps.inputElement,
        rest = _objectWithoutProperties(providedProps, ["inputElement"]);

    return _objectSpread({
      action: '',
      noValidate: true,
      role: 'search',
      onSubmit: function onSubmit(event) {
        var _providedProps$inputE;

        event.preventDefault();
        props.onSubmit(_objectSpread({
          event: event,
          refresh: refresh,
          state: store.getState()
        }, setters));
        store.dispatch('submit', null);
        (_providedProps$inputE = providedProps.inputElement) === null || _providedProps$inputE === void 0 ? void 0 : _providedProps$inputE.blur();
      },
      onReset: function onReset(event) {
        var _providedProps$inputE2;

        event.preventDefault();
        props.onReset(_objectSpread({
          event: event,
          refresh: refresh,
          state: store.getState()
        }, setters));
        store.dispatch('reset', null);
        (_providedProps$inputE2 = providedProps.inputElement) === null || _providedProps$inputE2 === void 0 ? void 0 : _providedProps$inputE2.focus();
      }
    }, rest);
  };

  var getInputProps = function getInputProps(providedProps) {
    function onFocus(event) {
      // We want to trigger a query when `openOnFocus` is true
      // because the panel should open with the current query.
      if (props.openOnFocus || Boolean(store.getState().query)) {
        Object(_onInput__WEBPACK_IMPORTED_MODULE_0__["onInput"])(_objectSpread({
          event: event,
          props: props,
          query: store.getState().completion || store.getState().query,
          refresh: refresh,
          store: store
        }, setters));
      }

      store.dispatch('focus', null);
    }

    var isTouchDevice = ('ontouchstart' in props.environment);

    var _ref2 = providedProps || {},
        inputElement = _ref2.inputElement,
        _ref2$maxLength = _ref2.maxLength,
        maxLength = _ref2$maxLength === void 0 ? 512 : _ref2$maxLength,
        rest = _objectWithoutProperties(_ref2, ["inputElement", "maxLength"]);

    var activeItem = Object(_utils__WEBPACK_IMPORTED_MODULE_2__["getActiveItem"])(store.getState());
    return _objectSpread({
      'aria-autocomplete': 'both',
      'aria-activedescendant': store.getState().isOpen && store.getState().activeItemId !== null ? "".concat(props.id, "-item-").concat(store.getState().activeItemId) : undefined,
      'aria-controls': store.getState().isOpen ? "".concat(props.id, "-list") : undefined,
      'aria-labelledby': "".concat(props.id, "-label"),
      value: store.getState().completion || store.getState().query,
      id: "".concat(props.id, "-input"),
      autoComplete: 'off',
      autoCorrect: 'off',
      autoCapitalize: 'off',
      enterKeyHint: activeItem !== null && activeItem !== void 0 && activeItem.itemUrl ? 'go' : 'search',
      spellCheck: 'false',
      autoFocus: props.autoFocus,
      placeholder: props.placeholder,
      maxLength: maxLength,
      type: 'search',
      onChange: function onChange(event) {
        Object(_onInput__WEBPACK_IMPORTED_MODULE_0__["onInput"])(_objectSpread({
          event: event,
          props: props,
          query: event.currentTarget.value.slice(0, maxLength),
          refresh: refresh,
          store: store
        }, setters));
      },
      onKeyDown: function onKeyDown(event) {
        Object(_onKeyDown__WEBPACK_IMPORTED_MODULE_1__["onKeyDown"])(_objectSpread({
          event: event,
          props: props,
          refresh: refresh,
          store: store
        }, setters));
      },
      onFocus: onFocus,
      onBlur: function onBlur() {
        // We do rely on the `blur` event on touch devices.
        // See explanation in `onTouchStart`.
        if (!isTouchDevice) {
          store.dispatch('blur', null);
        }
      },
      onClick: function onClick(event) {
        // When the panel is closed and you click on the input while
        // the input is focused, the `onFocus` event is not triggered
        // (default browser behavior).
        // In an autocomplete context, it makes sense to open the panel in this
        // case.
        // We mimic this event by catching the `onClick` event which
        // triggers the `onFocus` for the panel to open.
        if (providedProps.inputElement === props.environment.document.activeElement && !store.getState().isOpen) {
          onFocus(event);
        }
      }
    }, rest);
  };

  var getLabelProps = function getLabelProps(rest) {
    return _objectSpread({
      htmlFor: "".concat(props.id, "-input"),
      id: "".concat(props.id, "-label")
    }, rest);
  };

  var getListProps = function getListProps(rest) {
    return _objectSpread({
      role: 'listbox',
      'aria-labelledby': "".concat(props.id, "-label"),
      id: "".concat(props.id, "-list")
    }, rest);
  };

  var getPanelProps = function getPanelProps(rest) {
    return _objectSpread({
      onMouseDown: function onMouseDown(event) {
        // Prevents the `activeElement` from being changed to the panel so
        // that the blur event is not triggered, otherwise it closes the
        // panel.
        event.preventDefault();
      },
      onMouseLeave: function onMouseLeave() {
        store.dispatch('mouseleave', null);
      }
    }, rest);
  };

  var getItemProps = function getItemProps(providedProps) {
    var item = providedProps.item,
        source = providedProps.source,
        rest = _objectWithoutProperties(providedProps, ["item", "source"]);

    return _objectSpread({
      id: "".concat(props.id, "-item-").concat(item.__autocomplete_id),
      role: 'option',
      'aria-selected': store.getState().activeItemId === item.__autocomplete_id,
      onMouseMove: function onMouseMove(event) {
        if (item.__autocomplete_id === store.getState().activeItemId) {
          return;
        }

        store.dispatch('mousemove', item.__autocomplete_id);
        var activeItem = Object(_utils__WEBPACK_IMPORTED_MODULE_2__["getActiveItem"])(store.getState());

        if (store.getState().activeItemId !== null && activeItem) {
          var _item = activeItem.item,
              itemInputValue = activeItem.itemInputValue,
              itemUrl = activeItem.itemUrl,
              _source = activeItem.source;

          _source.onActive(_objectSpread({
            event: event,
            item: _item,
            itemInputValue: itemInputValue,
            itemUrl: itemUrl,
            refresh: refresh,
            source: _source,
            state: store.getState()
          }, setters));
        }
      },
      onMouseDown: function onMouseDown(event) {
        // Prevents the `activeElement` from being changed to the item so it
        // can remain with the current `activeElement`.
        event.preventDefault();
      },
      onClick: function onClick(event) {
        var itemInputValue = source.getItemInputValue({
          item: item,
          state: store.getState()
        });
        var itemUrl = source.getItemUrl({
          item: item,
          state: store.getState()
        }); // If `getItemUrl` is provided, it means that the suggestion
        // is a link, not plain text that aims at updating the query.
        // We can therefore skip the state change because it will update
        // the `activeItemId`, resulting in a UI flash, especially
        // noticeable on mobile.

        var runPreCommand = itemUrl ? Promise.resolve() : Object(_onInput__WEBPACK_IMPORTED_MODULE_0__["onInput"])(_objectSpread({
          event: event,
          nextState: {
            isOpen: false
          },
          props: props,
          query: itemInputValue,
          refresh: refresh,
          store: store
        }, setters));
        runPreCommand.then(function () {
          source.onSelect(_objectSpread({
            event: event,
            item: item,
            itemInputValue: itemInputValue,
            itemUrl: itemUrl,
            refresh: refresh,
            source: source,
            state: store.getState()
          }, setters));
        });
      }
    }, rest);
  };

  return {
    getEnvironmentProps: getEnvironmentProps,
    getRootProps: getRootProps,
    getFormProps: getFormProps,
    getLabelProps: getLabelProps,
    getInputProps: getInputProps,
    getPanelProps: getPanelProps,
    getListProps: getListProps,
    getItemProps: getItemProps
  };
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-core/dist/esm/index.js":
/*!*******************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-core/dist/esm/index.js ***!
  \*******************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _createAutocomplete__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./createAutocomplete */ "./node_modules/@algolia/autocomplete-core/dist/esm/createAutocomplete.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "createAutocomplete", function() { return _createAutocomplete__WEBPACK_IMPORTED_MODULE_0__["createAutocomplete"]; });

/* harmony import */ var _getDefaultProps__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./getDefaultProps */ "./node_modules/@algolia/autocomplete-core/dist/esm/getDefaultProps.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "getDefaultProps", function() { return _getDefaultProps__WEBPACK_IMPORTED_MODULE_1__["getDefaultProps"]; });

/* harmony import */ var _types__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./types */ "./node_modules/@algolia/autocomplete-core/dist/esm/types/index.js");
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _types__WEBPACK_IMPORTED_MODULE_2__) if(["default","createAutocomplete","getDefaultProps"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _types__WEBPACK_IMPORTED_MODULE_2__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _version__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./version */ "./node_modules/@algolia/autocomplete-core/dist/esm/version.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "version", function() { return _version__WEBPACK_IMPORTED_MODULE_3__["version"]; });






/***/ }),

/***/ "./node_modules/@algolia/autocomplete-core/dist/esm/onInput.js":
/*!*********************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-core/dist/esm/onInput.js ***!
  \*********************************************************************/
/*! exports provided: onInput */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "onInput", function() { return onInput; });
/* harmony import */ var _resolve__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./resolve */ "./node_modules/@algolia/autocomplete-core/dist/esm/resolve.js");
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./utils */ "./node_modules/@algolia/autocomplete-core/dist/esm/utils/index.js");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _objectWithoutProperties(source, excluded) { if (source == null) return {}; var target = _objectWithoutPropertiesLoose(source, excluded); var key, i; if (Object.getOwnPropertySymbols) { var sourceSymbolKeys = Object.getOwnPropertySymbols(source); for (i = 0; i < sourceSymbolKeys.length; i++) { key = sourceSymbolKeys[i]; if (excluded.indexOf(key) >= 0) continue; if (!Object.prototype.propertyIsEnumerable.call(source, key)) continue; target[key] = source[key]; } } return target; }

function _objectWithoutPropertiesLoose(source, excluded) { if (source == null) return {}; var target = {}; var sourceKeys = Object.keys(source); var key, i; for (i = 0; i < sourceKeys.length; i++) { key = sourceKeys[i]; if (excluded.indexOf(key) >= 0) continue; target[key] = source[key]; } return target; }



var lastStalledId = null;
function onInput(_ref) {
  var event = _ref.event,
      _ref$nextState = _ref.nextState,
      nextState = _ref$nextState === void 0 ? {} : _ref$nextState,
      props = _ref.props,
      query = _ref.query,
      refresh = _ref.refresh,
      store = _ref.store,
      setters = _objectWithoutProperties(_ref, ["event", "nextState", "props", "query", "refresh", "store"]);

  if (lastStalledId) {
    props.environment.clearTimeout(lastStalledId);
  }

  var setCollections = setters.setCollections,
      setIsOpen = setters.setIsOpen,
      setQuery = setters.setQuery,
      setActiveItemId = setters.setActiveItemId,
      setStatus = setters.setStatus;
  setQuery(query);
  setActiveItemId(props.defaultActiveItemId);

  if (!query && props.openOnFocus === false) {
    var _nextState$isOpen;

    setStatus('idle');
    setCollections(store.getState().collections.map(function (collection) {
      return _objectSpread(_objectSpread({}, collection), {}, {
        items: []
      });
    }));
    setIsOpen((_nextState$isOpen = nextState.isOpen) !== null && _nextState$isOpen !== void 0 ? _nextState$isOpen : props.shouldPanelOpen({
      state: store.getState()
    }));
    return Promise.resolve();
  }

  setStatus('loading');
  lastStalledId = props.environment.setTimeout(function () {
    setStatus('stalled');
  }, props.stallThreshold);
  return props.getSources(_objectSpread({
    query: query,
    refresh: refresh,
    state: store.getState()
  }, setters)).then(function (sources) {
    setStatus('loading');
    return Promise.all(sources.map(function (source) {
      return Promise.resolve(source.getItems(_objectSpread({
        query: query,
        refresh: refresh,
        state: store.getState()
      }, setters))).then(function (itemsOrDescription) {
        return Object(_resolve__WEBPACK_IMPORTED_MODULE_0__["preResolve"])(itemsOrDescription, source.sourceId);
      });
    })).then(_resolve__WEBPACK_IMPORTED_MODULE_0__["resolve"]).then(function (responses) {
      return Object(_resolve__WEBPACK_IMPORTED_MODULE_0__["postResolve"])(responses, sources);
    }).then(function (collections) {
      var _nextState$isOpen2;

      setStatus('idle');
      setCollections(collections);
      var isPanelOpen = props.shouldPanelOpen({
        state: store.getState()
      });
      setIsOpen((_nextState$isOpen2 = nextState.isOpen) !== null && _nextState$isOpen2 !== void 0 ? _nextState$isOpen2 : props.openOnFocus && !query && isPanelOpen || isPanelOpen);
      var highlightedItem = Object(_utils__WEBPACK_IMPORTED_MODULE_1__["getActiveItem"])(store.getState());

      if (store.getState().activeItemId !== null && highlightedItem) {
        var item = highlightedItem.item,
            itemInputValue = highlightedItem.itemInputValue,
            itemUrl = highlightedItem.itemUrl,
            source = highlightedItem.source;
        source.onActive(_objectSpread({
          event: event,
          item: item,
          itemInputValue: itemInputValue,
          itemUrl: itemUrl,
          refresh: refresh,
          source: source,
          state: store.getState()
        }, setters));
      }
    }).finally(function () {
      if (lastStalledId) {
        props.environment.clearTimeout(lastStalledId);
      }
    });
  });
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-core/dist/esm/onKeyDown.js":
/*!***********************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-core/dist/esm/onKeyDown.js ***!
  \***********************************************************************/
/*! exports provided: onKeyDown */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "onKeyDown", function() { return onKeyDown; });
/* harmony import */ var _onInput__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./onInput */ "./node_modules/@algolia/autocomplete-core/dist/esm/onInput.js");
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./utils */ "./node_modules/@algolia/autocomplete-core/dist/esm/utils/index.js");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _objectWithoutProperties(source, excluded) { if (source == null) return {}; var target = _objectWithoutPropertiesLoose(source, excluded); var key, i; if (Object.getOwnPropertySymbols) { var sourceSymbolKeys = Object.getOwnPropertySymbols(source); for (i = 0; i < sourceSymbolKeys.length; i++) { key = sourceSymbolKeys[i]; if (excluded.indexOf(key) >= 0) continue; if (!Object.prototype.propertyIsEnumerable.call(source, key)) continue; target[key] = source[key]; } } return target; }

function _objectWithoutPropertiesLoose(source, excluded) { if (source == null) return {}; var target = {}; var sourceKeys = Object.keys(source); var key, i; for (i = 0; i < sourceKeys.length; i++) { key = sourceKeys[i]; if (excluded.indexOf(key) >= 0) continue; target[key] = source[key]; } return target; }



function onKeyDown(_ref) {
  var event = _ref.event,
      props = _ref.props,
      refresh = _ref.refresh,
      store = _ref.store,
      setters = _objectWithoutProperties(_ref, ["event", "props", "refresh", "store"]);

  if (event.key === 'ArrowUp' || event.key === 'ArrowDown') {
    // eslint-disable-next-line no-inner-declarations
    var triggerScrollIntoView = function triggerScrollIntoView() {
      var nodeItem = props.environment.document.getElementById("".concat(props.id, "-item-").concat(store.getState().activeItemId));

      if (nodeItem) {
        if (nodeItem.scrollIntoViewIfNeeded) {
          nodeItem.scrollIntoViewIfNeeded(false);
        } else {
          nodeItem.scrollIntoView(false);
        }
      }
    }; // eslint-disable-next-line no-inner-declarations


    var triggerOnActive = function triggerOnActive() {
      var highlightedItem = Object(_utils__WEBPACK_IMPORTED_MODULE_1__["getActiveItem"])(store.getState());

      if (store.getState().activeItemId !== null && highlightedItem) {
        var item = highlightedItem.item,
            itemInputValue = highlightedItem.itemInputValue,
            itemUrl = highlightedItem.itemUrl,
            source = highlightedItem.source;
        source.onActive(_objectSpread({
          event: event,
          item: item,
          itemInputValue: itemInputValue,
          itemUrl: itemUrl,
          refresh: refresh,
          source: source,
          state: store.getState()
        }, setters));
      }
    }; // Default browser behavior changes the caret placement on ArrowUp and
    // ArrowDown.


    event.preventDefault(); // When re-opening the panel, we need to split the logic to keep the actions
    // synchronized as `onInput` returns a promise.

    if (store.getState().isOpen === false && (props.openOnFocus || Boolean(store.getState().query))) {
      Object(_onInput__WEBPACK_IMPORTED_MODULE_0__["onInput"])(_objectSpread({
        event: event,
        props: props,
        query: store.getState().query,
        refresh: refresh,
        store: store
      }, setters)).then(function () {
        store.dispatch(event.key, {
          nextActiveItemId: props.defaultActiveItemId
        });
        triggerOnActive(); // Since we rely on the DOM, we need to wait for all the micro tasks to
        // finish (which include re-opening the panel) to make sure all the
        // elements are available.

        setTimeout(triggerScrollIntoView, 0);
      });
    } else {
      store.dispatch(event.key, {});
      triggerOnActive();
      triggerScrollIntoView();
    }
  } else if (event.key === 'Escape') {
    // This prevents the default browser behavior on `input[type="search"]`
    // from removing the query right away because we first want to close the
    // panel.
    event.preventDefault();
    store.dispatch(event.key, null);
  } else if (event.key === 'Enter') {
    // No active item, so we let the browser handle the native `onSubmit` form
    // event.
    if (store.getState().activeItemId === null || store.getState().collections.every(function (collection) {
      return collection.items.length === 0;
    })) {
      return;
    } // This prevents the `onSubmit` event to be sent because an item is
    // highlighted.


    event.preventDefault();

    var _ref2 = Object(_utils__WEBPACK_IMPORTED_MODULE_1__["getActiveItem"])(store.getState()),
        item = _ref2.item,
        itemInputValue = _ref2.itemInputValue,
        itemUrl = _ref2.itemUrl,
        source = _ref2.source;

    if (event.metaKey || event.ctrlKey) {
      if (itemUrl !== undefined) {
        source.onSelect(_objectSpread({
          event: event,
          item: item,
          itemInputValue: itemInputValue,
          itemUrl: itemUrl,
          refresh: refresh,
          source: source,
          state: store.getState()
        }, setters));
        props.navigator.navigateNewTab({
          itemUrl: itemUrl,
          item: item,
          state: store.getState()
        });
      }
    } else if (event.shiftKey) {
      if (itemUrl !== undefined) {
        source.onSelect(_objectSpread({
          event: event,
          item: item,
          itemInputValue: itemInputValue,
          itemUrl: itemUrl,
          refresh: refresh,
          source: source,
          state: store.getState()
        }, setters));
        props.navigator.navigateNewWindow({
          itemUrl: itemUrl,
          item: item,
          state: store.getState()
        });
      }
    } else if (event.altKey) {// Keep native browser behavior
    } else {
      if (itemUrl !== undefined) {
        source.onSelect(_objectSpread({
          event: event,
          item: item,
          itemInputValue: itemInputValue,
          itemUrl: itemUrl,
          refresh: refresh,
          source: source,
          state: store.getState()
        }, setters));
        props.navigator.navigate({
          itemUrl: itemUrl,
          item: item,
          state: store.getState()
        });
        return;
      }

      Object(_onInput__WEBPACK_IMPORTED_MODULE_0__["onInput"])(_objectSpread({
        event: event,
        nextState: {
          isOpen: false
        },
        props: props,
        query: itemInputValue,
        refresh: refresh,
        store: store
      }, setters)).then(function () {
        source.onSelect(_objectSpread({
          event: event,
          item: item,
          itemInputValue: itemInputValue,
          itemUrl: itemUrl,
          refresh: refresh,
          source: source,
          state: store.getState()
        }, setters));
      });
    }
  }
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-core/dist/esm/resolve.js":
/*!*********************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-core/dist/esm/resolve.js ***!
  \*********************************************************************/
/*! exports provided: preResolve, resolve, postResolve */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "preResolve", function() { return preResolve; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "resolve", function() { return resolve; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "postResolve", function() { return postResolve; });
/* harmony import */ var _algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @algolia/autocomplete-shared */ "./node_modules/@algolia/autocomplete-shared/dist/esm/index.js");
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./utils */ "./node_modules/@algolia/autocomplete-core/dist/esm/utils/index.js");
function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && Symbol.iterator in Object(iter)) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }




function isDescription(item) {
  return Boolean(item.execute);
}

function isRequesterDescription(description) {
  return Boolean(description === null || description === void 0 ? void 0 : description.execute);
}

function preResolve(itemsOrDescription, sourceId) {
  if (isRequesterDescription(itemsOrDescription)) {
    return _objectSpread(_objectSpread({}, itemsOrDescription), {}, {
      requests: itemsOrDescription.queries.map(function (query) {
        return {
          query: query,
          sourceId: sourceId,
          transformResponse: itemsOrDescription.transformResponse
        };
      })
    });
  }

  return {
    items: itemsOrDescription,
    sourceId: sourceId
  };
}
function resolve(items) {
  var packed = items.reduce(function (acc, current) {
    if (!isDescription(current)) {
      acc.push(current);
      return acc;
    }

    var searchClient = current.searchClient,
        execute = current.execute,
        requests = current.requests;
    var container = acc.find(function (item) {
      return isDescription(current) && isDescription(item) && item.searchClient === searchClient && item.execute === execute;
    });

    if (container) {
      var _container$items;

      (_container$items = container.items).push.apply(_container$items, _toConsumableArray(requests));
    } else {
      var request = {
        execute: execute,
        items: requests,
        searchClient: searchClient
      };
      acc.push(request);
    }

    return acc;
  }, []);
  var values = packed.map(function (maybeDescription) {
    if (!isDescription(maybeDescription)) {
      return Promise.resolve(maybeDescription);
    }

    var _ref = maybeDescription,
        execute = _ref.execute,
        items = _ref.items,
        searchClient = _ref.searchClient;
    return execute({
      searchClient: searchClient,
      requests: items
    });
  });
  return Promise.all(values).then(function (responses) {
    return Object(_utils__WEBPACK_IMPORTED_MODULE_1__["flatten"])(responses);
  });
}
function postResolve(responses, sources) {
  return sources.map(function (source) {
    var matches = responses.filter(function (response) {
      return response.sourceId === source.sourceId;
    });
    var results = matches.map(function (_ref2) {
      var items = _ref2.items;
      return items;
    });
    var transform = matches[0].transformResponse;
    var items = transform ? transform(Object(_utils__WEBPACK_IMPORTED_MODULE_1__["mapToAlgoliaResponse"])(results)) : results;
    Object(_algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_0__["invariant"])(Array.isArray(items), "The `getItems` function from source \"".concat(source.sourceId, "\" must return an array of items but returned type ").concat(JSON.stringify(_typeof(items)), ":\n\n").concat(JSON.stringify(items, null, 2), ".\n\nSee: https://www.algolia.com/doc/ui-libraries/autocomplete/core-concepts/sources/#param-getitems"));
    Object(_algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_0__["invariant"])(items.every(Boolean), "The `getItems` function from source \"".concat(source.sourceId, "\" must return an array of items but returned ").concat(JSON.stringify(undefined), ".\n\nDid you forget to return items?\n\nSee: https://www.algolia.com/doc/ui-libraries/autocomplete/core-concepts/sources/#param-getitems"));
    return {
      source: source,
      items: items
    };
  });
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-core/dist/esm/stateReducer.js":
/*!**************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-core/dist/esm/stateReducer.js ***!
  \**************************************************************************/
/*! exports provided: stateReducer */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "stateReducer", function() { return stateReducer; });
/* harmony import */ var _algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @algolia/autocomplete-shared */ "./node_modules/@algolia/autocomplete-shared/dist/esm/index.js");
/* harmony import */ var _getCompletion__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./getCompletion */ "./node_modules/@algolia/autocomplete-core/dist/esm/getCompletion.js");
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./utils */ "./node_modules/@algolia/autocomplete-core/dist/esm/utils/index.js");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }




var stateReducer = function stateReducer(state, action) {
  switch (action.type) {
    case 'setActiveItemId':
      {
        return _objectSpread(_objectSpread({}, state), {}, {
          activeItemId: action.payload
        });
      }

    case 'setQuery':
      {
        return _objectSpread(_objectSpread({}, state), {}, {
          query: action.payload,
          completion: null
        });
      }

    case 'setCollections':
      {
        return _objectSpread(_objectSpread({}, state), {}, {
          collections: action.payload
        });
      }

    case 'setIsOpen':
      {
        return _objectSpread(_objectSpread({}, state), {}, {
          isOpen: action.payload
        });
      }

    case 'setStatus':
      {
        return _objectSpread(_objectSpread({}, state), {}, {
          status: action.payload
        });
      }

    case 'setContext':
      {
        return _objectSpread(_objectSpread({}, state), {}, {
          context: _objectSpread(_objectSpread({}, state.context), action.payload)
        });
      }

    case 'ArrowDown':
      {
        var nextState = _objectSpread(_objectSpread({}, state), {}, {
          activeItemId: action.payload.hasOwnProperty('nextActiveItemId') ? action.payload.nextActiveItemId : Object(_utils__WEBPACK_IMPORTED_MODULE_2__["getNextActiveItemId"])(1, state.activeItemId, Object(_algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_0__["getItemsCount"])(state), action.props.defaultActiveItemId)
        });

        return _objectSpread(_objectSpread({}, nextState), {}, {
          completion: Object(_getCompletion__WEBPACK_IMPORTED_MODULE_1__["getCompletion"])({
            state: nextState
          })
        });
      }

    case 'ArrowUp':
      {
        var _nextState = _objectSpread(_objectSpread({}, state), {}, {
          activeItemId: Object(_utils__WEBPACK_IMPORTED_MODULE_2__["getNextActiveItemId"])(-1, state.activeItemId, Object(_algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_0__["getItemsCount"])(state), action.props.defaultActiveItemId)
        });

        return _objectSpread(_objectSpread({}, _nextState), {}, {
          completion: Object(_getCompletion__WEBPACK_IMPORTED_MODULE_1__["getCompletion"])({
            state: _nextState
          })
        });
      }

    case 'Escape':
      {
        if (state.isOpen) {
          return _objectSpread(_objectSpread({}, state), {}, {
            activeItemId: null,
            isOpen: false,
            completion: null
          });
        }

        return _objectSpread(_objectSpread({}, state), {}, {
          activeItemId: null,
          query: '',
          status: 'idle',
          collections: []
        });
      }

    case 'submit':
      {
        return _objectSpread(_objectSpread({}, state), {}, {
          activeItemId: null,
          isOpen: false,
          status: 'idle'
        });
      }

    case 'reset':
      {
        return _objectSpread(_objectSpread({}, state), {}, {
          activeItemId: // Since we open the panel on reset when openOnFocus=true
          // we need to restore the highlighted index to the defaultActiveItemId. (DocSearch use-case)
          // Since we close the panel when openOnFocus=false
          // we lose track of the highlighted index. (Query-suggestions use-case)
          action.props.openOnFocus === true ? action.props.defaultActiveItemId : null,
          status: 'idle',
          query: ''
        });
      }

    case 'focus':
      {
        return _objectSpread(_objectSpread({}, state), {}, {
          activeItemId: action.props.defaultActiveItemId,
          isOpen: (action.props.openOnFocus || Boolean(state.query)) && action.props.shouldPanelOpen({
            state: state
          })
        });
      }

    case 'blur':
      {
        if (action.props.debug) {
          return state;
        }

        return _objectSpread(_objectSpread({}, state), {}, {
          isOpen: false,
          activeItemId: null
        });
      }

    case 'mousemove':
      {
        return _objectSpread(_objectSpread({}, state), {}, {
          activeItemId: action.payload
        });
      }

    case 'mouseleave':
      {
        return _objectSpread(_objectSpread({}, state), {}, {
          activeItemId: action.props.defaultActiveItemId
        });
      }

    default:
      Object(_algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_0__["invariant"])(false, "The reducer action ".concat(JSON.stringify(action.type), " is not supported."));
      return state;
  }
};

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompleteApi.js":
/*!***********************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompleteApi.js ***!
  \***********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompleteCollection.js":
/*!******************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompleteCollection.js ***!
  \******************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompleteContext.js":
/*!***************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompleteContext.js ***!
  \***************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompleteEnvironment.js":
/*!*******************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompleteEnvironment.js ***!
  \*******************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompleteOptions.js":
/*!***************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompleteOptions.js ***!
  \***************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompletePlugin.js":
/*!**************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompletePlugin.js ***!
  \**************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompletePropGetters.js":
/*!*******************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompletePropGetters.js ***!
  \*******************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompleteSetters.js":
/*!***************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompleteSetters.js ***!
  \***************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompleteSource.js":
/*!**************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompleteSource.js ***!
  \**************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompleteState.js":
/*!*************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompleteState.js ***!
  \*************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompleteStore.js":
/*!*************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompleteStore.js ***!
  \*************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompleteSubscribers.js":
/*!*******************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompleteSubscribers.js ***!
  \*******************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./node_modules/@algolia/autocomplete-core/dist/esm/types/index.js":
/*!*************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-core/dist/esm/types/index.js ***!
  \*************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _AutocompleteApi__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./AutocompleteApi */ "./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompleteApi.js");
/* harmony import */ var _AutocompleteApi__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_AutocompleteApi__WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _AutocompleteApi__WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _AutocompleteApi__WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _AutocompleteCollection__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./AutocompleteCollection */ "./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompleteCollection.js");
/* harmony import */ var _AutocompleteCollection__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_AutocompleteCollection__WEBPACK_IMPORTED_MODULE_1__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _AutocompleteCollection__WEBPACK_IMPORTED_MODULE_1__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _AutocompleteCollection__WEBPACK_IMPORTED_MODULE_1__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _AutocompleteContext__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./AutocompleteContext */ "./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompleteContext.js");
/* harmony import */ var _AutocompleteContext__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_AutocompleteContext__WEBPACK_IMPORTED_MODULE_2__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _AutocompleteContext__WEBPACK_IMPORTED_MODULE_2__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _AutocompleteContext__WEBPACK_IMPORTED_MODULE_2__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _AutocompleteEnvironment__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./AutocompleteEnvironment */ "./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompleteEnvironment.js");
/* harmony import */ var _AutocompleteEnvironment__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_AutocompleteEnvironment__WEBPACK_IMPORTED_MODULE_3__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _AutocompleteEnvironment__WEBPACK_IMPORTED_MODULE_3__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _AutocompleteEnvironment__WEBPACK_IMPORTED_MODULE_3__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _AutocompleteOptions__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./AutocompleteOptions */ "./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompleteOptions.js");
/* harmony import */ var _AutocompleteOptions__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_AutocompleteOptions__WEBPACK_IMPORTED_MODULE_4__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _AutocompleteOptions__WEBPACK_IMPORTED_MODULE_4__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _AutocompleteOptions__WEBPACK_IMPORTED_MODULE_4__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _AutocompleteSource__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./AutocompleteSource */ "./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompleteSource.js");
/* harmony import */ var _AutocompleteSource__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_AutocompleteSource__WEBPACK_IMPORTED_MODULE_5__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _AutocompleteSource__WEBPACK_IMPORTED_MODULE_5__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _AutocompleteSource__WEBPACK_IMPORTED_MODULE_5__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _AutocompletePropGetters__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./AutocompletePropGetters */ "./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompletePropGetters.js");
/* harmony import */ var _AutocompletePropGetters__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_AutocompletePropGetters__WEBPACK_IMPORTED_MODULE_6__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _AutocompletePropGetters__WEBPACK_IMPORTED_MODULE_6__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _AutocompletePropGetters__WEBPACK_IMPORTED_MODULE_6__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _AutocompletePlugin__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./AutocompletePlugin */ "./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompletePlugin.js");
/* harmony import */ var _AutocompletePlugin__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_AutocompletePlugin__WEBPACK_IMPORTED_MODULE_7__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _AutocompletePlugin__WEBPACK_IMPORTED_MODULE_7__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _AutocompletePlugin__WEBPACK_IMPORTED_MODULE_7__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _AutocompleteSetters__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./AutocompleteSetters */ "./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompleteSetters.js");
/* harmony import */ var _AutocompleteSetters__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(_AutocompleteSetters__WEBPACK_IMPORTED_MODULE_8__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _AutocompleteSetters__WEBPACK_IMPORTED_MODULE_8__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _AutocompleteSetters__WEBPACK_IMPORTED_MODULE_8__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _AutocompleteState__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./AutocompleteState */ "./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompleteState.js");
/* harmony import */ var _AutocompleteState__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(_AutocompleteState__WEBPACK_IMPORTED_MODULE_9__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _AutocompleteState__WEBPACK_IMPORTED_MODULE_9__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _AutocompleteState__WEBPACK_IMPORTED_MODULE_9__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _AutocompleteStore__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./AutocompleteStore */ "./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompleteStore.js");
/* harmony import */ var _AutocompleteStore__WEBPACK_IMPORTED_MODULE_10___default = /*#__PURE__*/__webpack_require__.n(_AutocompleteStore__WEBPACK_IMPORTED_MODULE_10__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _AutocompleteStore__WEBPACK_IMPORTED_MODULE_10__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _AutocompleteStore__WEBPACK_IMPORTED_MODULE_10__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _AutocompleteSubscribers__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ./AutocompleteSubscribers */ "./node_modules/@algolia/autocomplete-core/dist/esm/types/AutocompleteSubscribers.js");
/* harmony import */ var _AutocompleteSubscribers__WEBPACK_IMPORTED_MODULE_11___default = /*#__PURE__*/__webpack_require__.n(_AutocompleteSubscribers__WEBPACK_IMPORTED_MODULE_11__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _AutocompleteSubscribers__WEBPACK_IMPORTED_MODULE_11__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _AutocompleteSubscribers__WEBPACK_IMPORTED_MODULE_11__[key]; }) }(__WEBPACK_IMPORT_KEY__));













/***/ }),

/***/ "./node_modules/@algolia/autocomplete-core/dist/esm/utils/createConcurrentSafePromise.js":
/*!***********************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-core/dist/esm/utils/createConcurrentSafePromise.js ***!
  \***********************************************************************************************/
/*! exports provided: createConcurrentSafePromise */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "createConcurrentSafePromise", function() { return createConcurrentSafePromise; });
/**
 * Creates a runner that executes promises in a concurrent-safe way.
 *
 * This is useful to prevent older promises to resolve after a newer promise,
 * otherwise resulting in stale resolved values.
 */
function createConcurrentSafePromise() {
  var basePromiseId = -1;
  var latestResolvedId = -1;
  var latestResolvedValue = undefined;
  return function runConcurrentSafePromise(promise) {
    basePromiseId++;
    var currentPromiseId = basePromiseId;
    return Promise.resolve(promise).then(function (x) {
      // The promise might take too long to resolve and get outdated. This would
      // result in resolving stale values.
      // When this happens, we ignore the promise value and return the one
      // coming from the latest resolved value.
      //
      // +----------------------------------+
      // |        100ms                     |
      // | run(1) +--->  R1                 |
      // |        300ms                     |
      // | run(2) +-------------> R2 (SKIP) |
      // |        200ms                     |
      // | run(3) +--------> R3             |
      // +----------------------------------+
      if (latestResolvedValue && currentPromiseId < latestResolvedId) {
        return latestResolvedValue;
      }

      latestResolvedId = currentPromiseId;
      latestResolvedValue = x;
      return x;
    });
  };
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-core/dist/esm/utils/flatten.js":
/*!***************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-core/dist/esm/utils/flatten.js ***!
  \***************************************************************************/
/*! exports provided: flatten */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "flatten", function() { return flatten; });
function flatten(values) {
  return values.reduce(function (a, b) {
    return a.concat(b);
  }, []);
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-core/dist/esm/utils/getActiveItem.js":
/*!*********************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-core/dist/esm/utils/getActiveItem.js ***!
  \*********************************************************************************/
/*! exports provided: getActiveItem */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getActiveItem", function() { return getActiveItem; });
// We don't have access to the autocomplete source when we call `onKeyDown`
// or `onClick` because those are native browser events.
// However, we can get the source from the suggestion index.
function getCollectionFromActiveItemId(state) {
  // Given 3 sources with respectively 1, 2 and 3 suggestions: [1, 2, 3]
  // We want to get the accumulated counts:
  // [1, 1 + 2, 1 + 2 + 3] = [1, 3, 3 + 3] = [1, 3, 6]
  var accumulatedCollectionsCount = state.collections.map(function (collections) {
    return collections.items.length;
  }).reduce(function (acc, collectionsCount, index) {
    var previousValue = acc[index - 1] || 0;
    var nextValue = previousValue + collectionsCount;
    acc.push(nextValue);
    return acc;
  }, []); // Based on the accumulated counts, we can infer the index of the suggestion.

  var collectionIndex = accumulatedCollectionsCount.reduce(function (acc, current) {
    if (current <= state.activeItemId) {
      return acc + 1;
    }

    return acc;
  }, 0);
  return state.collections[collectionIndex];
}
/**
 * Gets the highlighted index relative to a suggestion object (not the absolute
 * highlighted index).
 *
 * Example:
 *  [['a', 'b'], ['c', 'd', 'e'], ['f']]
 *                      ↑
 *         (absolute: 3, relative: 1)
 */


function getRelativeActiveItemId(_ref) {
  var state = _ref.state,
      collection = _ref.collection;
  var isOffsetFound = false;
  var counter = 0;
  var previousItemsOffset = 0;

  while (isOffsetFound === false) {
    var currentCollection = state.collections[counter];

    if (currentCollection === collection) {
      isOffsetFound = true;
      break;
    }

    previousItemsOffset += currentCollection.items.length;
    counter++;
  }

  return state.activeItemId - previousItemsOffset;
}

function getActiveItem(state) {
  var collection = getCollectionFromActiveItemId(state);

  if (!collection) {
    return null;
  }

  var item = collection.items[getRelativeActiveItemId({
    state: state,
    collection: collection
  })];
  var source = collection.source;
  var itemInputValue = source.getItemInputValue({
    item: item,
    state: state
  });
  var itemUrl = source.getItemUrl({
    item: item,
    state: state
  });
  return {
    item: item,
    itemInputValue: itemInputValue,
    itemUrl: itemUrl,
    source: source
  };
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-core/dist/esm/utils/getNextActiveItemId.js":
/*!***************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-core/dist/esm/utils/getNextActiveItemId.js ***!
  \***************************************************************************************/
/*! exports provided: getNextActiveItemId */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getNextActiveItemId", function() { return getNextActiveItemId; });
/**
 * Returns the next active item ID from the current state.
 *
 * We allow circular keyboard navigation from the base index.
 * The base index can either be `null` (nothing is highlighted) or `0`
 * (the first item is highlighted).
 * The base index is allowed to get assigned `null` only if
 * `props.defaultActiveItemId` is `null`. This pattern allows to "stop"
 * by the actual query before navigating to other suggestions as seen on
 * Google or Amazon.
 *
 * @param moveAmount The offset to increment (or decrement) the last index
 * @param baseIndex The current index to compute the next index from
 * @param itemCount The number of items
 * @param defaultActiveItemId The default active index to fallback to
 */
function getNextActiveItemId(moveAmount, baseIndex, itemCount, defaultActiveItemId) {
  if (!itemCount) {
    return null;
  }

  if (moveAmount < 0 && (baseIndex === null || defaultActiveItemId !== null && baseIndex === 0)) {
    return itemCount + moveAmount;
  }

  var numericIndex = (baseIndex === null ? -1 : baseIndex) + moveAmount;

  if (numericIndex <= -1 || numericIndex >= itemCount) {
    return defaultActiveItemId === null ? null : 0;
  }

  return numericIndex;
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-core/dist/esm/utils/getNormalizedSources.js":
/*!****************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-core/dist/esm/utils/getNormalizedSources.js ***!
  \****************************************************************************************/
/*! exports provided: getNormalizedSources */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getNormalizedSources", function() { return getNormalizedSources; });
/* harmony import */ var _algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @algolia/autocomplete-shared */ "./node_modules/@algolia/autocomplete-shared/dist/esm/index.js");
/* harmony import */ var _noop__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./noop */ "./node_modules/@algolia/autocomplete-core/dist/esm/utils/noop.js");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }



function getNormalizedSources(getSources, params) {
  var seenSourceIds = [];
  return Promise.resolve(getSources(params)).then(function (sources) {
    Object(_algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_0__["invariant"])(Array.isArray(sources), "The `getSources` function must return an array of sources but returned type ".concat(JSON.stringify(_typeof(sources)), ":\n\n").concat(JSON.stringify(sources, null, 2)));
    return Promise.all(sources // We allow `undefined` and `false` sources to allow users to use
    // `Boolean(query) && source` (=> `false`).
    // We need to remove these values at this point.
    .filter(function (maybeSource) {
      return Boolean(maybeSource);
    }).map(function (source) {
      Object(_algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_0__["invariant"])(typeof source.sourceId === 'string', 'A source must provide a `sourceId` string.');

      if (seenSourceIds.includes(source.sourceId)) {
        throw new Error("[Autocomplete] The `sourceId` ".concat(JSON.stringify(source.sourceId), " is not unique."));
      }

      seenSourceIds.push(source.sourceId);

      var normalizedSource = _objectSpread({
        getItemInputValue: function getItemInputValue(_ref) {
          var state = _ref.state;
          return state.query;
        },
        getItemUrl: function getItemUrl() {
          return undefined;
        },
        onSelect: function onSelect(_ref2) {
          var setIsOpen = _ref2.setIsOpen;
          setIsOpen(false);
        },
        onActive: _noop__WEBPACK_IMPORTED_MODULE_1__["noop"]
      }, source);

      return Promise.resolve(normalizedSource);
    }));
  });
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-core/dist/esm/utils/index.js":
/*!*************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-core/dist/esm/utils/index.js ***!
  \*************************************************************************/
/*! exports provided: createConcurrentSafePromise, flatten, getNextActiveItemId, getNormalizedSources, getActiveItem, isOrContainsNode, mapToAlgoliaResponse, noop */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _createConcurrentSafePromise__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./createConcurrentSafePromise */ "./node_modules/@algolia/autocomplete-core/dist/esm/utils/createConcurrentSafePromise.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "createConcurrentSafePromise", function() { return _createConcurrentSafePromise__WEBPACK_IMPORTED_MODULE_0__["createConcurrentSafePromise"]; });

/* harmony import */ var _flatten__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./flatten */ "./node_modules/@algolia/autocomplete-core/dist/esm/utils/flatten.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "flatten", function() { return _flatten__WEBPACK_IMPORTED_MODULE_1__["flatten"]; });

/* harmony import */ var _getNextActiveItemId__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./getNextActiveItemId */ "./node_modules/@algolia/autocomplete-core/dist/esm/utils/getNextActiveItemId.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "getNextActiveItemId", function() { return _getNextActiveItemId__WEBPACK_IMPORTED_MODULE_2__["getNextActiveItemId"]; });

/* harmony import */ var _getNormalizedSources__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./getNormalizedSources */ "./node_modules/@algolia/autocomplete-core/dist/esm/utils/getNormalizedSources.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "getNormalizedSources", function() { return _getNormalizedSources__WEBPACK_IMPORTED_MODULE_3__["getNormalizedSources"]; });

/* harmony import */ var _getActiveItem__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./getActiveItem */ "./node_modules/@algolia/autocomplete-core/dist/esm/utils/getActiveItem.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "getActiveItem", function() { return _getActiveItem__WEBPACK_IMPORTED_MODULE_4__["getActiveItem"]; });

/* harmony import */ var _isOrContainsNode__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./isOrContainsNode */ "./node_modules/@algolia/autocomplete-core/dist/esm/utils/isOrContainsNode.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "isOrContainsNode", function() { return _isOrContainsNode__WEBPACK_IMPORTED_MODULE_5__["isOrContainsNode"]; });

/* harmony import */ var _mapToAlgoliaResponse__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./mapToAlgoliaResponse */ "./node_modules/@algolia/autocomplete-core/dist/esm/utils/mapToAlgoliaResponse.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "mapToAlgoliaResponse", function() { return _mapToAlgoliaResponse__WEBPACK_IMPORTED_MODULE_6__["mapToAlgoliaResponse"]; });

/* harmony import */ var _noop__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./noop */ "./node_modules/@algolia/autocomplete-core/dist/esm/utils/noop.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "noop", function() { return _noop__WEBPACK_IMPORTED_MODULE_7__["noop"]; });










/***/ }),

/***/ "./node_modules/@algolia/autocomplete-core/dist/esm/utils/isOrContainsNode.js":
/*!************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-core/dist/esm/utils/isOrContainsNode.js ***!
  \************************************************************************************/
/*! exports provided: isOrContainsNode */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "isOrContainsNode", function() { return isOrContainsNode; });
function isOrContainsNode(parent, child) {
  return parent === child || parent.contains(child);
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-core/dist/esm/utils/mapToAlgoliaResponse.js":
/*!****************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-core/dist/esm/utils/mapToAlgoliaResponse.js ***!
  \****************************************************************************************/
/*! exports provided: mapToAlgoliaResponse */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "mapToAlgoliaResponse", function() { return mapToAlgoliaResponse; });
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function mapToAlgoliaResponse(rawResults) {
  var results = rawResults.map(function (result) {
    var _hits;

    return _objectSpread(_objectSpread({}, result), {}, {
      hits: (_hits = result.hits) === null || _hits === void 0 ? void 0 : _hits.map(function (hit) {
        // Bring support for the Insights plugin.
        return _objectSpread(_objectSpread({}, hit), {}, {
          __autocomplete_indexName: result.index,
          __autocomplete_queryID: result.queryID
        });
      })
    });
  });
  return {
    results: results,
    hits: results.map(function (result) {
      return result.hits;
    }).filter(Boolean),
    facetHits: results.map(function (result) {
      var _facetHits;

      return (_facetHits = result.facetHits) === null || _facetHits === void 0 ? void 0 : _facetHits.map(function (facetHit) {
        // Bring support for the highlighting components.
        return {
          label: facetHit.value,
          count: facetHit.count,
          _highlightResult: {
            label: {
              value: facetHit.highlighted
            }
          }
        };
      });
    }).filter(Boolean)
  };
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-core/dist/esm/utils/noop.js":
/*!************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-core/dist/esm/utils/noop.js ***!
  \************************************************************************/
/*! exports provided: noop */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "noop", function() { return noop; });
var noop = function noop() {};

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-core/dist/esm/version.js":
/*!*********************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-core/dist/esm/version.js ***!
  \*********************************************************************/
/*! exports provided: version */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "version", function() { return version; });
var version = '1.2.2';

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/autocomplete.js":
/*!************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/autocomplete.js ***!
  \************************************************************************/
/*! exports provided: autocomplete */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "autocomplete", function() { return autocomplete; });
/* harmony import */ var _algolia_autocomplete_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @algolia/autocomplete-core */ "./node_modules/@algolia/autocomplete-core/dist/esm/index.js");
/* harmony import */ var _algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @algolia/autocomplete-shared */ "./node_modules/@algolia/autocomplete-shared/dist/esm/index.js");
/* harmony import */ var _createAutocompleteDom__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./createAutocompleteDom */ "./node_modules/@algolia/autocomplete-js/dist/esm/createAutocompleteDom.js");
/* harmony import */ var _createEffectWrapper__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./createEffectWrapper */ "./node_modules/@algolia/autocomplete-js/dist/esm/createEffectWrapper.js");
/* harmony import */ var _createReactiveWrapper__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./createReactiveWrapper */ "./node_modules/@algolia/autocomplete-js/dist/esm/createReactiveWrapper.js");
/* harmony import */ var _getDefaultOptions__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./getDefaultOptions */ "./node_modules/@algolia/autocomplete-js/dist/esm/getDefaultOptions.js");
/* harmony import */ var _getPanelPlacementStyle__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./getPanelPlacementStyle */ "./node_modules/@algolia/autocomplete-js/dist/esm/getPanelPlacementStyle.js");
/* harmony import */ var _render__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./render */ "./node_modules/@algolia/autocomplete-js/dist/esm/render.js");
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./utils */ "./node_modules/@algolia/autocomplete-js/dist/esm/utils/index.js");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }










function autocomplete(options) {
  var _createEffectWrapper = Object(_createEffectWrapper__WEBPACK_IMPORTED_MODULE_3__["createEffectWrapper"])(),
      runEffect = _createEffectWrapper.runEffect,
      cleanupEffects = _createEffectWrapper.cleanupEffects,
      runEffects = _createEffectWrapper.runEffects;

  var _createReactiveWrappe = Object(_createReactiveWrapper__WEBPACK_IMPORTED_MODULE_4__["createReactiveWrapper"])(),
      reactive = _createReactiveWrappe.reactive,
      runReactives = _createReactiveWrappe.runReactives;

  var hasNoResultsSourceTemplateRef = Object(_algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_1__["createRef"])(false);
  var optionsRef = Object(_algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_1__["createRef"])(options);
  var onStateChangeRef = Object(_algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_1__["createRef"])(undefined);
  var props = reactive(function () {
    return Object(_getDefaultOptions__WEBPACK_IMPORTED_MODULE_5__["getDefaultOptions"])(optionsRef.current);
  });
  var isDetached = reactive(function () {
    return props.value.core.environment.matchMedia(props.value.renderer.detachedMediaQuery).matches;
  });
  var autocomplete = reactive(function () {
    return Object(_algolia_autocomplete_core__WEBPACK_IMPORTED_MODULE_0__["createAutocomplete"])(_objectSpread(_objectSpread({}, props.value.core), {}, {
      onStateChange: function onStateChange(params) {
        var _onStateChangeRef$cur, _props$value$core$onS, _props$value$core;

        hasNoResultsSourceTemplateRef.current = params.state.collections.some(function (collection) {
          return collection.source.templates.noResults;
        });
        (_onStateChangeRef$cur = onStateChangeRef.current) === null || _onStateChangeRef$cur === void 0 ? void 0 : _onStateChangeRef$cur.call(onStateChangeRef, params);
        (_props$value$core$onS = (_props$value$core = props.value.core).onStateChange) === null || _props$value$core$onS === void 0 ? void 0 : _props$value$core$onS.call(_props$value$core, params);
      },
      shouldPanelOpen: optionsRef.current.shouldPanelOpen || function (_ref) {
        var state = _ref.state;

        if (isDetached.value) {
          return true;
        }

        var hasItems = Object(_algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_1__["getItemsCount"])(state) > 0;

        if (!props.value.core.openOnFocus && !state.query) {
          return hasItems;
        }

        var hasNoResultsTemplate = Boolean(hasNoResultsSourceTemplateRef.current || props.value.renderer.renderNoResults);
        return !hasItems && hasNoResultsTemplate || hasItems;
      }
    }));
  });
  var lastStateRef = Object(_algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_1__["createRef"])(_objectSpread({
    collections: [],
    completion: null,
    context: {},
    isOpen: false,
    query: '',
    activeItemId: null,
    status: 'idle'
  }, props.value.core.initialState));
  var propGetters = {
    getEnvironmentProps: props.value.renderer.getEnvironmentProps,
    getFormProps: props.value.renderer.getFormProps,
    getInputProps: props.value.renderer.getInputProps,
    getItemProps: props.value.renderer.getItemProps,
    getLabelProps: props.value.renderer.getLabelProps,
    getListProps: props.value.renderer.getListProps,
    getPanelProps: props.value.renderer.getPanelProps,
    getRootProps: props.value.renderer.getRootProps
  };
  var autocompleteScopeApi = {
    setActiveItemId: autocomplete.value.setActiveItemId,
    setQuery: autocomplete.value.setQuery,
    setCollections: autocomplete.value.setCollections,
    setIsOpen: autocomplete.value.setIsOpen,
    setStatus: autocomplete.value.setStatus,
    setContext: autocomplete.value.setContext,
    refresh: autocomplete.value.refresh
  };
  var dom = reactive(function () {
    return Object(_createAutocompleteDom__WEBPACK_IMPORTED_MODULE_2__["createAutocompleteDom"])({
      autocomplete: autocomplete.value,
      autocompleteScopeApi: autocompleteScopeApi,
      classNames: props.value.renderer.classNames,
      environment: props.value.core.environment,
      isDetached: isDetached.value,
      placeholder: props.value.core.placeholder,
      propGetters: propGetters,
      setIsModalOpen: setIsModalOpen,
      state: lastStateRef.current,
      translations: props.value.renderer.translations
    });
  });

  function setPanelPosition() {
    Object(_utils__WEBPACK_IMPORTED_MODULE_8__["setProperties"])(dom.value.panel, {
      style: isDetached.value ? {} : Object(_getPanelPlacementStyle__WEBPACK_IMPORTED_MODULE_6__["getPanelPlacementStyle"])({
        panelPlacement: props.value.renderer.panelPlacement,
        container: dom.value.root,
        form: dom.value.form,
        environment: props.value.core.environment
      })
    });
  }

  function scheduleRender(state) {
    lastStateRef.current = state;
    var renderProps = {
      autocomplete: autocomplete.value,
      autocompleteScopeApi: autocompleteScopeApi,
      classNames: props.value.renderer.classNames,
      components: props.value.renderer.components,
      container: props.value.renderer.container,
      createElement: props.value.renderer.renderer.createElement,
      dom: dom.value,
      Fragment: props.value.renderer.renderer.Fragment,
      panelContainer: isDetached.value ? dom.value.detachedContainer : props.value.renderer.panelContainer,
      propGetters: propGetters,
      state: lastStateRef.current
    };
    var render = !Object(_algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_1__["getItemsCount"])(state) && !hasNoResultsSourceTemplateRef.current && props.value.renderer.renderNoResults || props.value.renderer.render;
    Object(_render__WEBPACK_IMPORTED_MODULE_7__["renderSearchBox"])(renderProps);
    Object(_render__WEBPACK_IMPORTED_MODULE_7__["renderPanel"])(render, renderProps);
  }

  runEffect(function () {
    var environmentProps = autocomplete.value.getEnvironmentProps({
      formElement: dom.value.form,
      panelElement: dom.value.panel,
      inputElement: dom.value.input
    });
    Object(_utils__WEBPACK_IMPORTED_MODULE_8__["setProperties"])(props.value.core.environment, environmentProps);
    return function () {
      Object(_utils__WEBPACK_IMPORTED_MODULE_8__["setProperties"])(props.value.core.environment, Object.keys(environmentProps).reduce(function (acc, key) {
        return _objectSpread(_objectSpread({}, acc), {}, _defineProperty({}, key, undefined));
      }, {}));
    };
  });
  runEffect(function () {
    var panelContainerElement = isDetached.value ? props.value.core.environment.document.body : props.value.renderer.panelContainer;
    var panelElement = isDetached.value ? dom.value.detachedOverlay : dom.value.panel;

    if (isDetached.value && lastStateRef.current.isOpen) {
      setIsModalOpen(true);
    }

    scheduleRender(lastStateRef.current);
    return function () {
      if (panelContainerElement.contains(panelElement)) {
        panelContainerElement.removeChild(panelElement);
      }
    };
  });
  runEffect(function () {
    var containerElement = props.value.renderer.container;
    containerElement.appendChild(dom.value.root);
    return function () {
      containerElement.removeChild(dom.value.root);
    };
  });
  runEffect(function () {
    var debouncedRender = Object(_algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_1__["debounce"])(function (_ref2) {
      var state = _ref2.state;
      scheduleRender(state);
    }, 0);

    onStateChangeRef.current = function (_ref3) {
      var state = _ref3.state,
          prevState = _ref3.prevState;

      if (isDetached.value && prevState.isOpen !== state.isOpen) {
        setIsModalOpen(state.isOpen);
      } // The outer DOM might have changed since the last time the panel was
      // positioned. The layout might have shifted vertically for instance.
      // It's therefore safer to re-calculate the panel position before opening
      // it again.


      if (!isDetached.value && state.isOpen && !prevState.isOpen) {
        setPanelPosition();
      } // We scroll to the top of the panel whenever the query changes (i.e. new
      // results come in) so that users don't have to.


      if (state.query !== prevState.query) {
        var scrollablePanels = props.value.core.environment.document.querySelectorAll('.aa-Panel--scrollable');
        scrollablePanels.forEach(function (scrollablePanel) {
          if (scrollablePanel.scrollTop !== 0) {
            scrollablePanel.scrollTop = 0;
          }
        });
      }

      debouncedRender({
        state: state
      });
    };

    return function () {
      onStateChangeRef.current = undefined;
    };
  });
  runEffect(function () {
    var onResize = Object(_algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_1__["debounce"])(function () {
      var previousIsDetached = isDetached.value;
      isDetached.value = props.value.core.environment.matchMedia(props.value.renderer.detachedMediaQuery).matches;

      if (previousIsDetached !== isDetached.value) {
        update({});
      } else {
        requestAnimationFrame(setPanelPosition);
      }
    }, 20);
    props.value.core.environment.addEventListener('resize', onResize);
    return function () {
      props.value.core.environment.removeEventListener('resize', onResize);
    };
  });
  runEffect(function () {
    if (!isDetached.value) {
      return function () {};
    }

    function toggleModalClassname(isActive) {
      dom.value.detachedContainer.classList.toggle('aa-DetachedContainer--modal', isActive);
    }

    function onChange(event) {
      toggleModalClassname(event.matches);
    }

    var isModalDetachedMql = props.value.core.environment.matchMedia(getComputedStyle(props.value.core.environment.document.documentElement).getPropertyValue('--aa-detached-modal-media-query'));
    toggleModalClassname(isModalDetachedMql.matches); // Prior to Safari 14, `MediaQueryList` isn't based on `EventTarget`,
    // so we must use `addListener` and `removeListener` to observe media query lists.
    // See https://developer.mozilla.org/en-US/docs/Web/API/MediaQueryList/addListener

    var hasModernEventListener = Boolean(isModalDetachedMql.addEventListener);
    hasModernEventListener ? isModalDetachedMql.addEventListener('change', onChange) : isModalDetachedMql.addListener(onChange);
    return function () {
      hasModernEventListener ? isModalDetachedMql.removeEventListener('change', onChange) : isModalDetachedMql.removeListener(onChange);
    };
  });
  runEffect(function () {
    requestAnimationFrame(setPanelPosition);
    return function () {};
  });

  function destroy() {
    cleanupEffects();
  }

  function update() {
    var updatedOptions = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
    cleanupEffects();
    optionsRef.current = Object(_utils__WEBPACK_IMPORTED_MODULE_8__["mergeDeep"])(props.value.renderer, props.value.core, {
      initialState: lastStateRef.current
    }, updatedOptions);
    runReactives();
    runEffects();
    autocomplete.value.refresh().then(function () {
      scheduleRender(lastStateRef.current);
    });
  }

  function setIsModalOpen(value) {
    requestAnimationFrame(function () {
      var prevValue = props.value.core.environment.document.body.contains(dom.value.detachedOverlay);

      if (value === prevValue) {
        return;
      }

      if (value) {
        props.value.core.environment.document.body.appendChild(dom.value.detachedOverlay);
        props.value.core.environment.document.body.classList.add('aa-Detached');
        dom.value.input.focus();
      } else {
        props.value.core.environment.document.body.removeChild(dom.value.detachedOverlay);
        props.value.core.environment.document.body.classList.remove('aa-Detached');
        autocomplete.value.setQuery('');
        autocomplete.value.refresh();
      }
    });
  }

  return _objectSpread(_objectSpread({}, autocompleteScopeApi), {}, {
    update: update,
    destroy: destroy
  });
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/components/Highlight.js":
/*!********************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/components/Highlight.js ***!
  \********************************************************************************/
/*! exports provided: createHighlightComponent */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "createHighlightComponent", function() { return createHighlightComponent; });
/* harmony import */ var _algolia_autocomplete_preset_algolia__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @algolia/autocomplete-preset-algolia */ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/index.js");

function createHighlightComponent(_ref) {
  var createElement = _ref.createElement,
      Fragment = _ref.Fragment;
  return function Highlight(_ref2) {
    var hit = _ref2.hit,
        attribute = _ref2.attribute,
        _ref2$tagName = _ref2.tagName,
        tagName = _ref2$tagName === void 0 ? 'mark' : _ref2$tagName;
    return createElement(Fragment, {}, Object(_algolia_autocomplete_preset_algolia__WEBPACK_IMPORTED_MODULE_0__["parseAlgoliaHitHighlight"])({
      hit: hit,
      attribute: attribute
    }).map(function (x, index) {
      return x.isHighlighted ? createElement(tagName, {
        key: index
      }, x.value) : x.value;
    }));
  };
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/components/ReverseHighlight.js":
/*!***************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/components/ReverseHighlight.js ***!
  \***************************************************************************************/
/*! exports provided: createReverseHighlightComponent */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "createReverseHighlightComponent", function() { return createReverseHighlightComponent; });
/* harmony import */ var _algolia_autocomplete_preset_algolia__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @algolia/autocomplete-preset-algolia */ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/index.js");

function createReverseHighlightComponent(_ref) {
  var createElement = _ref.createElement,
      Fragment = _ref.Fragment;
  return function ReverseHighlight(_ref2) {
    var hit = _ref2.hit,
        attribute = _ref2.attribute,
        _ref2$tagName = _ref2.tagName,
        tagName = _ref2$tagName === void 0 ? 'mark' : _ref2$tagName;
    return createElement(Fragment, {}, Object(_algolia_autocomplete_preset_algolia__WEBPACK_IMPORTED_MODULE_0__["parseAlgoliaHitReverseHighlight"])({
      hit: hit,
      attribute: attribute
    }).map(function (x, index) {
      return x.isHighlighted ? createElement(tagName, {
        key: index
      }, x.value) : x.value;
    }));
  };
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/components/ReverseSnippet.js":
/*!*************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/components/ReverseSnippet.js ***!
  \*************************************************************************************/
/*! exports provided: createReverseSnippetComponent */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "createReverseSnippetComponent", function() { return createReverseSnippetComponent; });
/* harmony import */ var _algolia_autocomplete_preset_algolia__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @algolia/autocomplete-preset-algolia */ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/index.js");

function createReverseSnippetComponent(_ref) {
  var createElement = _ref.createElement,
      Fragment = _ref.Fragment;
  return function ReverseSnippet(_ref2) {
    var hit = _ref2.hit,
        attribute = _ref2.attribute,
        _ref2$tagName = _ref2.tagName,
        tagName = _ref2$tagName === void 0 ? 'mark' : _ref2$tagName;
    return createElement(Fragment, {}, Object(_algolia_autocomplete_preset_algolia__WEBPACK_IMPORTED_MODULE_0__["parseAlgoliaHitReverseSnippet"])({
      hit: hit,
      attribute: attribute
    }).map(function (x, index) {
      return x.isHighlighted ? createElement(tagName, {
        key: index
      }, x.value) : x.value;
    }));
  };
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/components/Snippet.js":
/*!******************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/components/Snippet.js ***!
  \******************************************************************************/
/*! exports provided: createSnippetComponent */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "createSnippetComponent", function() { return createSnippetComponent; });
/* harmony import */ var _algolia_autocomplete_preset_algolia__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @algolia/autocomplete-preset-algolia */ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/index.js");

function createSnippetComponent(_ref) {
  var createElement = _ref.createElement,
      Fragment = _ref.Fragment;
  return function Snippet(_ref2) {
    var hit = _ref2.hit,
        attribute = _ref2.attribute,
        _ref2$tagName = _ref2.tagName,
        tagName = _ref2$tagName === void 0 ? 'mark' : _ref2$tagName;
    return createElement(Fragment, {}, Object(_algolia_autocomplete_preset_algolia__WEBPACK_IMPORTED_MODULE_0__["parseAlgoliaHitSnippet"])({
      hit: hit,
      attribute: attribute
    }).map(function (x, index) {
      return x.isHighlighted ? createElement(tagName, {
        key: index
      }, x.value) : x.value;
    }));
  };
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/components/index.js":
/*!****************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/components/index.js ***!
  \****************************************************************************/
/*! exports provided: createHighlightComponent, createReverseHighlightComponent, createReverseSnippetComponent, createSnippetComponent */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Highlight__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Highlight */ "./node_modules/@algolia/autocomplete-js/dist/esm/components/Highlight.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "createHighlightComponent", function() { return _Highlight__WEBPACK_IMPORTED_MODULE_0__["createHighlightComponent"]; });

/* harmony import */ var _ReverseHighlight__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ReverseHighlight */ "./node_modules/@algolia/autocomplete-js/dist/esm/components/ReverseHighlight.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "createReverseHighlightComponent", function() { return _ReverseHighlight__WEBPACK_IMPORTED_MODULE_1__["createReverseHighlightComponent"]; });

/* harmony import */ var _ReverseSnippet__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ReverseSnippet */ "./node_modules/@algolia/autocomplete-js/dist/esm/components/ReverseSnippet.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "createReverseSnippetComponent", function() { return _ReverseSnippet__WEBPACK_IMPORTED_MODULE_2__["createReverseSnippetComponent"]; });

/* harmony import */ var _Snippet__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./Snippet */ "./node_modules/@algolia/autocomplete-js/dist/esm/components/Snippet.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "createSnippetComponent", function() { return _Snippet__WEBPACK_IMPORTED_MODULE_3__["createSnippetComponent"]; });






/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/createAutocompleteDom.js":
/*!*********************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/createAutocompleteDom.js ***!
  \*********************************************************************************/
/*! exports provided: createAutocompleteDom */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "createAutocompleteDom", function() { return createAutocompleteDom; });
/* harmony import */ var _elements__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./elements */ "./node_modules/@algolia/autocomplete-js/dist/esm/elements/index.js");
/* harmony import */ var _getCreateDomElement__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./getCreateDomElement */ "./node_modules/@algolia/autocomplete-js/dist/esm/getCreateDomElement.js");
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./utils */ "./node_modules/@algolia/autocomplete-js/dist/esm/utils/index.js");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }




function createAutocompleteDom(_ref) {
  var autocomplete = _ref.autocomplete,
      autocompleteScopeApi = _ref.autocompleteScopeApi,
      classNames = _ref.classNames,
      environment = _ref.environment,
      isDetached = _ref.isDetached,
      _ref$placeholder = _ref.placeholder,
      placeholder = _ref$placeholder === void 0 ? 'Search' : _ref$placeholder,
      propGetters = _ref.propGetters,
      setIsModalOpen = _ref.setIsModalOpen,
      state = _ref.state,
      translations = _ref.translations;
  var createDomElement = Object(_getCreateDomElement__WEBPACK_IMPORTED_MODULE_1__["getCreateDomElement"])(environment);
  var rootProps = propGetters.getRootProps(_objectSpread({
    state: state,
    props: autocomplete.getRootProps({})
  }, autocompleteScopeApi));
  var root = createDomElement('div', _objectSpread({
    class: classNames.root
  }, rootProps));
  var detachedContainer = createDomElement('div', {
    class: classNames.detachedContainer,
    onMouseDown: function onMouseDown(event) {
      event.stopPropagation();
    }
  });
  var detachedOverlay = createDomElement('div', {
    class: classNames.detachedOverlay,
    children: [detachedContainer],
    onMouseDown: function onMouseDown() {
      setIsModalOpen(false);
      autocomplete.setIsOpen(false);
    }
  });
  var labelProps = propGetters.getLabelProps(_objectSpread({
    state: state,
    props: autocomplete.getLabelProps({})
  }, autocompleteScopeApi));
  var submitButton = createDomElement('button', {
    class: classNames.submitButton,
    type: 'submit',
    title: translations.submitButtonTitle,
    children: [Object(_elements__WEBPACK_IMPORTED_MODULE_0__["SearchIcon"])({
      environment: environment
    })]
  });
  var label = createDomElement('label', _objectSpread({
    class: classNames.label,
    children: [submitButton]
  }, labelProps));
  var clearButton = createDomElement('button', {
    class: classNames.clearButton,
    type: 'reset',
    title: translations.clearButtonTitle,
    children: [Object(_elements__WEBPACK_IMPORTED_MODULE_0__["ClearIcon"])({
      environment: environment
    })]
  });
  var loadingIndicator = createDomElement('div', {
    class: classNames.loadingIndicator,
    children: [Object(_elements__WEBPACK_IMPORTED_MODULE_0__["LoadingIcon"])({
      environment: environment
    })]
  });
  var input = Object(_elements__WEBPACK_IMPORTED_MODULE_0__["Input"])({
    class: classNames.input,
    environment: environment,
    state: state,
    getInputProps: propGetters.getInputProps,
    getInputPropsCore: autocomplete.getInputProps,
    autocompleteScopeApi: autocompleteScopeApi,
    onDetachedEscape: isDetached ? function () {
      autocomplete.setIsOpen(false);
      setIsModalOpen(false);
    } : undefined
  });
  var inputWrapperPrefix = createDomElement('div', {
    class: classNames.inputWrapperPrefix,
    children: [label, loadingIndicator]
  });
  var inputWrapperSuffix = createDomElement('div', {
    class: classNames.inputWrapperSuffix,
    children: [clearButton]
  });
  var inputWrapper = createDomElement('div', {
    class: classNames.inputWrapper,
    children: [input]
  });
  var formProps = propGetters.getFormProps(_objectSpread({
    state: state,
    props: autocomplete.getFormProps({
      inputElement: input
    })
  }, autocompleteScopeApi));
  var form = createDomElement('form', _objectSpread({
    class: classNames.form,
    children: [inputWrapperPrefix, inputWrapper, inputWrapperSuffix]
  }, formProps));
  var panelProps = propGetters.getPanelProps(_objectSpread({
    state: state,
    props: autocomplete.getPanelProps({})
  }, autocompleteScopeApi));
  var panel = createDomElement('div', _objectSpread({
    class: classNames.panel
  }, panelProps));

  if (false) {}

  if (isDetached) {
    var detachedSearchButtonIcon = createDomElement('div', {
      class: classNames.detachedSearchButtonIcon,
      children: [Object(_elements__WEBPACK_IMPORTED_MODULE_0__["SearchIcon"])({
        environment: environment
      })]
    });
    var detachedSearchButtonPlaceholder = createDomElement('div', {
      class: classNames.detachedSearchButtonPlaceholder,
      textContent: placeholder
    });
    var detachedSearchButton = createDomElement('button', {
      class: classNames.detachedSearchButton,
      onClick: function onClick(event) {
        event.preventDefault();
        setIsModalOpen(true);
      },
      children: [detachedSearchButtonIcon, detachedSearchButtonPlaceholder]
    });
    var detachedCancelButton = createDomElement('button', {
      class: classNames.detachedCancelButton,
      textContent: translations.detachedCancelButtonText,
      onClick: function onClick() {
        autocomplete.setIsOpen(false);
        setIsModalOpen(false);
      }
    });
    var detachedFormContainer = createDomElement('div', {
      class: classNames.detachedFormContainer,
      children: [form, detachedCancelButton]
    });
    detachedContainer.appendChild(detachedFormContainer);
    root.appendChild(detachedSearchButton);
  } else {
    root.appendChild(form);
  }

  return {
    detachedContainer: detachedContainer,
    detachedOverlay: detachedOverlay,
    inputWrapper: inputWrapper,
    input: input,
    root: root,
    form: form,
    label: label,
    submitButton: submitButton,
    clearButton: clearButton,
    loadingIndicator: loadingIndicator,
    panel: panel
  };
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/createEffectWrapper.js":
/*!*******************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/createEffectWrapper.js ***!
  \*******************************************************************************/
/*! exports provided: createEffectWrapper */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "createEffectWrapper", function() { return createEffectWrapper; });
function createEffectWrapper() {
  var effects = [];
  var cleanups = [];

  function runEffect(fn) {
    effects.push(fn);
    var effectCleanup = fn();
    cleanups.push(effectCleanup);
  }

  return {
    runEffect: runEffect,
    cleanupEffects: function cleanupEffects() {
      var currentCleanups = cleanups;
      cleanups = [];
      currentCleanups.forEach(function (cleanup) {
        cleanup();
      });
    },
    runEffects: function runEffects() {
      var currentEffects = effects;
      effects = [];
      currentEffects.forEach(function (effect) {
        runEffect(effect);
      });
    }
  };
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/createReactiveWrapper.js":
/*!*********************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/createReactiveWrapper.js ***!
  \*********************************************************************************/
/*! exports provided: createReactiveWrapper */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "createReactiveWrapper", function() { return createReactiveWrapper; });
function createReactiveWrapper() {
  var reactives = [];
  return {
    reactive: function reactive(value) {
      var current = value();
      var reactive = {
        _fn: value,
        _ref: {
          current: current
        },

        get value() {
          return this._ref.current;
        },

        set value(value) {
          this._ref.current = value;
        }

      };
      reactives.push(reactive);
      return reactive;
    },
    runReactives: function runReactives() {
      reactives.forEach(function (value) {
        value._ref.current = value._fn();
      });
    }
  };
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/elements/ClearIcon.js":
/*!******************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/elements/ClearIcon.js ***!
  \******************************************************************************/
/*! exports provided: ClearIcon */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "ClearIcon", function() { return ClearIcon; });
var ClearIcon = function ClearIcon(_ref) {
  var environment = _ref.environment;
  var element = environment.document.createElementNS('http://www.w3.org/2000/svg', 'svg');
  element.setAttribute('class', 'aa-ClearIcon');
  element.setAttribute('viewBox', '0 0 24 24');
  element.setAttribute('width', '18');
  element.setAttribute('height', '18');
  element.setAttribute('fill', 'currentColor');
  var path = environment.document.createElementNS('http://www.w3.org/2000/svg', 'path');
  path.setAttribute('d', 'M5.293 6.707l5.293 5.293-5.293 5.293c-0.391 0.391-0.391 1.024 0 1.414s1.024 0.391 1.414 0l5.293-5.293 5.293 5.293c0.391 0.391 1.024 0.391 1.414 0s0.391-1.024 0-1.414l-5.293-5.293 5.293-5.293c0.391-0.391 0.391-1.024 0-1.414s-1.024-0.391-1.414 0l-5.293 5.293-5.293-5.293c-0.391-0.391-1.024-0.391-1.414 0s-0.391 1.024 0 1.414z');
  element.appendChild(path);
  return element;
};

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/elements/Input.js":
/*!**************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/elements/Input.js ***!
  \**************************************************************************/
/*! exports provided: Input */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Input", function() { return Input; });
/* harmony import */ var _getCreateDomElement__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../getCreateDomElement */ "./node_modules/@algolia/autocomplete-js/dist/esm/getCreateDomElement.js");
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../utils */ "./node_modules/@algolia/autocomplete-js/dist/esm/utils/index.js");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _objectWithoutProperties(source, excluded) { if (source == null) return {}; var target = _objectWithoutPropertiesLoose(source, excluded); var key, i; if (Object.getOwnPropertySymbols) { var sourceSymbolKeys = Object.getOwnPropertySymbols(source); for (i = 0; i < sourceSymbolKeys.length; i++) { key = sourceSymbolKeys[i]; if (excluded.indexOf(key) >= 0) continue; if (!Object.prototype.propertyIsEnumerable.call(source, key)) continue; target[key] = source[key]; } } return target; }

function _objectWithoutPropertiesLoose(source, excluded) { if (source == null) return {}; var target = {}; var sourceKeys = Object.keys(source); var key, i; for (i = 0; i < sourceKeys.length; i++) { key = sourceKeys[i]; if (excluded.indexOf(key) >= 0) continue; target[key] = source[key]; } return target; }



var Input = function Input(_ref) {
  var autocompleteScopeApi = _ref.autocompleteScopeApi,
      environment = _ref.environment,
      classNames = _ref.classNames,
      getInputProps = _ref.getInputProps,
      getInputPropsCore = _ref.getInputPropsCore,
      onDetachedEscape = _ref.onDetachedEscape,
      state = _ref.state,
      props = _objectWithoutProperties(_ref, ["autocompleteScopeApi", "environment", "classNames", "getInputProps", "getInputPropsCore", "onDetachedEscape", "state"]);

  var createDomElement = Object(_getCreateDomElement__WEBPACK_IMPORTED_MODULE_0__["getCreateDomElement"])(environment);
  var element = createDomElement('input', props);
  var inputProps = getInputProps(_objectSpread({
    state: state,
    props: getInputPropsCore({
      inputElement: element
    }),
    inputElement: element
  }, autocompleteScopeApi));
  Object(_utils__WEBPACK_IMPORTED_MODULE_1__["setProperties"])(element, _objectSpread(_objectSpread({}, inputProps), {}, {
    onKeyDown: function onKeyDown(event) {
      if (onDetachedEscape && event.key === 'Escape') {
        event.preventDefault();
        onDetachedEscape();
        return;
      }

      inputProps.onKeyDown(event);
    }
  }));
  return element;
};

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/elements/LoadingIcon.js":
/*!********************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/elements/LoadingIcon.js ***!
  \********************************************************************************/
/*! exports provided: LoadingIcon */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "LoadingIcon", function() { return LoadingIcon; });
var LoadingIcon = function LoadingIcon(_ref) {
  var environment = _ref.environment;
  var element = environment.document.createElementNS('http://www.w3.org/2000/svg', 'svg');
  element.setAttribute('class', 'aa-LoadingIcon');
  element.setAttribute('viewBox', '0 0 100 100');
  element.setAttribute('width', '20');
  element.setAttribute('height', '20');
  element.innerHTML = "<circle\n  cx=\"50\"\n  cy=\"50\"\n  fill=\"none\"\n  r=\"35\"\n  stroke=\"currentColor\"\n  stroke-dasharray=\"164.93361431346415 56.97787143782138\"\n  stroke-width=\"6\"\n>\n  <animateTransform\n    attributeName=\"transform\"\n    type=\"rotate\"\n    repeatCount=\"indefinite\"\n    dur=\"1s\"\n    values=\"0 50 50;90 50 50;180 50 50;360 50 50\"\n    keyTimes=\"0;0.40;0.65;1\"\n  />\n</circle>";
  return element;
};

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/elements/SearchIcon.js":
/*!*******************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/elements/SearchIcon.js ***!
  \*******************************************************************************/
/*! exports provided: SearchIcon */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "SearchIcon", function() { return SearchIcon; });
var SearchIcon = function SearchIcon(_ref) {
  var environment = _ref.environment;
  var element = environment.document.createElementNS('http://www.w3.org/2000/svg', 'svg');
  element.setAttribute('class', 'aa-SubmitIcon');
  element.setAttribute('viewBox', '0 0 24 24');
  element.setAttribute('width', '20');
  element.setAttribute('height', '20');
  element.setAttribute('fill', 'currentColor');
  var path = environment.document.createElementNS('http://www.w3.org/2000/svg', 'path');
  path.setAttribute('d', 'M16.041 15.856c-0.034 0.026-0.067 0.055-0.099 0.087s-0.060 0.064-0.087 0.099c-1.258 1.213-2.969 1.958-4.855 1.958-1.933 0-3.682-0.782-4.95-2.050s-2.050-3.017-2.050-4.95 0.782-3.682 2.050-4.95 3.017-2.050 4.95-2.050 3.682 0.782 4.95 2.050 2.050 3.017 2.050 4.95c0 1.886-0.745 3.597-1.959 4.856zM21.707 20.293l-3.675-3.675c1.231-1.54 1.968-3.493 1.968-5.618 0-2.485-1.008-4.736-2.636-6.364s-3.879-2.636-6.364-2.636-4.736 1.008-6.364 2.636-2.636 3.879-2.636 6.364 1.008 4.736 2.636 6.364 3.879 2.636 6.364 2.636c2.125 0 4.078-0.737 5.618-1.968l3.675 3.675c0.391 0.391 1.024 0.391 1.414 0s0.391-1.024 0-1.414z');
  element.appendChild(path);
  return element;
};

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/elements/index.js":
/*!**************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/elements/index.js ***!
  \**************************************************************************/
/*! exports provided: ClearIcon, Input, LoadingIcon, SearchIcon */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ClearIcon__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ClearIcon */ "./node_modules/@algolia/autocomplete-js/dist/esm/elements/ClearIcon.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "ClearIcon", function() { return _ClearIcon__WEBPACK_IMPORTED_MODULE_0__["ClearIcon"]; });

/* harmony import */ var _Input__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Input */ "./node_modules/@algolia/autocomplete-js/dist/esm/elements/Input.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "Input", function() { return _Input__WEBPACK_IMPORTED_MODULE_1__["Input"]; });

/* harmony import */ var _LoadingIcon__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./LoadingIcon */ "./node_modules/@algolia/autocomplete-js/dist/esm/elements/LoadingIcon.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "LoadingIcon", function() { return _LoadingIcon__WEBPACK_IMPORTED_MODULE_2__["LoadingIcon"]; });

/* harmony import */ var _SearchIcon__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./SearchIcon */ "./node_modules/@algolia/autocomplete-js/dist/esm/elements/SearchIcon.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "SearchIcon", function() { return _SearchIcon__WEBPACK_IMPORTED_MODULE_3__["SearchIcon"]; });






/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/getCreateDomElement.js":
/*!*******************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/getCreateDomElement.js ***!
  \*******************************************************************************/
/*! exports provided: getCreateDomElement */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getCreateDomElement", function() { return getCreateDomElement; });
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./utils */ "./node_modules/@algolia/autocomplete-js/dist/esm/utils/index.js");
function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && Symbol.iterator in Object(iter)) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _objectWithoutProperties(source, excluded) { if (source == null) return {}; var target = _objectWithoutPropertiesLoose(source, excluded); var key, i; if (Object.getOwnPropertySymbols) { var sourceSymbolKeys = Object.getOwnPropertySymbols(source); for (i = 0; i < sourceSymbolKeys.length; i++) { key = sourceSymbolKeys[i]; if (excluded.indexOf(key) >= 0) continue; if (!Object.prototype.propertyIsEnumerable.call(source, key)) continue; target[key] = source[key]; } } return target; }

function _objectWithoutPropertiesLoose(source, excluded) { if (source == null) return {}; var target = {}; var sourceKeys = Object.keys(source); var key, i; for (i = 0; i < sourceKeys.length; i++) { key = sourceKeys[i]; if (excluded.indexOf(key) >= 0) continue; target[key] = source[key]; } return target; }


function getCreateDomElement(environment) {
  return function createDomElement(tagName, _ref) {
    var _ref$children = _ref.children,
        children = _ref$children === void 0 ? [] : _ref$children,
        props = _objectWithoutProperties(_ref, ["children"]);

    var element = environment.document.createElement(tagName);
    Object(_utils__WEBPACK_IMPORTED_MODULE_0__["setProperties"])(element, props);
    element.append.apply(element, _toConsumableArray(children));
    return element;
  };
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/getDefaultOptions.js":
/*!*****************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/getDefaultOptions.js ***!
  \*****************************************************************************/
/*! exports provided: getDefaultOptions */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getDefaultOptions", function() { return getDefaultOptions; });
/* harmony import */ var _algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @algolia/autocomplete-shared */ "./node_modules/@algolia/autocomplete-shared/dist/esm/index.js");
/* harmony import */ var preact__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! preact */ "./node_modules/preact/dist/preact.module.js");
/* harmony import */ var _components__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./components */ "./node_modules/@algolia/autocomplete-js/dist/esm/components/index.js");
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./utils */ "./node_modules/@algolia/autocomplete-js/dist/esm/utils/index.js");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _objectWithoutProperties(source, excluded) { if (source == null) return {}; var target = _objectWithoutPropertiesLoose(source, excluded); var key, i; if (Object.getOwnPropertySymbols) { var sourceSymbolKeys = Object.getOwnPropertySymbols(source); for (i = 0; i < sourceSymbolKeys.length; i++) { key = sourceSymbolKeys[i]; if (excluded.indexOf(key) >= 0) continue; if (!Object.prototype.propertyIsEnumerable.call(source, key)) continue; target[key] = source[key]; } } return target; }

function _objectWithoutPropertiesLoose(source, excluded) { if (source == null) return {}; var target = {}; var sourceKeys = Object.keys(source); var key, i; for (i = 0; i < sourceKeys.length; i++) { key = sourceKeys[i]; if (excluded.indexOf(key) >= 0) continue; target[key] = source[key]; } return target; }





var defaultClassNames = {
  clearButton: 'aa-ClearButton',
  detachedCancelButton: 'aa-DetachedCancelButton',
  detachedContainer: 'aa-DetachedContainer',
  detachedFormContainer: 'aa-DetachedFormContainer',
  detachedOverlay: 'aa-DetachedOverlay',
  detachedSearchButton: 'aa-DetachedSearchButton',
  detachedSearchButtonIcon: 'aa-DetachedSearchButtonIcon',
  detachedSearchButtonPlaceholder: 'aa-DetachedSearchButtonPlaceholder',
  form: 'aa-Form',
  input: 'aa-Input',
  inputWrapper: 'aa-InputWrapper',
  inputWrapperPrefix: 'aa-InputWrapperPrefix',
  inputWrapperSuffix: 'aa-InputWrapperSuffix',
  item: 'aa-Item',
  label: 'aa-Label',
  list: 'aa-List',
  loadingIndicator: 'aa-LoadingIndicator',
  panel: 'aa-Panel',
  panelLayout: 'aa-PanelLayout aa-Panel--scrollable',
  root: 'aa-Autocomplete',
  source: 'aa-Source',
  sourceFooter: 'aa-SourceFooter',
  sourceHeader: 'aa-SourceHeader',
  sourceNoResults: 'aa-SourceNoResults',
  submitButton: 'aa-SubmitButton'
};

var defaultRender = function defaultRender(_ref, root) {
  var children = _ref.children;
  Object(preact__WEBPACK_IMPORTED_MODULE_1__["render"])(children, root);
};

var defaultRenderer = {
  createElement: preact__WEBPACK_IMPORTED_MODULE_1__["createElement"],
  Fragment: preact__WEBPACK_IMPORTED_MODULE_1__["Fragment"]
};
function getDefaultOptions(options) {
  var _core$id;

  var classNames = options.classNames,
      container = options.container,
      getEnvironmentProps = options.getEnvironmentProps,
      getFormProps = options.getFormProps,
      getInputProps = options.getInputProps,
      getItemProps = options.getItemProps,
      getLabelProps = options.getLabelProps,
      getListProps = options.getListProps,
      getPanelProps = options.getPanelProps,
      getRootProps = options.getRootProps,
      panelContainer = options.panelContainer,
      panelPlacement = options.panelPlacement,
      render = options.render,
      renderNoResults = options.renderNoResults,
      renderer = options.renderer,
      detachedMediaQuery = options.detachedMediaQuery,
      components = options.components,
      translations = options.translations,
      core = _objectWithoutProperties(options, ["classNames", "container", "getEnvironmentProps", "getFormProps", "getInputProps", "getItemProps", "getLabelProps", "getListProps", "getPanelProps", "getRootProps", "panelContainer", "panelPlacement", "render", "renderNoResults", "renderer", "detachedMediaQuery", "components", "translations"]);
  /* eslint-disable no-restricted-globals */


  var environment = typeof window !== 'undefined' ? window : {};
  /* eslint-enable no-restricted-globals */

  var containerElement = Object(_utils__WEBPACK_IMPORTED_MODULE_3__["getHTMLElement"])(environment, container);
  Object(_algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_0__["invariant"])(containerElement.tagName !== 'INPUT', 'The `container` option does not support `input` elements. You need to change the container to a `div`.');
  var defaultedRenderer = renderer !== null && renderer !== void 0 ? renderer : defaultRenderer;
  var defaultComponents = {
    Highlight: Object(_components__WEBPACK_IMPORTED_MODULE_2__["createHighlightComponent"])(defaultedRenderer),
    ReverseHighlight: Object(_components__WEBPACK_IMPORTED_MODULE_2__["createReverseHighlightComponent"])(defaultedRenderer),
    ReverseSnippet: Object(_components__WEBPACK_IMPORTED_MODULE_2__["createReverseSnippetComponent"])(defaultedRenderer),
    Snippet: Object(_components__WEBPACK_IMPORTED_MODULE_2__["createSnippetComponent"])(defaultedRenderer)
  };
  var defaultTranslations = {
    clearButtonTitle: 'Clear',
    detachedCancelButtonText: 'Cancel',
    submitButtonTitle: 'Submit'
  };
  return {
    renderer: {
      classNames: Object(_utils__WEBPACK_IMPORTED_MODULE_3__["mergeClassNames"])(defaultClassNames, classNames !== null && classNames !== void 0 ? classNames : {}),
      container: containerElement,
      getEnvironmentProps: getEnvironmentProps !== null && getEnvironmentProps !== void 0 ? getEnvironmentProps : function (_ref2) {
        var props = _ref2.props;
        return props;
      },
      getFormProps: getFormProps !== null && getFormProps !== void 0 ? getFormProps : function (_ref3) {
        var props = _ref3.props;
        return props;
      },
      getInputProps: getInputProps !== null && getInputProps !== void 0 ? getInputProps : function (_ref4) {
        var props = _ref4.props;
        return props;
      },
      getItemProps: getItemProps !== null && getItemProps !== void 0 ? getItemProps : function (_ref5) {
        var props = _ref5.props;
        return props;
      },
      getLabelProps: getLabelProps !== null && getLabelProps !== void 0 ? getLabelProps : function (_ref6) {
        var props = _ref6.props;
        return props;
      },
      getListProps: getListProps !== null && getListProps !== void 0 ? getListProps : function (_ref7) {
        var props = _ref7.props;
        return props;
      },
      getPanelProps: getPanelProps !== null && getPanelProps !== void 0 ? getPanelProps : function (_ref8) {
        var props = _ref8.props;
        return props;
      },
      getRootProps: getRootProps !== null && getRootProps !== void 0 ? getRootProps : function (_ref9) {
        var props = _ref9.props;
        return props;
      },
      panelContainer: panelContainer ? Object(_utils__WEBPACK_IMPORTED_MODULE_3__["getHTMLElement"])(environment, panelContainer) : environment.document.body,
      panelPlacement: panelPlacement !== null && panelPlacement !== void 0 ? panelPlacement : 'input-wrapper-width',
      render: render !== null && render !== void 0 ? render : defaultRender,
      renderNoResults: renderNoResults,
      renderer: defaultedRenderer,
      detachedMediaQuery: detachedMediaQuery !== null && detachedMediaQuery !== void 0 ? detachedMediaQuery : getComputedStyle(environment.document.documentElement).getPropertyValue('--aa-detached-media-query'),
      components: _objectSpread(_objectSpread({}, defaultComponents), components),
      translations: _objectSpread(_objectSpread({}, defaultTranslations), translations)
    },
    core: _objectSpread(_objectSpread({}, core), {}, {
      id: (_core$id = core.id) !== null && _core$id !== void 0 ? _core$id : Object(_algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_0__["generateAutocompleteId"])(),
      environment: environment
    })
  };
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/getPanelPlacementStyle.js":
/*!**********************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/getPanelPlacementStyle.js ***!
  \**********************************************************************************/
/*! exports provided: getPanelPlacementStyle */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getPanelPlacementStyle", function() { return getPanelPlacementStyle; });
function getPanelPlacementStyle(_ref) {
  var panelPlacement = _ref.panelPlacement,
      container = _ref.container,
      form = _ref.form,
      environment = _ref.environment;
  var containerRect = container.getBoundingClientRect(); // Some browsers have specificities to retrieve the document scroll position.
  // See https://stackoverflow.com/a/28633515/9940315

  var scrollTop = environment.pageYOffset || environment.document.documentElement.scrollTop || environment.document.body.scrollTop || 0;
  var top = scrollTop + containerRect.top + containerRect.height;

  switch (panelPlacement) {
    case 'start':
      {
        return {
          top: top,
          left: containerRect.left
        };
      }

    case 'end':
      {
        return {
          top: top,
          right: environment.document.documentElement.clientWidth - (containerRect.left + containerRect.width)
        };
      }

    case 'full-width':
      {
        return {
          top: top,
          left: 0,
          right: 0,
          width: 'unset',
          maxWidth: 'unset'
        };
      }

    case 'input-wrapper-width':
      {
        var formRect = form.getBoundingClientRect();
        return {
          top: top,
          left: formRect.left,
          right: environment.document.documentElement.clientWidth - (formRect.left + formRect.width),
          width: 'unset',
          maxWidth: 'unset'
        };
      }

    default:
      {
        throw new Error("[Autocomplete] The `panelPlacement` value ".concat(JSON.stringify(panelPlacement), " is not valid."));
      }
  }
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/index.js":
/*!*****************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/index.js ***!
  \*****************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _autocomplete__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./autocomplete */ "./node_modules/@algolia/autocomplete-js/dist/esm/autocomplete.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "autocomplete", function() { return _autocomplete__WEBPACK_IMPORTED_MODULE_0__["autocomplete"]; });

/* harmony import */ var _requesters__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./requesters */ "./node_modules/@algolia/autocomplete-js/dist/esm/requesters/index.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "getAlgoliaFacets", function() { return _requesters__WEBPACK_IMPORTED_MODULE_1__["getAlgoliaFacets"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "getAlgoliaResults", function() { return _requesters__WEBPACK_IMPORTED_MODULE_1__["getAlgoliaResults"]; });

/* harmony import */ var _types__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./types */ "./node_modules/@algolia/autocomplete-js/dist/esm/types/index.js");
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _types__WEBPACK_IMPORTED_MODULE_2__) if(["default","autocomplete","getAlgoliaFacets","getAlgoliaResults"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _types__WEBPACK_IMPORTED_MODULE_2__[key]; }) }(__WEBPACK_IMPORT_KEY__));




/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/render.js":
/*!******************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/render.js ***!
  \******************************************************************/
/*! exports provided: renderSearchBox, renderPanel */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "renderSearchBox", function() { return renderSearchBox; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "renderPanel", function() { return renderPanel; });
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./utils */ "./node_modules/@algolia/autocomplete-js/dist/esm/utils/index.js");
function _extends() { _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; return _extends.apply(this, arguments); }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

/** @jsx createElement */

function renderSearchBox(_ref) {
  var autocomplete = _ref.autocomplete,
      autocompleteScopeApi = _ref.autocompleteScopeApi,
      dom = _ref.dom,
      propGetters = _ref.propGetters,
      state = _ref.state;
  Object(_utils__WEBPACK_IMPORTED_MODULE_0__["setPropertiesWithoutEvents"])(dom.root, propGetters.getRootProps(_objectSpread({
    state: state,
    props: autocomplete.getRootProps({})
  }, autocompleteScopeApi)));
  Object(_utils__WEBPACK_IMPORTED_MODULE_0__["setPropertiesWithoutEvents"])(dom.input, propGetters.getInputProps(_objectSpread({
    state: state,
    props: autocomplete.getInputProps({
      inputElement: dom.input
    }),
    inputElement: dom.input
  }, autocompleteScopeApi)));
  Object(_utils__WEBPACK_IMPORTED_MODULE_0__["setProperties"])(dom.label, {
    hidden: state.status === 'stalled'
  });
  Object(_utils__WEBPACK_IMPORTED_MODULE_0__["setProperties"])(dom.loadingIndicator, {
    hidden: state.status !== 'stalled'
  });
  Object(_utils__WEBPACK_IMPORTED_MODULE_0__["setProperties"])(dom.clearButton, {
    hidden: !state.query
  });
}
function renderPanel(render, _ref2) {
  var autocomplete = _ref2.autocomplete,
      autocompleteScopeApi = _ref2.autocompleteScopeApi,
      classNames = _ref2.classNames,
      createElement = _ref2.createElement,
      dom = _ref2.dom,
      Fragment = _ref2.Fragment,
      panelContainer = _ref2.panelContainer,
      propGetters = _ref2.propGetters,
      state = _ref2.state,
      components = _ref2.components;

  if (!state.isOpen) {
    if (panelContainer.contains(dom.panel)) {
      panelContainer.removeChild(dom.panel);
    }

    return;
  } // We add the panel element to the DOM when it's not yet appended and that the
  // items are fetched.


  if (!panelContainer.contains(dom.panel) && state.status !== 'loading') {
    panelContainer.appendChild(dom.panel);
  }

  dom.panel.classList.toggle('aa-Panel--stalled', state.status === 'stalled');
  var sections = state.collections.filter(function (_ref3) {
    var source = _ref3.source,
        items = _ref3.items;
    return source.templates.noResults || items.length > 0;
  }).map(function (_ref4, sourceIndex) {
    var source = _ref4.source,
        items = _ref4.items;
    return createElement("section", {
      key: sourceIndex,
      className: classNames.source,
      "data-autocomplete-source-id": source.sourceId
    }, source.templates.header && createElement("div", {
      className: classNames.sourceHeader
    }, source.templates.header({
      components: components,
      createElement: createElement,
      Fragment: Fragment,
      items: items,
      source: source,
      state: state
    })), source.templates.noResults && items.length === 0 ? createElement("div", {
      className: classNames.sourceNoResults
    }, source.templates.noResults({
      components: components,
      createElement: createElement,
      Fragment: Fragment,
      source: source,
      state: state
    })) : createElement("ul", _extends({
      className: classNames.list
    }, propGetters.getListProps(_objectSpread({
      state: state,
      props: autocomplete.getListProps({})
    }, autocompleteScopeApi))), items.map(function (item) {
      var itemProps = autocomplete.getItemProps({
        item: item,
        source: source
      });
      return createElement("li", _extends({
        key: itemProps.id,
        className: classNames.item
      }, propGetters.getItemProps(_objectSpread({
        state: state,
        props: itemProps
      }, autocompleteScopeApi))), source.templates.item({
        components: components,
        createElement: createElement,
        Fragment: Fragment,
        item: item,
        state: state
      }));
    })), source.templates.footer && createElement("div", {
      className: classNames.sourceFooter
    }, source.templates.footer({
      components: components,
      createElement: createElement,
      Fragment: Fragment,
      items: items,
      source: source,
      state: state
    })));
  });
  var children = createElement(Fragment, null, createElement("div", {
    className: classNames.panelLayout
  }, sections), createElement("div", {
    className: "aa-GradientBottom"
  }));
  var elements = sections.reduce(function (acc, current) {
    acc[current.props['data-autocomplete-source-id']] = current;
    return acc;
  }, {});
  render(_objectSpread({
    children: children,
    state: state,
    sections: sections,
    elements: elements,
    createElement: createElement,
    Fragment: Fragment,
    components: components
  }, autocompleteScopeApi), dom.panel);
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/requesters/createAlgoliaRequester.js":
/*!*********************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/requesters/createAlgoliaRequester.js ***!
  \*********************************************************************************************/
/*! exports provided: createAlgoliaRequester */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "createAlgoliaRequester", function() { return createAlgoliaRequester; });
/* harmony import */ var _algolia_autocomplete_preset_algolia__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @algolia/autocomplete-preset-algolia */ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/index.js");
/* harmony import */ var _version__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../version */ "./node_modules/@algolia/autocomplete-js/dist/esm/version.js");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }



var createAlgoliaRequester = Object(_algolia_autocomplete_preset_algolia__WEBPACK_IMPORTED_MODULE_0__["createRequester"])(function (params) {
  return Object(_algolia_autocomplete_preset_algolia__WEBPACK_IMPORTED_MODULE_0__["fetchAlgoliaResults"])(_objectSpread(_objectSpread({}, params), {}, {
    userAgents: [{
      segment: 'autocomplete-js',
      version: _version__WEBPACK_IMPORTED_MODULE_1__["version"]
    }]
  }));
});

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/requesters/getAlgoliaFacets.js":
/*!***************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/requesters/getAlgoliaFacets.js ***!
  \***************************************************************************************/
/*! exports provided: getAlgoliaFacets */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getAlgoliaFacets", function() { return getAlgoliaFacets; });
/* harmony import */ var _createAlgoliaRequester__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./createAlgoliaRequester */ "./node_modules/@algolia/autocomplete-js/dist/esm/requesters/createAlgoliaRequester.js");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }


/**
 * Retrieves Algolia facet hits from multiple indices.
 */

function getAlgoliaFacets(requestParams) {
  var requester = Object(_createAlgoliaRequester__WEBPACK_IMPORTED_MODULE_0__["createAlgoliaRequester"])({
    transformResponse: function transformResponse(response) {
      return response.facetHits;
    }
  });
  var queries = requestParams.queries.map(function (query) {
    return _objectSpread(_objectSpread({}, query), {}, {
      type: 'facet'
    });
  });
  return requester(_objectSpread(_objectSpread({}, requestParams), {}, {
    queries: queries
  }));
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/requesters/getAlgoliaResults.js":
/*!****************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/requesters/getAlgoliaResults.js ***!
  \****************************************************************************************/
/*! exports provided: getAlgoliaResults */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getAlgoliaResults", function() { return getAlgoliaResults; });
/* harmony import */ var _createAlgoliaRequester__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./createAlgoliaRequester */ "./node_modules/@algolia/autocomplete-js/dist/esm/requesters/createAlgoliaRequester.js");

/**
 * Retrieves Algolia results from multiple indices.
 */

var getAlgoliaResults = Object(_createAlgoliaRequester__WEBPACK_IMPORTED_MODULE_0__["createAlgoliaRequester"])({
  transformResponse: function transformResponse(response) {
    return response.hits;
  }
});

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/requesters/index.js":
/*!****************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/requesters/index.js ***!
  \****************************************************************************/
/*! exports provided: getAlgoliaFacets, getAlgoliaResults */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _getAlgoliaFacets__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./getAlgoliaFacets */ "./node_modules/@algolia/autocomplete-js/dist/esm/requesters/getAlgoliaFacets.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "getAlgoliaFacets", function() { return _getAlgoliaFacets__WEBPACK_IMPORTED_MODULE_0__["getAlgoliaFacets"]; });

/* harmony import */ var _getAlgoliaResults__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./getAlgoliaResults */ "./node_modules/@algolia/autocomplete-js/dist/esm/requesters/getAlgoliaResults.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "getAlgoliaResults", function() { return _getAlgoliaResults__WEBPACK_IMPORTED_MODULE_1__["getAlgoliaResults"]; });




/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompleteApi.js":
/*!*********************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompleteApi.js ***!
  \*********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompleteClassNames.js":
/*!****************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompleteClassNames.js ***!
  \****************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompleteCollection.js":
/*!****************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompleteCollection.js ***!
  \****************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompleteComponents.js":
/*!****************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompleteComponents.js ***!
  \****************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompleteDom.js":
/*!*********************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompleteDom.js ***!
  \*********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompleteOptions.js":
/*!*************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompleteOptions.js ***!
  \*************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompletePlugin.js":
/*!************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompletePlugin.js ***!
  \************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompletePropGetters.js":
/*!*****************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompletePropGetters.js ***!
  \*****************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompleteRender.js":
/*!************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompleteRender.js ***!
  \************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompleteRenderer.js":
/*!**************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompleteRenderer.js ***!
  \**************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompleteSource.js":
/*!************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompleteSource.js ***!
  \************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompleteState.js":
/*!***********************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompleteState.js ***!
  \***********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompleteTranslations.js":
/*!******************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompleteTranslations.js ***!
  \******************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/types/HighlightHitParams.js":
/*!************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/types/HighlightHitParams.js ***!
  \************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/types/index.js":
/*!***********************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/types/index.js ***!
  \***********************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _AutocompleteApi__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./AutocompleteApi */ "./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompleteApi.js");
/* harmony import */ var _AutocompleteApi__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_AutocompleteApi__WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _AutocompleteApi__WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _AutocompleteApi__WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _AutocompleteClassNames__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./AutocompleteClassNames */ "./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompleteClassNames.js");
/* harmony import */ var _AutocompleteClassNames__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_AutocompleteClassNames__WEBPACK_IMPORTED_MODULE_1__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _AutocompleteClassNames__WEBPACK_IMPORTED_MODULE_1__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _AutocompleteClassNames__WEBPACK_IMPORTED_MODULE_1__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _AutocompleteCollection__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./AutocompleteCollection */ "./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompleteCollection.js");
/* harmony import */ var _AutocompleteCollection__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_AutocompleteCollection__WEBPACK_IMPORTED_MODULE_2__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _AutocompleteCollection__WEBPACK_IMPORTED_MODULE_2__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _AutocompleteCollection__WEBPACK_IMPORTED_MODULE_2__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _AutocompleteComponents__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./AutocompleteComponents */ "./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompleteComponents.js");
/* harmony import */ var _AutocompleteComponents__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_AutocompleteComponents__WEBPACK_IMPORTED_MODULE_3__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _AutocompleteComponents__WEBPACK_IMPORTED_MODULE_3__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _AutocompleteComponents__WEBPACK_IMPORTED_MODULE_3__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _AutocompleteDom__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./AutocompleteDom */ "./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompleteDom.js");
/* harmony import */ var _AutocompleteDom__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_AutocompleteDom__WEBPACK_IMPORTED_MODULE_4__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _AutocompleteDom__WEBPACK_IMPORTED_MODULE_4__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _AutocompleteDom__WEBPACK_IMPORTED_MODULE_4__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _AutocompleteOptions__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./AutocompleteOptions */ "./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompleteOptions.js");
/* harmony import */ var _AutocompleteOptions__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_AutocompleteOptions__WEBPACK_IMPORTED_MODULE_5__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _AutocompleteOptions__WEBPACK_IMPORTED_MODULE_5__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _AutocompleteOptions__WEBPACK_IMPORTED_MODULE_5__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _AutocompletePlugin__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./AutocompletePlugin */ "./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompletePlugin.js");
/* harmony import */ var _AutocompletePlugin__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_AutocompletePlugin__WEBPACK_IMPORTED_MODULE_6__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _AutocompletePlugin__WEBPACK_IMPORTED_MODULE_6__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _AutocompletePlugin__WEBPACK_IMPORTED_MODULE_6__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _AutocompletePropGetters__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./AutocompletePropGetters */ "./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompletePropGetters.js");
/* harmony import */ var _AutocompletePropGetters__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_AutocompletePropGetters__WEBPACK_IMPORTED_MODULE_7__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _AutocompletePropGetters__WEBPACK_IMPORTED_MODULE_7__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _AutocompletePropGetters__WEBPACK_IMPORTED_MODULE_7__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _AutocompleteRender__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./AutocompleteRender */ "./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompleteRender.js");
/* harmony import */ var _AutocompleteRender__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(_AutocompleteRender__WEBPACK_IMPORTED_MODULE_8__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _AutocompleteRender__WEBPACK_IMPORTED_MODULE_8__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _AutocompleteRender__WEBPACK_IMPORTED_MODULE_8__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _AutocompleteRenderer__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./AutocompleteRenderer */ "./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompleteRenderer.js");
/* harmony import */ var _AutocompleteRenderer__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(_AutocompleteRenderer__WEBPACK_IMPORTED_MODULE_9__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _AutocompleteRenderer__WEBPACK_IMPORTED_MODULE_9__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _AutocompleteRenderer__WEBPACK_IMPORTED_MODULE_9__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _AutocompleteSource__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./AutocompleteSource */ "./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompleteSource.js");
/* harmony import */ var _AutocompleteSource__WEBPACK_IMPORTED_MODULE_10___default = /*#__PURE__*/__webpack_require__.n(_AutocompleteSource__WEBPACK_IMPORTED_MODULE_10__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _AutocompleteSource__WEBPACK_IMPORTED_MODULE_10__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _AutocompleteSource__WEBPACK_IMPORTED_MODULE_10__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _AutocompleteState__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ./AutocompleteState */ "./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompleteState.js");
/* harmony import */ var _AutocompleteState__WEBPACK_IMPORTED_MODULE_11___default = /*#__PURE__*/__webpack_require__.n(_AutocompleteState__WEBPACK_IMPORTED_MODULE_11__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _AutocompleteState__WEBPACK_IMPORTED_MODULE_11__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _AutocompleteState__WEBPACK_IMPORTED_MODULE_11__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _AutocompleteTranslations__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! ./AutocompleteTranslations */ "./node_modules/@algolia/autocomplete-js/dist/esm/types/AutocompleteTranslations.js");
/* harmony import */ var _AutocompleteTranslations__WEBPACK_IMPORTED_MODULE_12___default = /*#__PURE__*/__webpack_require__.n(_AutocompleteTranslations__WEBPACK_IMPORTED_MODULE_12__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _AutocompleteTranslations__WEBPACK_IMPORTED_MODULE_12__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _AutocompleteTranslations__WEBPACK_IMPORTED_MODULE_12__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _HighlightHitParams__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! ./HighlightHitParams */ "./node_modules/@algolia/autocomplete-js/dist/esm/types/HighlightHitParams.js");
/* harmony import */ var _HighlightHitParams__WEBPACK_IMPORTED_MODULE_13___default = /*#__PURE__*/__webpack_require__.n(_HighlightHitParams__WEBPACK_IMPORTED_MODULE_13__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _HighlightHitParams__WEBPACK_IMPORTED_MODULE_13__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _HighlightHitParams__WEBPACK_IMPORTED_MODULE_13__[key]; }) }(__WEBPACK_IMPORT_KEY__));















/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/utils/getHTMLElement.js":
/*!********************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/utils/getHTMLElement.js ***!
  \********************************************************************************/
/*! exports provided: getHTMLElement */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getHTMLElement", function() { return getHTMLElement; });
/* harmony import */ var _algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @algolia/autocomplete-shared */ "./node_modules/@algolia/autocomplete-shared/dist/esm/index.js");

function getHTMLElement(environment, value) {
  if (typeof value === 'string') {
    var element = environment.document.querySelector(value);
    Object(_algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_0__["invariant"])(element !== null, "The element ".concat(JSON.stringify(value), " is not in the document."));
    return element;
  }

  return value;
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/utils/index.js":
/*!***********************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/utils/index.js ***!
  \***********************************************************************/
/*! exports provided: getHTMLElement, mergeClassNames, mergeDeep, setProperty, setProperties, setPropertiesWithoutEvents */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _getHTMLElement__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./getHTMLElement */ "./node_modules/@algolia/autocomplete-js/dist/esm/utils/getHTMLElement.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "getHTMLElement", function() { return _getHTMLElement__WEBPACK_IMPORTED_MODULE_0__["getHTMLElement"]; });

/* harmony import */ var _mergeClassNames__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./mergeClassNames */ "./node_modules/@algolia/autocomplete-js/dist/esm/utils/mergeClassNames.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "mergeClassNames", function() { return _mergeClassNames__WEBPACK_IMPORTED_MODULE_1__["mergeClassNames"]; });

/* harmony import */ var _mergeDeep__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./mergeDeep */ "./node_modules/@algolia/autocomplete-js/dist/esm/utils/mergeDeep.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "mergeDeep", function() { return _mergeDeep__WEBPACK_IMPORTED_MODULE_2__["mergeDeep"]; });

/* harmony import */ var _setProperties__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./setProperties */ "./node_modules/@algolia/autocomplete-js/dist/esm/utils/setProperties.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "setProperty", function() { return _setProperties__WEBPACK_IMPORTED_MODULE_3__["setProperty"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "setProperties", function() { return _setProperties__WEBPACK_IMPORTED_MODULE_3__["setProperties"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "setPropertiesWithoutEvents", function() { return _setProperties__WEBPACK_IMPORTED_MODULE_3__["setPropertiesWithoutEvents"]; });






/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/utils/mergeClassNames.js":
/*!*********************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/utils/mergeClassNames.js ***!
  \*********************************************************************************/
/*! exports provided: mergeClassNames */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "mergeClassNames", function() { return mergeClassNames; });
function mergeClassNames() {
  for (var _len = arguments.length, values = new Array(_len), _key = 0; _key < _len; _key++) {
    values[_key] = arguments[_key];
  }

  return values.reduce(function (acc, current) {
    Object.keys(current).forEach(function (key) {
      var accValue = acc[key];
      var currentValue = current[key];

      if (accValue !== currentValue) {
        acc[key] = [accValue, currentValue].filter(Boolean).join(' ');
      }
    });
    return acc;
  }, {});
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/utils/mergeDeep.js":
/*!***************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/utils/mergeDeep.js ***!
  \***************************************************************************/
/*! exports provided: mergeDeep */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "mergeDeep", function() { return mergeDeep; });
function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && Symbol.iterator in Object(iter)) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

var isObject = function isObject(value) {
  return value && _typeof(value) === 'object';
};

function mergeDeep() {
  for (var _len = arguments.length, values = new Array(_len), _key = 0; _key < _len; _key++) {
    values[_key] = arguments[_key];
  }

  return values.reduce(function (acc, current) {
    Object.keys(current).forEach(function (key) {
      var accValue = acc[key];
      var currentValue = current[key];

      if (Array.isArray(accValue) && Array.isArray(currentValue)) {
        acc[key] = accValue.concat.apply(accValue, _toConsumableArray(currentValue));
      } else if (isObject(accValue) && isObject(currentValue)) {
        acc[key] = mergeDeep(accValue, currentValue);
      } else {
        acc[key] = currentValue;
      }
    });
    return acc;
  }, {});
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/utils/setProperties.js":
/*!*******************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/utils/setProperties.js ***!
  \*******************************************************************************/
/*! exports provided: setProperty, setProperties, setPropertiesWithoutEvents */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "setProperty", function() { return setProperty; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "setProperties", function() { return setProperties; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "setPropertiesWithoutEvents", function() { return setPropertiesWithoutEvents; });
/* eslint-disable */

/*
 * Taken from Preact
 *
 * See https://github.com/preactjs/preact/blob/6ab49d9020740127577bf4af66bf63f4af7f9fee/src/diff/props.js#L58-L151
 */
function setStyle(style, key, value) {
  if (value === null) {
    style[key] = '';
  } else if (typeof value !== 'number') {
    style[key] = value;
  } else {
    style[key] = value + 'px';
  }
}
/**
 * Proxy an event to hooked event handlers
 */


function eventProxy(event) {
  this._listeners[event.type](event);
}
/**
 * Set a property value on a DOM node
 */


function setProperty(dom, name, value) {
  var useCapture;
  var nameLower;
  var oldValue = dom[name];

  if (name === 'style') {
    if (typeof value == 'string') {
      dom.style = value;
    } else {
      if (value === null) {
        dom.style = '';
      } else {
        for (name in value) {
          if (!oldValue || value[name] !== oldValue[name]) {
            setStyle(dom.style, name, value[name]);
          }
        }
      }
    }
  } // Benchmark for comparison: https://esbench.com/bench/574c954bdb965b9a00965ac6
  else if (name[0] === 'o' && name[1] === 'n') {
      useCapture = name !== (name = name.replace(/Capture$/, ''));
      nameLower = name.toLowerCase();
      if (nameLower in dom) name = nameLower;
      name = name.slice(2);
      if (!dom._listeners) dom._listeners = {};
      dom._listeners[name] = value;

      if (value) {
        if (!oldValue) dom.addEventListener(name, eventProxy, useCapture);
      } else {
        dom.removeEventListener(name, eventProxy, useCapture);
      }
    } else if (name !== 'list' && name !== 'tagName' && // HTMLButtonElement.form and HTMLInputElement.form are read-only but can be set using
    // setAttribute
    name !== 'form' && name !== 'type' && name !== 'size' && name !== 'download' && name !== 'href' && name in dom) {
      dom[name] = value == null ? '' : value;
    } else if (typeof value != 'function' && name !== 'dangerouslySetInnerHTML') {
      if (value == null || value === false && // ARIA-attributes have a different notion of boolean values.
      // The value `false` is different from the attribute not
      // existing on the DOM, so we can't remove it. For non-boolean
      // ARIA-attributes we could treat false as a removal, but the
      // amount of exceptions would cost us too many bytes. On top of
      // that other VDOM frameworks also always stringify `false`.
      !/^ar/.test(name)) {
        dom.removeAttribute(name);
      } else {
        dom.setAttribute(name, value);
      }
    }
}

function getNormalizedName(name) {
  switch (name) {
    case 'onChange':
      return 'onInput';

    default:
      return name;
  }
}

function setProperties(dom, props) {
  for (var name in props) {
    setProperty(dom, getNormalizedName(name), props[name]);
  }
}
function setPropertiesWithoutEvents(dom, props) {
  for (var name in props) {
    if (!(name[0] === 'o' && name[1] === 'n')) {
      setProperty(dom, getNormalizedName(name), props[name]);
    }
  }
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-js/dist/esm/version.js":
/*!*******************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-js/dist/esm/version.js ***!
  \*******************************************************************/
/*! exports provided: version */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "version", function() { return version; });
var version = '1.2.2';

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/constants/index.js":
/*!***************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/constants/index.js ***!
  \***************************************************************************************/
/*! exports provided: HIGHLIGHT_PRE_TAG, HIGHLIGHT_POST_TAG */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "HIGHLIGHT_PRE_TAG", function() { return HIGHLIGHT_PRE_TAG; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "HIGHLIGHT_POST_TAG", function() { return HIGHLIGHT_POST_TAG; });
var HIGHLIGHT_PRE_TAG = '__aa-highlight__';
var HIGHLIGHT_POST_TAG = '__/aa-highlight__';

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/highlight/HighlightedHit.js":
/*!************************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/highlight/HighlightedHit.js ***!
  \************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/highlight/SnippetedHit.js":
/*!**********************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/highlight/SnippetedHit.js ***!
  \**********************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/highlight/index.js":
/*!***************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/highlight/index.js ***!
  \***************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _HighlightedHit__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./HighlightedHit */ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/highlight/HighlightedHit.js");
/* harmony import */ var _HighlightedHit__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_HighlightedHit__WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _HighlightedHit__WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _HighlightedHit__WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _parseAlgoliaHitHighlight__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./parseAlgoliaHitHighlight */ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/highlight/parseAlgoliaHitHighlight.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "parseAlgoliaHitHighlight", function() { return _parseAlgoliaHitHighlight__WEBPACK_IMPORTED_MODULE_1__["parseAlgoliaHitHighlight"]; });

/* harmony import */ var _parseAlgoliaHitReverseHighlight__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./parseAlgoliaHitReverseHighlight */ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/highlight/parseAlgoliaHitReverseHighlight.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "parseAlgoliaHitReverseHighlight", function() { return _parseAlgoliaHitReverseHighlight__WEBPACK_IMPORTED_MODULE_2__["parseAlgoliaHitReverseHighlight"]; });

/* harmony import */ var _parseAlgoliaHitReverseSnippet__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./parseAlgoliaHitReverseSnippet */ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/highlight/parseAlgoliaHitReverseSnippet.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "parseAlgoliaHitReverseSnippet", function() { return _parseAlgoliaHitReverseSnippet__WEBPACK_IMPORTED_MODULE_3__["parseAlgoliaHitReverseSnippet"]; });

/* harmony import */ var _parseAlgoliaHitSnippet__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./parseAlgoliaHitSnippet */ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/highlight/parseAlgoliaHitSnippet.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "parseAlgoliaHitSnippet", function() { return _parseAlgoliaHitSnippet__WEBPACK_IMPORTED_MODULE_4__["parseAlgoliaHitSnippet"]; });

/* harmony import */ var _SnippetedHit__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./SnippetedHit */ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/highlight/SnippetedHit.js");
/* harmony import */ var _SnippetedHit__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_SnippetedHit__WEBPACK_IMPORTED_MODULE_5__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _SnippetedHit__WEBPACK_IMPORTED_MODULE_5__) if(["default","parseAlgoliaHitHighlight","parseAlgoliaHitReverseHighlight","parseAlgoliaHitReverseSnippet","parseAlgoliaHitSnippet"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _SnippetedHit__WEBPACK_IMPORTED_MODULE_5__[key]; }) }(__WEBPACK_IMPORT_KEY__));







/***/ }),

/***/ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/highlight/isPartHighlighted.js":
/*!***************************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/highlight/isPartHighlighted.js ***!
  \***************************************************************************************************/
/*! exports provided: isPartHighlighted */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "isPartHighlighted", function() { return isPartHighlighted; });
var htmlEscapes = {
  '&amp;': '&',
  '&lt;': '<',
  '&gt;': '>',
  '&quot;': '"',
  '&#39;': "'"
};
var hasAlphanumeric = new RegExp(/\w/i);
var regexEscapedHtml = /&(amp|quot|lt|gt|#39);/g;
var regexHasEscapedHtml = RegExp(regexEscapedHtml.source);

function unescape(value) {
  return value && regexHasEscapedHtml.test(value) ? value.replace(regexEscapedHtml, function (character) {
    return htmlEscapes[character];
  }) : value;
}

function isPartHighlighted(parts, i) {
  var _parts, _parts2;

  var current = parts[i];
  var isNextHighlighted = ((_parts = parts[i + 1]) === null || _parts === void 0 ? void 0 : _parts.isHighlighted) || true;
  var isPreviousHighlighted = ((_parts2 = parts[i - 1]) === null || _parts2 === void 0 ? void 0 : _parts2.isHighlighted) || true;

  if (!hasAlphanumeric.test(unescape(current.value)) && isPreviousHighlighted === isNextHighlighted) {
    return isPreviousHighlighted;
  }

  return current.isHighlighted;
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/highlight/parseAlgoliaHitHighlight.js":
/*!**********************************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/highlight/parseAlgoliaHitHighlight.js ***!
  \**********************************************************************************************************/
/*! exports provided: parseAlgoliaHitHighlight */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "parseAlgoliaHitHighlight", function() { return parseAlgoliaHitHighlight; });
/* harmony import */ var _algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @algolia/autocomplete-shared */ "./node_modules/@algolia/autocomplete-shared/dist/esm/index.js");
/* harmony import */ var _parseAttribute__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./parseAttribute */ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/highlight/parseAttribute.js");
function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && Symbol.iterator in Object(iter)) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }



function parseAlgoliaHitHighlight(_ref) {
  var hit = _ref.hit,
      attribute = _ref.attribute;
  var path = Array.isArray(attribute) ? attribute : [attribute];
  var highlightedValue = Object(_algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_0__["getAttributeValueByPath"])(hit, ['_highlightResult'].concat(_toConsumableArray(path), ['value']));

  if (typeof highlightedValue !== 'string') {
     true ? Object(_algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_0__["warn"])(false, "The attribute \"".concat(path.join('.'), "\" described by the path ").concat(JSON.stringify(path), " does not exist on the hit. Did you set it in `attributesToHighlight`?") + '\nSee https://www.algolia.com/doc/api-reference/api-parameters/attributesToHighlight/') : undefined;
    highlightedValue = Object(_algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_0__["getAttributeValueByPath"])(hit, path) || '';
  }

  return Object(_parseAttribute__WEBPACK_IMPORTED_MODULE_1__["parseAttribute"])({
    highlightedValue: highlightedValue
  });
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/highlight/parseAlgoliaHitReverseHighlight.js":
/*!*****************************************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/highlight/parseAlgoliaHitReverseHighlight.js ***!
  \*****************************************************************************************************************/
/*! exports provided: parseAlgoliaHitReverseHighlight */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "parseAlgoliaHitReverseHighlight", function() { return parseAlgoliaHitReverseHighlight; });
/* harmony import */ var _parseAlgoliaHitHighlight__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./parseAlgoliaHitHighlight */ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/highlight/parseAlgoliaHitHighlight.js");
/* harmony import */ var _reverseHighlightedParts__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./reverseHighlightedParts */ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/highlight/reverseHighlightedParts.js");


function parseAlgoliaHitReverseHighlight(props) {
  return Object(_reverseHighlightedParts__WEBPACK_IMPORTED_MODULE_1__["reverseHighlightedParts"])(Object(_parseAlgoliaHitHighlight__WEBPACK_IMPORTED_MODULE_0__["parseAlgoliaHitHighlight"])(props));
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/highlight/parseAlgoliaHitReverseSnippet.js":
/*!***************************************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/highlight/parseAlgoliaHitReverseSnippet.js ***!
  \***************************************************************************************************************/
/*! exports provided: parseAlgoliaHitReverseSnippet */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "parseAlgoliaHitReverseSnippet", function() { return parseAlgoliaHitReverseSnippet; });
/* harmony import */ var _parseAlgoliaHitSnippet__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./parseAlgoliaHitSnippet */ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/highlight/parseAlgoliaHitSnippet.js");
/* harmony import */ var _reverseHighlightedParts__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./reverseHighlightedParts */ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/highlight/reverseHighlightedParts.js");


function parseAlgoliaHitReverseSnippet(props) {
  return Object(_reverseHighlightedParts__WEBPACK_IMPORTED_MODULE_1__["reverseHighlightedParts"])(Object(_parseAlgoliaHitSnippet__WEBPACK_IMPORTED_MODULE_0__["parseAlgoliaHitSnippet"])(props));
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/highlight/parseAlgoliaHitSnippet.js":
/*!********************************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/highlight/parseAlgoliaHitSnippet.js ***!
  \********************************************************************************************************/
/*! exports provided: parseAlgoliaHitSnippet */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "parseAlgoliaHitSnippet", function() { return parseAlgoliaHitSnippet; });
/* harmony import */ var _algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @algolia/autocomplete-shared */ "./node_modules/@algolia/autocomplete-shared/dist/esm/index.js");
/* harmony import */ var _parseAttribute__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./parseAttribute */ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/highlight/parseAttribute.js");
function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && Symbol.iterator in Object(iter)) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }



function parseAlgoliaHitSnippet(_ref) {
  var hit = _ref.hit,
      attribute = _ref.attribute;
  var path = Array.isArray(attribute) ? attribute : [attribute];
  var highlightedValue = Object(_algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_0__["getAttributeValueByPath"])(hit, ['_snippetResult'].concat(_toConsumableArray(path), ['value']));

  if (typeof highlightedValue !== 'string') {
     true ? Object(_algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_0__["warn"])(false, "The attribute \"".concat(path.join('.'), "\" described by the path ").concat(JSON.stringify(path), " does not exist on the hit. Did you set it in `attributesToSnippet`?") + '\nSee https://www.algolia.com/doc/api-reference/api-parameters/attributesToSnippet/') : undefined;
    highlightedValue = Object(_algolia_autocomplete_shared__WEBPACK_IMPORTED_MODULE_0__["getAttributeValueByPath"])(hit, path) || '';
  }

  return Object(_parseAttribute__WEBPACK_IMPORTED_MODULE_1__["parseAttribute"])({
    highlightedValue: highlightedValue
  });
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/highlight/parseAttribute.js":
/*!************************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/highlight/parseAttribute.js ***!
  \************************************************************************************************/
/*! exports provided: parseAttribute */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "parseAttribute", function() { return parseAttribute; });
/* harmony import */ var _constants__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../constants */ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/constants/index.js");


/**
 * Creates a data structure that allows to concatenate similar highlighting
 * parts in a single value.
 */
function createAttributeSet() {
  var initialValue = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [];
  var value = initialValue;
  return {
    get: function get() {
      return value;
    },
    add: function add(part) {
      var lastPart = value[value.length - 1];

      if ((lastPart === null || lastPart === void 0 ? void 0 : lastPart.isHighlighted) === part.isHighlighted) {
        value[value.length - 1] = {
          value: lastPart.value + part.value,
          isHighlighted: lastPart.isHighlighted
        };
      } else {
        value.push(part);
      }
    }
  };
}

function parseAttribute(_ref) {
  var highlightedValue = _ref.highlightedValue;
  var preTagParts = highlightedValue.split(_constants__WEBPACK_IMPORTED_MODULE_0__["HIGHLIGHT_PRE_TAG"]);
  var firstValue = preTagParts.shift();
  var parts = createAttributeSet(firstValue ? [{
    value: firstValue,
    isHighlighted: false
  }] : []);
  preTagParts.forEach(function (part) {
    var postTagParts = part.split(_constants__WEBPACK_IMPORTED_MODULE_0__["HIGHLIGHT_POST_TAG"]);
    parts.add({
      value: postTagParts[0],
      isHighlighted: true
    });

    if (postTagParts[1] !== '') {
      parts.add({
        value: postTagParts[1],
        isHighlighted: false
      });
    }
  });
  return parts.get();
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/highlight/reverseHighlightedParts.js":
/*!*********************************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/highlight/reverseHighlightedParts.js ***!
  \*********************************************************************************************************/
/*! exports provided: reverseHighlightedParts */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "reverseHighlightedParts", function() { return reverseHighlightedParts; });
/* harmony import */ var _isPartHighlighted__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./isPartHighlighted */ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/highlight/isPartHighlighted.js");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }


function reverseHighlightedParts(parts) {
  // We don't want to highlight the whole word when no parts match.
  if (!parts.some(function (part) {
    return part.isHighlighted;
  })) {
    return parts.map(function (part) {
      return _objectSpread(_objectSpread({}, part), {}, {
        isHighlighted: false
      });
    });
  }

  return parts.map(function (part, i) {
    return _objectSpread(_objectSpread({}, part), {}, {
      isHighlighted: !Object(_isPartHighlighted__WEBPACK_IMPORTED_MODULE_0__["isPartHighlighted"])(parts, i)
    });
  });
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/index.js":
/*!*****************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/index.js ***!
  \*****************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _highlight__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./highlight */ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/highlight/index.js");
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _highlight__WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _highlight__WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _requester__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./requester */ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/requester/index.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "createRequester", function() { return _requester__WEBPACK_IMPORTED_MODULE_1__["createRequester"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "getAlgoliaFacets", function() { return _requester__WEBPACK_IMPORTED_MODULE_1__["getAlgoliaFacets"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "getAlgoliaResults", function() { return _requester__WEBPACK_IMPORTED_MODULE_1__["getAlgoliaResults"]; });

/* harmony import */ var _search__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./search */ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/search/index.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "fetchAlgoliaResults", function() { return _search__WEBPACK_IMPORTED_MODULE_2__["fetchAlgoliaResults"]; });





/***/ }),

/***/ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/requester/createAlgoliaRequester.js":
/*!********************************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/requester/createAlgoliaRequester.js ***!
  \********************************************************************************************************/
/*! exports provided: createAlgoliaRequester */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "createAlgoliaRequester", function() { return createAlgoliaRequester; });
/* harmony import */ var _search__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../search */ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/search/index.js");
/* harmony import */ var _createRequester__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./createRequester */ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/requester/createRequester.js");


var createAlgoliaRequester = Object(_createRequester__WEBPACK_IMPORTED_MODULE_1__["createRequester"])(_search__WEBPACK_IMPORTED_MODULE_0__["fetchAlgoliaResults"]);

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/requester/createRequester.js":
/*!*************************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/requester/createRequester.js ***!
  \*************************************************************************************************/
/*! exports provided: createRequester */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "createRequester", function() { return createRequester; });
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function createRequester(fetcher) {
  function execute(fetcherParams) {
    return fetcher({
      searchClient: fetcherParams.searchClient,
      queries: fetcherParams.requests.map(function (x) {
        return x.query;
      })
    }).then(function (responses) {
      return responses.map(function (response, index) {
        var _fetcherParams$reques = fetcherParams.requests[index],
            sourceId = _fetcherParams$reques.sourceId,
            transformResponse = _fetcherParams$reques.transformResponse;
        return {
          items: response,
          sourceId: sourceId,
          transformResponse: transformResponse
        };
      });
    });
  }

  return function createSpecifiedRequester(requesterParams) {
    return function requester(requestParams) {
      return _objectSpread(_objectSpread({
        execute: execute
      }, requesterParams), requestParams);
    };
  };
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/requester/getAlgoliaFacets.js":
/*!**************************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/requester/getAlgoliaFacets.js ***!
  \**************************************************************************************************/
/*! exports provided: getAlgoliaFacets */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getAlgoliaFacets", function() { return getAlgoliaFacets; });
/* harmony import */ var _createAlgoliaRequester__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./createAlgoliaRequester */ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/requester/createAlgoliaRequester.js");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }



/**
 * Retrieves Algolia facet hits from multiple indices.
 */
function getAlgoliaFacets(requestParams) {
  var requester = Object(_createAlgoliaRequester__WEBPACK_IMPORTED_MODULE_0__["createAlgoliaRequester"])({
    transformResponse: function transformResponse(response) {
      return response.facetHits;
    }
  });
  var queries = requestParams.queries.map(function (query) {
    return _objectSpread(_objectSpread({}, query), {}, {
      type: 'facet'
    });
  });
  return requester(_objectSpread(_objectSpread({}, requestParams), {}, {
    queries: queries
  }));
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/requester/getAlgoliaResults.js":
/*!***************************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/requester/getAlgoliaResults.js ***!
  \***************************************************************************************************/
/*! exports provided: getAlgoliaResults */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getAlgoliaResults", function() { return getAlgoliaResults; });
/* harmony import */ var _createAlgoliaRequester__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./createAlgoliaRequester */ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/requester/createAlgoliaRequester.js");

/**
 * Retrieves Algolia results from multiple indices.
 */

var getAlgoliaResults = Object(_createAlgoliaRequester__WEBPACK_IMPORTED_MODULE_0__["createAlgoliaRequester"])({
  transformResponse: function transformResponse(response) {
    return response.hits;
  }
});

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/requester/index.js":
/*!***************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/requester/index.js ***!
  \***************************************************************************************/
/*! exports provided: createRequester, getAlgoliaFacets, getAlgoliaResults */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _createRequester__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./createRequester */ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/requester/createRequester.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "createRequester", function() { return _createRequester__WEBPACK_IMPORTED_MODULE_0__["createRequester"]; });

/* harmony import */ var _getAlgoliaFacets__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./getAlgoliaFacets */ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/requester/getAlgoliaFacets.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "getAlgoliaFacets", function() { return _getAlgoliaFacets__WEBPACK_IMPORTED_MODULE_1__["getAlgoliaFacets"]; });

/* harmony import */ var _getAlgoliaResults__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./getAlgoliaResults */ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/requester/getAlgoliaResults.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "getAlgoliaResults", function() { return _getAlgoliaResults__WEBPACK_IMPORTED_MODULE_2__["getAlgoliaResults"]; });





/***/ }),

/***/ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/search/fetchAlgoliaResults.js":
/*!**************************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/search/fetchAlgoliaResults.js ***!
  \**************************************************************************************************/
/*! exports provided: fetchAlgoliaResults */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "fetchAlgoliaResults", function() { return fetchAlgoliaResults; });
/* harmony import */ var _constants__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../constants */ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/constants/index.js");
/* harmony import */ var _version__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../version */ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/version.js");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _objectWithoutProperties(source, excluded) { if (source == null) return {}; var target = _objectWithoutPropertiesLoose(source, excluded); var key, i; if (Object.getOwnPropertySymbols) { var sourceSymbolKeys = Object.getOwnPropertySymbols(source); for (i = 0; i < sourceSymbolKeys.length; i++) { key = sourceSymbolKeys[i]; if (excluded.indexOf(key) >= 0) continue; if (!Object.prototype.propertyIsEnumerable.call(source, key)) continue; target[key] = source[key]; } } return target; }

function _objectWithoutPropertiesLoose(source, excluded) { if (source == null) return {}; var target = {}; var sourceKeys = Object.keys(source); var key, i; for (i = 0; i < sourceKeys.length; i++) { key = sourceKeys[i]; if (excluded.indexOf(key) >= 0) continue; target[key] = source[key]; } return target; }

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && Symbol.iterator in Object(iter)) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }



function fetchAlgoliaResults(_ref) {
  var searchClient = _ref.searchClient,
      queries = _ref.queries,
      _ref$userAgents = _ref.userAgents,
      userAgents = _ref$userAgents === void 0 ? [] : _ref$userAgents;

  if (typeof searchClient.addAlgoliaAgent === 'function') {
    var algoliaAgents = [{
      segment: 'autocomplete-core',
      version: _version__WEBPACK_IMPORTED_MODULE_1__["version"]
    }].concat(_toConsumableArray(userAgents));
    algoliaAgents.forEach(function (_ref2) {
      var segment = _ref2.segment,
          version = _ref2.version;
      searchClient.addAlgoliaAgent(segment, version);
    });
  }

  return searchClient.search(queries.map(function (searchParameters) {
    var params = searchParameters.params,
        headers = _objectWithoutProperties(searchParameters, ["params"]);

    return _objectSpread(_objectSpread({}, headers), {}, {
      params: _objectSpread({
        hitsPerPage: 5,
        highlightPreTag: _constants__WEBPACK_IMPORTED_MODULE_0__["HIGHLIGHT_PRE_TAG"],
        highlightPostTag: _constants__WEBPACK_IMPORTED_MODULE_0__["HIGHLIGHT_POST_TAG"]
      }, params)
    });
  })).then(function (response) {
    return response.results;
  });
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/search/index.js":
/*!************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/search/index.js ***!
  \************************************************************************************/
/*! exports provided: fetchAlgoliaResults */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _fetchAlgoliaResults__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./fetchAlgoliaResults */ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/search/fetchAlgoliaResults.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "fetchAlgoliaResults", function() { return _fetchAlgoliaResults__WEBPACK_IMPORTED_MODULE_0__["fetchAlgoliaResults"]; });



/***/ }),

/***/ "./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/version.js":
/*!*******************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-preset-algolia/dist/esm/version.js ***!
  \*******************************************************************************/
/*! exports provided: version */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "version", function() { return version; });
var version = '1.2.2';

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-shared/dist/esm/MaybePromise.js":
/*!****************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-shared/dist/esm/MaybePromise.js ***!
  \****************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./node_modules/@algolia/autocomplete-shared/dist/esm/createRef.js":
/*!*************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-shared/dist/esm/createRef.js ***!
  \*************************************************************************/
/*! exports provided: createRef */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "createRef", function() { return createRef; });
function createRef(initialValue) {
  return {
    current: initialValue
  };
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-shared/dist/esm/debounce.js":
/*!************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-shared/dist/esm/debounce.js ***!
  \************************************************************************/
/*! exports provided: debounce */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "debounce", function() { return debounce; });
function debounce(fn, time) {
  var timerId = undefined;
  return function () {
    for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
      args[_key] = arguments[_key];
    }

    if (timerId) {
      clearTimeout(timerId);
    }

    timerId = setTimeout(function () {
      return fn.apply(void 0, args);
    }, time);
  };
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-shared/dist/esm/generateAutocompleteId.js":
/*!**************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-shared/dist/esm/generateAutocompleteId.js ***!
  \**************************************************************************************/
/*! exports provided: generateAutocompleteId */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "generateAutocompleteId", function() { return generateAutocompleteId; });
var autocompleteId = 0;
function generateAutocompleteId() {
  return "autocomplete-".concat(autocompleteId++);
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-shared/dist/esm/getAttributeValueByPath.js":
/*!***************************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-shared/dist/esm/getAttributeValueByPath.js ***!
  \***************************************************************************************/
/*! exports provided: getAttributeValueByPath */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getAttributeValueByPath", function() { return getAttributeValueByPath; });
function getAttributeValueByPath(record, path) {
  return path.reduce(function (current, key) {
    return current && current[key];
  }, record);
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-shared/dist/esm/getItemsCount.js":
/*!*****************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-shared/dist/esm/getItemsCount.js ***!
  \*****************************************************************************/
/*! exports provided: getItemsCount */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getItemsCount", function() { return getItemsCount; });
function getItemsCount(state) {
  if (state.collections.length === 0) {
    return 0;
  }

  return state.collections.reduce(function (sum, collection) {
    return sum + collection.items.length;
  }, 0);
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-shared/dist/esm/index.js":
/*!*********************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-shared/dist/esm/index.js ***!
  \*********************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _createRef__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./createRef */ "./node_modules/@algolia/autocomplete-shared/dist/esm/createRef.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "createRef", function() { return _createRef__WEBPACK_IMPORTED_MODULE_0__["createRef"]; });

/* harmony import */ var _debounce__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./debounce */ "./node_modules/@algolia/autocomplete-shared/dist/esm/debounce.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "debounce", function() { return _debounce__WEBPACK_IMPORTED_MODULE_1__["debounce"]; });

/* harmony import */ var _generateAutocompleteId__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./generateAutocompleteId */ "./node_modules/@algolia/autocomplete-shared/dist/esm/generateAutocompleteId.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "generateAutocompleteId", function() { return _generateAutocompleteId__WEBPACK_IMPORTED_MODULE_2__["generateAutocompleteId"]; });

/* harmony import */ var _getAttributeValueByPath__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./getAttributeValueByPath */ "./node_modules/@algolia/autocomplete-shared/dist/esm/getAttributeValueByPath.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "getAttributeValueByPath", function() { return _getAttributeValueByPath__WEBPACK_IMPORTED_MODULE_3__["getAttributeValueByPath"]; });

/* harmony import */ var _getItemsCount__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./getItemsCount */ "./node_modules/@algolia/autocomplete-shared/dist/esm/getItemsCount.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "getItemsCount", function() { return _getItemsCount__WEBPACK_IMPORTED_MODULE_4__["getItemsCount"]; });

/* harmony import */ var _invariant__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./invariant */ "./node_modules/@algolia/autocomplete-shared/dist/esm/invariant.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "invariant", function() { return _invariant__WEBPACK_IMPORTED_MODULE_5__["invariant"]; });

/* harmony import */ var _isEqual__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./isEqual */ "./node_modules/@algolia/autocomplete-shared/dist/esm/isEqual.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "isEqual", function() { return _isEqual__WEBPACK_IMPORTED_MODULE_6__["isEqual"]; });

/* harmony import */ var _MaybePromise__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./MaybePromise */ "./node_modules/@algolia/autocomplete-shared/dist/esm/MaybePromise.js");
/* harmony import */ var _MaybePromise__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_MaybePromise__WEBPACK_IMPORTED_MODULE_7__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _MaybePromise__WEBPACK_IMPORTED_MODULE_7__) if(["default","createRef","debounce","generateAutocompleteId","getAttributeValueByPath","getItemsCount","invariant","isEqual"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _MaybePromise__WEBPACK_IMPORTED_MODULE_7__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _warn__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./warn */ "./node_modules/@algolia/autocomplete-shared/dist/esm/warn.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "warnCache", function() { return _warn__WEBPACK_IMPORTED_MODULE_8__["warnCache"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "warn", function() { return _warn__WEBPACK_IMPORTED_MODULE_8__["warn"]; });











/***/ }),

/***/ "./node_modules/@algolia/autocomplete-shared/dist/esm/invariant.js":
/*!*************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-shared/dist/esm/invariant.js ***!
  \*************************************************************************/
/*! exports provided: invariant */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "invariant", function() { return invariant; });
/**
 * Throws an error if the condition is not met in development mode.
 * This is used to make development a better experience to provide guidance as
 * to where the error comes from.
 */
function invariant(condition, message) {
  if (false) {}

  if (!condition) {
    throw new Error("[Autocomplete] ".concat(message));
  }
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-shared/dist/esm/isEqual.js":
/*!***********************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-shared/dist/esm/isEqual.js ***!
  \***********************************************************************/
/*! exports provided: isEqual */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "isEqual", function() { return isEqual; });
function isPrimitive(obj) {
  return obj !== Object(obj);
}

function isEqual(first, second) {
  if (first === second) {
    return true;
  }

  if (isPrimitive(first) || isPrimitive(second) || typeof first === 'function' || typeof second === 'function') {
    return first === second;
  }

  if (Object.keys(first).length !== Object.keys(second).length) {
    return false;
  }

  for (var _i = 0, _Object$keys = Object.keys(first); _i < _Object$keys.length; _i++) {
    var key = _Object$keys[_i];

    if (!(key in second)) {
      return false;
    }

    if (!isEqual(first[key], second[key])) {
      return false;
    }
  }

  return true;
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-shared/dist/esm/warn.js":
/*!********************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-shared/dist/esm/warn.js ***!
  \********************************************************************/
/*! exports provided: warnCache, warn */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "warnCache", function() { return warnCache; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "warn", function() { return warn; });
var warnCache = {
  current: {}
};
/**
 * Logs a warning if the condition is not met.
 * This is used to log issues in development environment only.
 */

function warn(condition, message) {
  if (false) {}

  if (condition) {
    return;
  }

  var sanitizedMessage = message.trim();
  var hasAlreadyPrinted = warnCache.current[sanitizedMessage];

  if (!hasAlreadyPrinted) {
    warnCache.current[sanitizedMessage] = true; // eslint-disable-next-line no-console

    console.warn("[Autocomplete] ".concat(sanitizedMessage));
  }
}

/***/ }),

/***/ "./node_modules/@algolia/autocomplete-theme-classic/dist/theme.css":
/*!*************************************************************************!*\
  !*** ./node_modules/@algolia/autocomplete-theme-classic/dist/theme.css ***!
  \*************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../css-loader??ref--9-1!../../../postcss-loader/src??ref--9-2!./theme.css */ "./node_modules/css-loader/index.js?!./node_modules/postcss-loader/src/index.js?!./node_modules/@algolia/autocomplete-theme-classic/dist/theme.css");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/@babel/runtime/regenerator/index.js":
/*!**********************************************************!*\
  !*** ./node_modules/@babel/runtime/regenerator/index.js ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! regenerator-runtime */ "./node_modules/regenerator-runtime/runtime.js");


/***/ }),

/***/ "./node_modules/cross-fetch/dist/browser-polyfill.js":
/*!***********************************************************!*\
  !*** ./node_modules/cross-fetch/dist/browser-polyfill.js ***!
  \***********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function(self) {

var irrelevant = (function (exports) {

  var support = {
    searchParams: 'URLSearchParams' in self,
    iterable: 'Symbol' in self && 'iterator' in Symbol,
    blob:
      'FileReader' in self &&
      'Blob' in self &&
      (function() {
        try {
          new Blob();
          return true
        } catch (e) {
          return false
        }
      })(),
    formData: 'FormData' in self,
    arrayBuffer: 'ArrayBuffer' in self
  };

  function isDataView(obj) {
    return obj && DataView.prototype.isPrototypeOf(obj)
  }

  if (support.arrayBuffer) {
    var viewClasses = [
      '[object Int8Array]',
      '[object Uint8Array]',
      '[object Uint8ClampedArray]',
      '[object Int16Array]',
      '[object Uint16Array]',
      '[object Int32Array]',
      '[object Uint32Array]',
      '[object Float32Array]',
      '[object Float64Array]'
    ];

    var isArrayBufferView =
      ArrayBuffer.isView ||
      function(obj) {
        return obj && viewClasses.indexOf(Object.prototype.toString.call(obj)) > -1
      };
  }

  function normalizeName(name) {
    if (typeof name !== 'string') {
      name = String(name);
    }
    if (/[^a-z0-9\-#$%&'*+.^_`|~]/i.test(name)) {
      throw new TypeError('Invalid character in header field name')
    }
    return name.toLowerCase()
  }

  function normalizeValue(value) {
    if (typeof value !== 'string') {
      value = String(value);
    }
    return value
  }

  // Build a destructive iterator for the value list
  function iteratorFor(items) {
    var iterator = {
      next: function() {
        var value = items.shift();
        return {done: value === undefined, value: value}
      }
    };

    if (support.iterable) {
      iterator[Symbol.iterator] = function() {
        return iterator
      };
    }

    return iterator
  }

  function Headers(headers) {
    this.map = {};

    if (headers instanceof Headers) {
      headers.forEach(function(value, name) {
        this.append(name, value);
      }, this);
    } else if (Array.isArray(headers)) {
      headers.forEach(function(header) {
        this.append(header[0], header[1]);
      }, this);
    } else if (headers) {
      Object.getOwnPropertyNames(headers).forEach(function(name) {
        this.append(name, headers[name]);
      }, this);
    }
  }

  Headers.prototype.append = function(name, value) {
    name = normalizeName(name);
    value = normalizeValue(value);
    var oldValue = this.map[name];
    this.map[name] = oldValue ? oldValue + ', ' + value : value;
  };

  Headers.prototype['delete'] = function(name) {
    delete this.map[normalizeName(name)];
  };

  Headers.prototype.get = function(name) {
    name = normalizeName(name);
    return this.has(name) ? this.map[name] : null
  };

  Headers.prototype.has = function(name) {
    return this.map.hasOwnProperty(normalizeName(name))
  };

  Headers.prototype.set = function(name, value) {
    this.map[normalizeName(name)] = normalizeValue(value);
  };

  Headers.prototype.forEach = function(callback, thisArg) {
    for (var name in this.map) {
      if (this.map.hasOwnProperty(name)) {
        callback.call(thisArg, this.map[name], name, this);
      }
    }
  };

  Headers.prototype.keys = function() {
    var items = [];
    this.forEach(function(value, name) {
      items.push(name);
    });
    return iteratorFor(items)
  };

  Headers.prototype.values = function() {
    var items = [];
    this.forEach(function(value) {
      items.push(value);
    });
    return iteratorFor(items)
  };

  Headers.prototype.entries = function() {
    var items = [];
    this.forEach(function(value, name) {
      items.push([name, value]);
    });
    return iteratorFor(items)
  };

  if (support.iterable) {
    Headers.prototype[Symbol.iterator] = Headers.prototype.entries;
  }

  function consumed(body) {
    if (body.bodyUsed) {
      return Promise.reject(new TypeError('Already read'))
    }
    body.bodyUsed = true;
  }

  function fileReaderReady(reader) {
    return new Promise(function(resolve, reject) {
      reader.onload = function() {
        resolve(reader.result);
      };
      reader.onerror = function() {
        reject(reader.error);
      };
    })
  }

  function readBlobAsArrayBuffer(blob) {
    var reader = new FileReader();
    var promise = fileReaderReady(reader);
    reader.readAsArrayBuffer(blob);
    return promise
  }

  function readBlobAsText(blob) {
    var reader = new FileReader();
    var promise = fileReaderReady(reader);
    reader.readAsText(blob);
    return promise
  }

  function readArrayBufferAsText(buf) {
    var view = new Uint8Array(buf);
    var chars = new Array(view.length);

    for (var i = 0; i < view.length; i++) {
      chars[i] = String.fromCharCode(view[i]);
    }
    return chars.join('')
  }

  function bufferClone(buf) {
    if (buf.slice) {
      return buf.slice(0)
    } else {
      var view = new Uint8Array(buf.byteLength);
      view.set(new Uint8Array(buf));
      return view.buffer
    }
  }

  function Body() {
    this.bodyUsed = false;

    this._initBody = function(body) {
      this._bodyInit = body;
      if (!body) {
        this._bodyText = '';
      } else if (typeof body === 'string') {
        this._bodyText = body;
      } else if (support.blob && Blob.prototype.isPrototypeOf(body)) {
        this._bodyBlob = body;
      } else if (support.formData && FormData.prototype.isPrototypeOf(body)) {
        this._bodyFormData = body;
      } else if (support.searchParams && URLSearchParams.prototype.isPrototypeOf(body)) {
        this._bodyText = body.toString();
      } else if (support.arrayBuffer && support.blob && isDataView(body)) {
        this._bodyArrayBuffer = bufferClone(body.buffer);
        // IE 10-11 can't handle a DataView body.
        this._bodyInit = new Blob([this._bodyArrayBuffer]);
      } else if (support.arrayBuffer && (ArrayBuffer.prototype.isPrototypeOf(body) || isArrayBufferView(body))) {
        this._bodyArrayBuffer = bufferClone(body);
      } else {
        this._bodyText = body = Object.prototype.toString.call(body);
      }

      if (!this.headers.get('content-type')) {
        if (typeof body === 'string') {
          this.headers.set('content-type', 'text/plain;charset=UTF-8');
        } else if (this._bodyBlob && this._bodyBlob.type) {
          this.headers.set('content-type', this._bodyBlob.type);
        } else if (support.searchParams && URLSearchParams.prototype.isPrototypeOf(body)) {
          this.headers.set('content-type', 'application/x-www-form-urlencoded;charset=UTF-8');
        }
      }
    };

    if (support.blob) {
      this.blob = function() {
        var rejected = consumed(this);
        if (rejected) {
          return rejected
        }

        if (this._bodyBlob) {
          return Promise.resolve(this._bodyBlob)
        } else if (this._bodyArrayBuffer) {
          return Promise.resolve(new Blob([this._bodyArrayBuffer]))
        } else if (this._bodyFormData) {
          throw new Error('could not read FormData body as blob')
        } else {
          return Promise.resolve(new Blob([this._bodyText]))
        }
      };

      this.arrayBuffer = function() {
        if (this._bodyArrayBuffer) {
          return consumed(this) || Promise.resolve(this._bodyArrayBuffer)
        } else {
          return this.blob().then(readBlobAsArrayBuffer)
        }
      };
    }

    this.text = function() {
      var rejected = consumed(this);
      if (rejected) {
        return rejected
      }

      if (this._bodyBlob) {
        return readBlobAsText(this._bodyBlob)
      } else if (this._bodyArrayBuffer) {
        return Promise.resolve(readArrayBufferAsText(this._bodyArrayBuffer))
      } else if (this._bodyFormData) {
        throw new Error('could not read FormData body as text')
      } else {
        return Promise.resolve(this._bodyText)
      }
    };

    if (support.formData) {
      this.formData = function() {
        return this.text().then(decode)
      };
    }

    this.json = function() {
      return this.text().then(JSON.parse)
    };

    return this
  }

  // HTTP methods whose capitalization should be normalized
  var methods = ['DELETE', 'GET', 'HEAD', 'OPTIONS', 'POST', 'PUT'];

  function normalizeMethod(method) {
    var upcased = method.toUpperCase();
    return methods.indexOf(upcased) > -1 ? upcased : method
  }

  function Request(input, options) {
    options = options || {};
    var body = options.body;

    if (input instanceof Request) {
      if (input.bodyUsed) {
        throw new TypeError('Already read')
      }
      this.url = input.url;
      this.credentials = input.credentials;
      if (!options.headers) {
        this.headers = new Headers(input.headers);
      }
      this.method = input.method;
      this.mode = input.mode;
      this.signal = input.signal;
      if (!body && input._bodyInit != null) {
        body = input._bodyInit;
        input.bodyUsed = true;
      }
    } else {
      this.url = String(input);
    }

    this.credentials = options.credentials || this.credentials || 'same-origin';
    if (options.headers || !this.headers) {
      this.headers = new Headers(options.headers);
    }
    this.method = normalizeMethod(options.method || this.method || 'GET');
    this.mode = options.mode || this.mode || null;
    this.signal = options.signal || this.signal;
    this.referrer = null;

    if ((this.method === 'GET' || this.method === 'HEAD') && body) {
      throw new TypeError('Body not allowed for GET or HEAD requests')
    }
    this._initBody(body);
  }

  Request.prototype.clone = function() {
    return new Request(this, {body: this._bodyInit})
  };

  function decode(body) {
    var form = new FormData();
    body
      .trim()
      .split('&')
      .forEach(function(bytes) {
        if (bytes) {
          var split = bytes.split('=');
          var name = split.shift().replace(/\+/g, ' ');
          var value = split.join('=').replace(/\+/g, ' ');
          form.append(decodeURIComponent(name), decodeURIComponent(value));
        }
      });
    return form
  }

  function parseHeaders(rawHeaders) {
    var headers = new Headers();
    // Replace instances of \r\n and \n followed by at least one space or horizontal tab with a space
    // https://tools.ietf.org/html/rfc7230#section-3.2
    var preProcessedHeaders = rawHeaders.replace(/\r?\n[\t ]+/g, ' ');
    preProcessedHeaders.split(/\r?\n/).forEach(function(line) {
      var parts = line.split(':');
      var key = parts.shift().trim();
      if (key) {
        var value = parts.join(':').trim();
        headers.append(key, value);
      }
    });
    return headers
  }

  Body.call(Request.prototype);

  function Response(bodyInit, options) {
    if (!options) {
      options = {};
    }

    this.type = 'default';
    this.status = options.status === undefined ? 200 : options.status;
    this.ok = this.status >= 200 && this.status < 300;
    this.statusText = 'statusText' in options ? options.statusText : 'OK';
    this.headers = new Headers(options.headers);
    this.url = options.url || '';
    this._initBody(bodyInit);
  }

  Body.call(Response.prototype);

  Response.prototype.clone = function() {
    return new Response(this._bodyInit, {
      status: this.status,
      statusText: this.statusText,
      headers: new Headers(this.headers),
      url: this.url
    })
  };

  Response.error = function() {
    var response = new Response(null, {status: 0, statusText: ''});
    response.type = 'error';
    return response
  };

  var redirectStatuses = [301, 302, 303, 307, 308];

  Response.redirect = function(url, status) {
    if (redirectStatuses.indexOf(status) === -1) {
      throw new RangeError('Invalid status code')
    }

    return new Response(null, {status: status, headers: {location: url}})
  };

  exports.DOMException = self.DOMException;
  try {
    new exports.DOMException();
  } catch (err) {
    exports.DOMException = function(message, name) {
      this.message = message;
      this.name = name;
      var error = Error(message);
      this.stack = error.stack;
    };
    exports.DOMException.prototype = Object.create(Error.prototype);
    exports.DOMException.prototype.constructor = exports.DOMException;
  }

  function fetch(input, init) {
    return new Promise(function(resolve, reject) {
      var request = new Request(input, init);

      if (request.signal && request.signal.aborted) {
        return reject(new exports.DOMException('Aborted', 'AbortError'))
      }

      var xhr = new XMLHttpRequest();

      function abortXhr() {
        xhr.abort();
      }

      xhr.onload = function() {
        var options = {
          status: xhr.status,
          statusText: xhr.statusText,
          headers: parseHeaders(xhr.getAllResponseHeaders() || '')
        };
        options.url = 'responseURL' in xhr ? xhr.responseURL : options.headers.get('X-Request-URL');
        var body = 'response' in xhr ? xhr.response : xhr.responseText;
        resolve(new Response(body, options));
      };

      xhr.onerror = function() {
        reject(new TypeError('Network request failed'));
      };

      xhr.ontimeout = function() {
        reject(new TypeError('Network request failed'));
      };

      xhr.onabort = function() {
        reject(new exports.DOMException('Aborted', 'AbortError'));
      };

      xhr.open(request.method, request.url, true);

      if (request.credentials === 'include') {
        xhr.withCredentials = true;
      } else if (request.credentials === 'omit') {
        xhr.withCredentials = false;
      }

      if ('responseType' in xhr && support.blob) {
        xhr.responseType = 'blob';
      }

      request.headers.forEach(function(value, name) {
        xhr.setRequestHeader(name, value);
      });

      if (request.signal) {
        request.signal.addEventListener('abort', abortXhr);

        xhr.onreadystatechange = function() {
          // DONE (success or failure)
          if (xhr.readyState === 4) {
            request.signal.removeEventListener('abort', abortXhr);
          }
        };
      }

      xhr.send(typeof request._bodyInit === 'undefined' ? null : request._bodyInit);
    })
  }

  fetch.polyfill = true;

  if (!self.fetch) {
    self.fetch = fetch;
    self.Headers = Headers;
    self.Request = Request;
    self.Response = Response;
  }

  exports.Headers = Headers;
  exports.Request = Request;
  exports.Response = Response;
  exports.fetch = fetch;

  Object.defineProperty(exports, '__esModule', { value: true });

  return exports;

}({}));
})(typeof self !== 'undefined' ? self : this);


/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/postcss-loader/src/index.js?!./node_modules/@algolia/autocomplete-theme-classic/dist/theme.css":
/*!*********************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--9-1!./node_modules/postcss-loader/src??ref--9-2!./node_modules/@algolia/autocomplete-theme-classic/dist/theme.css ***!
  \*********************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "/*! @algolia/autocomplete-theme-classic 1.2.2 | MIT License | © Algolia, Inc. and contributors | https://github.com/algolia/autocomplete */\n:root{--aa-search-input-height:44px;--aa-input-icon-size:20px;--aa-base-unit:16;--aa-spacing-factor:1;--aa-spacing:calc(var(--aa-base-unit)*var(--aa-spacing-factor)*1px);--aa-spacing-half:calc(var(--aa-spacing)/2);--aa-panel-max-height:650px;--aa-base-z-index:9999;--aa-font-size:calc(var(--aa-base-unit)*1px);--aa-font-family:inherit;--aa-font-weight-medium:500;--aa-font-weight-semibold:600;--aa-font-weight-bold:700;--aa-icon-size:20px;--aa-icon-stroke-width:1.6;--aa-icon-color-rgb:119,119,163;--aa-icon-color-alpha:1;--aa-action-icon-size:20px;--aa-text-color-rgb:38,38,39;--aa-text-color-alpha:1;--aa-primary-color-rgb:62,52,211;--aa-primary-color-alpha:0.2;--aa-muted-color-rgb:128,126,163;--aa-muted-color-alpha:0.6;--aa-panel-border-color-rgb:128,126,163;--aa-panel-border-color-alpha:0.3;--aa-input-border-color-rgb:128,126,163;--aa-input-border-color-alpha:0.8;--aa-background-color-rgb:255,255,255;--aa-background-color-alpha:1;--aa-input-background-color-rgb:255,255,255;--aa-input-background-color-alpha:1;--aa-selected-color-rgb:179,173,214;--aa-selected-color-alpha:0.205;--aa-description-highlight-background-color-rgb:245,223,77;--aa-description-highlight-background-color-alpha:0.5;--aa-detached-media-query:(max-width:680px);--aa-detached-modal-media-query:(min-width:680px);--aa-detached-modal-max-width:680px;--aa-detached-modal-max-height:500px;--aa-overlay-color-rgb:115,114,129;--aa-overlay-color-alpha:0.4;--aa-panel-shadow:0 0 0 1px rgba(35,38,59,0.1),0 6px 16px -4px rgba(35,38,59,0.15);--aa-scrollbar-width:13px;--aa-scrollbar-track-background-color-rgb:234,234,234;--aa-scrollbar-track-background-color-alpha:1;--aa-scrollbar-thumb-background-color-rgb:var(--aa-background-color-rgb);--aa-scrollbar-thumb-background-color-alpha:1}@media (hover:none) and (pointer:coarse){:root{--aa-spacing-factor:1.2;--aa-action-icon-size:22px}}body.dark,body[data-theme=dark]{--aa-text-color-rgb:183,192,199;--aa-primary-color-rgb:146,138,255;--aa-muted-color-rgb:146,138,255;--aa-input-background-color-rgb:0,3,9;--aa-background-color-rgb:21,24,42;--aa-selected-color-rgb:146,138,255;--aa-selected-color-alpha:0.25;--aa-description-highlight-background-color-rgb:0 255 255;--aa-description-highlight-background-color-alpha:0.25;--aa-icon-color-rgb:119,119,163;--aa-panel-shadow:inset 1px 1px 0 0 #2c2e40,0 3px 8px 0 #000309;--aa-scrollbar-track-background-color-rgb:44,46,64;--aa-scrollbar-thumb-background-color-rgb:var(--aa-background-color-rgb)}.aa-Autocomplete *,.aa-DetachedFormContainer *,.aa-Panel *{box-sizing:border-box}.aa-Autocomplete,.aa-DetachedFormContainer,.aa-Panel{color:#262627;color:rgba(var(--aa-text-color-rgb),var(--aa-text-color-alpha));font-family:inherit;font-family:var(--aa-font-family);font-size:16px;font-size:var(--aa-font-size);font-weight:400;line-height:1em;margin:0;padding:0;text-align:left}.aa-Form{align-items:center;background-color:#fff;background-color:rgba(var(--aa-input-background-color-rgb),var(--aa-input-background-color-alpha));border:1px solid rgba(128,126,163,.8);border:1px solid rgba(var(--aa-input-border-color-rgb),var(--aa-input-border-color-alpha));border-radius:3px;display:flex;line-height:1em;margin:0;position:relative;width:100%}.aa-Form[focus-within]{border-color:#3e34d3;border-color:rgba(var(--aa-primary-color-rgb),1);box-shadow:0 0 0 2px rgba(62,52,211,.2),inset 0 0 0 2px rgba(62,52,211,.2);box-shadow:rgba(var(--aa-primary-color-rgb),var(--aa-primary-color-alpha)) 0 0 0 2px,inset rgba(var(--aa-primary-color-rgb),var(--aa-primary-color-alpha)) 0 0 0 2px;outline:medium none currentColor}.aa-Form:focus-within{border-color:#3e34d3;border-color:rgba(var(--aa-primary-color-rgb),1);box-shadow:0 0 0 2px rgba(62,52,211,.2),inset 0 0 0 2px rgba(62,52,211,.2);box-shadow:rgba(var(--aa-primary-color-rgb),var(--aa-primary-color-alpha)) 0 0 0 2px,inset rgba(var(--aa-primary-color-rgb),var(--aa-primary-color-alpha)) 0 0 0 2px;outline:medium none currentColor}.aa-InputWrapperPrefix{align-items:center;display:flex;flex-shrink:0;height:44px;height:var(--aa-search-input-height);order:1}.aa-Label,.aa-LoadingIndicator{cursor:auto;flex-shrink:0;height:100%;padding:0;text-align:left}.aa-Label svg,.aa-LoadingIndicator svg{color:#3e34d3;color:rgba(var(--aa-primary-color-rgb),1);height:auto;max-height:20px;max-height:var(--aa-input-icon-size);stroke-width:1.6;stroke-width:var(--aa-icon-stroke-width);width:20px;width:var(--aa-input-icon-size)}.aa-LoadingIndicator,.aa-SubmitButton{height:100%;padding-left:11px;padding-left:calc(var(--aa-spacing)*0.75 - 1px);padding-right:8px;padding-right:var(--aa-spacing-half);width:47px;width:calc(var(--aa-spacing)*1.75 + var(--aa-icon-size) - 1px)}@media (hover:none) and (pointer:coarse){.aa-LoadingIndicator,.aa-SubmitButton{padding-left:3px;padding-left:calc(var(--aa-spacing-half)/2 - 1px);width:39px;width:calc(var(--aa-icon-size) + var(--aa-spacing)*1.25 - 1px)}}.aa-SubmitButton{-webkit-appearance:none;-moz-appearance:none;appearance:none;background:none;border:0;margin:0}.aa-LoadingIndicator{align-items:center;display:flex;justify-content:center}.aa-LoadingIndicator[hidden]{display:none}.aa-InputWrapper{order:3;position:relative;width:100%}.aa-Input{-webkit-appearance:none;-moz-appearance:none;appearance:none;background:none;border:0;color:#262627;color:rgba(var(--aa-text-color-rgb),var(--aa-text-color-alpha));font:inherit;height:44px;height:var(--aa-search-input-height);padding:0;width:100%}.aa-Input::-moz-placeholder{color:rgba(128,126,163,.6);color:rgba(var(--aa-muted-color-rgb),var(--aa-muted-color-alpha));opacity:1}.aa-Input:-ms-input-placeholder{color:rgba(128,126,163,.6);color:rgba(var(--aa-muted-color-rgb),var(--aa-muted-color-alpha));opacity:1}.aa-Input::placeholder{color:rgba(128,126,163,.6);color:rgba(var(--aa-muted-color-rgb),var(--aa-muted-color-alpha));opacity:1}.aa-Input:focus{border-color:none;box-shadow:none;outline:none}.aa-Input::-webkit-search-cancel-button,.aa-Input::-webkit-search-decoration,.aa-Input::-webkit-search-results-button,.aa-Input::-webkit-search-results-decoration{-webkit-appearance:none;appearance:none}.aa-InputWrapperSuffix{align-items:center;display:flex;height:44px;height:var(--aa-search-input-height);order:4}.aa-ClearButton{align-items:center;background:none;border:0;color:rgba(128,126,163,.6);color:rgba(var(--aa-muted-color-rgb),var(--aa-muted-color-alpha));cursor:pointer;display:flex;height:100%;margin:0;padding:0 12.83333px;padding:0 calc(var(--aa-spacing)*0.83333 - .5px)}@media (hover:none) and (pointer:coarse){.aa-ClearButton{padding:0 10.16667px;padding:0 calc(var(--aa-spacing)*0.66667 - .5px)}}.aa-ClearButton:focus,.aa-ClearButton:hover{color:#262627;color:rgba(var(--aa-text-color-rgb),var(--aa-text-color-alpha))}.aa-ClearButton[hidden]{display:none}.aa-ClearButton svg{stroke-width:1.6;stroke-width:var(--aa-icon-stroke-width);width:20px;width:var(--aa-icon-size)}.aa-Panel{background-color:#fff;background-color:rgba(var(--aa-background-color-rgb),var(--aa-background-color-alpha));border-radius:4px;border-radius:calc(var(--aa-spacing)/4);box-shadow:0 0 0 1px rgba(35,38,59,.1),0 6px 16px -4px rgba(35,38,59,.15);box-shadow:var(--aa-panel-shadow);margin:8px 0 0;overflow:hidden;position:absolute;transition:opacity .2s ease-in,filter .2s ease-in}@media screen and (prefers-reduced-motion){.aa-Panel{transition:none}}.aa-Panel button{-webkit-appearance:none;-moz-appearance:none;appearance:none;background:none;border:0;margin:0;padding:0}.aa-PanelLayout{height:100%;margin:0;max-height:650px;max-height:var(--aa-panel-max-height);overflow-y:auto;padding:0;position:relative;text-align:left}.aa-PanelLayoutColumns--twoGolden{display:grid;grid-template-columns:39.2% auto;overflow:hidden;padding:0}.aa-PanelLayoutColumns--two{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));overflow:hidden;padding:0}.aa-PanelLayoutColumns--three{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));overflow:hidden;padding:0}.aa-Panel--stalled .aa-Source{filter:grayscale(1);opacity:.8}.aa-Panel--scrollable{margin:0;max-height:650px;max-height:var(--aa-panel-max-height);overflow-x:hidden;overflow-y:auto;padding:8px;padding:var(--aa-spacing-half);scrollbar-color:#fff #eaeaea;scrollbar-color:rgba(var(--aa-scrollbar-thumb-background-color-rgb),var(--aa-scrollbar-thumb-background-color-alpha)) rgba(var(--aa-scrollbar-track-background-color-rgb),var(--aa-scrollbar-track-background-color-alpha));scrollbar-width:thin}.aa-Panel--scrollable::-webkit-scrollbar{width:13px;width:var(--aa-scrollbar-width)}.aa-Panel--scrollable::-webkit-scrollbar-track{background-color:#eaeaea;background-color:rgba(var(--aa-scrollbar-track-background-color-rgb),var(--aa-scrollbar-track-background-color-alpha))}.aa-Panel--scrollable::-webkit-scrollbar-thumb{background-color:#fff;background-color:rgba(var(--aa-scrollbar-thumb-background-color-rgb),var(--aa-scrollbar-thumb-background-color-alpha));border-radius:9999px;border:3px solid #eaeaea;border-color:rgba(var(--aa-scrollbar-track-background-color-rgb),var(--aa-scrollbar-track-background-color-alpha));border-right:2px solid rgba(var(--aa-scrollbar-track-background-color-rgb),var(--aa-scrollbar-track-background-color-alpha))}.aa-Source{margin:0;padding:0;position:relative;width:100%}.aa-Source:empty{display:none}.aa-SourceNoResults{font-size:1em;margin:0;padding:16px;padding:var(--aa-spacing)}.aa-List{list-style:none;margin:0}.aa-List,.aa-SourceHeader{padding:0;position:relative}.aa-SourceHeader{margin:8px .5em 8px 0;margin:var(--aa-spacing-half) .5em var(--aa-spacing-half) 0}.aa-SourceHeader:empty{display:none}.aa-SourceHeaderTitle{background:#fff;background:rgba(var(--aa-background-color-rgb),var(--aa-background-color-alpha));color:#3e34d3;color:rgba(var(--aa-primary-color-rgb),1);display:inline-block;font-size:.8em;font-weight:600;font-weight:var(--aa-font-weight-semibold);margin:0;padding:0 8px 0 0;padding:0 var(--aa-spacing-half) 0 0;position:relative;z-index:9999;z-index:var(--aa-base-z-index)}.aa-SourceHeaderLine{border-bottom:1px solid #3e34d3;border-bottom:1px solid rgba(var(--aa-primary-color-rgb),1);display:block;height:2px;left:0;margin:0;opacity:.3;padding:0;position:absolute;right:0;top:8px;top:var(--aa-spacing-half);z-index:9998;z-index:calc(var(--aa-base-z-index) - 1)}.aa-SourceFooterSeeAll{background:linear-gradient(180deg,#fff,rgba(128,126,163,.14));background:linear-gradient(180deg,rgba(var(--aa-background-color-rgb),var(--aa-background-color-alpha)),rgba(128,126,163,.14));border:1px solid rgba(128,126,163,.6);border:1px solid rgba(var(--aa-muted-color-rgb),var(--aa-muted-color-alpha));border-radius:5px;box-shadow:inset 0 0 2px #fff,0 2px 2px -1px rgba(76,69,88,.15);color:inherit;font-size:.95em;font-weight:500;font-weight:var(--aa-font-weight-medium);padding:.475em 1em .6em;text-decoration:none}.aa-SourceFooterSeeAll:focus,.aa-SourceFooterSeeAll:hover{border:1px solid #3e34d3;border:1px solid rgba(var(--aa-primary-color-rgb),1);color:#3e34d3;color:rgba(var(--aa-primary-color-rgb),1)}.aa-Item{align-items:center;border-radius:3px;cursor:pointer;display:grid;min-height:40px;min-height:calc(var(--aa-spacing)*2.5);padding:4px;padding:calc(var(--aa-spacing-half)/2)}.aa-Item[aria-selected=true]{background-color:rgba(179,173,214,.205);background-color:rgba(var(--aa-selected-color-rgb),var(--aa-selected-color-alpha))}.aa-Item[aria-selected=true] .aa-ActiveOnly,.aa-Item[aria-selected=true] .aa-ItemActionButton{visibility:visible}.aa-ItemIcon{align-items:center;background:#fff;background:rgba(var(--aa-background-color-rgb),var(--aa-background-color-alpha));border-radius:3px;box-shadow:inset 0 0 0 1px rgba(128,126,163,.3);box-shadow:inset 0 0 0 1px rgba(var(--aa-panel-border-color-rgb),var(--aa-panel-border-color-alpha));color:#7777a3;color:rgba(var(--aa-icon-color-rgb),var(--aa-icon-color-alpha));display:flex;flex-shrink:0;font-size:.7em;height:28px;height:calc(var(--aa-icon-size) + var(--aa-spacing-half));justify-content:center;overflow:hidden;stroke-width:1.6;stroke-width:var(--aa-icon-stroke-width);text-align:center;width:28px;width:calc(var(--aa-icon-size) + var(--aa-spacing-half))}.aa-ItemIcon img{height:auto;max-height:20px;max-height:calc(var(--aa-icon-size) + var(--aa-spacing-half) - 8px);max-width:20px;max-width:calc(var(--aa-icon-size) + var(--aa-spacing-half) - 8px);width:auto}.aa-ItemIcon svg{height:20px;height:var(--aa-icon-size);width:20px;width:var(--aa-icon-size)}.aa-ItemIcon--alignTop{align-self:flex-start}.aa-ItemIcon--noBorder{background:none;box-shadow:none}.aa-ItemIcon--picture{height:96px;width:96px}.aa-ItemIcon--picture img{max-height:100%;max-width:100%;padding:8px;padding:var(--aa-spacing-half)}.aa-ItemContent{align-items:center;cursor:pointer;display:grid;grid-gap:8px;gap:8px;grid-gap:var(--aa-spacing-half);gap:var(--aa-spacing-half);grid-auto-flow:column;line-height:1.25em;overflow:hidden}.aa-ItemContent:empty{display:none}.aa-ItemContent mark{background:none;color:#262627;color:rgba(var(--aa-text-color-rgb),var(--aa-text-color-alpha));font-style:normal;font-weight:700;font-weight:var(--aa-font-weight-bold)}.aa-ItemContent--dual{display:flex;flex-direction:column;justify-content:space-between;text-align:left}.aa-ItemContent--dual .aa-ItemContentSubtitle,.aa-ItemContent--dual .aa-ItemContentTitle{display:block}.aa-ItemContent--indented{padding-left:36px;padding-left:calc(var(--aa-icon-size) + var(--aa-spacing))}.aa-ItemContentBody{display:grid;grid-gap:4px;gap:4px;grid-gap:calc(var(--aa-spacing-half)/2);gap:calc(var(--aa-spacing-half)/2)}.aa-ItemContentTitle{display:inline-block;margin:0 .5em 0 0;max-width:100%;overflow:hidden;padding:0;text-overflow:ellipsis;white-space:nowrap}.aa-ItemContentSubtitle{font-size:.92em}.aa-ItemContentSubtitleIcon:before{border-color:rgba(128,126,163,.64);border-color:rgba(var(--aa-muted-color-rgb),.64);border-style:solid;content:\"\";display:inline-block;left:1px;position:relative;top:-3px}.aa-ItemContentSubtitle--inline .aa-ItemContentSubtitleIcon:before{border-width:0 0 1.5px;margin-left:8px;margin-left:var(--aa-spacing-half);margin-right:4px;margin-right:calc(var(--aa-spacing-half)/2);width:10px;width:calc(var(--aa-spacing-half) + 2px)}.aa-ItemContentSubtitle--standalone{align-items:center;color:#262627;color:rgba(var(--aa-text-color-rgb),var(--aa-text-color-alpha));display:grid;grid-gap:8px;gap:8px;grid-gap:var(--aa-spacing-half);gap:var(--aa-spacing-half);grid-auto-flow:column;justify-content:start}.aa-ItemContentSubtitle--standalone .aa-ItemContentSubtitleIcon:before{border-radius:0 0 0 3px;border-width:0 0 1.5px 1.5px;height:8px;height:var(--aa-spacing-half);width:8px;width:var(--aa-spacing-half)}.aa-ItemContentSubtitleCategory{color:#807ea3;color:rgba(var(--aa-muted-color-rgb),1);font-weight:500}.aa-ItemContentDescription{color:#262627;color:rgba(var(--aa-text-color-rgb),var(--aa-text-color-alpha));font-size:.85em;max-width:100%;overflow-x:hidden;text-overflow:ellipsis}.aa-ItemContentDescription:empty{display:none}.aa-ItemContentDescription mark{background:rgba(245,223,77,.5);background:rgba(var(--aa-description-highlight-background-color-rgb),var(--aa-description-highlight-background-color-alpha));color:#262627;color:rgba(var(--aa-text-color-rgb),var(--aa-text-color-alpha));font-style:normal;font-weight:500;font-weight:var(--aa-font-weight-medium)}.aa-ItemContentDash{color:rgba(128,126,163,.6);color:rgba(var(--aa-muted-color-rgb),var(--aa-muted-color-alpha));display:none;opacity:.4}.aa-ItemContentTag{background-color:rgba(62,52,211,.2);background-color:rgba(var(--aa-primary-color-rgb),var(--aa-primary-color-alpha));border-radius:3px;margin:0 .4em 0 0;padding:.08em .3em}.aa-ItemLink,.aa-ItemWrapper{align-items:center;color:inherit;display:grid;grid-gap:4px;gap:4px;grid-gap:calc(var(--aa-spacing-half)/2);gap:calc(var(--aa-spacing-half)/2);grid-auto-flow:column;justify-content:space-between;width:100%}.aa-ItemLink{color:inherit;text-decoration:none}.aa-ItemActions{display:grid;grid-auto-flow:column;height:100%;justify-self:end;margin:0 -5.33333px;margin:0 calc(var(--aa-spacing)/-3);padding:0 2px 0 0}.aa-ItemActionButton{align-items:center;background:none;border:0;color:rgba(128,126,163,.6);color:rgba(var(--aa-muted-color-rgb),var(--aa-muted-color-alpha));cursor:pointer;display:flex;flex-shrink:0;padding:0}.aa-ItemActionButton:focus svg,.aa-ItemActionButton:hover svg{color:#262627;color:rgba(var(--aa-text-color-rgb),var(--aa-text-color-alpha))}@media (hover:none) and (pointer:coarse){.aa-ItemActionButton:focus svg,.aa-ItemActionButton:hover svg{color:inherit}}.aa-ItemActionButton svg{color:rgba(128,126,163,.6);color:rgba(var(--aa-muted-color-rgb),var(--aa-muted-color-alpha));margin:5.33333px;margin:calc(var(--aa-spacing)/3);stroke-width:1.6;stroke-width:var(--aa-icon-stroke-width);width:20px;width:var(--aa-action-icon-size)}.aa-ActiveOnly{visibility:hidden}.aa-PanelHeader{align-items:center;background:#3e34d3;background:rgba(var(--aa-primary-color-rgb),1);color:#fff;display:grid;height:var(--aa-modal-header-height);margin:0;padding:8px 16px;padding:var(--aa-spacing-half) var(--aa-spacing);position:relative}.aa-PanelHeader:after{background-image:linear-gradient(#fff,hsla(0,0%,100%,0));background-image:linear-gradient(rgba(var(--aa-background-color-rgb),1),rgba(var(--aa-background-color-rgb),0));bottom:-8px;bottom:calc(var(--aa-spacing-half)*-1);content:\"\";height:8px;height:var(--aa-spacing-half);left:0;pointer-events:none;position:absolute;right:0}.aa-PanelFooter,.aa-PanelHeader:after{z-index:9999;z-index:var(--aa-base-z-index)}.aa-PanelFooter{background-color:#fff;background-color:rgba(var(--aa-background-color-rgb),var(--aa-background-color-alpha));box-shadow:inset 0 1px 0 rgba(128,126,163,.3);box-shadow:inset 0 1px 0 rgba(var(--aa-panel-border-color-rgb),var(--aa-panel-border-color-alpha));display:flex;justify-content:space-between;margin:0;padding:16px;padding:var(--aa-spacing);position:relative}.aa-PanelFooter:after{background-image:linear-gradient(hsla(0,0%,100%,0),rgba(128,126,163,.6));background-image:linear-gradient(rgba(var(--aa-background-color-rgb),0),rgba(var(--aa-muted-color-rgb),var(--aa-muted-color-alpha)));content:\"\";height:16px;height:var(--aa-spacing);left:0;opacity:.12;pointer-events:none;position:absolute;right:0;top:-16px;top:calc(var(--aa-spacing)*-1);z-index:9998;z-index:calc(var(--aa-base-z-index) - 1)}.aa-DetachedContainer{background:#fff;background:rgba(var(--aa-background-color-rgb),var(--aa-background-color-alpha));bottom:0;box-shadow:0 0 0 1px rgba(35,38,59,.1),0 6px 16px -4px rgba(35,38,59,.15);box-shadow:var(--aa-panel-shadow);display:flex;flex-direction:column;left:0;margin:0;overflow:hidden;padding:0;position:fixed;right:0;top:0;z-index:9999;z-index:var(--aa-base-z-index)}.aa-DetachedContainer:after{height:32px}.aa-DetachedContainer .aa-SourceHeader{margin:8px 0 8px 2px;margin:var(--aa-spacing-half) 0 var(--aa-spacing-half) 2px}.aa-DetachedContainer .aa-Panel{background-color:#fff;background-color:rgba(var(--aa-background-color-rgb),var(--aa-background-color-alpha));border-radius:0;box-shadow:none;flex-grow:1;margin:0;padding:0;position:relative}.aa-DetachedContainer .aa-PanelLayout{bottom:0;box-shadow:none;left:0;margin:0;max-height:none;overflow-y:auto;position:absolute;right:0;top:0;width:100%}.aa-DetachedFormContainer{border-bottom:1px solid rgba(128,126,163,.3);border-bottom:1px solid rgba(var(--aa-panel-border-color-rgb),var(--aa-panel-border-color-alpha));display:flex;flex-direction:row;justify-content:space-between;margin:0;padding:8px;padding:var(--aa-spacing-half)}.aa-DetachedCancelButton{background:none;border:0;border-radius:3px;color:inherit;color:#262627;color:rgba(var(--aa-text-color-rgb),var(--aa-text-color-alpha));cursor:pointer;font:inherit;margin:0 0 0 8px;margin:0 0 0 var(--aa-spacing-half);padding:0 8px;padding:0 var(--aa-spacing-half)}.aa-DetachedCancelButton:focus,.aa-DetachedCancelButton:hover{box-shadow:inset 0 0 0 1px rgba(128,126,163,.3);box-shadow:inset 0 0 0 1px rgba(var(--aa-panel-border-color-rgb),var(--aa-panel-border-color-alpha))}.aa-DetachedContainer--modal{border-radius:6px;bottom:inherit;height:auto;margin:0 auto;max-width:680px;max-width:var(--aa-detached-modal-max-width);position:absolute;top:3%}.aa-DetachedContainer--modal .aa-PanelLayout{max-height:500px;max-height:var(--aa-detached-modal-max-height);padding-bottom:8px;padding-bottom:var(--aa-spacing-half);position:static}.aa-DetachedSearchButton{align-items:center;background-color:#fff;background-color:rgba(var(--aa-input-background-color-rgb),var(--aa-input-background-color-alpha));border:1px solid rgba(128,126,163,.8);border:1px solid rgba(var(--aa-input-border-color-rgb),var(--aa-input-border-color-alpha));border-radius:3px;color:rgba(128,126,163,.6);color:rgba(var(--aa-muted-color-rgb),var(--aa-muted-color-alpha));cursor:pointer;display:flex;font:inherit;font-family:inherit;font-family:var(--aa-font-family);font-size:16px;font-size:var(--aa-font-size);height:44px;height:var(--aa-search-input-height);margin:0;padding:0 5.5px;padding:0 calc(var(--aa-search-input-height)/8);position:relative;text-align:left;width:100%}.aa-DetachedSearchButton:focus{border-color:#3e34d3;border-color:rgba(var(--aa-primary-color-rgb),1);box-shadow:0 0 0 3px rgba(62,52,211,.2),inset 0 0 0 2px rgba(62,52,211,.2);box-shadow:rgba(var(--aa-primary-color-rgb),var(--aa-primary-color-alpha)) 0 0 0 3px,inset rgba(var(--aa-primary-color-rgb),var(--aa-primary-color-alpha)) 0 0 0 2px;outline:medium none currentColor}.aa-DetachedSearchButtonIcon{align-items:center;color:#3e34d3;color:rgba(var(--aa-primary-color-rgb),1);cursor:auto;display:flex;height:100%;justify-content:center;width:36px;width:calc(var(--aa-icon-size) + var(--aa-spacing))}.aa-Detached{height:100vh;overflow:hidden}.aa-DetachedOverlay{background-color:rgba(115,114,129,.4);background-color:rgba(var(--aa-overlay-color-rgb),var(--aa-overlay-color-alpha));height:100vh;left:0;margin:0;padding:0;position:fixed;right:0;top:0;z-index:9998;z-index:calc(var(--aa-base-z-index) - 1)}.aa-GradientBottom,.aa-GradientTop{height:8px;height:var(--aa-spacing-half);left:0;pointer-events:none;position:absolute;right:0;z-index:9999;z-index:var(--aa-base-z-index)}.aa-GradientTop{background-image:linear-gradient(#fff,hsla(0,0%,100%,0));background-image:linear-gradient(rgba(var(--aa-background-color-rgb),1),rgba(var(--aa-background-color-rgb),0));top:0}.aa-GradientBottom{background-image:linear-gradient(hsla(0,0%,100%,0),#fff);background-image:linear-gradient(rgba(var(--aa-background-color-rgb),0),rgba(var(--aa-background-color-rgb),1));border-bottom-left-radius:4px;border-bottom-left-radius:calc(var(--aa-spacing)/4);border-bottom-right-radius:4px;border-bottom-right-radius:calc(var(--aa-spacing)/4);bottom:0}@media (hover:none) and (pointer:coarse){.aa-DesktopOnly{display:none}}@media (hover:hover){.aa-TouchOnly{display:none}}", ""]);

// exports


/***/ }),

/***/ "./node_modules/css-loader/lib/css-base.js":
/*!*************************************************!*\
  !*** ./node_modules/css-loader/lib/css-base.js ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

/*
	MIT License http://www.opensource.org/licenses/mit-license.php
	Author Tobias Koppers @sokra
*/
// css base code, injected by the css-loader
module.exports = function(useSourceMap) {
	var list = [];

	// return the list of modules as css string
	list.toString = function toString() {
		return this.map(function (item) {
			var content = cssWithMappingToString(item, useSourceMap);
			if(item[2]) {
				return "@media " + item[2] + "{" + content + "}";
			} else {
				return content;
			}
		}).join("");
	};

	// import a list of modules into the list
	list.i = function(modules, mediaQuery) {
		if(typeof modules === "string")
			modules = [[null, modules, ""]];
		var alreadyImportedModules = {};
		for(var i = 0; i < this.length; i++) {
			var id = this[i][0];
			if(typeof id === "number")
				alreadyImportedModules[id] = true;
		}
		for(i = 0; i < modules.length; i++) {
			var item = modules[i];
			// skip already imported module
			// this implementation is not 100% perfect for weird media query combinations
			//  when a module is imported multiple times with different media queries.
			//  I hope this will never occur (Hey this way we have smaller bundles)
			if(typeof item[0] !== "number" || !alreadyImportedModules[item[0]]) {
				if(mediaQuery && !item[2]) {
					item[2] = mediaQuery;
				} else if(mediaQuery) {
					item[2] = "(" + item[2] + ") and (" + mediaQuery + ")";
				}
				list.push(item);
			}
		}
	};
	return list;
};

function cssWithMappingToString(item, useSourceMap) {
	var content = item[1] || '';
	var cssMapping = item[3];
	if (!cssMapping) {
		return content;
	}

	if (useSourceMap && typeof btoa === 'function') {
		var sourceMapping = toComment(cssMapping);
		var sourceURLs = cssMapping.sources.map(function (source) {
			return '/*# sourceURL=' + cssMapping.sourceRoot + source + ' */'
		});

		return [content].concat(sourceURLs).concat([sourceMapping]).join('\n');
	}

	return [content].join('\n');
}

// Adapted from convert-source-map (MIT)
function toComment(sourceMap) {
	// eslint-disable-next-line no-undef
	var base64 = btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap))));
	var data = 'sourceMappingURL=data:application/json;charset=utf-8;base64,' + base64;

	return '/*# ' + data + ' */';
}


/***/ }),

/***/ "./node_modules/htm/dist/htm.module.js":
/*!*********************************************!*\
  !*** ./node_modules/htm/dist/htm.module.js ***!
  \*********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
var n=function(t,s,r,e){var u;s[0]=0;for(var h=1;h<s.length;h++){var p=s[h++],a=s[h]?(s[0]|=p?1:2,r[s[h++]]):s[++h];3===p?e[0]=a:4===p?e[1]=Object.assign(e[1]||{},a):5===p?(e[1]=e[1]||{})[s[++h]]=a:6===p?e[1][s[++h]]+=a+"":p?(u=t.apply(a,n(t,a,r,["",null])),e.push(u),a[0]?s[0]|=2:(s[h-2]=0,s[h]=u)):e.push(a)}return e},t=new Map;/* harmony default export */ __webpack_exports__["default"] = (function(s){var r=t.get(this);return r||(r=new Map,t.set(this,r)),(r=n(this,r.get(s)||(r.set(s,r=function(n){for(var t,s,r=1,e="",u="",h=[0],p=function(n){1===r&&(n||(e=e.replace(/^\s*\n\s*|\s*\n\s*$/g,"")))?h.push(0,n,e):3===r&&(n||e)?(h.push(3,n,e),r=2):2===r&&"..."===e&&n?h.push(4,n,0):2===r&&e&&!n?h.push(5,0,!0,e):r>=5&&((e||!n&&5===r)&&(h.push(r,0,e,s),r=6),n&&(h.push(r,n,0,s),r=6)),e=""},a=0;a<n.length;a++){a&&(1===r&&p(),p(a));for(var l=0;l<n[a].length;l++)t=n[a][l],1===r?"<"===t?(p(),h=[h],r=3):e+=t:4===r?"--"===e&&">"===t?(r=1,e=""):e=t+e[0]:u?t===u?u="":e+=t:'"'===t||"'"===t?u=t:">"===t?(p(),r=1):r&&("="===t?(r=5,s=e,e=""):"/"===t&&(r<5||">"===n[a][l+1])?(p(),3===r&&(h=h[0]),r=h,(h=h[0]).push(2,0,r),r=0):" "===t||"\t"===t||"\n"===t||"\r"===t?(p(),r=2):e+=t),3===r&&"!--"===e&&(r=4,h=h[0])}return p(),h}(s)),r),arguments,[])).length>1?r:r[0]});


/***/ }),

/***/ "./node_modules/htm/preact/index.module.js":
/*!*************************************************!*\
  !*** ./node_modules/htm/preact/index.module.js ***!
  \*************************************************/
/*! exports provided: h, render, Component, html */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "html", function() { return m; });
/* harmony import */ var preact__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! preact */ "./node_modules/preact/dist/preact.module.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "h", function() { return preact__WEBPACK_IMPORTED_MODULE_0__["h"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return preact__WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "Component", function() { return preact__WEBPACK_IMPORTED_MODULE_0__["Component"]; });

/* harmony import */ var htm__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! htm */ "./node_modules/htm/dist/htm.module.js");
var m=htm__WEBPACK_IMPORTED_MODULE_1__["default"].bind(preact__WEBPACK_IMPORTED_MODULE_0__["h"]);


/***/ }),

/***/ "./node_modules/meilisearch/dist/bundles/meilisearch.umd.js":
/*!******************************************************************!*\
  !*** ./node_modules/meilisearch/dist/bundles/meilisearch.umd.js ***!
  \******************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

(function (global, factory) {
     true ? factory(exports, __webpack_require__(/*! cross-fetch/polyfill */ "./node_modules/cross-fetch/dist/browser-polyfill.js")) :
    undefined;
}(this, (function (exports) { 'use strict';

    /*! *****************************************************************************
    Copyright (c) Microsoft Corporation.

    Permission to use, copy, modify, and/or distribute this software for any
    purpose with or without fee is hereby granted.

    THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES WITH
    REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF MERCHANTABILITY
    AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY SPECIAL, DIRECT,
    INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES WHATSOEVER RESULTING FROM
    LOSS OF USE, DATA OR PROFITS, WHETHER IN AN ACTION OF CONTRACT, NEGLIGENCE OR
    OTHER TORTIOUS ACTION, ARISING OUT OF OR IN CONNECTION WITH THE USE OR
    PERFORMANCE OF THIS SOFTWARE.
    ***************************************************************************** */
    /* global Reflect, Promise */

    var extendStatics = function(d, b) {
        extendStatics = Object.setPrototypeOf ||
            ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
            function (d, b) { for (var p in b) if (Object.prototype.hasOwnProperty.call(b, p)) d[p] = b[p]; };
        return extendStatics(d, b);
    };

    function __extends(d, b) {
        if (typeof b !== "function" && b !== null)
            throw new TypeError("Class extends value " + String(b) + " is not a constructor or null");
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    }

    var __assign = function() {
        __assign = Object.assign || function __assign(t) {
            for (var s, i = 1, n = arguments.length; i < n; i++) {
                s = arguments[i];
                for (var p in s) if (Object.prototype.hasOwnProperty.call(s, p)) t[p] = s[p];
            }
            return t;
        };
        return __assign.apply(this, arguments);
    };

    function __awaiter(thisArg, _arguments, P, generator) {
        function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
        return new (P || (P = Promise))(function (resolve, reject) {
            function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
            function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
            function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
            step((generator = generator.apply(thisArg, _arguments || [])).next());
        });
    }

    function __generator(thisArg, body) {
        var _ = { label: 0, sent: function() { if (t[0] & 1) throw t[1]; return t[1]; }, trys: [], ops: [] }, f, y, t, g;
        return g = { next: verb(0), "throw": verb(1), "return": verb(2) }, typeof Symbol === "function" && (g[Symbol.iterator] = function() { return this; }), g;
        function verb(n) { return function (v) { return step([n, v]); }; }
        function step(op) {
            if (f) throw new TypeError("Generator is already executing.");
            while (_) try {
                if (f = 1, y && (t = op[0] & 2 ? y["return"] : op[0] ? y["throw"] || ((t = y["return"]) && t.call(y), 0) : y.next) && !(t = t.call(y, op[1])).done) return t;
                if (y = 0, t) op = [op[0] & 2, t.value];
                switch (op[0]) {
                    case 0: case 1: t = op; break;
                    case 4: _.label++; return { value: op[1], done: false };
                    case 5: _.label++; y = op[1]; op = [0]; continue;
                    case 7: op = _.ops.pop(); _.trys.pop(); continue;
                    default:
                        if (!(t = _.trys, t = t.length > 0 && t[t.length - 1]) && (op[0] === 6 || op[0] === 2)) { _ = 0; continue; }
                        if (op[0] === 3 && (!t || (op[1] > t[0] && op[1] < t[3]))) { _.label = op[1]; break; }
                        if (op[0] === 6 && _.label < t[1]) { _.label = t[1]; t = op; break; }
                        if (t && _.label < t[2]) { _.label = t[2]; _.ops.push(op); break; }
                        if (t[2]) _.ops.pop();
                        _.trys.pop(); continue;
                }
                op = body.call(thisArg, _);
            } catch (e) { op = [6, e]; y = 0; } finally { f = t = 0; }
            if (op[0] & 5) throw op[1]; return { value: op[0] ? op[1] : void 0, done: true };
        }
    }

    var MeiliSearchError =
    /** @class */
    function (_super) {
      __extends(MeiliSearchError, _super);

      function MeiliSearchError(message) {
        var _this = _super.call(this, message) || this;

        _this.name = 'MeiliSearchError';
        _this.type = 'MeiliSearchError';

        if (Error.captureStackTrace) {
          Error.captureStackTrace(_this, MeiliSearchError);
        }

        return _this;
      }

      return MeiliSearchError;
    }(Error);

    var MeiliSearchTimeOutError =
    /** @class */
    function (_super) {
      __extends(MeiliSearchTimeOutError, _super);

      function MeiliSearchTimeOutError(message) {
        var _this = _super.call(this, message) || this;

        _this.name = 'MeiliSearchTimeOutError';
        _this.type = _this.constructor.name;

        if (Error.captureStackTrace) {
          Error.captureStackTrace(_this, MeiliSearchTimeOutError);
        }

        return _this;
      }

      return MeiliSearchTimeOutError;
    }(Error);

    /**
     * Removes undefined entries from object
     */

    function removeUndefinedFromObject(obj) {
      return Object.entries(obj).reduce(function (acc, curEntry) {
        var key = curEntry[0],
            val = curEntry[1];
        if (val !== undefined) acc[key] = val;
        return acc;
      }, {});
    }

    function sleep(ms) {
      return __awaiter(this, void 0, void 0, function () {
        return __generator(this, function (_a) {
          switch (_a.label) {
            case 0:
              return [4
              /*yield*/
              , new Promise(function (resolve) {
                return setTimeout(resolve, ms);
              })];

            case 1:
              return [2
              /*return*/
              , _a.sent()];
          }
        });
      });
    }

    var MeiliSearchCommunicationError =
    /** @class */
    function (_super) {
      __extends(MeiliSearchCommunicationError, _super);

      function MeiliSearchCommunicationError(message, body) {
        var _this = _super.call(this, message) || this;

        _this.name = 'MeiliSearchCommunicationError';
        _this.type = 'MeiliSearchCommunicationError';

        if (body instanceof Response) {
          _this.message = body.statusText;
          _this.statusCode = body.status;
        }

        if (body instanceof Error) {
          _this.errno = body.errno;
          _this.code = body.code;
        }

        if (Error.captureStackTrace) {
          Error.captureStackTrace(_this, MeiliSearchCommunicationError);
        }

        return _this;
      }

      return MeiliSearchCommunicationError;
    }(Error);

    var MeiliSearchApiError =
    /** @class */
    function (_super) {
      __extends(class_1, _super);

      function class_1(error, status) {
        var _this = _super.call(this, error.message) || this;

        _this.type = 'MeiliSearchApiError';
        _this.name = 'MeiliSearchApiError';
        _this.errorCode = error.errorCode;
        _this.errorType = error.errorType;
        _this.errorLink = error.errorLink;
        _this.message = error.message;
        _this.httpStatus = status;

        if (Error.captureStackTrace) {
          Error.captureStackTrace(_this, MeiliSearchApiError);
        }

        return _this;
      }

      return class_1;
    }(Error);

    function httpResponseErrorHandler(response) {
      return __awaiter(this, void 0, void 0, function () {
        var err;
        return __generator(this, function (_a) {
          switch (_a.label) {
            case 0:
              if (!!response.ok) return [3
              /*break*/
              , 5];
              err = void 0;
              _a.label = 1;

            case 1:
              _a.trys.push([1, 3,, 4]);

              return [4
              /*yield*/
              , response.json()];

            case 2:
              err = _a.sent();
              return [3
              /*break*/
              , 4];

            case 3:
              _a.sent();
              throw new MeiliSearchCommunicationError(response.statusText, response);

            case 4:
              throw new MeiliSearchApiError(err, response.status);

            case 5:
              return [2
              /*return*/
              , response];
          }
        });
      });
    }

    function httpErrorHandler(response) {
      if (response.type !== 'MeiliSearchApiError') {
        throw new MeiliSearchCommunicationError(response.message, response);
      }

      throw response;
    }

    var HttpRequests =
    /** @class */
    function () {
      function HttpRequests(config) {
        this.headers = __assign(__assign(__assign({}, config.headers || {}), {
          'Content-Type': 'application/json'
        }), config.apiKey ? {
          'X-Meili-API-Key': config.apiKey
        } : {});
        this.url = new URL(config.host);
      }

      HttpRequests.addTrailingSlash = function (url) {
        if (!url.endsWith('/')) {
          url += '/';
        }

        return url;
      };

      HttpRequests.prototype.request = function (_a) {
        var method = _a.method,
            url = _a.url,
            params = _a.params,
            body = _a.body,
            config = _a.config;
        return __awaiter(this, void 0, void 0, function () {
          var constructURL, queryParams_1, response, parsedBody, parsedJson, e_1;
          return __generator(this, function (_b) {
            switch (_b.label) {
              case 0:
                _b.trys.push([0, 3,, 4]);

                constructURL = new URL(url, this.url);

                if (params) {
                  queryParams_1 = new URLSearchParams();
                  Object.keys(params).filter(function (x) {
                    return params[x] !== null;
                  }).map(function (x) {
                    return queryParams_1.set(x, params[x]);
                  });
                  constructURL.search = queryParams_1.toString();
                }

                return [4
                /*yield*/
                , fetch(constructURL.toString(), __assign(__assign({}, config), {
                  method: method,
                  body: JSON.stringify(body),
                  headers: this.headers
                })).then(function (res) {
                  return httpResponseErrorHandler(res);
                })];

              case 1:
                response = _b.sent();
                return [4
                /*yield*/
                , response.text()];

              case 2:
                parsedBody = _b.sent();

                try {
                  parsedJson = JSON.parse(parsedBody);
                  return [2
                  /*return*/
                  , parsedJson];
                } catch (_) {
                  return [2
                  /*return*/
                  ];
                }

                return [3
                /*break*/
                , 4];

              case 3:
                e_1 = _b.sent();
                httpErrorHandler(e_1);
                return [3
                /*break*/
                , 4];

              case 4:
                return [2
                /*return*/
                ];
            }
          });
        });
      };

      HttpRequests.prototype.get = function (url, params, config) {
        return __awaiter(this, void 0, void 0, function () {
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                return [4
                /*yield*/
                , this.request({
                  method: 'GET',
                  url: url,
                  params: params,
                  config: config
                })];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      };

      HttpRequests.prototype.post = function (url, data, params, config) {
        return __awaiter(this, void 0, void 0, function () {
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                return [4
                /*yield*/
                , this.request({
                  method: 'POST',
                  url: url,
                  body: data,
                  params: params,
                  config: config
                })];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      };

      HttpRequests.prototype.put = function (url, data, params, config) {
        return __awaiter(this, void 0, void 0, function () {
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                return [4
                /*yield*/
                , this.request({
                  method: 'PUT',
                  url: url,
                  body: data,
                  params: params,
                  config: config
                })];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      };

      HttpRequests.prototype["delete"] = function (url, data, params, config) {
        return __awaiter(this, void 0, void 0, function () {
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                return [4
                /*yield*/
                , this.request({
                  method: 'DELETE',
                  url: url,
                  body: data,
                  params: params,
                  config: config
                })];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      };

      return HttpRequests;
    }();

    /*
     * Bundle: MeiliSearch / Indexes
     * Project: MeiliSearch - Javascript API
     * Author: Quentin de Quelen <quentin@meilisearch.com>
     * Copyright: 2019, MeiliSearch
     */

    var Index =
    /** @class */
    function () {
      function Index(config, uid, primaryKey) {
        this.uid = uid;
        this.primaryKey = primaryKey;
        this.httpRequest = new HttpRequests(config);
      } ///
      /// UTILS
      ///


      Index.prototype.waitForPendingUpdate = function (updateId, _a) {
        var _b = _a === void 0 ? {} : _a,
            _c = _b.timeOutMs,
            timeOutMs = _c === void 0 ? 5000 : _c,
            _d = _b.intervalMs,
            intervalMs = _d === void 0 ? 50 : _d;

        return __awaiter(this, void 0, void 0, function () {
          var startingTime, response;
          return __generator(this, function (_e) {
            switch (_e.label) {
              case 0:
                startingTime = Date.now();
                _e.label = 1;

              case 1:
                if (!(Date.now() - startingTime < timeOutMs)) return [3
                /*break*/
                , 4];
                return [4
                /*yield*/
                , this.getUpdateStatus(updateId)];

              case 2:
                response = _e.sent();
                if (response.status !== 'enqueued') return [2
                /*return*/
                , response];
                return [4
                /*yield*/
                , sleep(intervalMs)];

              case 3:
                _e.sent();

                return [3
                /*break*/
                , 1];

              case 4:
                throw new MeiliSearchTimeOutError("timeout of " + timeOutMs + "ms has exceeded on process " + updateId + " when waiting for pending update to resolve.");
            }
          });
        });
      }; ///
      /// SEARCH
      ///

      /**
       * Search for documents into an index
       * @memberof Index
       * @method search
       */


      Index.prototype.search = function (query, options, method, config) {
        if (method === void 0) {
          method = 'POST';
        }

        return __awaiter(this, void 0, void 0, function () {
          var url, params, getParams;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid + "/search";
                params = {
                  q: query,
                  offset: options === null || options === void 0 ? void 0 : options.offset,
                  limit: options === null || options === void 0 ? void 0 : options.limit,
                  cropLength: options === null || options === void 0 ? void 0 : options.cropLength,
                  filters: options === null || options === void 0 ? void 0 : options.filters,
                  matches: options === null || options === void 0 ? void 0 : options.matches,
                  facetFilters: options === null || options === void 0 ? void 0 : options.facetFilters,
                  facetsDistribution: options === null || options === void 0 ? void 0 : options.facetsDistribution,
                  attributesToRetrieve: options === null || options === void 0 ? void 0 : options.attributesToRetrieve,
                  attributesToCrop: options === null || options === void 0 ? void 0 : options.attributesToCrop,
                  attributesToHighlight: options === null || options === void 0 ? void 0 : options.attributesToHighlight
                };
                if (!(method.toUpperCase() === 'POST')) return [3
                /*break*/
                , 2];
                return [4
                /*yield*/
                , this.httpRequest.post(url, removeUndefinedFromObject(params), undefined, config)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];

              case 2:
                if (!(method.toUpperCase() === 'GET')) return [3
                /*break*/
                , 4];
                getParams = __assign(__assign({}, params), {
                  facetFilters: Array.isArray(options === null || options === void 0 ? void 0 : options.facetFilters) && (options === null || options === void 0 ? void 0 : options.facetFilters) ? JSON.stringify(options.facetFilters) : undefined,
                  facetsDistribution: (options === null || options === void 0 ? void 0 : options.facetsDistribution) ? JSON.stringify(options.facetsDistribution) : undefined,
                  attributesToRetrieve: (options === null || options === void 0 ? void 0 : options.attributesToRetrieve) ? options.attributesToRetrieve.join(',') : undefined,
                  attributesToCrop: (options === null || options === void 0 ? void 0 : options.attributesToCrop) ? options.attributesToCrop.join(',') : undefined,
                  attributesToHighlight: (options === null || options === void 0 ? void 0 : options.attributesToHighlight) ? options.attributesToHighlight.join(',') : undefined
                });
                return [4
                /*yield*/
                , this.httpRequest.get(url, removeUndefinedFromObject(getParams), config)];

              case 3:
                return [2
                /*return*/
                , _a.sent()];

              case 4:
                throw new MeiliSearchError('method parameter should be either POST or GET');
            }
          });
        });
      }; ///
      /// INDEX
      ///

      /**
       * Get index information.
       * @memberof Index
       * @method getRawInfo
       */


      Index.prototype.getRawInfo = function () {
        return __awaiter(this, void 0, void 0, function () {
          var url, res;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid;
                return [4
                /*yield*/
                , this.httpRequest.get(url)];

              case 1:
                res = _a.sent();
                this.primaryKey = res.primaryKey;
                return [2
                /*return*/
                , res];
            }
          });
        });
      };
      /**
       * Fetch and update Index information.
       * @memberof Index
       * @method fetchInfo
       */


      Index.prototype.fetchInfo = function () {
        return __awaiter(this, void 0, void 0, function () {
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                return [4
                /*yield*/
                , this.getRawInfo()];

              case 1:
                _a.sent();

                return [2
                /*return*/
                , this];
            }
          });
        });
      };
      /**
       * Get Primary Key.
       * @memberof Index
       * @method fetchPrimaryKey
       */


      Index.prototype.fetchPrimaryKey = function () {
        return __awaiter(this, void 0, void 0, function () {
          var _a;

          return __generator(this, function (_b) {
            switch (_b.label) {
              case 0:
                _a = this;
                return [4
                /*yield*/
                , this.getRawInfo()];

              case 1:
                _a.primaryKey = _b.sent().primaryKey;
                return [2
                /*return*/
                , this.primaryKey];
            }
          });
        });
      };
      /**
       * Create an index.
       * @memberof Index
       * @method create
       */


      Index.create = function (config, uid, options) {
        if (options === void 0) {
          options = {};
        }

        return __awaiter(this, void 0, void 0, function () {
          var url, req, index;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes";
                req = new HttpRequests(config);
                return [4
                /*yield*/
                , req.post(url, __assign(__assign({}, options), {
                  uid: uid
                }))];

              case 1:
                index = _a.sent();
                return [2
                /*return*/
                , new Index(config, uid, index.primaryKey)];
            }
          });
        });
      };
      /**
       * Update an index.
       * @memberof Index
       * @method update
       */


      Index.prototype.update = function (data) {
        return __awaiter(this, void 0, void 0, function () {
          var url, index;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid;
                return [4
                /*yield*/
                , this.httpRequest.put(url, data)];

              case 1:
                index = _a.sent();
                this.primaryKey = index.primaryKey;
                return [2
                /*return*/
                , this];
            }
          });
        });
      };
      /**
       * Delete an index.
       * @memberof Index
       * @method delete
       */


      Index.prototype["delete"] = function () {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid;
                return [4
                /*yield*/
                , this.httpRequest["delete"](url)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      };
      /**
       * Deletes an index if it already exists.
       * @memberof Index
       * @method deleteIfExists
       */


      Index.prototype.deleteIfExists = function () {
        return __awaiter(this, void 0, void 0, function () {
          var e_1;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                _a.trys.push([0, 2,, 3]);

                return [4
                /*yield*/
                , this["delete"]()];

              case 1:
                _a.sent();

                return [2
                /*return*/
                , true];

              case 2:
                e_1 = _a.sent();

                if (e_1.errorCode === 'index_not_found') {
                  return [2
                  /*return*/
                  , false];
                }

                throw e_1;

              case 3:
                return [2
                /*return*/
                ];
            }
          });
        });
      }; ///
      /// UPDATES
      ///

      /**
       * Get the list of all updates
       * @memberof Index
       * @method getAllUpdateStatus
       */


      Index.prototype.getAllUpdateStatus = function () {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid + "/updates";
                return [4
                /*yield*/
                , this.httpRequest.get(url)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      };
      /**
       * Get the informations about an update status
       * @memberof Index
       * @method getUpdateStatus
       */


      Index.prototype.getUpdateStatus = function (updateId) {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid + "/updates/" + updateId;
                return [4
                /*yield*/
                , this.httpRequest.get(url)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      }; ///
      /// STATS
      ///

      /**
       * get stats of an index
       * @memberof Index
       * @method getStats
       */


      Index.prototype.getStats = function () {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid + "/stats";
                return [4
                /*yield*/
                , this.httpRequest.get(url)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      }; ///
      /// DOCUMENTS
      ///

      /**
       * get documents of an index
       * @memberof Index
       * @method getDocuments
       */


      Index.prototype.getDocuments = function (options) {
        return __awaiter(this, void 0, void 0, function () {
          var url, attr;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid + "/documents";

                if (options !== undefined && Array.isArray(options.attributesToRetrieve)) {
                  attr = options.attributesToRetrieve.join(',');
                }

                return [4
                /*yield*/
                , this.httpRequest.get(url, __assign(__assign({}, options), attr !== undefined ? {
                  attributesToRetrieve: attr
                } : {}))];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      };
      /**
       * Get one document
       * @memberof Index
       * @method getDocument
       */


      Index.prototype.getDocument = function (documentId) {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid + "/documents/" + documentId;
                return [4
                /*yield*/
                , this.httpRequest.get(url)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      };
      /**
       * Add or replace multiples documents to an index
       * @memberof Index
       * @method addDocuments
       */


      Index.prototype.addDocuments = function (documents, options) {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid + "/documents";
                return [4
                /*yield*/
                , this.httpRequest.post(url, documents, options)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      };
      /**
       * Add or update multiples documents to an index
       * @memberof Index
       * @method updateDocuments
       */


      Index.prototype.updateDocuments = function (documents, options) {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid + "/documents";
                return [4
                /*yield*/
                , this.httpRequest.put(url, documents, options)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      };
      /**
       * Delete one document
       * @memberof Index
       * @method deleteDocument
       */


      Index.prototype.deleteDocument = function (documentId) {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid + "/documents/" + documentId;
                return [4
                /*yield*/
                , this.httpRequest["delete"](url)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      };
      /**
       * Delete multiples documents of an index
       * @memberof Index
       * @method deleteDocuments
       */


      Index.prototype.deleteDocuments = function (documentsIds) {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid + "/documents/delete-batch";
                return [4
                /*yield*/
                , this.httpRequest.post(url, documentsIds)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      };
      /**
       * Delete all documents of an index
       * @memberof Index
       * @method deleteAllDocuments
       */


      Index.prototype.deleteAllDocuments = function () {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid + "/documents";
                return [4
                /*yield*/
                , this.httpRequest["delete"](url)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      }; ///
      /// SETTINGS
      ///

      /**
       * Retrieve all settings
       * @memberof Index
       * @method getSettings
       */


      Index.prototype.getSettings = function () {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid + "/settings";
                return [4
                /*yield*/
                , this.httpRequest.get(url)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      };
      /**
       * Update all settings
       * Any parameters not provided will be left unchanged.
       * @memberof Index
       * @method updateSettings
       */


      Index.prototype.updateSettings = function (settings) {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid + "/settings";
                return [4
                /*yield*/
                , this.httpRequest.post(url, settings)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      };
      /**
       * Reset settings.
       * @memberof Index
       * @method resetSettings
       */


      Index.prototype.resetSettings = function () {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid + "/settings";
                return [4
                /*yield*/
                , this.httpRequest["delete"](url)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      }; ///
      /// SYNONYMS
      ///

      /**
       * Get the list of all synonyms
       * @memberof Index
       * @method getSynonyms
       */


      Index.prototype.getSynonyms = function () {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid + "/settings/synonyms";
                return [4
                /*yield*/
                , this.httpRequest.get(url)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      };
      /**
       * Update the list of synonyms. Overwrite the old list.
       * @memberof Index
       * @method updateSynonyms
       */


      Index.prototype.updateSynonyms = function (synonyms) {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid + "/settings/synonyms";
                return [4
                /*yield*/
                , this.httpRequest.post(url, synonyms)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      };
      /**
       * Reset the synonym list to be empty again
       * @memberof Index
       * @method resetSynonyms
       */


      Index.prototype.resetSynonyms = function () {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid + "/settings/synonyms";
                return [4
                /*yield*/
                , this.httpRequest["delete"](url)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      }; ///
      /// STOP WORDS
      ///

      /**
       * Get the list of all stop-words
       * @memberof Index
       * @method getStopWords
       */


      Index.prototype.getStopWords = function () {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid + "/settings/stop-words";
                return [4
                /*yield*/
                , this.httpRequest.get(url)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      };
      /**
       * Update the list of stop-words. Overwrite the old list.
       * @memberof Index
       * @method updateStopWords
       */


      Index.prototype.updateStopWords = function (stopWords) {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid + "/settings/stop-words";
                return [4
                /*yield*/
                , this.httpRequest.post(url, stopWords)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      };
      /**
       * Reset the stop-words list to be empty again
       * @memberof Index
       * @method resetStopWords
       */


      Index.prototype.resetStopWords = function () {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid + "/settings/stop-words";
                return [4
                /*yield*/
                , this.httpRequest["delete"](url)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      }; ///
      /// RANKING RULES
      ///

      /**
       * Get the list of all ranking-rules
       * @memberof Index
       * @method getRankingRules
       */


      Index.prototype.getRankingRules = function () {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid + "/settings/ranking-rules";
                return [4
                /*yield*/
                , this.httpRequest.get(url)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      };
      /**
       * Update the list of ranking-rules. Overwrite the old list.
       * @memberof Index
       * @method updateRankingRules
       */


      Index.prototype.updateRankingRules = function (rankingRules) {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid + "/settings/ranking-rules";
                return [4
                /*yield*/
                , this.httpRequest.post(url, rankingRules)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      };
      /**
       * Reset the ranking rules list to its default value
       * @memberof Index
       * @method resetRankingRules
       */


      Index.prototype.resetRankingRules = function () {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid + "/settings/ranking-rules";
                return [4
                /*yield*/
                , this.httpRequest["delete"](url)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      }; ///
      /// DISTINCT ATTRIBUTE
      ///

      /**
       * Get the distinct-attribute
       * @memberof Index
       * @method getDistinctAttribute
       */


      Index.prototype.getDistinctAttribute = function () {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid + "/settings/distinct-attribute";
                return [4
                /*yield*/
                , this.httpRequest.get(url)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      };
      /**
       * Update the distinct-attribute.
       * @memberof Index
       * @method updateDistinctAttribute
       */


      Index.prototype.updateDistinctAttribute = function (distinctAttribute) {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid + "/settings/distinct-attribute";
                return [4
                /*yield*/
                , this.httpRequest.post(url, distinctAttribute)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      };
      /**
       * Reset the distinct-attribute.
       * @memberof Index
       * @method resetDistinctAttribute
       */


      Index.prototype.resetDistinctAttribute = function () {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid + "/settings/distinct-attribute";
                return [4
                /*yield*/
                , this.httpRequest["delete"](url)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      }; ///
      /// ATTRIBUTES FOR FACETING
      ///

      /**
       * Get the attributes-for-faceting
       * @memberof Index
       * @method getAttributesForFaceting
       */


      Index.prototype.getAttributesForFaceting = function () {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid + "/settings/attributes-for-faceting";
                return [4
                /*yield*/
                , this.httpRequest.get(url)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      };
      /**
       * Update the attributes-for-faceting.
       * @memberof Index
       * @method updateAttributesForFaceting
       */


      Index.prototype.updateAttributesForFaceting = function (attributesForFaceting) {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid + "/settings/attributes-for-faceting";
                return [4
                /*yield*/
                , this.httpRequest.post(url, attributesForFaceting)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      };
      /**
       * Reset the attributes-for-faceting.
       * @memberof Index
       * @method resetAttributesForFaceting
       */


      Index.prototype.resetAttributesForFaceting = function () {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid + "/settings/attributes-for-faceting";
                return [4
                /*yield*/
                , this.httpRequest["delete"](url)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      }; ///
      /// SEARCHABLE ATTRIBUTE
      ///

      /**
       * Get the searchable-attributes
       * @memberof Index
       * @method getSearchableAttributes
       */


      Index.prototype.getSearchableAttributes = function () {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid + "/settings/searchable-attributes";
                return [4
                /*yield*/
                , this.httpRequest.get(url)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      };
      /**
       * Update the searchable-attributes.
       * @memberof Index
       * @method updateSearchableAttributes
       */


      Index.prototype.updateSearchableAttributes = function (searchableAttributes) {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid + "/settings/searchable-attributes";
                return [4
                /*yield*/
                , this.httpRequest.post(url, searchableAttributes)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      };
      /**
       * Reset the searchable-attributes.
       * @memberof Index
       * @method resetSearchableAttributes
       */


      Index.prototype.resetSearchableAttributes = function () {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid + "/settings/searchable-attributes";
                return [4
                /*yield*/
                , this.httpRequest["delete"](url)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      }; ///
      /// DISPLAYED ATTRIBUTE
      ///

      /**
       * Get the displayed-attributes
       * @memberof Index
       * @method getDisplayedAttributes
       */


      Index.prototype.getDisplayedAttributes = function () {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid + "/settings/displayed-attributes";
                return [4
                /*yield*/
                , this.httpRequest.get(url)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      };
      /**
       * Update the displayed-attributes.
       * @memberof Index
       * @method updateDisplayedAttributes
       */


      Index.prototype.updateDisplayedAttributes = function (displayedAttributes) {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid + "/settings/displayed-attributes";
                return [4
                /*yield*/
                , this.httpRequest.post(url, displayedAttributes)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      };
      /**
       * Reset the displayed-attributes.
       * @memberof Index
       * @method resetDisplayedAttributes
       */


      Index.prototype.resetDisplayedAttributes = function () {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes/" + this.uid + "/settings/displayed-attributes";
                return [4
                /*yield*/
                , this.httpRequest["delete"](url)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      };

      return Index;
    }();

    /*
     * Bundle: MeiliSearch
     * Project: MeiliSearch - Javascript API
     * Author: Quentin de Quelen <quentin@meilisearch.com>
     * Copyright: 2019, MeiliSearch
     */

    var MeiliSearch =
    /** @class */
    function () {
      function MeiliSearch(config) {
        config.host = HttpRequests.addTrailingSlash(config.host);
        this.config = config;
        this.httpRequest = new HttpRequests(config);
      }
      /**
       * Return an Index instance
       * @memberof MeiliSearch
       * @method index
       */


      MeiliSearch.prototype.index = function (indexUid) {
        return new Index(this.config, indexUid);
      };
      /**
       * Gather information about an index by calling MeiliSearch and
       * return an Index instance with the gathered information
       * @memberof MeiliSearch
       * @method getIndex
       */


      MeiliSearch.prototype.getIndex = function (indexUid) {
        return __awaiter(this, void 0, void 0, function () {
          return __generator(this, function (_a) {
            return [2
            /*return*/
            , new Index(this.config, indexUid).fetchInfo()];
          });
        });
      };
      /**
       * Get an index or create it if it does not exist
       * @memberof MeiliSearch
       * @method getOrCreateIndex
       */


      MeiliSearch.prototype.getOrCreateIndex = function (uid, options) {
        if (options === void 0) {
          options = {};
        }

        return __awaiter(this, void 0, void 0, function () {
          var index, e_1;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                _a.trys.push([0, 2,, 3]);

                return [4
                /*yield*/
                , this.getIndex(uid)];

              case 1:
                index = _a.sent();
                return [2
                /*return*/
                , index];

              case 2:
                e_1 = _a.sent();

                if (e_1.errorCode === 'index_not_found') {
                  return [2
                  /*return*/
                  , this.createIndex(uid, options)];
                }

                throw new MeiliSearchApiError(e_1, e_1.status);

              case 3:
                return [2
                /*return*/
                ];
            }
          });
        });
      };
      /**
       * List all indexes in the database
       * @memberof MeiliSearch
       * @method listIndexes
       */


      MeiliSearch.prototype.listIndexes = function () {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "indexes";
                return [4
                /*yield*/
                , this.httpRequest.get(url)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      };
      /**
       * Create a new index
       * @memberof MeiliSearch
       * @method createIndex
       */


      MeiliSearch.prototype.createIndex = function (uid, options) {
        if (options === void 0) {
          options = {};
        }

        return __awaiter(this, void 0, void 0, function () {
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                return [4
                /*yield*/
                , Index.create(this.config, uid, options)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      };
      /**
       * Update an index
       * @memberof MeiliSearch
       * @method updateIndex
       */


      MeiliSearch.prototype.updateIndex = function (uid, options) {
        if (options === void 0) {
          options = {};
        }

        return __awaiter(this, void 0, void 0, function () {
          return __generator(this, function (_a) {
            return [2
            /*return*/
            , new Index(this.config, uid).update(options)];
          });
        });
      };
      /**
       * Delete an index
       * @memberof MeiliSearch
       * @method deleteIndex
       */


      MeiliSearch.prototype.deleteIndex = function (uid) {
        return __awaiter(this, void 0, void 0, function () {
          return __generator(this, function (_a) {
            return [2
            /*return*/
            , new Index(this.config, uid)["delete"]()];
          });
        });
      };
      /**
       * Deletes an index if it already exists.
       * @memberof MeiliSearch
       * @method deleteIndexIfExists
       */


      MeiliSearch.prototype.deleteIndexIfExists = function (uid) {
        return __awaiter(this, void 0, void 0, function () {
          var e_2;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                _a.trys.push([0, 2,, 3]);

                return [4
                /*yield*/
                , this.deleteIndex(uid)];

              case 1:
                _a.sent();

                return [2
                /*return*/
                , true];

              case 2:
                e_2 = _a.sent();

                if (e_2.errorCode === 'index_not_found') {
                  return [2
                  /*return*/
                  , false];
                }

                throw e_2;

              case 3:
                return [2
                /*return*/
                ];
            }
          });
        });
      }; ///
      /// KEYS
      ///

      /**
       * Get private and public key
       * @memberof MeiliSearch
       * @method getKey
       */


      MeiliSearch.prototype.getKeys = function () {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "keys";
                return [4
                /*yield*/
                , this.httpRequest.get(url)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      }; ///
      /// HEALTH
      ///

      /**
       * Checks if the server is healthy, otherwise an error will be thrown.
       *
       * @memberof MeiliSearch
       * @method health
       */


      MeiliSearch.prototype.health = function () {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "health";
                return [4
                /*yield*/
                , this.httpRequest.get(url)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      };
      /**
       * Checks if the server is healthy, return true or false.
       *
       * @memberof MeiliSearch
       * @method isHealthy
       */


      MeiliSearch.prototype.isHealthy = function () {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                _a.trys.push([0, 2,, 3]);

                url = "health";
                return [4
                /*yield*/
                , this.httpRequest.get(url)];

              case 1:
                _a.sent();

                return [2
                /*return*/
                , true];

              case 2:
                _a.sent();
                return [2
                /*return*/
                , false];

              case 3:
                return [2
                /*return*/
                ];
            }
          });
        });
      }; ///
      /// STATS
      ///

      /**
       * Get the stats of all the database
       * @memberof MeiliSearch
       * @method stats
       */


      MeiliSearch.prototype.stats = function () {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "stats";
                return [4
                /*yield*/
                , this.httpRequest.get(url)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      }; ///
      /// VERSION
      ///

      /**
       * Get the version of MeiliSearch
       * @memberof MeiliSearch
       * @method version
       */


      MeiliSearch.prototype.version = function () {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "version";
                return [4
                /*yield*/
                , this.httpRequest.get(url)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      }; ///
      /// DUMPS
      ///

      /**
       * Triggers a dump creation process
       * @memberof MeiliSearch
       * @method createDump
       */


      MeiliSearch.prototype.createDump = function () {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "dumps";
                return [4
                /*yield*/
                , this.httpRequest.post(url)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      };
      /**
       * Get the status of a dump creation process
       * @memberof MeiliSearch
       * @method getDumpStatus
       */


      MeiliSearch.prototype.getDumpStatus = function (dumpUid) {
        return __awaiter(this, void 0, void 0, function () {
          var url;
          return __generator(this, function (_a) {
            switch (_a.label) {
              case 0:
                url = "dumps/" + dumpUid + "/status";
                return [4
                /*yield*/
                , this.httpRequest.get(url)];

              case 1:
                return [2
                /*return*/
                , _a.sent()];
            }
          });
        });
      };

      return MeiliSearch;
    }();

    exports.MeiliSearch = MeiliSearch;

    Object.defineProperty(exports, '__esModule', { value: true });

})));


/***/ }),

/***/ "./node_modules/preact/dist/preact.module.js":
/*!***************************************************!*\
  !*** ./node_modules/preact/dist/preact.module.js ***!
  \***************************************************/
/*! exports provided: render, hydrate, createElement, h, Fragment, createRef, isValidElement, Component, cloneElement, createContext, toChildArray, options */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return S; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "hydrate", function() { return q; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "createElement", function() { return v; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "h", function() { return v; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Fragment", function() { return d; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "createRef", function() { return p; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "isValidElement", function() { return i; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Component", function() { return _; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "cloneElement", function() { return B; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "createContext", function() { return D; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "toChildArray", function() { return A; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "options", function() { return l; });
var n,l,u,i,t,o,r,f,e={},c=[],s=/acit|ex(?:s|g|n|p|$)|rph|grid|ows|mnc|ntw|ine[ch]|zoo|^ord|itera/i;function a(n,l){for(var u in l)n[u]=l[u];return n}function h(n){var l=n.parentNode;l&&l.removeChild(n)}function v(l,u,i){var t,o,r,f={};for(r in u)"key"==r?t=u[r]:"ref"==r?o=u[r]:f[r]=u[r];if(arguments.length>2&&(f.children=arguments.length>3?n.call(arguments,2):i),"function"==typeof l&&null!=l.defaultProps)for(r in l.defaultProps)void 0===f[r]&&(f[r]=l.defaultProps[r]);return y(l,f,t,o,null)}function y(n,i,t,o,r){var f={type:n,props:i,key:t,ref:o,__k:null,__:null,__b:0,__e:null,__d:void 0,__c:null,__h:null,constructor:void 0,__v:null==r?++u:r};return null!=l.vnode&&l.vnode(f),f}function p(){return{current:null}}function d(n){return n.children}function _(n,l){this.props=n,this.context=l}function k(n,l){if(null==l)return n.__?k(n.__,n.__.__k.indexOf(n)+1):null;for(var u;l<n.__k.length;l++)if(null!=(u=n.__k[l])&&null!=u.__e)return u.__e;return"function"==typeof n.type?k(n):null}function b(n){var l,u;if(null!=(n=n.__)&&null!=n.__c){for(n.__e=n.__c.base=null,l=0;l<n.__k.length;l++)if(null!=(u=n.__k[l])&&null!=u.__e){n.__e=n.__c.base=u.__e;break}return b(n)}}function m(n){(!n.__d&&(n.__d=!0)&&t.push(n)&&!g.__r++||r!==l.debounceRendering)&&((r=l.debounceRendering)||o)(g)}function g(){for(var n;g.__r=t.length;)n=t.sort(function(n,l){return n.__v.__b-l.__v.__b}),t=[],n.some(function(n){var l,u,i,t,o,r;n.__d&&(o=(t=(l=n).__v).__e,(r=l.__P)&&(u=[],(i=a({},t)).__v=t.__v+1,j(r,t,i,l.__n,void 0!==r.ownerSVGElement,null!=t.__h?[o]:null,u,null==o?k(t):o,t.__h),z(u,t),t.__e!=o&&b(t)))})}function w(n,l,u,i,t,o,r,f,s,a){var h,v,p,_,b,m,g,w=i&&i.__k||c,A=w.length;for(u.__k=[],h=0;h<l.length;h++)if(null!=(_=u.__k[h]=null==(_=l[h])||"boolean"==typeof _?null:"string"==typeof _||"number"==typeof _||"bigint"==typeof _?y(null,_,null,null,_):Array.isArray(_)?y(d,{children:_},null,null,null):_.__b>0?y(_.type,_.props,_.key,null,_.__v):_)){if(_.__=u,_.__b=u.__b+1,null===(p=w[h])||p&&_.key==p.key&&_.type===p.type)w[h]=void 0;else for(v=0;v<A;v++){if((p=w[v])&&_.key==p.key&&_.type===p.type){w[v]=void 0;break}p=null}j(n,_,p=p||e,t,o,r,f,s,a),b=_.__e,(v=_.ref)&&p.ref!=v&&(g||(g=[]),p.ref&&g.push(p.ref,null,_),g.push(v,_.__c||b,_)),null!=b?(null==m&&(m=b),"function"==typeof _.type&&null!=_.__k&&_.__k===p.__k?_.__d=s=x(_,s,n):s=P(n,_,p,w,b,s),a||"option"!==u.type?"function"==typeof u.type&&(u.__d=s):n.value=""):s&&p.__e==s&&s.parentNode!=n&&(s=k(p))}for(u.__e=m,h=A;h--;)null!=w[h]&&("function"==typeof u.type&&null!=w[h].__e&&w[h].__e==u.__d&&(u.__d=k(i,h+1)),N(w[h],w[h]));if(g)for(h=0;h<g.length;h++)M(g[h],g[++h],g[++h])}function x(n,l,u){var i,t;for(i=0;i<n.__k.length;i++)(t=n.__k[i])&&(t.__=n,l="function"==typeof t.type?x(t,l,u):P(u,t,t,n.__k,t.__e,l));return l}function A(n,l){return l=l||[],null==n||"boolean"==typeof n||(Array.isArray(n)?n.some(function(n){A(n,l)}):l.push(n)),l}function P(n,l,u,i,t,o){var r,f,e;if(void 0!==l.__d)r=l.__d,l.__d=void 0;else if(null==u||t!=o||null==t.parentNode)n:if(null==o||o.parentNode!==n)n.appendChild(t),r=null;else{for(f=o,e=0;(f=f.nextSibling)&&e<i.length;e+=2)if(f==t)break n;n.insertBefore(t,o),r=o}return void 0!==r?r:t.nextSibling}function C(n,l,u,i,t){var o;for(o in u)"children"===o||"key"===o||o in l||H(n,o,null,u[o],i);for(o in l)t&&"function"!=typeof l[o]||"children"===o||"key"===o||"value"===o||"checked"===o||u[o]===l[o]||H(n,o,l[o],u[o],i)}function $(n,l,u){"-"===l[0]?n.setProperty(l,u):n[l]=null==u?"":"number"!=typeof u||s.test(l)?u:u+"px"}function H(n,l,u,i,t){var o;n:if("style"===l)if("string"==typeof u)n.style.cssText=u;else{if("string"==typeof i&&(n.style.cssText=i=""),i)for(l in i)u&&l in u||$(n.style,l,"");if(u)for(l in u)i&&u[l]===i[l]||$(n.style,l,u[l])}else if("o"===l[0]&&"n"===l[1])o=l!==(l=l.replace(/Capture$/,"")),l=l.toLowerCase()in n?l.toLowerCase().slice(2):l.slice(2),n.l||(n.l={}),n.l[l+o]=u,u?i||n.addEventListener(l,o?T:I,o):n.removeEventListener(l,o?T:I,o);else if("dangerouslySetInnerHTML"!==l){if(t)l=l.replace(/xlink[H:h]/,"h").replace(/sName$/,"s");else if("href"!==l&&"list"!==l&&"form"!==l&&"tabIndex"!==l&&"download"!==l&&l in n)try{n[l]=null==u?"":u;break n}catch(n){}"function"==typeof u||(null!=u&&(!1!==u||"a"===l[0]&&"r"===l[1])?n.setAttribute(l,u):n.removeAttribute(l))}}function I(n){this.l[n.type+!1](l.event?l.event(n):n)}function T(n){this.l[n.type+!0](l.event?l.event(n):n)}function j(n,u,i,t,o,r,f,e,c){var s,h,v,y,p,k,b,m,g,x,A,P=u.type;if(void 0!==u.constructor)return null;null!=i.__h&&(c=i.__h,e=u.__e=i.__e,u.__h=null,r=[e]),(s=l.__b)&&s(u);try{n:if("function"==typeof P){if(m=u.props,g=(s=P.contextType)&&t[s.__c],x=s?g?g.props.value:s.__:t,i.__c?b=(h=u.__c=i.__c).__=h.__E:("prototype"in P&&P.prototype.render?u.__c=h=new P(m,x):(u.__c=h=new _(m,x),h.constructor=P,h.render=O),g&&g.sub(h),h.props=m,h.state||(h.state={}),h.context=x,h.__n=t,v=h.__d=!0,h.__h=[]),null==h.__s&&(h.__s=h.state),null!=P.getDerivedStateFromProps&&(h.__s==h.state&&(h.__s=a({},h.__s)),a(h.__s,P.getDerivedStateFromProps(m,h.__s))),y=h.props,p=h.state,v)null==P.getDerivedStateFromProps&&null!=h.componentWillMount&&h.componentWillMount(),null!=h.componentDidMount&&h.__h.push(h.componentDidMount);else{if(null==P.getDerivedStateFromProps&&m!==y&&null!=h.componentWillReceiveProps&&h.componentWillReceiveProps(m,x),!h.__e&&null!=h.shouldComponentUpdate&&!1===h.shouldComponentUpdate(m,h.__s,x)||u.__v===i.__v){h.props=m,h.state=h.__s,u.__v!==i.__v&&(h.__d=!1),h.__v=u,u.__e=i.__e,u.__k=i.__k,u.__k.forEach(function(n){n&&(n.__=u)}),h.__h.length&&f.push(h);break n}null!=h.componentWillUpdate&&h.componentWillUpdate(m,h.__s,x),null!=h.componentDidUpdate&&h.__h.push(function(){h.componentDidUpdate(y,p,k)})}h.context=x,h.props=m,h.state=h.__s,(s=l.__r)&&s(u),h.__d=!1,h.__v=u,h.__P=n,s=h.render(h.props,h.state,h.context),h.state=h.__s,null!=h.getChildContext&&(t=a(a({},t),h.getChildContext())),v||null==h.getSnapshotBeforeUpdate||(k=h.getSnapshotBeforeUpdate(y,p)),A=null!=s&&s.type===d&&null==s.key?s.props.children:s,w(n,Array.isArray(A)?A:[A],u,i,t,o,r,f,e,c),h.base=u.__e,u.__h=null,h.__h.length&&f.push(h),b&&(h.__E=h.__=null),h.__e=!1}else null==r&&u.__v===i.__v?(u.__k=i.__k,u.__e=i.__e):u.__e=L(i.__e,u,i,t,o,r,f,c);(s=l.diffed)&&s(u)}catch(n){u.__v=null,(c||null!=r)&&(u.__e=e,u.__h=!!c,r[r.indexOf(e)]=null),l.__e(n,u,i)}}function z(n,u){l.__c&&l.__c(u,n),n.some(function(u){try{n=u.__h,u.__h=[],n.some(function(n){n.call(u)})}catch(n){l.__e(n,u.__v)}})}function L(l,u,i,t,o,r,f,c){var s,a,v,y=i.props,p=u.props,d=u.type,_=0;if("svg"===d&&(o=!0),null!=r)for(;_<r.length;_++)if((s=r[_])&&(s===l||(d?s.localName==d:3==s.nodeType))){l=s,r[_]=null;break}if(null==l){if(null===d)return document.createTextNode(p);l=o?document.createElementNS("http://www.w3.org/2000/svg",d):document.createElement(d,p.is&&p),r=null,c=!1}if(null===d)y===p||c&&l.data===p||(l.data=p);else{if(r=r&&n.call(l.childNodes),a=(y=i.props||e).dangerouslySetInnerHTML,v=p.dangerouslySetInnerHTML,!c){if(null!=r)for(y={},_=0;_<l.attributes.length;_++)y[l.attributes[_].name]=l.attributes[_].value;(v||a)&&(v&&(a&&v.__html==a.__html||v.__html===l.innerHTML)||(l.innerHTML=v&&v.__html||""))}if(C(l,p,y,o,c),v)u.__k=[];else if(_=u.props.children,w(l,Array.isArray(_)?_:[_],u,i,t,o&&"foreignObject"!==d,r,f,r?r[0]:i.__k&&k(i,0),c),null!=r)for(_=r.length;_--;)null!=r[_]&&h(r[_]);c||("value"in p&&void 0!==(_=p.value)&&(_!==l.value||"progress"===d&&!_)&&H(l,"value",_,y.value,!1),"checked"in p&&void 0!==(_=p.checked)&&_!==l.checked&&H(l,"checked",_,y.checked,!1))}return l}function M(n,u,i){try{"function"==typeof n?n(u):n.current=u}catch(n){l.__e(n,i)}}function N(n,u,i){var t,o;if(l.unmount&&l.unmount(n),(t=n.ref)&&(t.current&&t.current!==n.__e||M(t,null,u)),null!=(t=n.__c)){if(t.componentWillUnmount)try{t.componentWillUnmount()}catch(n){l.__e(n,u)}t.base=t.__P=null}if(t=n.__k)for(o=0;o<t.length;o++)t[o]&&N(t[o],u,"function"!=typeof n.type);i||null==n.__e||h(n.__e),n.__e=n.__d=void 0}function O(n,l,u){return this.constructor(n,u)}function S(u,i,t){var o,r,f;l.__&&l.__(u,i),r=(o="function"==typeof t)?null:t&&t.__k||i.__k,f=[],j(i,u=(!o&&t||i).__k=v(d,null,[u]),r||e,e,void 0!==i.ownerSVGElement,!o&&t?[t]:r?null:i.firstChild?n.call(i.childNodes):null,f,!o&&t?t:r?r.__e:i.firstChild,o),z(f,u)}function q(n,l){S(n,l,q)}function B(l,u,i){var t,o,r,f=a({},l.props);for(r in u)"key"==r?t=u[r]:"ref"==r?o=u[r]:f[r]=u[r];return arguments.length>2&&(f.children=arguments.length>3?n.call(arguments,2):i),y(l.type,f,t||l.key,o||l.ref,null)}function D(n,l){var u={__c:l="__cC"+f++,__:n,Consumer:function(n,l){return n.children(l)},Provider:function(n){var u,i;return this.getChildContext||(u=[],(i={})[l]=this,this.getChildContext=function(){return i},this.shouldComponentUpdate=function(n){this.props.value!==n.value&&u.some(m)},this.sub=function(n){u.push(n);var l=n.componentWillUnmount;n.componentWillUnmount=function(){u.splice(u.indexOf(n),1),l&&l.call(n)}}),n.children}};return u.Provider.__=u.Consumer.contextType=u}n=c.slice,l={__e:function(n,l){for(var u,i,t;l=l.__;)if((u=l.__c)&&!u.__)try{if((i=u.constructor)&&null!=i.getDerivedStateFromError&&(u.setState(i.getDerivedStateFromError(n)),t=u.__d),null!=u.componentDidCatch&&(u.componentDidCatch(n),t=u.__d),t)return u.__E=u}catch(l){n=l}throw n}},u=0,i=function(n){return null!=n&&void 0===n.constructor},_.prototype.setState=function(n,l){var u;u=null!=this.__s&&this.__s!==this.state?this.__s:this.__s=a({},this.state),"function"==typeof n&&(n=n(a({},u),this.props)),n&&a(u,n),null!=n&&this.__v&&(l&&this.__h.push(l),m(this))},_.prototype.forceUpdate=function(n){this.__v&&(this.__e=!0,n&&this.__h.push(n),m(this))},_.prototype.render=d,t=[],o="function"==typeof Promise?Promise.prototype.then.bind(Promise.resolve()):setTimeout,g.__r=0,f=0;
//# sourceMappingURL=preact.module.js.map


/***/ }),

/***/ "./node_modules/regenerator-runtime/runtime.js":
/*!*****************************************************!*\
  !*** ./node_modules/regenerator-runtime/runtime.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/**
 * Copyright (c) 2014-present, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

var runtime = (function (exports) {
  "use strict";

  var Op = Object.prototype;
  var hasOwn = Op.hasOwnProperty;
  var undefined; // More compressible than void 0.
  var $Symbol = typeof Symbol === "function" ? Symbol : {};
  var iteratorSymbol = $Symbol.iterator || "@@iterator";
  var asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator";
  var toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag";

  function define(obj, key, value) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
    return obj[key];
  }
  try {
    // IE 8 has a broken Object.defineProperty that only works on DOM objects.
    define({}, "");
  } catch (err) {
    define = function(obj, key, value) {
      return obj[key] = value;
    };
  }

  function wrap(innerFn, outerFn, self, tryLocsList) {
    // If outerFn provided and outerFn.prototype is a Generator, then outerFn.prototype instanceof Generator.
    var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator;
    var generator = Object.create(protoGenerator.prototype);
    var context = new Context(tryLocsList || []);

    // The ._invoke method unifies the implementations of the .next,
    // .throw, and .return methods.
    generator._invoke = makeInvokeMethod(innerFn, self, context);

    return generator;
  }
  exports.wrap = wrap;

  // Try/catch helper to minimize deoptimizations. Returns a completion
  // record like context.tryEntries[i].completion. This interface could
  // have been (and was previously) designed to take a closure to be
  // invoked without arguments, but in all the cases we care about we
  // already have an existing method we want to call, so there's no need
  // to create a new function object. We can even get away with assuming
  // the method takes exactly one argument, since that happens to be true
  // in every case, so we don't have to touch the arguments object. The
  // only additional allocation required is the completion record, which
  // has a stable shape and so hopefully should be cheap to allocate.
  function tryCatch(fn, obj, arg) {
    try {
      return { type: "normal", arg: fn.call(obj, arg) };
    } catch (err) {
      return { type: "throw", arg: err };
    }
  }

  var GenStateSuspendedStart = "suspendedStart";
  var GenStateSuspendedYield = "suspendedYield";
  var GenStateExecuting = "executing";
  var GenStateCompleted = "completed";

  // Returning this object from the innerFn has the same effect as
  // breaking out of the dispatch switch statement.
  var ContinueSentinel = {};

  // Dummy constructor functions that we use as the .constructor and
  // .constructor.prototype properties for functions that return Generator
  // objects. For full spec compliance, you may wish to configure your
  // minifier not to mangle the names of these two functions.
  function Generator() {}
  function GeneratorFunction() {}
  function GeneratorFunctionPrototype() {}

  // This is a polyfill for %IteratorPrototype% for environments that
  // don't natively support it.
  var IteratorPrototype = {};
  IteratorPrototype[iteratorSymbol] = function () {
    return this;
  };

  var getProto = Object.getPrototypeOf;
  var NativeIteratorPrototype = getProto && getProto(getProto(values([])));
  if (NativeIteratorPrototype &&
      NativeIteratorPrototype !== Op &&
      hasOwn.call(NativeIteratorPrototype, iteratorSymbol)) {
    // This environment has a native %IteratorPrototype%; use it instead
    // of the polyfill.
    IteratorPrototype = NativeIteratorPrototype;
  }

  var Gp = GeneratorFunctionPrototype.prototype =
    Generator.prototype = Object.create(IteratorPrototype);
  GeneratorFunction.prototype = Gp.constructor = GeneratorFunctionPrototype;
  GeneratorFunctionPrototype.constructor = GeneratorFunction;
  GeneratorFunction.displayName = define(
    GeneratorFunctionPrototype,
    toStringTagSymbol,
    "GeneratorFunction"
  );

  // Helper for defining the .next, .throw, and .return methods of the
  // Iterator interface in terms of a single ._invoke method.
  function defineIteratorMethods(prototype) {
    ["next", "throw", "return"].forEach(function(method) {
      define(prototype, method, function(arg) {
        return this._invoke(method, arg);
      });
    });
  }

  exports.isGeneratorFunction = function(genFun) {
    var ctor = typeof genFun === "function" && genFun.constructor;
    return ctor
      ? ctor === GeneratorFunction ||
        // For the native GeneratorFunction constructor, the best we can
        // do is to check its .name property.
        (ctor.displayName || ctor.name) === "GeneratorFunction"
      : false;
  };

  exports.mark = function(genFun) {
    if (Object.setPrototypeOf) {
      Object.setPrototypeOf(genFun, GeneratorFunctionPrototype);
    } else {
      genFun.__proto__ = GeneratorFunctionPrototype;
      define(genFun, toStringTagSymbol, "GeneratorFunction");
    }
    genFun.prototype = Object.create(Gp);
    return genFun;
  };

  // Within the body of any async function, `await x` is transformed to
  // `yield regeneratorRuntime.awrap(x)`, so that the runtime can test
  // `hasOwn.call(value, "__await")` to determine if the yielded value is
  // meant to be awaited.
  exports.awrap = function(arg) {
    return { __await: arg };
  };

  function AsyncIterator(generator, PromiseImpl) {
    function invoke(method, arg, resolve, reject) {
      var record = tryCatch(generator[method], generator, arg);
      if (record.type === "throw") {
        reject(record.arg);
      } else {
        var result = record.arg;
        var value = result.value;
        if (value &&
            typeof value === "object" &&
            hasOwn.call(value, "__await")) {
          return PromiseImpl.resolve(value.__await).then(function(value) {
            invoke("next", value, resolve, reject);
          }, function(err) {
            invoke("throw", err, resolve, reject);
          });
        }

        return PromiseImpl.resolve(value).then(function(unwrapped) {
          // When a yielded Promise is resolved, its final value becomes
          // the .value of the Promise<{value,done}> result for the
          // current iteration.
          result.value = unwrapped;
          resolve(result);
        }, function(error) {
          // If a rejected Promise was yielded, throw the rejection back
          // into the async generator function so it can be handled there.
          return invoke("throw", error, resolve, reject);
        });
      }
    }

    var previousPromise;

    function enqueue(method, arg) {
      function callInvokeWithMethodAndArg() {
        return new PromiseImpl(function(resolve, reject) {
          invoke(method, arg, resolve, reject);
        });
      }

      return previousPromise =
        // If enqueue has been called before, then we want to wait until
        // all previous Promises have been resolved before calling invoke,
        // so that results are always delivered in the correct order. If
        // enqueue has not been called before, then it is important to
        // call invoke immediately, without waiting on a callback to fire,
        // so that the async generator function has the opportunity to do
        // any necessary setup in a predictable way. This predictability
        // is why the Promise constructor synchronously invokes its
        // executor callback, and why async functions synchronously
        // execute code before the first await. Since we implement simple
        // async functions in terms of async generators, it is especially
        // important to get this right, even though it requires care.
        previousPromise ? previousPromise.then(
          callInvokeWithMethodAndArg,
          // Avoid propagating failures to Promises returned by later
          // invocations of the iterator.
          callInvokeWithMethodAndArg
        ) : callInvokeWithMethodAndArg();
    }

    // Define the unified helper method that is used to implement .next,
    // .throw, and .return (see defineIteratorMethods).
    this._invoke = enqueue;
  }

  defineIteratorMethods(AsyncIterator.prototype);
  AsyncIterator.prototype[asyncIteratorSymbol] = function () {
    return this;
  };
  exports.AsyncIterator = AsyncIterator;

  // Note that simple async functions are implemented on top of
  // AsyncIterator objects; they just return a Promise for the value of
  // the final result produced by the iterator.
  exports.async = function(innerFn, outerFn, self, tryLocsList, PromiseImpl) {
    if (PromiseImpl === void 0) PromiseImpl = Promise;

    var iter = new AsyncIterator(
      wrap(innerFn, outerFn, self, tryLocsList),
      PromiseImpl
    );

    return exports.isGeneratorFunction(outerFn)
      ? iter // If outerFn is a generator, return the full iterator.
      : iter.next().then(function(result) {
          return result.done ? result.value : iter.next();
        });
  };

  function makeInvokeMethod(innerFn, self, context) {
    var state = GenStateSuspendedStart;

    return function invoke(method, arg) {
      if (state === GenStateExecuting) {
        throw new Error("Generator is already running");
      }

      if (state === GenStateCompleted) {
        if (method === "throw") {
          throw arg;
        }

        // Be forgiving, per 25.3.3.3.3 of the spec:
        // https://people.mozilla.org/~jorendorff/es6-draft.html#sec-generatorresume
        return doneResult();
      }

      context.method = method;
      context.arg = arg;

      while (true) {
        var delegate = context.delegate;
        if (delegate) {
          var delegateResult = maybeInvokeDelegate(delegate, context);
          if (delegateResult) {
            if (delegateResult === ContinueSentinel) continue;
            return delegateResult;
          }
        }

        if (context.method === "next") {
          // Setting context._sent for legacy support of Babel's
          // function.sent implementation.
          context.sent = context._sent = context.arg;

        } else if (context.method === "throw") {
          if (state === GenStateSuspendedStart) {
            state = GenStateCompleted;
            throw context.arg;
          }

          context.dispatchException(context.arg);

        } else if (context.method === "return") {
          context.abrupt("return", context.arg);
        }

        state = GenStateExecuting;

        var record = tryCatch(innerFn, self, context);
        if (record.type === "normal") {
          // If an exception is thrown from innerFn, we leave state ===
          // GenStateExecuting and loop back for another invocation.
          state = context.done
            ? GenStateCompleted
            : GenStateSuspendedYield;

          if (record.arg === ContinueSentinel) {
            continue;
          }

          return {
            value: record.arg,
            done: context.done
          };

        } else if (record.type === "throw") {
          state = GenStateCompleted;
          // Dispatch the exception by looping back around to the
          // context.dispatchException(context.arg) call above.
          context.method = "throw";
          context.arg = record.arg;
        }
      }
    };
  }

  // Call delegate.iterator[context.method](context.arg) and handle the
  // result, either by returning a { value, done } result from the
  // delegate iterator, or by modifying context.method and context.arg,
  // setting context.delegate to null, and returning the ContinueSentinel.
  function maybeInvokeDelegate(delegate, context) {
    var method = delegate.iterator[context.method];
    if (method === undefined) {
      // A .throw or .return when the delegate iterator has no .throw
      // method always terminates the yield* loop.
      context.delegate = null;

      if (context.method === "throw") {
        // Note: ["return"] must be used for ES3 parsing compatibility.
        if (delegate.iterator["return"]) {
          // If the delegate iterator has a return method, give it a
          // chance to clean up.
          context.method = "return";
          context.arg = undefined;
          maybeInvokeDelegate(delegate, context);

          if (context.method === "throw") {
            // If maybeInvokeDelegate(context) changed context.method from
            // "return" to "throw", let that override the TypeError below.
            return ContinueSentinel;
          }
        }

        context.method = "throw";
        context.arg = new TypeError(
          "The iterator does not provide a 'throw' method");
      }

      return ContinueSentinel;
    }

    var record = tryCatch(method, delegate.iterator, context.arg);

    if (record.type === "throw") {
      context.method = "throw";
      context.arg = record.arg;
      context.delegate = null;
      return ContinueSentinel;
    }

    var info = record.arg;

    if (! info) {
      context.method = "throw";
      context.arg = new TypeError("iterator result is not an object");
      context.delegate = null;
      return ContinueSentinel;
    }

    if (info.done) {
      // Assign the result of the finished delegate to the temporary
      // variable specified by delegate.resultName (see delegateYield).
      context[delegate.resultName] = info.value;

      // Resume execution at the desired location (see delegateYield).
      context.next = delegate.nextLoc;

      // If context.method was "throw" but the delegate handled the
      // exception, let the outer generator proceed normally. If
      // context.method was "next", forget context.arg since it has been
      // "consumed" by the delegate iterator. If context.method was
      // "return", allow the original .return call to continue in the
      // outer generator.
      if (context.method !== "return") {
        context.method = "next";
        context.arg = undefined;
      }

    } else {
      // Re-yield the result returned by the delegate method.
      return info;
    }

    // The delegate iterator is finished, so forget it and continue with
    // the outer generator.
    context.delegate = null;
    return ContinueSentinel;
  }

  // Define Generator.prototype.{next,throw,return} in terms of the
  // unified ._invoke helper method.
  defineIteratorMethods(Gp);

  define(Gp, toStringTagSymbol, "Generator");

  // A Generator should always return itself as the iterator object when the
  // @@iterator function is called on it. Some browsers' implementations of the
  // iterator prototype chain incorrectly implement this, causing the Generator
  // object to not be returned from this call. This ensures that doesn't happen.
  // See https://github.com/facebook/regenerator/issues/274 for more details.
  Gp[iteratorSymbol] = function() {
    return this;
  };

  Gp.toString = function() {
    return "[object Generator]";
  };

  function pushTryEntry(locs) {
    var entry = { tryLoc: locs[0] };

    if (1 in locs) {
      entry.catchLoc = locs[1];
    }

    if (2 in locs) {
      entry.finallyLoc = locs[2];
      entry.afterLoc = locs[3];
    }

    this.tryEntries.push(entry);
  }

  function resetTryEntry(entry) {
    var record = entry.completion || {};
    record.type = "normal";
    delete record.arg;
    entry.completion = record;
  }

  function Context(tryLocsList) {
    // The root entry object (effectively a try statement without a catch
    // or a finally block) gives us a place to store values thrown from
    // locations where there is no enclosing try statement.
    this.tryEntries = [{ tryLoc: "root" }];
    tryLocsList.forEach(pushTryEntry, this);
    this.reset(true);
  }

  exports.keys = function(object) {
    var keys = [];
    for (var key in object) {
      keys.push(key);
    }
    keys.reverse();

    // Rather than returning an object with a next method, we keep
    // things simple and return the next function itself.
    return function next() {
      while (keys.length) {
        var key = keys.pop();
        if (key in object) {
          next.value = key;
          next.done = false;
          return next;
        }
      }

      // To avoid creating an additional object, we just hang the .value
      // and .done properties off the next function object itself. This
      // also ensures that the minifier will not anonymize the function.
      next.done = true;
      return next;
    };
  };

  function values(iterable) {
    if (iterable) {
      var iteratorMethod = iterable[iteratorSymbol];
      if (iteratorMethod) {
        return iteratorMethod.call(iterable);
      }

      if (typeof iterable.next === "function") {
        return iterable;
      }

      if (!isNaN(iterable.length)) {
        var i = -1, next = function next() {
          while (++i < iterable.length) {
            if (hasOwn.call(iterable, i)) {
              next.value = iterable[i];
              next.done = false;
              return next;
            }
          }

          next.value = undefined;
          next.done = true;

          return next;
        };

        return next.next = next;
      }
    }

    // Return an iterator with no values.
    return { next: doneResult };
  }
  exports.values = values;

  function doneResult() {
    return { value: undefined, done: true };
  }

  Context.prototype = {
    constructor: Context,

    reset: function(skipTempReset) {
      this.prev = 0;
      this.next = 0;
      // Resetting context._sent for legacy support of Babel's
      // function.sent implementation.
      this.sent = this._sent = undefined;
      this.done = false;
      this.delegate = null;

      this.method = "next";
      this.arg = undefined;

      this.tryEntries.forEach(resetTryEntry);

      if (!skipTempReset) {
        for (var name in this) {
          // Not sure about the optimal order of these conditions:
          if (name.charAt(0) === "t" &&
              hasOwn.call(this, name) &&
              !isNaN(+name.slice(1))) {
            this[name] = undefined;
          }
        }
      }
    },

    stop: function() {
      this.done = true;

      var rootEntry = this.tryEntries[0];
      var rootRecord = rootEntry.completion;
      if (rootRecord.type === "throw") {
        throw rootRecord.arg;
      }

      return this.rval;
    },

    dispatchException: function(exception) {
      if (this.done) {
        throw exception;
      }

      var context = this;
      function handle(loc, caught) {
        record.type = "throw";
        record.arg = exception;
        context.next = loc;

        if (caught) {
          // If the dispatched exception was caught by a catch block,
          // then let that catch block handle the exception normally.
          context.method = "next";
          context.arg = undefined;
        }

        return !! caught;
      }

      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        var record = entry.completion;

        if (entry.tryLoc === "root") {
          // Exception thrown outside of any try block that could handle
          // it, so set the completion value of the entire function to
          // throw the exception.
          return handle("end");
        }

        if (entry.tryLoc <= this.prev) {
          var hasCatch = hasOwn.call(entry, "catchLoc");
          var hasFinally = hasOwn.call(entry, "finallyLoc");

          if (hasCatch && hasFinally) {
            if (this.prev < entry.catchLoc) {
              return handle(entry.catchLoc, true);
            } else if (this.prev < entry.finallyLoc) {
              return handle(entry.finallyLoc);
            }

          } else if (hasCatch) {
            if (this.prev < entry.catchLoc) {
              return handle(entry.catchLoc, true);
            }

          } else if (hasFinally) {
            if (this.prev < entry.finallyLoc) {
              return handle(entry.finallyLoc);
            }

          } else {
            throw new Error("try statement without catch or finally");
          }
        }
      }
    },

    abrupt: function(type, arg) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.tryLoc <= this.prev &&
            hasOwn.call(entry, "finallyLoc") &&
            this.prev < entry.finallyLoc) {
          var finallyEntry = entry;
          break;
        }
      }

      if (finallyEntry &&
          (type === "break" ||
           type === "continue") &&
          finallyEntry.tryLoc <= arg &&
          arg <= finallyEntry.finallyLoc) {
        // Ignore the finally entry if control is not jumping to a
        // location outside the try/catch block.
        finallyEntry = null;
      }

      var record = finallyEntry ? finallyEntry.completion : {};
      record.type = type;
      record.arg = arg;

      if (finallyEntry) {
        this.method = "next";
        this.next = finallyEntry.finallyLoc;
        return ContinueSentinel;
      }

      return this.complete(record);
    },

    complete: function(record, afterLoc) {
      if (record.type === "throw") {
        throw record.arg;
      }

      if (record.type === "break" ||
          record.type === "continue") {
        this.next = record.arg;
      } else if (record.type === "return") {
        this.rval = this.arg = record.arg;
        this.method = "return";
        this.next = "end";
      } else if (record.type === "normal" && afterLoc) {
        this.next = afterLoc;
      }

      return ContinueSentinel;
    },

    finish: function(finallyLoc) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.finallyLoc === finallyLoc) {
          this.complete(entry.completion, entry.afterLoc);
          resetTryEntry(entry);
          return ContinueSentinel;
        }
      }
    },

    "catch": function(tryLoc) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.tryLoc === tryLoc) {
          var record = entry.completion;
          if (record.type === "throw") {
            var thrown = record.arg;
            resetTryEntry(entry);
          }
          return thrown;
        }
      }

      // The context.catch method must only be called with a location
      // argument that corresponds to a known catch block.
      throw new Error("illegal catch attempt");
    },

    delegateYield: function(iterable, resultName, nextLoc) {
      this.delegate = {
        iterator: values(iterable),
        resultName: resultName,
        nextLoc: nextLoc
      };

      if (this.method === "next") {
        // Deliberately forget the last sent value so that we don't
        // accidentally pass it on to the delegate.
        this.arg = undefined;
      }

      return ContinueSentinel;
    }
  };

  // Regardless of whether this script is executing as a CommonJS module
  // or not, return the runtime object so that we can declare the variable
  // regeneratorRuntime in the outer scope, which allows this module to be
  // injected easily by `bin/regenerator --include-runtime script.js`.
  return exports;

}(
  // If this script is executing as a CommonJS module, use module.exports
  // as the regeneratorRuntime namespace. Otherwise create a new empty
  // object. Either way, the resulting object will be used to initialize
  // the regeneratorRuntime variable at the top of this file.
   true ? module.exports : undefined
));

try {
  regeneratorRuntime = runtime;
} catch (accidentalStrictMode) {
  // This module should not be running in strict mode, so the above
  // assignment should always work unless something is misconfigured. Just
  // in case runtime.js accidentally runs in strict mode, we can escape
  // strict mode using a global Function call. This could conceivably fail
  // if a Content Security Policy forbids using Function, but in that case
  // the proper solution is to fix the accidental strict mode problem. If
  // you've misconfigured your bundler to force strict mode and applied a
  // CSP to forbid Function, and you're not willing to fix either of those
  // problems, please detail your unique predicament in a GitHub issue.
  Function("r", "regeneratorRuntime = r")(runtime);
}


/***/ }),

/***/ "./node_modules/style-loader/lib/addStyles.js":
/*!****************************************************!*\
  !*** ./node_modules/style-loader/lib/addStyles.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/*
	MIT License http://www.opensource.org/licenses/mit-license.php
	Author Tobias Koppers @sokra
*/

var stylesInDom = {};

var	memoize = function (fn) {
	var memo;

	return function () {
		if (typeof memo === "undefined") memo = fn.apply(this, arguments);
		return memo;
	};
};

var isOldIE = memoize(function () {
	// Test for IE <= 9 as proposed by Browserhacks
	// @see http://browserhacks.com/#hack-e71d8692f65334173fee715c222cb805
	// Tests for existence of standard globals is to allow style-loader
	// to operate correctly into non-standard environments
	// @see https://github.com/webpack-contrib/style-loader/issues/177
	return window && document && document.all && !window.atob;
});

var getTarget = function (target, parent) {
  if (parent){
    return parent.querySelector(target);
  }
  return document.querySelector(target);
};

var getElement = (function (fn) {
	var memo = {};

	return function(target, parent) {
                // If passing function in options, then use it for resolve "head" element.
                // Useful for Shadow Root style i.e
                // {
                //   insertInto: function () { return document.querySelector("#foo").shadowRoot }
                // }
                if (typeof target === 'function') {
                        return target();
                }
                if (typeof memo[target] === "undefined") {
			var styleTarget = getTarget.call(this, target, parent);
			// Special case to return head of iframe instead of iframe itself
			if (window.HTMLIFrameElement && styleTarget instanceof window.HTMLIFrameElement) {
				try {
					// This will throw an exception if access to iframe is blocked
					// due to cross-origin restrictions
					styleTarget = styleTarget.contentDocument.head;
				} catch(e) {
					styleTarget = null;
				}
			}
			memo[target] = styleTarget;
		}
		return memo[target]
	};
})();

var singleton = null;
var	singletonCounter = 0;
var	stylesInsertedAtTop = [];

var	fixUrls = __webpack_require__(/*! ./urls */ "./node_modules/style-loader/lib/urls.js");

module.exports = function(list, options) {
	if (typeof DEBUG !== "undefined" && DEBUG) {
		if (typeof document !== "object") throw new Error("The style-loader cannot be used in a non-browser environment");
	}

	options = options || {};

	options.attrs = typeof options.attrs === "object" ? options.attrs : {};

	// Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
	// tags it will allow on a page
	if (!options.singleton && typeof options.singleton !== "boolean") options.singleton = isOldIE();

	// By default, add <style> tags to the <head> element
        if (!options.insertInto) options.insertInto = "head";

	// By default, add <style> tags to the bottom of the target
	if (!options.insertAt) options.insertAt = "bottom";

	var styles = listToStyles(list, options);

	addStylesToDom(styles, options);

	return function update (newList) {
		var mayRemove = [];

		for (var i = 0; i < styles.length; i++) {
			var item = styles[i];
			var domStyle = stylesInDom[item.id];

			domStyle.refs--;
			mayRemove.push(domStyle);
		}

		if(newList) {
			var newStyles = listToStyles(newList, options);
			addStylesToDom(newStyles, options);
		}

		for (var i = 0; i < mayRemove.length; i++) {
			var domStyle = mayRemove[i];

			if(domStyle.refs === 0) {
				for (var j = 0; j < domStyle.parts.length; j++) domStyle.parts[j]();

				delete stylesInDom[domStyle.id];
			}
		}
	};
};

function addStylesToDom (styles, options) {
	for (var i = 0; i < styles.length; i++) {
		var item = styles[i];
		var domStyle = stylesInDom[item.id];

		if(domStyle) {
			domStyle.refs++;

			for(var j = 0; j < domStyle.parts.length; j++) {
				domStyle.parts[j](item.parts[j]);
			}

			for(; j < item.parts.length; j++) {
				domStyle.parts.push(addStyle(item.parts[j], options));
			}
		} else {
			var parts = [];

			for(var j = 0; j < item.parts.length; j++) {
				parts.push(addStyle(item.parts[j], options));
			}

			stylesInDom[item.id] = {id: item.id, refs: 1, parts: parts};
		}
	}
}

function listToStyles (list, options) {
	var styles = [];
	var newStyles = {};

	for (var i = 0; i < list.length; i++) {
		var item = list[i];
		var id = options.base ? item[0] + options.base : item[0];
		var css = item[1];
		var media = item[2];
		var sourceMap = item[3];
		var part = {css: css, media: media, sourceMap: sourceMap};

		if(!newStyles[id]) styles.push(newStyles[id] = {id: id, parts: [part]});
		else newStyles[id].parts.push(part);
	}

	return styles;
}

function insertStyleElement (options, style) {
	var target = getElement(options.insertInto)

	if (!target) {
		throw new Error("Couldn't find a style target. This probably means that the value for the 'insertInto' parameter is invalid.");
	}

	var lastStyleElementInsertedAtTop = stylesInsertedAtTop[stylesInsertedAtTop.length - 1];

	if (options.insertAt === "top") {
		if (!lastStyleElementInsertedAtTop) {
			target.insertBefore(style, target.firstChild);
		} else if (lastStyleElementInsertedAtTop.nextSibling) {
			target.insertBefore(style, lastStyleElementInsertedAtTop.nextSibling);
		} else {
			target.appendChild(style);
		}
		stylesInsertedAtTop.push(style);
	} else if (options.insertAt === "bottom") {
		target.appendChild(style);
	} else if (typeof options.insertAt === "object" && options.insertAt.before) {
		var nextSibling = getElement(options.insertAt.before, target);
		target.insertBefore(style, nextSibling);
	} else {
		throw new Error("[Style Loader]\n\n Invalid value for parameter 'insertAt' ('options.insertAt') found.\n Must be 'top', 'bottom', or Object.\n (https://github.com/webpack-contrib/style-loader#insertat)\n");
	}
}

function removeStyleElement (style) {
	if (style.parentNode === null) return false;
	style.parentNode.removeChild(style);

	var idx = stylesInsertedAtTop.indexOf(style);
	if(idx >= 0) {
		stylesInsertedAtTop.splice(idx, 1);
	}
}

function createStyleElement (options) {
	var style = document.createElement("style");

	if(options.attrs.type === undefined) {
		options.attrs.type = "text/css";
	}

	if(options.attrs.nonce === undefined) {
		var nonce = getNonce();
		if (nonce) {
			options.attrs.nonce = nonce;
		}
	}

	addAttrs(style, options.attrs);
	insertStyleElement(options, style);

	return style;
}

function createLinkElement (options) {
	var link = document.createElement("link");

	if(options.attrs.type === undefined) {
		options.attrs.type = "text/css";
	}
	options.attrs.rel = "stylesheet";

	addAttrs(link, options.attrs);
	insertStyleElement(options, link);

	return link;
}

function addAttrs (el, attrs) {
	Object.keys(attrs).forEach(function (key) {
		el.setAttribute(key, attrs[key]);
	});
}

function getNonce() {
	if (false) {}

	return __webpack_require__.nc;
}

function addStyle (obj, options) {
	var style, update, remove, result;

	// If a transform function was defined, run it on the css
	if (options.transform && obj.css) {
	    result = typeof options.transform === 'function'
		 ? options.transform(obj.css) 
		 : options.transform.default(obj.css);

	    if (result) {
	    	// If transform returns a value, use that instead of the original css.
	    	// This allows running runtime transformations on the css.
	    	obj.css = result;
	    } else {
	    	// If the transform function returns a falsy value, don't add this css.
	    	// This allows conditional loading of css
	    	return function() {
	    		// noop
	    	};
	    }
	}

	if (options.singleton) {
		var styleIndex = singletonCounter++;

		style = singleton || (singleton = createStyleElement(options));

		update = applyToSingletonTag.bind(null, style, styleIndex, false);
		remove = applyToSingletonTag.bind(null, style, styleIndex, true);

	} else if (
		obj.sourceMap &&
		typeof URL === "function" &&
		typeof URL.createObjectURL === "function" &&
		typeof URL.revokeObjectURL === "function" &&
		typeof Blob === "function" &&
		typeof btoa === "function"
	) {
		style = createLinkElement(options);
		update = updateLink.bind(null, style, options);
		remove = function () {
			removeStyleElement(style);

			if(style.href) URL.revokeObjectURL(style.href);
		};
	} else {
		style = createStyleElement(options);
		update = applyToTag.bind(null, style);
		remove = function () {
			removeStyleElement(style);
		};
	}

	update(obj);

	return function updateStyle (newObj) {
		if (newObj) {
			if (
				newObj.css === obj.css &&
				newObj.media === obj.media &&
				newObj.sourceMap === obj.sourceMap
			) {
				return;
			}

			update(obj = newObj);
		} else {
			remove();
		}
	};
}

var replaceText = (function () {
	var textStore = [];

	return function (index, replacement) {
		textStore[index] = replacement;

		return textStore.filter(Boolean).join('\n');
	};
})();

function applyToSingletonTag (style, index, remove, obj) {
	var css = remove ? "" : obj.css;

	if (style.styleSheet) {
		style.styleSheet.cssText = replaceText(index, css);
	} else {
		var cssNode = document.createTextNode(css);
		var childNodes = style.childNodes;

		if (childNodes[index]) style.removeChild(childNodes[index]);

		if (childNodes.length) {
			style.insertBefore(cssNode, childNodes[index]);
		} else {
			style.appendChild(cssNode);
		}
	}
}

function applyToTag (style, obj) {
	var css = obj.css;
	var media = obj.media;

	if(media) {
		style.setAttribute("media", media)
	}

	if(style.styleSheet) {
		style.styleSheet.cssText = css;
	} else {
		while(style.firstChild) {
			style.removeChild(style.firstChild);
		}

		style.appendChild(document.createTextNode(css));
	}
}

function updateLink (link, options, obj) {
	var css = obj.css;
	var sourceMap = obj.sourceMap;

	/*
		If convertToAbsoluteUrls isn't defined, but sourcemaps are enabled
		and there is no publicPath defined then lets turn convertToAbsoluteUrls
		on by default.  Otherwise default to the convertToAbsoluteUrls option
		directly
	*/
	var autoFixUrls = options.convertToAbsoluteUrls === undefined && sourceMap;

	if (options.convertToAbsoluteUrls || autoFixUrls) {
		css = fixUrls(css);
	}

	if (sourceMap) {
		// http://stackoverflow.com/a/26603875
		css += "\n/*# sourceMappingURL=data:application/json;base64," + btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))) + " */";
	}

	var blob = new Blob([css], { type: "text/css" });

	var oldSrc = link.href;

	link.href = URL.createObjectURL(blob);

	if(oldSrc) URL.revokeObjectURL(oldSrc);
}


/***/ }),

/***/ "./node_modules/style-loader/lib/urls.js":
/*!***********************************************!*\
  !*** ./node_modules/style-loader/lib/urls.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports) {


/**
 * When source maps are enabled, `style-loader` uses a link element with a data-uri to
 * embed the css on the page. This breaks all relative urls because now they are relative to a
 * bundle instead of the current page.
 *
 * One solution is to only use full urls, but that may be impossible.
 *
 * Instead, this function "fixes" the relative urls to be absolute according to the current page location.
 *
 * A rudimentary test suite is located at `test/fixUrls.js` and can be run via the `npm test` command.
 *
 */

module.exports = function (css) {
  // get current location
  var location = typeof window !== "undefined" && window.location;

  if (!location) {
    throw new Error("fixUrls requires window.location");
  }

	// blank or null?
	if (!css || typeof css !== "string") {
	  return css;
  }

  var baseUrl = location.protocol + "//" + location.host;
  var currentDir = baseUrl + location.pathname.replace(/\/[^\/]*$/, "/");

	// convert each url(...)
	/*
	This regular expression is just a way to recursively match brackets within
	a string.

	 /url\s*\(  = Match on the word "url" with any whitespace after it and then a parens
	   (  = Start a capturing group
	     (?:  = Start a non-capturing group
	         [^)(]  = Match anything that isn't a parentheses
	         |  = OR
	         \(  = Match a start parentheses
	             (?:  = Start another non-capturing groups
	                 [^)(]+  = Match anything that isn't a parentheses
	                 |  = OR
	                 \(  = Match a start parentheses
	                     [^)(]*  = Match anything that isn't a parentheses
	                 \)  = Match a end parentheses
	             )  = End Group
              *\) = Match anything and then a close parens
          )  = Close non-capturing group
          *  = Match anything
       )  = Close capturing group
	 \)  = Match a close parens

	 /gi  = Get all matches, not the first.  Be case insensitive.
	 */
	var fixedCss = css.replace(/url\s*\(((?:[^)(]|\((?:[^)(]+|\([^)(]*\))*\))*)\)/gi, function(fullMatch, origUrl) {
		// strip quotes (if they exist)
		var unquotedOrigUrl = origUrl
			.trim()
			.replace(/^"(.*)"$/, function(o, $1){ return $1; })
			.replace(/^'(.*)'$/, function(o, $1){ return $1; });

		// already a full url? no change
		if (/^(#|data:|http:\/\/|https:\/\/|file:\/\/\/|\s*$)/i.test(unquotedOrigUrl)) {
		  return fullMatch;
		}

		// convert the url to a full url
		var newUrl;

		if (unquotedOrigUrl.indexOf("//") === 0) {
		  	//TODO: should we add protocol?
			newUrl = unquotedOrigUrl;
		} else if (unquotedOrigUrl.indexOf("/") === 0) {
			// path should be relative to the base url
			newUrl = baseUrl + unquotedOrigUrl; // already starts with '/'
		} else {
			// path should be relative to current directory
			newUrl = currentDir + unquotedOrigUrl.replace(/^\.\//, ""); // Strip leading './'
		}

		// send back the fixed url(...)
		return "url(" + JSON.stringify(newUrl) + ")";
	});

	// send back the fixed css
	return fixedCss;
};


/***/ }),

/***/ "./resources/js/search/search.js":
/*!***************************************!*\
  !*** ./resources/js/search/search.js ***!
  \***************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _algolia_autocomplete_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @algolia/autocomplete-js */ "./node_modules/@algolia/autocomplete-js/dist/esm/index.js");
/* harmony import */ var _algolia_autocomplete_theme_classic__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @algolia/autocomplete-theme-classic */ "./node_modules/@algolia/autocomplete-theme-classic/dist/theme.css");
/* harmony import */ var _algolia_autocomplete_theme_classic__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_algolia_autocomplete_theme_classic__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var meilisearch__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! meilisearch */ "./node_modules/meilisearch/dist/bundles/meilisearch.umd.js");
/* harmony import */ var meilisearch__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(meilisearch__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var htm_preact__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! htm/preact */ "./node_modules/htm/preact/index.module.js");


function _templateObject3() {
  var data = _taggedTemplateLiteral(["<!--<div className=\"aa-ItemWrapper\"><div className=\"aa-ItemContent\"><div className=\"aa-ItemIcon aa-ItemIcon&#45;&#45;alignTop\"><img src=", " alt=", " width=\"40\" height=\"40\" /></div><div className=\"aa-ItemContentBody\"><div className=\"aa-ItemContentTitle\">", "</div></div></div><div className=\"aa-ItemActions\"><buttonclassName=\"aa-ItemActionButton aa-DesktopOnly aa-ActiveOnly\"type=\"button\"title=\"Select\"style={{ pointerEvents: 'none' }}><svg viewBox=\"0 0 24 24\" width=\"20\" height=\"20\" fill=\"currentColor\"><path d=\"M18.984 6.984h2.016v6h-15.188l3.609 3.609-1.406 1.406-6-6 6-6 1.406 1.406-3.609 3.609h13.172v-4.031z\" /></svg></button></div></div>-->"]);

  _templateObject3 = function _templateObject3() {
    return data;
  };

  return data;
}

function _templateObject2() {
  var data = _taggedTemplateLiteral(["<div className=\"aa-ItemWrapper\">", "</div>"]);

  _templateObject2 = function _templateObject2() {
    return data;
  };

  return data;
}

function _templateObject() {
  var data = _taggedTemplateLiteral(["<span className=\"aa-SourceHeaderTitle\">Movies</span><div className=\"aa-SourceHeaderLine\" />"]);

  _templateObject = function _templateObject() {
    return data;
  };

  return data;
}

function _taggedTemplateLiteral(strings, raw) { if (!raw) { raw = strings.slice(0); } return Object.freeze(Object.defineProperties(strings, { raw: { value: Object.freeze(raw) } })); }

function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }





var client = new meilisearch__WEBPACK_IMPORTED_MODULE_3__["MeiliSearch"]({
  host: 'http://127.0.0.1:7700'
});
var searchIndex = client.index('movies');
Object(_algolia_autocomplete_js__WEBPACK_IMPORTED_MODULE_1__["autocomplete"])({
  container: '#autocomplete',
  placeholder: 'Search for products',
  getSources: function getSources(_ref) {
    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee2() {
      var query;
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee2$(_context2) {
        while (1) {
          switch (_context2.prev = _context2.next) {
            case 0:
              query = _ref.query;
              return _context2.abrupt("return", [{
                sourceId: 'links',
                getItems: function getItems(_ref2) {
                  return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
                    var query, a;
                    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
                      while (1) {
                        switch (_context.prev = _context.next) {
                          case 0:
                            query = _ref2.query;
                            _context.next = 3;
                            return searchIndex.search(query);

                          case 3:
                            a = _context.sent;
                            console.log(a);
                            return _context.abrupt("return", a.hits);

                          case 6:
                          case "end":
                            return _context.stop();
                        }
                      }
                    }, _callee);
                  }))();
                },
                getItemUrl: function getItemUrl(_ref3) {
                  var item = _ref3.item;
                  return item.poster;
                },
                templates: {
                  header: function header() {
                    return Object(htm_preact__WEBPACK_IMPORTED_MODULE_4__["html"])(_templateObject());
                  },
                  item: function item(_ref4) {
                    var item = _ref4.item;
                    return AutocompleteProductItem({
                      hit: item
                    }); //item.title;
                  },
                  noResults: function noResults() {
                    return 'No products for this query.';
                  }
                }
              }]);

            case 2:
            case "end":
              return _context2.stop();
          }
        }
      }, _callee2);
    }))();
  }
});

function AutocompleteProductItem(_ref5) {
  var hit = _ref5.hit;
  console.log(hit);
  return Object(htm_preact__WEBPACK_IMPORTED_MODULE_4__["html"])(_templateObject2(), hit.title);
  return Object(htm_preact__WEBPACK_IMPORTED_MODULE_4__["html"])(_templateObject3(), hit.poster, hit.title, hit.title);
}

/***/ }),

/***/ 3:
/*!*********************************************!*\
  !*** multi ./resources/js/search/search.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\Users\molbal\Documents\JetBrains\abyss-tracker\resources\js\search\search.js */"./resources/js/search/search.js");


/***/ })

/******/ });
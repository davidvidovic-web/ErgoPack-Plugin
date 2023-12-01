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
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/js/index.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/@babel/runtime/helpers/assertThisInitialized.js":
/*!**********************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/assertThisInitialized.js ***!
  \**********************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _assertThisInitialized(self) {
  if (self === void 0) {
    throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
  }

  return self;
}

module.exports = _assertThisInitialized;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/classCallCheck.js":
/*!***************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/classCallCheck.js ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _classCallCheck(instance, Constructor) {
  if (!(instance instanceof Constructor)) {
    throw new TypeError("Cannot call a class as a function");
  }
}

module.exports = _classCallCheck;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/createClass.js":
/*!************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/createClass.js ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _defineProperties(target, props) {
  for (var i = 0; i < props.length; i++) {
    var descriptor = props[i];
    descriptor.enumerable = descriptor.enumerable || false;
    descriptor.configurable = true;
    if ("value" in descriptor) descriptor.writable = true;
    Object.defineProperty(target, descriptor.key, descriptor);
  }
}

function _createClass(Constructor, protoProps, staticProps) {
  if (protoProps) _defineProperties(Constructor.prototype, protoProps);
  if (staticProps) _defineProperties(Constructor, staticProps);
  return Constructor;
}

module.exports = _createClass;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/getPrototypeOf.js":
/*!***************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/getPrototypeOf.js ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _getPrototypeOf(o) {
  module.exports = _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) {
    return o.__proto__ || Object.getPrototypeOf(o);
  };
  return _getPrototypeOf(o);
}

module.exports = _getPrototypeOf;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/inherits.js":
/*!*********************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/inherits.js ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var setPrototypeOf = __webpack_require__(/*! ./setPrototypeOf */ "./node_modules/@babel/runtime/helpers/setPrototypeOf.js");

function _inherits(subClass, superClass) {
  if (typeof superClass !== "function" && superClass !== null) {
    throw new TypeError("Super expression must either be null or a function");
  }

  subClass.prototype = Object.create(superClass && superClass.prototype, {
    constructor: {
      value: subClass,
      writable: true,
      configurable: true
    }
  });
  if (superClass) setPrototypeOf(subClass, superClass);
}

module.exports = _inherits;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/possibleConstructorReturn.js":
/*!**************************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/possibleConstructorReturn.js ***!
  \**************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var _typeof = __webpack_require__(/*! @babel/runtime/helpers/typeof */ "./node_modules/@babel/runtime/helpers/typeof.js");

var assertThisInitialized = __webpack_require__(/*! ./assertThisInitialized */ "./node_modules/@babel/runtime/helpers/assertThisInitialized.js");

function _possibleConstructorReturn(self, call) {
  if (call && (_typeof(call) === "object" || typeof call === "function")) {
    return call;
  }

  return assertThisInitialized(self);
}

module.exports = _possibleConstructorReturn;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/setPrototypeOf.js":
/*!***************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/setPrototypeOf.js ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _setPrototypeOf(o, p) {
  module.exports = _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) {
    o.__proto__ = p;
    return o;
  };

  return _setPrototypeOf(o, p);
}

module.exports = _setPrototypeOf;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/typeof.js":
/*!*******************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/typeof.js ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _typeof(obj) {
  "@babel/helpers - typeof";

  if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") {
    module.exports = _typeof = function _typeof(obj) {
      return typeof obj;
    };
  } else {
    module.exports = _typeof = function _typeof(obj) {
      return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
    };
  }

  return _typeof(obj);
}

module.exports = _typeof;

/***/ }),

/***/ "./src/js/App.js":
/*!***********************!*\
  !*** ./src/js/App.js ***!
  \***********************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/classCallCheck */ "./node_modules/@babel/runtime/helpers/classCallCheck.js");
/* harmony import */ var _babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/helpers/createClass */ "./node_modules/@babel/runtime/helpers/createClass.js");
/* harmony import */ var _babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_1__);



/**
 * App
 */
var App = /*#__PURE__*/function () {
  function App() {
    _babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default()(this, App);
  }

  _babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_1___default()(App, [{
    key: "loaderStart",
    value: function loaderStart() {}
  }, {
    key: "loaderEnd",
    value: function loaderEnd() {}
    /**
     * Refresh CodyHouse components
     */

  }, {
    key: "refreshCodyhouseComponenets",
    value: function refreshCodyhouseComponenets() {
      // Accordion
      if (typeof Accordion == 'function') {
        var accordions = document.getElementsByClassName('js-accordion');

        if (accordions.length > 0) {
          for (var i = 0; i < accordions.length; i++) {
            (function (i) {
              new Accordion(accordions[i]);
            })(i);
          }
        }
      } // Tabs


      if (typeof Tab == 'function') {
        var tabs = document.getElementsByClassName('js-tabs');

        if (tabs.length > 0) {
          for (var i = 0; i < tabs.length; i++) {
            (function (i) {
              new Tab(tabs[i]);
            })(i);
          }
        }
      } // Modal


      if (typeof Modal == 'function') {
        var modals = document.getElementsByClassName('js-modal'); // generic focusable elements string selector

        var focusableElString = '[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, [tabindex]:not([tabindex="-1"]), [contenteditable], audio[controls], video[controls], summary';

        if (modals.length > 0) {
          var modalArrays = [];

          for (var i = 0; i < modals.length; i++) {
            (function (i) {
              modalArrays.push(new Modal(modals[i]));
            })(i);
          }

          window.addEventListener('keydown', function (event) {
            //close modal window on esc
            if (event.keyCode && event.keyCode == 27 || event.key && event.key.toLowerCase() == 'escape') {
              for (var i = 0; i < modalArrays.length; i++) {
                (function (i) {
                  modalArrays[i].closeModal();
                })(i);
              }

              ;
            }
          });
        }
      }
    }
    /**
     * AJAX request
     *
     * @param url
     * @param data
     * @param success
     */

  }, {
    key: "ajax",
    value: function ajax(url, data, success) {
      var request = new XMLHttpRequest();
      request.open('POST', url, true);
      request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

      request.onload = function () {
        if (this.status >= 200 && this.status < 400) {
          success(this.response);
        }
      };

      request.onerror = function () {};

      request.send(data);
    }
    /**
     * AJAX request
     *
     * @param url
     * @param data
     * @param success
     */

  }, {
    key: "ajaxJson",
    value: function ajaxJson(url, data, success) {
      var request = new XMLHttpRequest();
      request.open('POST', url, true);
      request.setRequestHeader('Content-Type', 'application/json');

      request.onload = function () {
        if (this.status >= 200 && this.status < 400) {
          success(this.response);
        }
      };

      request.onerror = function () {};

      request.send(data);
    }
    /**
     * Ready (similar to jQuery .ready)
     *
     * @param fn
     */

  }, {
    key: "ready",
    value: function ready(fn) {
      if (document.readyState != 'loading') {
        fn();
      } else {
        document.addEventListener('DOMContentLoaded', fn);
      }
    }
  }]);

  return App;
}();

/* harmony default export */ __webpack_exports__["default"] = (App);

/***/ }),

/***/ "./src/js/Configurator.js":
/*!********************************!*\
  !*** ./src/js/Configurator.js ***!
  \********************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/classCallCheck */ "./node_modules/@babel/runtime/helpers/classCallCheck.js");
/* harmony import */ var _babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/helpers/createClass */ "./node_modules/@babel/runtime/helpers/createClass.js");
/* harmony import */ var _babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_helpers_inherits__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime/helpers/inherits */ "./node_modules/@babel/runtime/helpers/inherits.js");
/* harmony import */ var _babel_runtime_helpers_inherits__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_inherits__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _babel_runtime_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @babel/runtime/helpers/possibleConstructorReturn */ "./node_modules/@babel/runtime/helpers/possibleConstructorReturn.js");
/* harmony import */ var _babel_runtime_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @babel/runtime/helpers/getPrototypeOf */ "./node_modules/@babel/runtime/helpers/getPrototypeOf.js");
/* harmony import */ var _babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _App__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./App */ "./src/js/App.js");






function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_4___default()(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_4___default()(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _babel_runtime_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_3___default()(this, result); }; }

function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Date.prototype.toString.call(Reflect.construct(Date, [], function () {})); return true; } catch (e) { return false; } }


/**
 * Class Configurator
 */

var Configurator = /*#__PURE__*/function (_App) {
  _babel_runtime_helpers_inherits__WEBPACK_IMPORTED_MODULE_2___default()(Configurator, _App);

  var _super = _createSuper(Configurator);

  /**
   * Constructor
   */
  function Configurator() {
    var _this;

    _babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default()(this, Configurator);

    _this = _super.call(this);
    _this.radioLastState = {};
    _this.confForm = document.getElementById('eppConfForm');
    _this.confSubmit = document.getElementById('eppConfSubmit');
    _this.modelWrapper = document.getElementById('eppProductModel');
    _this.feedbackWrapper = document.getElementById('eppProductFeedback');
    _this.feedbackError = document.getElementById('eppProductError');
    _this.feedbackLoader = document.getElementById('eppFeedbackLoader');
    return _this;
  }

  _babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_1___default()(Configurator, [{
    key: "loaderStart",
    value: function loaderStart() {
      this.feedbackWrapper.classList.add('loading');
      this.feedbackLoader.setAttribute("aria-hidden", 'false');
    }
  }, {
    key: "loaderEnd",
    value: function loaderEnd() {
      this.feedbackWrapper.classList.remove('loading');
      this.feedbackLoader.setAttribute("aria-hidden", 'true');
    }
    /**
     * Load attributes via AJAX
     *
     * @param pid
     */

  }, {
    key: "attributesLoad",
    value: function attributesLoad(pid) {
      var t = this;
      var data = [];
      data.push('action=epp_load_attributes');
      data.push('pid=' + pid);
      t.loaderStart();
      t.ajax(epp.ajax_url, data.join('&'), function (response) {
        t.feedbackWrapper.innerHTML = response;
        t.feedbackError.classList.add('is-hidden');
        t.loaderEnd();
        t.refreshCodyhouseComponenets();
        t.attributesEvents();
      });
    }
    /**
     * Add attribute events
     */

  }, {
    key: "attributesEvents",
    value: function attributesEvents() {
      var t = this; // parents

      document.querySelectorAll('.epp-conf-choice').forEach(function (parent) {
        parent.addEventListener('click', function () {
          // has children
          if (parent.classList.contains('epp-conf-has-children')) {
            var tid = parent.getAttribute('data-tid');
            document.querySelectorAll('.epp-conf-child-' + tid).forEach(function (child) {
              var label = child.nextElementSibling;

              if (parent.checked) {
                label.classList.remove('is-hidden');
              } else {
                label.classList.add('is-hidden');
                child.checked = 0;
              }
            }); // no children
          } else {
            // allow to check/uncheck radio
            if ('radio' === parent.type) {
              if (parent.checked && t.radioLastState.hasOwnProperty(parent.name) && t.radioLastState[parent.name] == parent.value) {
                parent.checked = 0;
                t.radioLastState[parent.name] = null;
              } else {
                t.radioLastState[parent.name] = parent.value;
              }
            }
          }
        });
      });
    }
    /**
     *
     * @param e
     */

  }, {
    key: "submitForm",
    value: function submitForm() {
      var t = this;
      var params = [].filter.call(t.confForm.elements, function (el) {
        return el.type == 'hidden' || el.checked;
      }).filter(function (el) {
        return !!el.name;
      }).filter(function (el) {
        return !el.disabled;
      }).map(function (el) {
        return encodeURIComponent(el.name) + '=' + encodeURIComponent(el.value);
      }).join('&');
      t.loaderStart();
      t.ajax(epp.ajax_url, params, function (response) {
        var json = JSON.parse(response);

        if (json.status == 'success') {
          var html = json.message + '<br>' + json.order_preview_link; // display response

          t.feedbackWrapper.innerHTML = html; // hide elements

          t.modelWrapper.classList.add('is-hidden');
          t.confSubmit.classList.add('is-hidden');
          t.feedbackError.classList.add('is-hidden');
        } else {
          console.log(t.feedbackError);
          t.feedbackError.innerHTML = json.message;
          t.feedbackError.classList.remove('is-hidden');
        }

        t.loaderEnd(); //t.refreshCodyhouseComponenets();

        t.attributesEvents();
      });
    }
    /**
     * Run
     */

  }, {
    key: "run",
    value: function run() {
      var t = this;
      t.ready(function () {
        document.querySelectorAll('input[name=epp_conf_model]').forEach(function (item) {
          item.addEventListener('change', function (e) {
            t.attributesLoad(e.target.value);
          });
        });

        if (t.confSubmit) {
          t.confSubmit.addEventListener('click', function (e) {
            e.preventDefault();
            t.submitForm(e.target);
          });
        }
      });
    }
  }]);

  return Configurator;
}(_App__WEBPACK_IMPORTED_MODULE_5__["default"]);

/* harmony default export */ __webpack_exports__["default"] = (Configurator);

/***/ }),

/***/ "./src/js/index.js":
/*!*************************!*\
  !*** ./src/js/index.js ***!
  \*************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _woocommerce_Checkout__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./woocommerce/Checkout */ "./src/js/woocommerce/Checkout.js");
/* harmony import */ var _Configurator__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Configurator */ "./src/js/Configurator.js");


var appWooCheckout = new _woocommerce_Checkout__WEBPACK_IMPORTED_MODULE_0__["default"]();
appWooCheckout.run();

/***/ }),

/***/ "./src/js/woocommerce/Checkout.js":
/*!****************************************!*\
  !*** ./src/js/woocommerce/Checkout.js ***!
  \****************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/classCallCheck */ "./node_modules/@babel/runtime/helpers/classCallCheck.js");
/* harmony import */ var _babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/helpers/createClass */ "./node_modules/@babel/runtime/helpers/createClass.js");
/* harmony import */ var _babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_helpers_inherits__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime/helpers/inherits */ "./node_modules/@babel/runtime/helpers/inherits.js");
/* harmony import */ var _babel_runtime_helpers_inherits__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_inherits__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _babel_runtime_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @babel/runtime/helpers/possibleConstructorReturn */ "./node_modules/@babel/runtime/helpers/possibleConstructorReturn.js");
/* harmony import */ var _babel_runtime_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @babel/runtime/helpers/getPrototypeOf */ "./node_modules/@babel/runtime/helpers/getPrototypeOf.js");
/* harmony import */ var _babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _App__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./../App */ "./src/js/App.js");






function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_4___default()(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_4___default()(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _babel_runtime_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_3___default()(this, result); }; }

function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Date.prototype.toString.call(Reflect.construct(Date, [], function () {})); return true; } catch (e) { return false; } }


/**
 * Class Checkout
 */

var Checkout = /*#__PURE__*/function (_App) {
  _babel_runtime_helpers_inherits__WEBPACK_IMPORTED_MODULE_2___default()(Checkout, _App);

  var _super = _createSuper(Checkout);

  /**
   * Constructor
   */
  function Checkout() {
    var _this;

    _babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default()(this, Checkout);

    _this = _super.call(this);
    _this.customerSelect = document.getElementById('eppCustomerSelect');
    _this.customerSelectWrapper = document.getElementById('eppCustomerSelectWrapper');
    _this.customerDetailsWrapper = document.getElementById('customer_details');
    _this.billing_shipping_names = ['billing_first_name', 'billing_last_name', 'billing_company', 'billing_address_1', 'billing_address_2', 'billing_postcode', 'billing_city', 'billing_country', 'billing_phone', 'billing_email', 'shipping_first_name', 'shipping_last_name', 'shipping_company', 'shipping_address_1', 'shipping_address_2', 'shipping_postcode', 'shipping_city', 'shipping_country', 'epp_customer_title', 'epp_customer_salutation'];
    _this.billing_shipping = {
      'billing_first_name': document.getElementById('billing_first_name'),
      'billing_last_name': document.getElementById('billing_last_name'),
      'billing_company': document.getElementById('billing_company'),
      'billing_address_1': document.getElementById('billing_address_1'),
      'billing_address_2': document.getElementById('billing_address_2'),
      'billing_postcode': document.getElementById('billing_postcode'),
      'billing_city': document.getElementById('billing_city'),
      'billing_country': document.getElementById('billing_country'),
      'billing_phone': document.getElementById('billing_phone'),
      'billing_email': document.getElementById('billing_email'),
      'shipping_first_name': document.getElementById('shipping_first_name'),
      'shipping_last_name': document.getElementById('shipping_last_name'),
      'shipping_company': document.getElementById('shipping_company'),
      'shipping_address_1': document.getElementById('shipping_address_1'),
      'shipping_address_2': document.getElementById('shipping_address_2'),
      'shipping_postcode': document.getElementById('shipping_postcode'),
      'shipping_city': document.getElementById('shipping_city'),
      'shipping_country': document.getElementById('shipping_country'),
      'epp_customer_title': document.getElementById('epp_customer_title'),
      'epp_customer_salutation': document.getElementById('epp_customer_salutation')
    };
    return _this;
  }

  _babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_1___default()(Checkout, [{
    key: "loaderStart",
    value: function loaderStart() {
      this.customerSelectWrapper.classList.add('loading');
      this.customerSelectWrapper.setAttribute("aria-hidden", 'false');
    }
  }, {
    key: "loaderEnd",
    value: function loaderEnd() {
      this.customerSelectWrapper.classList.remove('loading');
      this.customerSelectWrapper.setAttribute("aria-hidden", 'true');
    }
  }, {
    key: "cleanUpForm",
    value: function cleanUpForm() {
      for (var idx in this.billing_shipping_names) {
        if (this.billing_shipping[this.billing_shipping_names[idx]]) {
          this.billing_shipping[this.billing_shipping_names[idx]].value = null;
        }
      }
    }
  }, {
    key: "fillBillingShippingFields",
    value: function fillBillingShippingFields(data) {
      for (var idx in this.billing_shipping_names) {
        if (this.billing_shipping[this.billing_shipping_names[idx]] && data[this.billing_shipping_names[idx]]) {
          if (this.billing_shipping_names[idx] === 'title' || this.billing_shipping_names[idx] === 'salutation') {
            var el = document.querySelector('#' + this.billing_shipping_names[idx] + ' [value="' + data[this.billing_shipping_names[idx]] + '"]');
            if (el) el.selected = true;
          } else {
            this.billing_shipping[this.billing_shipping_names[idx]].value = data[this.billing_shipping_names[idx]];
          }
        }
      }
    }
  }, {
    key: "loadCustomerData",
    value: function loadCustomerData(cid) {
      var t = this;
      var data = [];
      data.push('action=epp_load_customer_data');
      data.push('cid=' + cid);
      data.push('nonce=' + epp.nonce);
      var $form = jQuery('form[name=checkout]');
      $form.addClass('processing').block({
        message: null,
        overlayCSS: {
          background: '#fff',
          opacity: 0.6
        }
      });
      t.ajax(epp.ajax_url, data.join('&'), function (response) {
        $form.removeClass('processing').unblock();
        var json = JSON.parse(response);
        t.cleanUpForm();

        if (json && json.success == 'ok') {
          t.fillBillingShippingFields(json.data);
        }
      });
    }
    /**
     * Run
     */

  }, {
    key: "run",
    value: function run() {
      var t = this;
      var $ = jQuery;
      t.ready(function () {
        var $select = $('#eppCustomerSelect');

        if ($select.length) {
          $select.select2({
            minimumInputLength: 3
          });
          $select.on('change', function (e) {
            e.preventDefault();
            t.loadCustomerData(e.target.value);
          });
        }

        var $quotationHidden = $('#is_order_quotation');
        $quotationHidden.val('');
        $(document).on('click', '#place_order_quotation', function (e) {
          $quotationHidden.val('1');
          $('#place_order').trigger('click');
        });
        $(document).on('click', '#place_order_trig', function (e) {
          $quotationHidden.val('');
          $('#place_order').trigger('click');
        });
      });
    }
  }]);

  return Checkout;
}(_App__WEBPACK_IMPORTED_MODULE_5__["default"]);

/* harmony default export */ __webpack_exports__["default"] = (Checkout);

/***/ })

/******/ });
//# sourceMappingURL=index.js.map
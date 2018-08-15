webpackJsonp([7],{

/***/ 23:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(24);


/***/ }),

/***/ 24:
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {
$("form[name=form]").validate({
    rules: {
        local_id: { required: true },
        nome: { required: true, minlength: 3, maxlength: 80 },
        email: { email: true, required: true }
    }
});
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(0)))

/***/ })

},[23]);
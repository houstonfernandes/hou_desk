webpackJsonp([15],{

/***/ 159:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(160);


/***/ }),

/***/ 160:
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {
$("form[name=form]").validate({
    rules: {
        local_id: { required: true },
        nome: { required: true, minlength: 3, maxlength: 80 },
        email: { email: true, required: true },
        password: { required: true },
        password_confirmation: { required: true, equalTo: password }
    }
});
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(1)))

/***/ })

},[159]);
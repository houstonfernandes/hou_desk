webpackJsonp([18],{

/***/ 48:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(49);


/***/ }),

/***/ 49:
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {/**
 * Created by houston on 20/09/17 -15/05/18 comercial.
 */
$("#select_all").change(function () {
    $('[name^=permissions]').prop('checked', $(this).prop("checked"));
});

$('[name^=permissions]').on('click', function () {
    //desmarca selecionar tudo
    if ($("#select_all").prop('checked')) $("#select_all").prop('checked', false);
});
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(0)))

/***/ })

},[48]);
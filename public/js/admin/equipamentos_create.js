webpackJsonp([5],{

/***/ 15:
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(16);
__webpack_require__(17);
module.exports = __webpack_require__(18);


/***/ }),

/***/ 16:
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {$(function () {
	$("form[name=form]").validate({
		rules: {
			nome: { required: true, minlength: 2, maxlength: 80 },
			data_aquisicao: { dateBR: true },
			setor_id: { required: true },
			tipo_equipamento_id: { required: true }
		}
	});
	/*	.submit(function(e){
 		console.log('parou');
 		e.preventDefault();
 		
 	});
 	*/
});
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(0)))

/***/ }),

/***/ 17:
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 18:
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })

},[15]);
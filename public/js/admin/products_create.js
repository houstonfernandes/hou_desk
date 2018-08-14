webpackJsonp([20],{

/***/ 31:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(32);


/***/ }),

/***/ 32:
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {
$("form[name=form]").validate({
    rules: {
        nome: { required: true, minlength: 3, maxlength: 80 },
        preco: { required: true, min: 0, number: true },
        preco_promocao: {//number:true,
            /*        	required: {
                    		param:true,
                    		depends:function(elem){
                    			return $("#promocao").is(":checked");        			
                    		}        		        	
                    	},        	
                    	max: function() {
                    		let valor = $('#preco').val();
                        	if(valor == null || valor == 'undefined'|| valor == '') return 9999999999;
                            	return valor;                
                        }*/
        },
        qtd_min: 'number',
        qtd_max: 'number'
    }
});

$('#preco').blur(function () {
    //	console.log('\nvai validar');
    $("#preco_promocao").rules('add', {
        max: function max() {
            valor = $('#preco').val();
            if (valor == null || valor == 'undefined' || valor == '') return 9999999999;
            return valor;
        }
    });
});

$('#promocao').on('click', function () {
    if ($("#promocao").is(':checked')) {
        $("#preco_promocao").rules('add', {
            required: true
        });
    } else $('#preco_promocao').rules('remove', 'required');
});

$('form[name=form]').submit(function (e) {
    $(this).validate(); //chama validacao
    if ($(this).valid()) {//se passar na validacao
        //        console.log('passou');
        //          return false;
    }
});
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(0)))

/***/ })

},[31]);
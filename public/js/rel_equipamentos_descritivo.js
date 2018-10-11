webpackJsonp([13],{

/***/ 147:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(148);


/***/ }),

/***/ 148:
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {$(function () {
  local_id = $('#local_id').val();

  if (local_id != '') {
    listarSetores();
  }

  $('#local_id').on('change', function () {
    local_id = $(this).val();
    if (local_id == '') {
      limparSetores();
      return false;
    }
    listarSetores();
  });
});

var local_id = void 0;
var limparSetores = function limparSetores() {
  $('#setor_id').empty();
};

var listarSetores = function listarSetores() {
  //buscar locais e montar options
  $.ajax({
    url: baseUrl + 'api/locais/listar_setores/' + local_id,
    type: 'GET',
    data: {
      //	        	_token: _token
    },
    success: function success(data) {
      console.log(data.msg);
      $('#setor_id').empty();
      var $option = $('<option>').prop({
        'value': '', 'selected': 'selected'
      }).html('todos');
      $('#setor_id').append($option);
      var selected = $('#setor_id_value').val();
      $.each(data.setores, function (i, setor) {
        var texto = setor.nome;
        var $option = $('<option>').prop({
          'value': setor.id
        });
        if (selected == setor.id) {
          $option.prop('selected', 'selected');
        }
        $option.html(texto);
        $('#setor_id').append($option);
      });
    },
    error: function error(jqXhr) {
      var parsedJson = jqXhr.responseJSON;
      if (jqXhr.status === 500) {
        $('#divMsg').html(parsedJson.msg);
      }
      if (jqXhr.status === 404) {
        var $option = $('<option>').prop({
          'value': ''
        }).html(parsedJson.msg);
        $('#setor_id').html($option);
        //$('#divMsg').html(parsedJson.msg);
      }
    }
  });
};
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(1)))

/***/ })

},[147]);
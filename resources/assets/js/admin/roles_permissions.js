/**
 * Created by houston on 20/09/17 -15/05/18 comercial.
 */
$("#select_all").change(function(){
    $('[name^=permissions]').prop('checked', $(this).prop("checked"));
});

$('[name^=permissions]').on('click', function(){//desmarca selecionar tudo
    if($("#select_all").prop('checked'))
        $("#select_all").prop('checked',false);
});


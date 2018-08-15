
$("form[name=form]").validate({
    rules: {
        nome:{required: true, minlength:3, maxlength:80},
    }
});

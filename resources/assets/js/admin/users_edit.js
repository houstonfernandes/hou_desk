
$("form[name=form]").validate({
    rules: {
    	local_id:{required: true},
        nome:{required: true, minlength:3, maxlength:80},
        email:{email:true, required:true},
    }
});


$(function(){
    var flag1 = false;
    var flag2 = false;

    $("[type='submit']").click(function (event){
        event.preventDefault();
        if (flag1 && flag2){
            $(".validation").val(1);
            $("#changePassForm").submit();
        }else {
            swal({title:"خطا",text:"لطفا فیلدهای موردنظر را با دقت پر کنید.",icon:"error" , button:"بستن",timer:4000});
        }
    });


    $("[name='password']").blur(function (){
        $(this).removeClass("is-valid is-invalid");
        $(this).next(".invalid-feedback").children("ul").children("li").remove();

        requiredMsg = required(this);
        if (requiredMsg == true){
            validPassMsg = validPass(this);
            if (validPassMsg == true){
                $(this).addClass("is-valid");
                flag1 = true;
            }else {
                $(this).next(".invalid-feedback").children("ul").append("<li>"+validPassMsg+"</li>");
                $(this).addClass("is-invalid");
                flag1 = false;
            }
        }else {
            $(this).next(".invalid-feedback").children("ul").append("<li>"+requiredMsg+"</li>");
            $(this).addClass("is-invalid");
            flag1 = false;
        }

    }).after("<div class='invalid-feedback'><ul class='list-unstyled'></ul></div>");


    $("[name='repeatPassword']").blur(function (){
        $(this).removeClass("is-valid is-invalid");
        $(this).next(".invalid-feedback").children("ul").children("li").remove();

        requiredMsg = required(this);
        if (requiredMsg == true){
            validPassMsg = validPass(this);
            if (validPassMsg == true){
                $(this).addClass("is-valid");
                flag2 = true;
            }else {
                $(this).next(".invalid-feedback").children("ul").append("<li>"+validPassMsg+"</li>");
                $(this).addClass("is-invalid");
                flag2 = false;
            }
        }else {
            $(this).next(".invalid-feedback").children("ul").append("<li>"+requiredMsg+"</li>");
            $(this).addClass("is-invalid");
            flag2 = false;
        }

    }).after("<div class='invalid-feedback'><ul class='list-unstyled'></ul></div>");


    function required(Item){
        var inpValue = $(Item).val().trim();
        if (inpValue.length == 0 || inpValue == "" || inpValue == null) {
            return "لطفا فیلد مورد نظر را پر کنید.";
        }
        return true;
    }

    function validPass(Item){
        var inpValue = $(Item).val().trim();
        if (inpValue.length < 6) {
            return "رمز عبور نباید کمتر از 6 کاراکتر باشد.";
        }
        return true;
    }


});
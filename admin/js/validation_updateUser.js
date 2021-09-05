$(function(){
    var flag1 = false;
    var flag2 = false;
    var flag3 = false;
    var flag4 = false;

    $("[type='submit']").click(function (event){
        event.preventDefault();
        $(".validation").val(1);
        if (flag1 && flag2 && flag3 && flag4){
            $("#updateUserForm").submit();
        }else {
            swal({title:"خطا",text:"لطفا فیلدهای موردنظر را با دقت پر کنید.",icon:"error" , button:"بستن",timer:4000});
        }
    });


    $("[name='first_name']").blur(function (){
        $(this).removeClass("is-valid is-invalid");
        $(this).next(".invalid-feedback").children("ul").children("li").remove();

        requiredMsg = required(this);
        if (requiredMsg == true){
            validFirstNameMsg = validFirstName(this);
            if (validFirstNameMsg == true){
                $(this).addClass("is-valid");
                flag1 = true;
            }else {
                $(this).next(".invalid-feedback").children("ul").append("<li>"+validFirstNameMsg+"</li>");
                $(this).addClass("is-invalid");
                flag1 = false;
            }
        }else {
            $(this).next(".invalid-feedback").children("ul").append("<li>"+requiredMsg+"</li>");
            $(this).addClass("is-invalid");
            flag1 = false;
        }

    }).after("<div class='invalid-feedback'><ul class='list-unstyled'></ul></div>");


    $("[name='last_name']").blur(function (){
        $(this).removeClass("is-valid is-invalid");
        $(this).next(".invalid-feedback").children("ul").children("li").remove();

        requiredMsg = required(this);
        if (requiredMsg == true){
            validLastNameMsg = validLastName(this);
            if (validLastNameMsg == true){
                $(this).addClass("is-valid");
                flag2 = true;
            }else {
                $(this).next(".invalid-feedback").children("ul").append("<li>"+validLastNameMsg+"</li>");
                $(this).addClass("is-invalid");
                flag2 = false;
            }
        }else {
            $(this).next(".invalid-feedback").children("ul").append("<li>"+requiredMsg+"</li>");
            $(this).addClass("is-invalid");
            flag2 = false;
        }

    }).after("<div class='invalid-feedback'><ul class='list-unstyled'></ul></div>");


    $("[name='mobile']").blur(function (){
        $(this).removeClass("is-valid is-invalid");
        $(this).next(".invalid-feedback").children("ul").children("li").remove();

        requiredMsg = required(this);
        if (requiredMsg == true){
            validMobileMsg = validMobile(this);
            if (validMobileMsg == true){
                $(this).addClass("is-valid");
                flag3 = true;
            }else {
                $(this).next(".invalid-feedback").children("ul").append("<li>"+validMobileMsg+"</li>");
                $(this).addClass("is-invalid");
                flag3 = false;
            }
        }else {
            $(this).next(".invalid-feedback").children("ul").append("<li>"+requiredMsg+"</li>");
            $(this).addClass("is-invalid");
            flag3 = false;
        }

    }).after("<div class='invalid-feedback'><ul class='list-unstyled'></ul></div>");


    $("[name='status']").blur(function (){
        $(this).removeClass("is-valid is-invalid");
        $(this).next(".invalid-feedback").children("ul").children("li").remove();

        requiredMsg = required(this);
        if (requiredMsg == true){
            $(this).addClass("is-valid");
            flag4 = true;
        }else {
            $(this).next(".invalid-feedback").children("ul").append("<li>"+requiredMsg+"</li>");
            $(this).addClass("is-invalid");
            flag4 = false;
        }

    }).after("<div class='invalid-feedback'><ul class='list-unstyled'></ul></div>");



    function required(Item){
        var inpValue = $(Item).val().trim();
        if (inpValue.length == 0 || inpValue == "" || inpValue == null) {
            return "لطفا فیلد مورد نظر را پر کنید.";
        }
        return true;
    }

    function validFirstName(Item){
        var inpValue = $(Item).val().trim();
        if (inpValue.length > 100) {
            return "نام نباید از 100 کاراکتر بیشتر باشد.";
        }
        return true;
    }

    function validLastName(Item){
        var inpValue = $(Item).val().trim();
        if (inpValue.length > 100) {
            return "نام خانوادگی نباید از 100 کاراکتر بیشتر باشد.";
        }
        return true;
    }

    function validMobile(Item){
        var inpValue = $(Item).val().trim();
        if (inpValue.length != 11 || !inpValue.startsWith("09")) {
            return "فرمت شماره همراه صحیح نمی باشد.";
        }
        return true;
    }

});
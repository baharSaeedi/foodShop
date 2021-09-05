$(function () {
    ////////////////////// Delete Button in Basket ////////////////////////
    $(".del-food").click(function (e){
        e.preventDefault();
        id = $(this).parent().parent().children(".id").children("input").val();

        swal({
            title: "اخطار",
            text: "آیا از حذف این محصول اطمینان دارید؟",
            icon: "warning",
            buttons: ["لغو","حذف"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $(".basketForm input[name='del-food']").val(id);
                $(".basketForm").submit();
            } else {
                swal({
                    title:"لغو",
                    text:"عملیات حذف لغو گردید.",
                    icon: "error",
                    button: "بستن",
                    timer: 4000
                });
            }
        });

    });

    ////////////////////// Plus Button in Basket ////////////////////////
    $(".plusBtn").click(function (e){
        e.preventDefault();
        id = $(this).parent().parent().children(".id").children("input").val();
        quantity = parseInt($(this).parent().children("input").val());



        $(".basketForm input[name='plus']").val(id);
        $.ajax({
            data: $(".basketForm").serialize(),
            type : "post",
            action : $(".basketForm").attr("action"),
            success : function (response) {

            },
            complete : function () {

            }
        })
        $(this).parent().children("input").val(quantity+1)
        $(this).parent().parent().children(".totalPrice").text(parseInt($(this).parent().parent().children(".totalPrice").text())+parseInt($(this).parent().parent().children(".price").text()))
        $(".sumOfPrice").text(parseInt($(".sumOfPrice").text())+parseInt($(this).parent().parent().children(".price").text()))
        $(".sum").val(parseInt($(".sum").val())+parseInt($(this).parent().parent().children(".price").text()))

    });

    ////////////////////// Minus Button in Basket ////////////////////////
    $(".minusBtn").click(function (e){
        e.preventDefault();
        id = $(this).parent().parent().children(".id").children("input").val();
        quantity = parseInt($(this).parent().children("input").val());

        if (quantity > 1) {
            $(".basketForm input[name='minus']").val(id);
            $.ajax({
                data: $(".basketForm").serialize(),
                type : "post",
                action : $(".basketForm").attr("action"),
                success : function (response) {
                },
                complete : function () {

                }
            })
            $(this).parent().children("input").val(quantity-1)
            $(this).parent().parent().children(".totalPrice").text(parseInt($(this).parent().parent().children(".totalPrice").text())-parseInt($(this).parent().parent().children(".price").text()))
            $(".sumOfPrice").text(parseInt($(".sumOfPrice").text())-parseInt($(this).parent().parent().children(".price").text()))
            $(".sum").val(parseInt($(".sum").val())-parseInt($(this).parent().parent().children(".price").text()))

        }
    });


    ////////////////////// Plus Button in ShowPost ////////////////////////
    $(".plus-btn").click(function (){
        var quantity = 0;
        quantity = parseInt($(this).parent().children("input").val());
            $(this).parent().children("input").val(quantity + 1);
    });

    ////////////////////// Minus Button in ShowPost ////////////////////////
    $(".minus-btn").click(function (){
        var quantity = 0;
        quantity = parseInt($(this).parent().children("input").val());
        if (quantity > 1) {
            $(this).parent().children("input").val(quantity - 1);
        }
    });



});
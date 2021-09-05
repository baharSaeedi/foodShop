$(function () {

    ////////////////////// Delete Button in Users ////////////////////////
    $(".del-user").click(function (e){
        e.preventDefault();
        id = $(this).parent().parent().children().eq(2).text();

        swal({
            title: "اخطار",
            text: "آیا از حذف این کاربر اطمینان دارید؟",
            icon: "warning",
            buttons: ["لغو","حذف"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $(".userForm input[name='del-user']").val(id);
                $(".userForm").submit();
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

    ////////////////////// Delete Button in Categories ////////////////////////
    $(".del-cat").click(function (e){
        e.preventDefault();
        id = $(this).parent().parent().children().eq(2).text();

        swal({
            title: "اخطار",
            text: "آیا از حذف این دسته بندی اطمینان دارید؟",
            icon: "warning",
            buttons: ["لغو","حذف"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $(".catForm input[name='del-cat']").val(id);
                $(".catForm").submit();
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

    ////////////////////// Delete Button in Images ////////////////////////
    $(".del-food").click(function (e){
        e.preventDefault();
        id = $(this).parent().parent().children().eq(2).text();

        swal({
            title: "اخطار",
            text: "آیا از حذف این غذا اطمینان دارید؟",
            icon: "warning",
            buttons: ["لغو","حذف"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $(".imageForm input[name='del-food']").val(id);
                $(".imageForm").submit();
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

    ////////////////////// Delete Button in Orders ////////////////////////
    $(".del-order").click(function (e){
        e.preventDefault();
        id = $(this).parent().parent().children().eq(2).text();

        swal({
            title: "اخطار",
            text: "آیا از حذف این سفارش اطمینان دارید؟",
            icon: "warning",
            buttons: ["لغو","حذف"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $(".orderForm input[name='del-order']").val(id);
                $(".orderForm").submit();
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

    ////////////////////// CheckBoxes ////////////////////////
    $(".check-all").change(function(){
        $(".checkbox").prop("checked",$(this).prop("checked"));
    });

    $(".checkbox").change(function(){
        if($(this).prop("checked") == false){
            $(".check-all").prop("checked", false);
        }
        if($(".checkbox:checked").length == $(".checkbox").length){
            $(".check-all").prop("checked", true);
        }
    });

    ////////////////////// Delete All Button in Categories ////////////////////////
    $(".dellCatsBtn").click(function (e){
        e.preventDefault();

        swal({
            title: "اخطار",
            text: "آیا از حذف این دسته بندی ها اطمینان دارید؟",
            icon: "warning",
            buttons: ["لغو","حذف"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $(".dellCats").val(1);
                $(".catForm").submit();
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

    ////////////////////// Delete All Button in Users ////////////////////////
    $(".dellUsersBtn").click(function (e){
        e.preventDefault();

        swal({
            title: "اخطار",
            text: "آیا از حذف این کاربران اطمینان دارید؟",
            icon: "warning",
            buttons: ["لغو","حذف"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $(".dellUsers").val(1);
                $(".userForm").submit();
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

    ////////////////////// Delete All Button in Images ////////////////////////
    $(".dellFoodsBtn").click(function (e){
        e.preventDefault();

        swal({
            title: "اخطار",
            text: "آیا از حذف این تصویر ها اطمینان دارید؟",
            icon: "warning",
            buttons: ["لغو","حذف"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $(".dellFoods").val(1);
                $(".foodForm").submit();
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

    ////////////////////// Delete All Button in Orders ////////////////////////
    $(".dellOrdersBtn").click(function (e){
        e.preventDefault();

        swal({
            title: "اخطار",
            text: "آیا از حذف این سفارش ها اطمینان دارید؟",
            icon: "warning",
            buttons: ["لغو","حذف"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $(".dellOrders").val(1);
                $(".orderForm").submit();
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

















});
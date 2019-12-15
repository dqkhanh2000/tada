// -------------------------------------------------------------
// --------------------------quick view-------------------------
// -------------------------------------------------------------

/*==================================================================
    [ Show modal1 ]*/
    $('.js-show-modal1').on('click',function(e){
        e.preventDefault();

        var id = $(e.target).parent().parent().attr("value");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $("#token").attr("token")
            },
            url: $("#home-url").attr('value')+"/get-detail",
            method: 'POST',
            data: {id: id}
        }).then(data => {
            var product = data[0],
                color = data[1],
                image = data[2],
                size = data[3],
                id = data[4],
                price = product.price.replace(",", "");
                price = price.replace("đ", "");
                price = price.replace("₫", "");
                price = parseInt(price);
            $("#group-name-detail").text(product.name);
            $("#groupID").text(product.code);
            $("#id-product-detail").text(id);

            if(product.sale > 0){
                $("#price").text(formatNumber(price*(100-product.sale)/100)+"đ");
                if($("#sale").css("display") === "none") $("#sale").show();
                $("#sale").text(formatNumber(price)+"đ");
            }
            else{
                $("#price").text(formatNumber(price)+"đ");
                $("#sale").hide();
            }

            loadSelect2($("#color-detail"), color);
            loadSelect2($("#size-detail"), size);

            addImageToModal(image);
            reloadSlick3();
            $('.js-modal1').addClass('show-modal1');
        })

    });

    function loadSelect2(target, data){
        target.empty().trigger('change');
        data.forEach(e=>{
            var option = new Option(e.text, e.id, true, true);
            target.append(option).trigger('change');
        });
        target.val(data[0].id).trigger('change');
    }

    $('.js-hide-modal1').on('click',function(){
        $('.js-modal1').removeClass('show-modal1');
    });

    function addImageToModal(image){
        $(".slick3").slick('unslick');
        $target = $("#gallery-modal");
        $target[0].innerHTML="";
        $(".wrap-slick3-dots")[0].innerHTML="";
        image.forEach(element => {
            var path = $("#home-url").attr('value') + "/image/"+element,
            data = '<div class="item-slick3" data-thumb="'+path +'">'+
                        '<div class="wrap-pic-w pos-relative">'+
                            '<img src="'+path+'" alt="IMG-PRODUCT">'+
                            '<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="'+path+'">'+
                                '<i class="fa fa-expand"></i>'+
                            '</a>'+
                        '</div>'+
                    '</div>';
            $target.append(data);
        });
    }

    function reloadSlick3(){
            $('.slick3').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                fade: true,

                arrows: true,
                appendArrows: $(this).find('.wrap-slick3-arrows'),
                prevArrow:'<button class="arrow-slick3 prev-slick3"><i class="fa fa-angle-left" aria-hidden="true"></i></button>',
                nextArrow:'<button class="arrow-slick3 next-slick3"><i class="fa fa-angle-right" aria-hidden="true"></i></button>',

                dots: true,
                appendDots: $('.wrap-slick3-dots'),
                dotsClass:'slick3-dots',
                customPaging: function(slick, index) {
                    var portrait = $(slick.$slides[index]).data('thumb');
                    return '<img src=" ' + portrait + ' "/><div class="slick3-dot-overlay"></div>';
                },
            });
    }

// -------------------------------------------------------------
// --------------------------selector 2-------------------------
// -------------------------------------------------------------
var city=false, district = false, commune = false, street = false;
$(".commune").select2({
    placeholder: "Phường/Xã"
});

$(".district").select2({
    placeholder: "Quận/Huyện"
});

$('.city').on('select2:select', function (e) {
    $data = [];
    $idCity = e.params.data.element.attributes.id.nodeValue;
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $("#token").attr("token")
        },
        url: $("#home-url").attr('value')+"/get-district",
        method: 'POST',
        data: {id: $idCity}
    }).then(e => {
        $data = e;
        $(".district").empty().trigger('change');
        $(".district").append($("<option />").text("Quận/Huyện"));
        $(".district").select2({

            data: $data
        });
        city = true;
    });

});

$('.district').on('select2:select', function (e) {
    $data = [];
    $idDistrict = e.params.data.id;
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $("#token").attr("token")
        },
        url: $("#home-url").attr('value')+"/get-commune",
        method: 'POST',
        data: {id: $idDistrict}
    }).then(e => {
        $data = e;
        $(".commune").empty().trigger('change');
        $(".commune").append($("<option />").text("Phường/Xã"));
        $(".commune").select2({
            data: $data
        });
    });
    district = true;
});

$('.commune').on('select2:select', function (e) {commune = true});

$('.checkout').click((e) =>{
    if($('.street').val() != '') street = true;
    if(!(city && district && commune && street)) {
        e.preventDefault();
        swal("", "Bạn phải điền đầy đủ thông tin địa chỉ", "error")
    }
    else{
        $city = $('.city').val();
        $district = $('.district').next().children(".selection").children(".select2-selection").children(".select2-selection__rendered").text();
        $commune = $('.commune').next().children(".selection").children(".select2-selection").children(".select2-selection__rendered").text();
        $street = $('.street').val();
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $("#token").attr("token")
            },
            method: 'POST',
            url: $("#home-url").attr('value')+"/checkout",
            data:  {
                city: $city,
                district: $district,
                commune: $commune,
                street: $street,
                voucher: $(".voucher").val()
            }
        }).then((e)=>{
            console.log(e);
        });
    }
})

$("#color-detail").on('select2:select', function(e){
    var color = e.params.data.text,
        groupID = $("#groupID").text();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $("#token").attr("token")
        },
        url: $("#home-url").attr('value')+"/get-size-by-color",
        method: 'POST',
        data: {
            color: color,
            groupID: groupID
        }
    }).then(function(data){
        $('#id-product-detail').text(data[0].id);
        $("#size-detail").empty().trigger('change');
        data.forEach(e =>{
            var option = new Option(e.text, e.id, true, true);
            $("#size-detail").append(option).trigger('change');
        })
        var id = $("#size-detail").val() ;
        $('#id-product-detail').text(id);
    })
})
$("#size-detail").on('select2:select', function(e){
    var id = e.params.data.id;
    $('#id-product-detail').text(id);
})

// -------------------------------------------------------------
// --------------------------add to ...-------------------------
// -------------------------------------------------------------

    $('.js-addwish-b2').on('click', function(e){
        e.preventDefault();
    });

    $('.js-addwish-b2').each(function(){
        var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
        $(this).on('click', function(){
            swal(nameProduct, "is added to wishlist !", "success");

            $(this).addClass('js-addedwish-b2');
            $(this).off('click');
        });
    });

    $('.js-addwish-detail').each(function(){
        var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

        $(this).on('click', function(){
            swal(nameProduct, "is added to wishlist !", "success");

            $(this).addClass('js-addedwish-detail');
            $(this).off('click');
        });
    });

    /*---------------------------------------------*/
    $('.js-addcart-detail').on('click', function(){
        // if(idCustomer){
            var id = $('#id-product-detail').text(),
                quant = $("#num-product").val(),
                color = document.getElementById("color-detail").value;

            if(quant == 0){
                swal("", "Số lượng phải lớn hơn 0!!", "warning");
            }
            else{
                var data = {
                    productID: id,
                    idCustomer: idCustomer,
                    quantity: quant
                };
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $("#token").attr("token")
                    },
                    method: "POST",
                    url: $("#home-url").attr('value')+"/add-to-cart",
                    data: data,
                })
                .then(result => {
                    console.log(result);
                    var nameProduct  = $("#group-name-detail").text();
                    if(result === 'ok'){
                        swal(nameProduct, "đã thêm vào giỏ hàng!", "success")
                        .then(e =>{location.reload()});
                    }
                    else
                        swal("Lỗi", "Có lỗi xuất hiện</br>Vui lòng thử lại sau", "Error");
                })
            }
    });


    // --------------------------------------------
    // --------------change password-----------------
    // --------------------------------------------
    var password = document.getElementById("modal-new-password"),
        oldPassword = document.getElementById("modal-old-password"),
        confirmPassword = document.getElementById("modal-confirm-password");

  function validatePassword(){
    if(password.value.length < 6){
        password.setCustomValidity("Mật khẩu ít nhất 6 kí tự");
        password.reportValidity();
    }
    else if(password.value != confirmPassword.value) {
      confirmPassword.setCustomValidity("Mật khẩu không khớp");
      confirmPassword.reportValidity();
    }
    else {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $("#token").attr("token")
            },
            url: $("#home-url").attr('value')+"/change-password",
            method: 'POST',
            data: {
                oldPassword: oldPassword.value,
                newPassword: password.value
            }
        }).then(response => {
            if(response.error){
                oldPassword.setCustomValidity("Mật khẩu không đúng")
                oldPassword.reportValidity();
            }
            else{
                $('#modal-profile').modal('hide');
                swal("Thành công", "Đổi mật khẩu thành công!", "success")
                .then(function(){
                    $('.modal-backdrop').hide();
                });
            }
        });
    }
  }

  $('#modal-btn-change-password').click(function(){
        validatePassword();
  });





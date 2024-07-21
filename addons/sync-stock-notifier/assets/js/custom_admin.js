jQuery(document).ready(function($) {
  var ajax_url = $("input#stock_notifier_ajax_url").val();

var modal = document.getElementById("popup-modal");

var triggerBtn = document.getElementById("popup-trigger");

var closeBtn = document.getElementsByClassName("close")[0];


$(document).on("click",".add_to_watch_list",function() {
  $(".popup_modale").css('display', 'block');
});


$(".close").on('click', function(){
  $(".popup_modale").css('display', 'none');
});

function openModal() {
  modal.style.display = "block";
}
function closeModal() {
  modal.style.display = "none";
}

$("#wc_sn_name").prop("required", true);
$("#wc_sn_email").prop("required", true);



$('.stock').each(function() {
  if ($(this).siblings('.in-stock').length) {
    $(this).find('.out_of_stock_add_favourite').hide();
  }
});

$('.stock').on('change', function() {
  if ($(this).siblings('.in-stock').length) {
    $(this).find('.out_of_stock_add_favourite').hide();
  } else {
    $(this).find('.out_of_stock_add_favourite').show();
  }
});

    (function () {
        var forms = document.querySelectorAll(".needs-validation")
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener("submit", function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }else {
                      synk_submit_notify_form(event);
                    }
                    form.classList.add("was-validated")
                }, false)
            })
    })()

    function synk_submit_notify_form(e){
        e.preventDefault();
   var name = $('#wc_sn_name').val();
  var product_id = $('#product_id').val();
  var product_name = $('#product_name').val();
  var email = $('#wc_sn_email').val();
  var phoneNumber = $('#wc_sn_phone_number').val();
  var product_link = $("#product_link").val();
  var nonce = ajax_object.nonce; 

  $.ajax({
      type: 'POST',
      dataType: 'json',
      url: ajax_object.ajax_url,
      data: {
          action: 'stock_subscription_notification',
          wc_sn_user_name: name,
          wc_sn_user_email: email,
          wc_sn_user_number: phoneNumber,
          wc_sn_user_poduct_id: product_id,
          wc_sn_user_product_name: product_name,
          wc_sn_product_ref: product_link,
          nonce: nonce 
      },
      success: function (response) {
            $(".out_of_stock_descrip").css('display', 'none');
            $(".stock_back_notification").css('display', 'block');
            $("#wc_sn_send_email_form")[0].reset();
            $(".popup_modale").hide();

      },
      error: function (xhr, status, error) {
          console.log(xhr.responseText);
          //$(".popup_modale").hide();
      }
  });

  return false;
}
});
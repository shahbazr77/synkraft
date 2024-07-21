jQuery(document).ready(function($) {
    var ajax_url = $("input#stock_notifier_ajax_url").val();
  $('form#stock_notifier_table_data').on('submit', function(e) {
    e.preventDefault();

   
    var action = $('select[name="action"]').val();
    var selectedItems = [];
    $('input[name="item[]"]:checked').each(function() {
      selectedItems.push($(this).val());
    });

    if (action === 'send_email') {
      if (selectedItems.length > 0) {
        var data = {
          action: 'wc_send_stock_back_notification_email',
          items: selectedItems,
        };

        $.post(ajax_url, data, function(response) {

          if (response.success == true) {
            
            console.log('Emails sent successfully.');
            location.reload();
          } else {
            alert('Failed to send emails.');
          }
        });
      } else {
        alert('Please select a row(s) to send email.');
        location.reload();
      }
    } else {
      $(this).off('submit').submit();
    }
  });

  $("#submit").on('click', function(){
      $('.settings_saved').css('display', 'block');
    })


//   $('#export-csv-button').on('click', function () {
//     alert("tayyab");
//     $.ajax({
//         url: ajaxurl, // The WordPress AJAX URL
//         type: 'POST',
//         data: {
//             action: 'export_csv_data' // This is the AJAX action to handle the export
//         },
//         success: function (response) {
//             // Handle the response, e.g., trigger a download
//             console.log(response);
//         }
//     });
// });
});
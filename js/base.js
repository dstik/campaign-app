$(function() {
   $('#upload_file').submit(function(e) {
      e.preventDefault();
      $.ajaxFileUpload({
        url            :'/index.php/upload/upload_file/',
        secureuri      :false,
        fileElementId  :'userfile',
        dataType       : 'json',
        data           : {
          'title': $('#title').val(),
          'description': $('#description').val(),
        },
        success: function (data, status) {
          if(data.status == 'success') {
            //console.log(data);
            clearAndHideForm();
            alert("Thanks for your submission " + data.msg);
          } else {
            alert("File could not be uploaded");
          }
        }
      });
      return false;
   });
});

function clearAndHideForm() {
  $('#upload_file')[0].reset();
  $('.upload_outer').hide();
}

$('#upload_btn').bind('click touch', function(e) {
  $('.upload_outer').show();
});

$('.upload_cancel').bind('click touch', clearAndHideForm);
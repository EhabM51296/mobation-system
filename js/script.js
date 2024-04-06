function showMessageModal(type, text) {
  if (typeof text !== 'undefined') {
    $(`#message-modal-container-${type} p`).html(text);
}
  $(`#message-modal-container-${type}`).fadeIn(function () {
    setTimeout(function () {
      $(`#message-modal-container-${type}`).fadeOut();
    }, 1000);
  });
}

function updateProfile(data)
{
  let name = data[0];
  let email = data[1];
  $(".username").html(name);
  $(".username-input").val(name);
  $(".useremail").html(email);
  $(".useremail-input").val(email);
}

$(document).ready(function(){
  // $(".sidebar-toggle").click(function(){
  //   $("#sidebar").toggleClass("show");
  // });

 
  $(document).on("click",".open-modal",function(){
    let id = $(this).attr("data-id");
    if($(this).hasAttr("data-hiddenid"))
    {
      let hiddenId = $(this).closest('tr').data('id');
      $(`#${id} form input[type='hidden']`).val(hiddenId);

    }
    $(`#${id}`).fadeIn();
  });

  $(".close-modal").click(function(){
    $(".modal-container").hide();
  });

  $('.show-hide-password').on('click', function () {
    let passwordField = $(this).parent().find('input');
    if (passwordField.attr('type') === 'password') {
        passwordField.attr('type', 'text');
    } else {
        passwordField.attr('type', 'password');
    }
});


});

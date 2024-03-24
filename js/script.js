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

$(document).ready(function(){
  // $(".sidebar-toggle").click(function(){
  //   $("#sidebar").toggleClass("show");
  // });

  $(".open-modal").click(function(){
    let id = $(this).attr("data-id");
    $(`#${id}`).fadeIn();
  });

  $(".close-modal").click(function(){
    $(".modal-container").hide();
  });


});

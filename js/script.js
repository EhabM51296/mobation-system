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

$(document).on("click", ".select-dropdown-control", function(){
  $(this).parent().toggleClass("active");
});

$(document).mouseup(function(e) 
{
    let container = $(".select-dropdown-control");
    let item = $(".dropdown-item");
    if (!container.is(e.target) && container.has(e.target).length === 0 && (!item.is(e.target) && item.has(e.target).length === 0)) 
    {
        container.parent().removeClass("active");
    }
    
});

$(document).on("click", ".dropdown-item", function(){
  let value = $(this).attr("data-value");
  let label = $(this).attr("data-label");
  let item = $(this);
  let container = $(this).parent().parent();
  let inputText = container.find(".select-dropdown-control span");
  let inputValues = container.find("input[type='hidden']");
  let isMultiDropdown = $(container).hasClass("multidropdown");
  if(!isMultiDropdown){
    inputValues.val(value);
    inputText.html(label);
    container.removeClass("active");
    container.find(".dropdown-item").removeClass("active");
    item.addClass("active");
  }
  else{
      if(inputValues.val().length > 0)
      {
        let arrayValues = inputValues.val().split(",");
        let labelValues = inputText.html().split(",");
        if(arrayValues.includes(value))
        {
          let index = arrayValues.indexOf(value);
          arrayValues.splice(index, 1);
          labelValues.splice(index, 1);
          arrayValues = arrayValues.toString();
          labelValues = labelValues.toString();
          inputValues.val(arrayValues);
          inputText.html(labelValues);
          item.removeClass("active");
        }
        else{
          inputValues.val(`${inputValues.val()},${value}`);
          inputText.html(`${inputText.html()},${label}`);
          item.addClass("active");
        }
      }
      else{
        inputValues.val(value);
        inputText.html(label);
        item.addClass("active");
      }
  }
  return;
});

});

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

function generateDropdownComponent(id, name, placeholder = "", server = "", values = [], required = true, errorMessage = "Required", multidropdown = false, className = "") {
  const iconPath = "./assets/icons";
  let html = '';
  if (multidropdown)
      html += `<div class="select-dropdown multidropdown ${className}">`;
  else
      html += `<div class="select-dropdown ${className}">`;
  html += `<button placeholder="${placeholder}" class="select-dropdown-control" type="button" data-server="${server}">`;
  html += `<span>${placeholder}</span>`;
  html += `<img src="${iconPath}/dropdownArrow.svg" width="12px" />`;
  html += '</button>';
  if (required) {
      html += `<input type="hidden" value="" class="dropdown-selected-values validate-input data-to-send" data-validate="required" data-required="${errorMessage}" id="${id}" name="${name}" />`;
  } else {
      html += `<input type="hidden" value="" class="dropdown-selected-values data-to-send" id="${id}" name="${name}" />`;
  }
  html += '<div class="dropdown-items">';
  if (server === "") {
      values.forEach(item => {
          html += `<button class="dropdown-item" data-value="${item.value}" data-label="${item.label}"> ${item.label} </button>`;
      });
  }
  html += '</div>';
  html += `<div class="validation-message" id="validation-message-${id}"></div>`;
  html += '</div>';
  return html;
}

function invoiceTotalPrice()
{
  let total = 0;
  $("#add-sales-products-selected-container button.remove-product").each(function() {
    let price = $(this).attr("data-price");
    let count = $(this).attr("data-value").split("_")[1];
    let amount = price * count;
    total += amount; 
});
let discount = $("#add-sales-discountAmount").val();
total = total - (total * discount / 100);
$(".add-total-amount").html(total);
}
$(document).ready(function(){
  // $(".sidebar-toggle").click(function(){
  //   $("#sidebar").toggleClass("show");
  // });


  $(document).on("click",".get-products",function(){
    $.ajax({
      type: "get",
      // async: false,
      processData: false,
      contentType: false,
      cache: false,
      url: `./backend/models/products/products.php?productsIdName=1`,
      success: function (data) {
        try {
          let res = JSON.parse(data);
          let status = res.status;
          let recentData = res.data;
          if(status === 1)
          {
            let html = "";
              Object.entries(recentData).forEach((e) => {
                  const [k, v] = e;
                  let dropdown = generateDropdownComponent(`add-sales-product-batch-dropdown-${k}`, `productBatch`, "Product Batch", `products/products.php?batchdropdown=${v.id}`, [], true, 'Batch is required', false, "w-min-320px");
                  html += `<div>
                                <div class="flex gap-5">
                                    <label>${v.name}</label>
                                    ${dropdown}
                                    <div>
                                        <input type="number" placeholder="Count" id="add-sales-count-${k}" name="count"
                                            class="form-input validate-input data-to-send"
                                            data-validate="positiveIntegerNotZero"
                                            data-positiveIntegerNotZero="Count must be greater than 0 and less than or equal to the number of available items" />
                                        <div class="validation-message" id="validation-message-add-sales-count-${k}">
                                        </div>
                                    </div>
                                    <div>
                                        <button data-inputid="add-sales-products-selected"
                                            class="bg-active add-edit-product-btn" type="button" data-productid = "${v.id}" data-productname="${v.name}">Add/Edit</button>
                                    </div>
                                </div>
                            </div>`;
              });
              $(".products-list-container").html(html);
          }
        } catch (e) {
          console.log(`error - ${e}`);
          return;
        }
      },
      error: function () {
        alert("failed to connect to database");
      },
    });
  });
 
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
  let serverValue = $(this).attr("data-server");
  // console.log(serverValue);
  if($(this).parent().hasClass("active") && serverValue !== "")
  {
    let currentValues = $(this).parent().find("input[type='hidden']").val().split(",");
    let dropdownItemsContainer = $(this).parent().find(".dropdown-items");
    // console.log(currentValues);
    $.ajax({
      type: "get",
      // async: false,
      processData: false,
      contentType: false,
      cache: false,
      url: `./backend/models/${serverValue}`,
      success: function (data) {
        try {
          let res = JSON.parse(data);
          let status = res.status;
          let recentData = res.data;
          if(status === 1)
          {
            let html = "";
              Object.entries(recentData).forEach((e) => {
                  const [k, v] = e;
                  let currentValueExists = currentValues.includes(v.id.toString()); 
                  let active = "";
                  if(currentValueExists)
                    active = "active";
                // console.log(k , " ", v.id);
                // console.log(currentValues);
                let dataValues = v.neededValues ?? "";
                 html += `<button type="button" class="dropdown-item ${active}" data-value="${v.id}" data-label="${v.name}" data-values = "${dataValues}"> ${v.name} </button>`;
              });
              dropdownItemsContainer.html(html);
          }
        } catch (e) {
          console.log(`error - ${e}`);
          return;
        }
      },
      error: function () {
        alert("failed to connect to database");
      },
    });
  }
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
  let dataValues = $(this).attr("data-values").split("_"); //recenty used in single dropdown not multi, we can edit the code when needed
  let item = $(this);
  let container = $(this).parent().parent();
  let inputText = container.find(".select-dropdown-control span");
  let inputValues = container.find("input[type='hidden']");
  let isMultiDropdown = $(container).hasClass("multidropdown");
  if(!isMultiDropdown){
    inputValues.val(value);
    inputText.html(label);
    dataValues.forEach(function(dataValue) {
      let splitter = dataValue.split(":");
      let dn = splitter[0];
      let dv = splitter[1];
      console.log(dataValue);
      inputValues.attr(`data-${dn}`, dv);
  });
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
  if(container.find("input[type='hidden']").val().length > 0)
  {
    container.find(".validation-message").html("");
  }
  else{
    container.find(".select-dropdown-control span").html(container.find(".select-dropdown-control").attr("placeholder"));
  }
  return;
});


$(document).on("click", ".remove-product", function(){
  let value = $(this).attr("data-value");
  inputValue = $(this).parent().parent().find("input[type='hidden']").val().split(",");
  let index = inputValue.indexOf(value);
  if (index !== -1) {
      inputValue.splice(index, 1);
  }

  // Join the array back into a string and set it as the value of the hidden input
  $(this).parent().parent().find("input[type='hidden']").val(inputValue.join(","));
  $(this).remove();
  invoiceTotalPrice();
});

$(document).on("input", ".discount-input", function(){
  invoiceTotalPrice();
});
});

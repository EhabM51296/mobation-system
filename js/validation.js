$(document).ready(function () {
  var validationsArray = {
    required: function checkRequired(val) {
      return val.trim() !== "";
    },
    requiredAllowedSpace: function requiredAllowedSpace(val) {
      return val !== "";
    },
    email: function checkEmail(val) {
      let formula = /\w+([-+.'][^\s]+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
      return formula.test(val);
    },
    password: function password(val) {
      let formula = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;
      return formula.test(val);
    },
    positiveInteger: function positiveInteger(val) {
      let formula = /^[0-9]\d*$/;
      return formula.test(val);
    },
    positiveIntegerNotZero: function positiveIntegerNotZero(val) {
      let formula = /^[1-9]\d*$/;
      return formula.test(val);
    },
    positiveNumber: function positiveNumber(val) {
      let formula = /^[0-9]\d*(\.\d+)?$/;
      return formula.test(val);
    },
    percentage: function percentage(val) {
      if (val === '') return true;
      let formula = /^(100(\.0{1,2})?|\d{1,2}(\.\d{1,2})?)$/;
      return formula.test(val);
    }
  };
  $.fn.hasAttr = function (name) {
    return this.attr(name) !== undefined;
  };
  function checkInput(inputId) {
    var errors = 0;
    let input = $(`#${inputId}`);
    let val = input.val();
    let validateList = input.attr("data-validate").split(" ");
    var currentvalidate = "";
    for (let i = 0; i < validateList.length; i++) {
      errors = 0;
      if (validationsArray.hasOwnProperty(validateList[i])) {
        if (!validationsArray[validateList[i]](val)) {
          errors++;
          currentvalidate = validateList[i];
          $(`#validation-message-${inputId}`)
            .html($("#" + inputId).attr(`data-${validateList[i]}`))
            .hide()
            .slideDown();
          input.addClass("invalid");
          input.removeClass("valid");
          return errors;
        }
      }
    }
    input.removeClass("invalid");
    input.addClass("valid");
    $(`#validation-message-${inputId}`).html("");
    return errors;
  }
  // check if a form is valid
  function checkForm(formid) {
    var validityErrors = 0;
    $("#" + formid + " :input.validate-input").each(function () {
      let inputid = $(this).attr("id");
      validityErrors += checkInput(inputid);
    });
    return validityErrors === 0;
  }

  $(document).on(
    "input",
    "input.validate-input, textarea.validate-input",
    function (e) {
      let id = e.target.id;
      checkInput(id);
    }
  );

  $(document).on("submit", "form", function (e) {
    e.preventDefault();
    let formid = $(this).attr("id");
    $(`#${formid} button[type=submit]`).attr("disabled", true);
    let validateForm = checkForm(formid);
    if (validateForm) {
      let datakey = $(`#${formid}`).attr("data-key");
      let method = $(`#${formid}`).attr("method");
      let url = $(`#${formid}`).attr("action");
      let data = new FormData();
      let object = $(`#${formid}`).attr("data-obj");
      data.append("datakey", datakey);
      $("#" + formid + " .data-to-send").each(function () {
        let val = "";
        let name = $(this).attr("name");
        val = $(this).val();
        data.append(name, val);
      });
      let isNotAdd = $(`#${formid}`).hasAttr("data-id");
      if (isNotAdd) {
        data.append("data-id", $(`#${formid}`).attr("data-id"));
      }
      for (var pair of data.entries()) {
        console.log(pair[0] + ", " + pair[1]);
      }
      $.ajax({
        type: method,
        // async: false,
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        url: url,
        success: function (res) {
          console.log(res);
          var d = "";
          try {
            d = JSON.parse(res);
            let status = d.status;
            if (status === 1) {
              showMessageModal("success");
              var dataTable = $(`#${object}-table`).DataTable();
              dataTable.ajax.reload();
              if (!isNotAdd) $(`#${formid}`)[0].reset();
            }
            else if (status === 10) {
              showMessageModal("success");
              updateProfile(d.data);
            }  
            else if (status === 0) {
              showMessageModal("failed", d.data);
            } else {
              showMessageModal("error");
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
    $(`#${formid} button[type=submit]`).attr("disabled", false);
    return false;
  });

  // add/edit prpduct to form
  $(document).on("click", ".add-edit-product-btn", function(){
    let productid = $(this).attr("data-productid");
    let batchInput = $(this).parent().parent().find(".select-dropdown input[type='hidden']");
    let availableCount = parseInt(batchInput.attr("data-count"));
    let price = parseInt(batchInput.attr("data-price"));
    let batchValue = batchInput.val();
    let batchName = $(this).parent().parent().find(".select-dropdown .select-dropdown-control span").html(); 
    let batchErrorMessage = batchInput.attr("data-required");
    let batchInputId = batchInput.attr("id");
    if(batchValue.length === 0)
    $(`#validation-message-${batchInputId}`).html(batchErrorMessage);
    let countInput = $(this).parent().parent().find("input[type='number']");
    let count = parseInt(countInput.val());
    let countErrorMessage = countInput.attr("data-positiveIntegerNotZero");
    let countInputId = countInput.attr("id"); 
    let valueToAdd = batchValue + "_" + count + "_" + productid;
    if(count.toString().length === 0 || count <= 0 || count > availableCount)
      $(`#validation-message-${countInputId}`).html(countErrorMessage);
    if(count.toString().length > 0 && count > 0 && count <= availableCount && batchValue.length > 0)
    {
      $(`#validation-message-${countInputId}`).html("");
      $(`#validation-message-${batchInputId}`).html("");

    let productName = $(this).attr("data-productname");
    let hiddenInputSelectedValuesId = $(this).attr("data-inputid");
    let selectedValues = $(`#${hiddenInputSelectedValuesId}`).val();
    if(selectedValues.length === 0)
    {
      $(`#${hiddenInputSelectedValuesId}`).val(`${valueToAdd}`);
      $(`#${hiddenInputSelectedValuesId}-container`).html(`<button data-value = "${valueToAdd}" class="remove-product flex flex-column" type="button" data-price="${price}">
      <div>${productName}</div>
      <div>${batchName}</div>
      <div>Requested: ${count}</div>
      </button>`)
    }
    else{
      let currentValues = $(`#${hiddenInputSelectedValuesId}`).val().split(",");
      let found = false;
      for (let i = 0; i < currentValues.length; i++) {
        let indexedProductId = currentValues[i].split("_")[2];
        if(indexedProductId === productid)
        {
          currentValues[i] = valueToAdd;
          $(`#${hiddenInputSelectedValuesId}`).val(currentValues);
          $(`#${hiddenInputSelectedValuesId}-container button:eq(${i})`).replaceWith(`<button data-value="${valueToAdd}" class="remove-product flex flex-column gap-5" type="button" data-price="${price}">
          <div>${productName}</div>
          <div>${batchName}</div>
          <div>Requested: ${count}</div>
          </button>`);
          found = true;
          break;

        }
      }
      if(!found)
      {
        $(`#${hiddenInputSelectedValuesId}`).val($(`#${hiddenInputSelectedValuesId}`).val() + `,${valueToAdd}`);
        $(`#${hiddenInputSelectedValuesId}-container`).append(`<button data-value = "${valueToAdd}" class="remove-product flex flex-column gap-5" type="button" data-price="${price}">
        <div>${productName}</div>
        <div>${batchName}</div> 
        <div>Requested: ${count}</div>
        </button>`)
      }
    }
    
    $("#validation-message-add-sales-products-selected").html("");
    invoiceTotalPrice();
    }
    return false;

  });
});

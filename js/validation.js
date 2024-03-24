$(document).ready(function () {
  var validationsArray = {
    required: function checkRequired(val) {
      return val.trim() !== "";
    },
    email: function checkEmail(val) {
      let formula = /\w+([-+.'][^\s]+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
      return formula.test(val);
    },
    password: function password(val) {
      return val.length > 5;
    },
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

  $("form").submit(function (e) {
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
        success: function (data) {
          console.log(data);
          var d = "";
          try {
            d = JSON.parse(data);
            let status = d.status;
            if (status === 1) {
              showMessageModal("success");
              var dataTable = $(`#${object}-table`).DataTable();
              dataTable.ajax.reload();
              if (!isNotAdd) $(`#${formid}`)[0].reset();
            } else if (status === 0) {
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
});

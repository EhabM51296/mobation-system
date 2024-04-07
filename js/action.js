$(document).ready(function(){
    $(document).on("click", ".action-edit",function(){
        let object = $(this).attr("data-obj");
        let id = $(this).closest('tr').data('id');
        $.ajax({
            type: "get",
            // async: false,
            processData: false,
            contentType: false,
            cache: false,
            url: `./backend/models/${object}/${object}.php?action-edit=${object}&id=${id}`,
            success: function (data) {
              try {
                let res = JSON.parse(data);
                let status = res.status;
                let recentData = res.data;
                if(status === 1)
                {
                    $(`#edit-${object}-form`).attr("data-id", id);
                    Object.entries(recentData).forEach((e) => {
                        const [k, v] = e;
                        Object.entries(v).forEach((entry) => {
                            const [key, value] = entry;
                            $(`#edit-${object}-form input[name=${key}]`).val(value);
                        });
                    });
                  $(`#edit-${object}-modal`).fadeIn();
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

    $(document).on("click", ".action-edit-batch",function(){
      let object = $(this).attr("data-obj");
      let id = $(this).closest('tr').data('id');
      $.ajax({
          type: "get",
          // async: false,
          processData: false,
          contentType: false,
          cache: false,
          url: `./backend/models/${object}/${object}.php?action-edit-batch=${object}&id=${id}`,
          success: function (data) {
            try {
              let res = JSON.parse(data);
              let status = res.status;
              let recentData = res.data;
              if(status === 1)
              {
                  $(`#edit-batch-form`).attr("data-id", id);
                  let html = `<div class="grid-2">`;
                  Object.entries(recentData).forEach((e) => {
                      const [k, v] = e;
                      html += `<form data-obj="batch" id="edit-batch-form-${k}" data-key="edit-batch" data-id='${v.id}' method="post"
                      action="./backend/models/products/products.php">
                      <div class="w-full flex flex-column">
                          <div>
                              <input type="text" placeholder="Name: ${v.name}" id="edit-batch-name-${k}" name="name"
                                  class="form-input validate-input data-to-send" data-validate="required"
                                  data-required="Name is required" value='${v.name}' />
                              <div class="validation-message" id="validation-message-edit-batch-name-${k}">
                              </div>
                          </div>
                          <div>
                              <input type="number" placeholder="Count: ${v.count}" id="edit-batch-count-${k}" name="count"
                                  class="form-input validate-input data-to-send" data-validate="positiveInteger"
                                  data-positiveInteger="Count must be a positive integer" value='${v.count}' />
                              <div class="validation-message" id="validation-message-edit-batch-count-${k}">
                              </div>
                          </div>
                          <div>
                              <input type="number" placeholder="Price: ${v.price}" id="edit-batch-price-${k}" name="price"
                                        class="form-input validate-input data-to-send" data-validate="positiveNumber"
                                        data-positiveNumber="Price must be a positive number" value="${v.price}" step="0.1"/>
                              <div class="validation-message" id="validation-message-edit-batch-price-${k}">
                              </div>
                              </div>
                          <div>
                              <input type="date" placeholder="Expiry date: ${v.expiry_date}" id="edit-batch-expiryDate-${k}"
                                  name="expiry_date" class="form-input validate-input data-to-send"
                                  data-validate="required" data-required="Expiry date is required" value='${v.expiry_date}'/>
                              <div class="validation-message" id="validation-message-edit-batch-expiryDate-${k}">
                              </div>
                          </div>
                          <div class="w-full">
                              <button class="bg-active" type="submit">Edit</button>
                          </div>
                      </div></form>`;
                  });
                  html += `</div>`;
                  $("#edit-batch-forms-container").html(html);
                $(`#edit-batch-modal`).fadeIn();
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

    $(document).on("click", ".action-delete",function(){
        let object = $(this).attr("data-obj");
        let id = $(this).closest('tr').data('id');
        $(".delete-data").attr("data-obj", object);
        $(".delete-data").attr("data-id", id);
        $(`#delete-modal`).css("display", "block");
    });

    $(".delete-data").click(function(){
        let id = $(this).attr("data-id");
        let object = $(this).attr("data-obj");
        let data = new FormData();
        data.append("action-delete", object);
        data.append("id", id);
        $.ajax({
            type: "POST",
            // async: false,
            processData: false,
            contentType: false,
            data: data,
            cache: false,
            url: `./backend/models/${object}/${object}.php`,
            success: function (data) {
              try {
                let res = JSON.parse(data);
                let status = res.status;
                if(status === 1)
                {
                  showMessageModal("success", res.data);  
                  $(".modal-container").hide();
                  var dataTable = $(`#${object}-table`).DataTable();
                  dataTable.ajax.reload();
                }
                else
                {
                  showMessageModal("failed", res.data);  
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
});
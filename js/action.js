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
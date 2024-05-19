$(document).ready(function () {
  function createtable(model) {
    var tables = $.fn.dataTable.tables();
    // Loop through each DataTable instance and destroy it if it exists
    $.each(tables, function (index, t) {
      if ($.fn.dataTable.isDataTable(t)) {
        var api = $(t).DataTable();
        if (api) {
          api.destroy();
        }
      }
    });
    var columns = [];
    $(`#${model}-table thead tr:first th`).each(function (index) {
      var columnData = $(this).attr("data-name");
      var orderable = $(this).hasAttr("data-orderable");
      if ($(this).hasAttr("data-image")) {
        columns.push({
          data: columnData,
          render: function (data, type, row) {
            if(data)
            return (
              '<img src="./assets/images/' +
              data +
              '" alt="' +
              row.name +
              '" width="50" height="50" class="image-cell">'
            );
            else return "";
          },
        });
      } else {
        columns.push({
          data: columnData,
          orderable: orderable,
        });
      }
    });
    if ($(`#${model}-table thead tr.filters`).length === 0) {
    $(`#${model}-table thead tr`)
      .clone(true)
      .addClass("filters")
      .appendTo(`#${model}-table thead`);
    }
    // ------------------------------------------------------------------------
    $(`#${model}-table`).DataTable({
      processing: true,
      serverSide: true,
      orderCellsTop: true,
      // fixedHeader: true,
      // fixedHeader:
      //   !/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
      //     navigator.userAgent
      //   ),
      scrollX: true,
      searching: true,
      lengthMenu: [1, 10, 25, 50, 100, 500, 1000, 5000, 10000, 50000, 100000],
      pageLength: 10,
      // dom: "Blfrtip",
      ajax: {
        url: `./backend/models/${model}/${model}.php`,
        type: "get",
        async: false,
        data: function (d) {
          d.datakey = `${model}`;
        },
        dataSrc: function (response) {
            console.log(response.checkdata);
          if (response.error) {
            console.log(response);
            alert("An error occurred: " + response.error);
          } else {
            return response.data;
          }
        },
      },
        columns: columns,
        order: [[0, "asc"]],
      rowCallback: function (row, data) {
          // Add the 'id' to the row's HTML
          $(row).attr("data-id", data.id);
          // if (data.dataColor_hide) {
          //   $(row).css("background-color", data.dataColor_hide);
          //   $(row).css("color", "white");
          // }
        },
      // "pagingType": "full_numbers",
      // language: {
      //     processing: '<div id="custom-loader">Loading...</div>'
      //   },
      initComplete: function () {
        var api = this.api();
        var dataTableContainer = $(api.table().container());

        // For each column
        api
          .columns()
          .eq(0)
          .each(function (colIdx) {
            // if (colIdx == 0) return false;

            // Set the header cell to contain the input element
            var cell = dataTableContainer
              .find(`.filters th`)
              .eq($(api.column(colIdx).header()).index());
            var title = $(cell).text();
            // var filterType = $(cell).data("filter");
            var hasFilter = $(cell).hasAttr("data-filter");
            // if (filterType === "text") {
            if (hasFilter) {
              $(cell).html('<input type="text" placeholder="' + title + '" class="filter-input" />');

              // On every keypress in this input
              $(
                "input",
                dataTableContainer
                  .find(".filters th")
                  .eq($(api.column(colIdx).header()).index())
              ).on("input", function (e) {
                e.stopPropagation();
                var inputField = $(this);
                var regexr = "({search})";
                var cursorPosition = inputField[0].selectionStart;

                api
                  .column(colIdx)
                  .search(
                    inputField.val() !== ""
                      ? regexr.replace(
                          "{search}",
                          "(((" + inputField.val() + ")))"
                        )
                      : "",
                    inputField.val() !== "",
                    inputField.val() === ""
                  )
                  .draw();

                // For mobile devices, focus on input after a slight delay
                if (
                  /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
                    navigator.userAgent
                  )
                ) {
                  setTimeout(function () {
                    inputField.focus();
                  }, 300);
                } else {
                  inputField[0].setSelectionRange(
                    cursorPosition,
                    cursorPosition
                  );
                }
              });
            }
          });
      },
    });
  }

  $(".sidebar-item").click(function () {
    pageid = $(this).attr("data-page");
    $(".page").css("display", "none");
    $(`#${pageid}`).css("display", "block");
    $(`.page-name`).html(pageid);
    $(".sidebar-item").removeClass("clicked");
    $(this).addClass("clicked"); 
    createtable(pageid);
  });
});

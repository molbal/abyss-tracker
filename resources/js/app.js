window.onunload = function(){console.log("unload")};
$(function () {
    $('[data-toggle="tooltip"]').tooltip();

    $(".select2-default").select2({
        theme: 'bootstrap',
        width: '100%'
    }).maximizeSelect2Height();

    $(".select2-nosearch").select2({
        theme: 'bootstrap',
        minimumResultsForSearch: -1,
        width: '100%'
    }).maximizeSelect2Height();

    var buttonCommon = {};
    var buttonExcelCopy = {
        exportOptions: {
            format: {
                body: function ( data, row, column, node ) {
                    // Strip $ from salary column to make it numeric
                    var regex = /^[0-9 ]{1,13} ISK$/;
                    if (data.match(regex)) {
                        replaced = data.match(/\d+/g).join("");
                        console.log("Matched: ", data, " and ", replaced);
                        return replaced;

                    }
                    else {
                        var div = document.createElement("div");
                        div.innerHTML = data;
                        var text = div.textContent || div.innerText || "";
                        return text;
                    }
                }
            }
        }
    };

    $('.datatable').DataTable({
        paginate: false,
        dom: 'Bfrtip',
        buttons: [
            $.extend( true, {}, buttonCommon, {
                extend: 'copyHtml5'
            } ),
            $.extend( true, {}, buttonExcelCopy, {
                extend: 'excelHtml5'
            } )
            // $.extend( true, {}, buttonCommon, {
            //     extend: 'pdfHtml5'
            // } )
        ]
    });
});

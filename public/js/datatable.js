$(document).ready(function () {

    const personnelTable = $('#example').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 10,
        lengthMenu: [5, 10, 20, 50, 100],
        pagingType: "full_numbers",
        filter: false,
        select: {
            style: 'single'
        },
        order: [[1, "desc"]],
        data: [],
        ajax: {
            url: location.origin + "/symfony/symfony5test/public/personnelData",
            type: "POST",
            datatype: "json",
            dataSrc: function (result) {
                console.log("dataSrc", result)
                if (result.data !== null) {
                    return result.data;
                }
                return [];
            },
            data: function (postData) {
                console.log("data", postData);
                return {
                    formFilter: $(".officeSelect").val(),
                    draw: postData.draw,
                    start: postData.start,
                    length: postData.length,
                    order: postData.order,
                    columns: postData.columns,
                    search: postData.search
                };
            },
        },
        columns: [
            {"data": "name"},
            {"data": "position"},
            {"data": "office"},
            {
                name: 'Actions',
                title: 'Actions',
                sortable: false,
                overflow: 'visible',
                className: 'dt-body-center',
                width: 30,
                data: function (row) {
                    let link = "";
                    link += `<a href="#" class="btn btn-sm mr-1"> 
                               <i class="fas fa-edit" style="font-size:14px;color:#5cb85c"></i>
                             </a>`;
                    link += `<a href="#" class="btn btn-sm mr-1">
                               <i class="fas fa-trash-restore" style="font-size:14px;color:red"></i>
                             </a>`;
                    return link;
                }
            },
        ],
    });
    $(".officeSelect").change(function () {
        personnelTable.ajax.reload();
    });
});
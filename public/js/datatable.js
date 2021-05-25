$(document).ready(function () {
    $('#example').DataTable({
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
            url: "http://localhost/symfony/symfony5test/public/personnelData",
            type: "GET",
            datatype: "json",
            dataSrc: function (result) {
                console.log("dataSrc", result)
                return result.data;
            },
            data: function (postData) {
                console.log("data", postData);
                return {
                    formFilter: 'allPersonel',
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
        ],
});
});
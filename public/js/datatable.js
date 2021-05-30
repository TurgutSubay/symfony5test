$(document).ready(function () {

    const personnelTable =  $('#example').DataTable({
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
            type: "GET",
            datatype: "json",
            dataSrc: function (result) {
                console.log("dataSrc", result)
                return result.data;
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
        ],
    });

    $(".officeSelect").change(function () {
        $.ajax({
            url: location.origin + '/symfony/symfony5test/public/personnelData',
            type: "get",
            data: {formFilter:  $(".officeSelect").val()}
        })
            .done(function (response) {
                console.log('Ajax',response.data);
                personnelTable.clear();
                personnelTable.rows.add(response.data).draw();
            })
            .fail(function (e) {
                alert("error"+ e);
            });
    });

    $.ajax({
        url: location.origin + '/symfony/symfony5test/public/officeData',
        type: "get",
        data: {}
    })
        .done(function (response) {
            console.log('Ajax',response.data);
            personnelTable.clear();
            personnelTable.rows.add(response.data).draw();
        })
        .fail(function (e) {
            alert("error"+ e);
        });

});
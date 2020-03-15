
$('#table').bootstrapTable({
    onClickCell: function (field, value, row, $element) {
        let colName = document.getElementsByTagName("th")[field].innerText;
        if (colName !== "Item ID" && colName !== "") {
            let object = $("#confirmItemEdit");
            $("#newValueLabel").html("<span>Change Item "+ row[0] + "<br>" +
                "Original " + colName +": "+ value + "<br>" +
                "New " + colName+":</span><br>");
            object.data("id", row[0]);
            object.data("col-name", colName);
            object.data("old-value", value);
            $('#editValueModal').modal("toggle");
        }
    }
});

$("#confirmItemEdit").click(function () {
    if ($("#newValue").val() != null) {
        let object = $("#confirmItemEdit");
        $.post(
            "editTableAjax",
            {itemID:object.data("id"), oldValue:object.data("old-value"),
                colName:object.data("col-name"), newValue:$("#newValue").val()},
            function (result) {
                window.location.assign(window.location);
            });
    }
});

$('.deleteItem').click(function () {
    $('#itemToDelete').text($(this).data("id")+", "+$(this).data("name"));
    $("#confirmItemDel").data("id", $(this).data("id"));
});

$("#confirmItemDel").click(function () {
    $.post(
        "editTableAjax",
        {itemID:$(this).data("id"), itemDeletion:true},
        function () {
            window.location.assign(window.location);
        });
});

$('#deleteCollection').click(function () {
    $("#confirmCollectionDel").data("id", $(this).data("id"));
});

$("#confirmCollectionDel").click(function () {
    $.post(
        "editTableAjax",
        {collID:$(this).data("id"), collectionDeletion:true},
        function () {
            window.location.assign("welcome");
        });
});
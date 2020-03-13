
$('#table').bootstrapTable({
    onClickCell: function (field, value, row, $element) {
        let colName = document.getElementsByTagName("th")[field].innerText;

        $("#newValueLabel").html("<span>Change Item "+ row[0] + "<br>" + "Original " + colName +": "+ value + "<br>" + "New " + colName+":</span><br>");
        $("#confirmItemEdit").data("id", row[0]);
        $("#confirmItemEdit").data("colName", colName);
        $("#confirmItemEdit").data("oldValue", value);

        if (colName !== "Item ID" && colName !== "") $('#editValueModal').modal("toggle");
    }
});

$("#confirmItemEdit").click(function () {
    if ($("#newValue").val() != null) {
        $.post(
            "editTableAjax",
            {itemID:$("#confirmItemEdit").data("id"), oldValue:$("#confirmItemEdit").data("oldValue"), colName:$("#confirmItemEdit").data("colName"), newValue:$("#newValue").val()},
            function (result) {
                $("#result").html(result);
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
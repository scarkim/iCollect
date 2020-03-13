
$('#table').bootstrapTable({
    onClickCell: function (field, value, row, $element) {
        /*alert(field +', '+ value +', '+ row[0] +', '+ $element[0]);*/
        let colName = document.getElementsByTagName("th")[field].innerText;
        if (colName === "") return;
        if (colName === "Item ID") return;
        let newValue = prompt("Change Item "+ row[0] + "\n" + "Original " + colName +": "+ value + "\n" + "New " + colName+":\n(leave blank to clear the data)");
        if (newValue != null) {
            $.post(
                "editTableAjax",
                {itemID:row[0], oldValue:value, colName:colName, newValue:newValue},
                function (result) {
                    $("#result").html(result);
                    window.location.assign(window.location);
                });
        }
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
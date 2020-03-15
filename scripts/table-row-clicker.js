
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

$("#confirmItemEdit").click(function (event) {
    let value= $("#newValue").val();
    if (value != null && value.match(/^[^<>#@%^*|]+$/) || $.trim(value) === "") {
        let object = $("#confirmItemEdit");
        $.post(
            "editTableAjax",
            {
                itemID: object.data("id"), oldValue: object.data("old-value"),
                colName: object.data("col-name"), newValue: $("#newValue").val()
            },
            function (result) {
                window.location.assign(window.location);
            });
    }
    else {
        event.preventDefault();
        event.stopPropagation();
        document.getElementById("err-edit").innerText =
            "No special characters allowed";
    }
});
//When Cancel button is clicked, clear error messages.
document.getElementById("button-edit").addEventListener("click", function() {
    document.getElementById("err-edit").innerText="";
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
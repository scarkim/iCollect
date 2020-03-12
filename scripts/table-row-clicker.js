
$('#table').bootstrapTable({
    onClickCell: function (field, value, row, $element) {
        /*alert(field +', '+ value +', '+ row[0] +', '+ $element[0]);*/
        let colName = document.getElementsByTagName("th")[field].innerText;
        let newValue;
        if (colName !== "Item ID") {
            newValue = prompt("Change Item "+ row[0] + "\n" + "Original " + colName +": "+ value + "\n" + "New " + colName+":");
        }
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

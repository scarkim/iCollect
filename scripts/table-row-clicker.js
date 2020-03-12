
$('#table').bootstrapTable({
    onClickCell: function (field, value, row, $element) {
        /*alert(field +', '+ value +', '+ row[0] +', '+ $element[0]);*/
        let colName = document.getElementsByTagName("th")[field].innerText;
        let newValue = prompt("Change Item "+ row[0] + "\n" + colName +": "+ row[1] + "\n" + colName+":");
        $.post(
            "editTableAjax",
            {itemID:row[0], oldValue:value, colName:colName, newValue:newValue},
            function (result) {
                $("#result").html(result);
                window.location.reload();
            });
    }
});

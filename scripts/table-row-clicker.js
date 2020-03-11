
$('#table').bootstrapTable({
    onClickCell: function (field, value, row, $element) {
        /*alert(field +', '+ value +', '+ row[0] +', '+ $element[0]);*/
        let colName = document.getElementsByTagName("th")[field].innerText;
        $.post(
            "editTableAjax",
            {itemID:row[0], oldValue:value, colName:colName},
            function (result) {
                $("#result").html(result);
            });
    }
});

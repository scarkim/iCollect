<?php
/** Reads all dreamers form database into table
 *  Nov 8, 2019
 */
//Turn on error reporting -- this is critical!
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
//REQUIRED CONNECTION TO DATABASE
require("/home/skimgree/connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dreamers Summary</title>
    <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
</head>
<body>
<div class="container">
    <?php
    //include admin header file
    include "adminHeader.php";
    ?>
    <h3 class="display-5 text-primary text-center">Dreamers Information Table</h3>
    <?php
    //Define the query
    $sql = 'SELECT `userID`, `active`, `first_name`, `middle_name`, `last_name`, `email`, `phone`, `grad_year`,
                               `birthday`, `college_interest`, `career_aspiration`, `fav_food`, 
                               (SELECT ethnicity.ethnicity_name FROM ethnicity 
                               WHERE ethnicity.ethnicity_id = dreamer.ethnicity_id) as `ethnicity_name`, `ethnicity_other`, `parent_name`, `parent_phone`, `parent_email`
                    FROM dreamer
                    INNER JOIN ethnicity ON dreamer.ethnicity_id = ethnicity.ethnicity_id';
    //    echo "<h3>$sql</h3>";
    //Send the query to the database
    $result = mysqli_query($cnxn, $sql);
    //    var_dump($result);
    ?>
    <!--table to display after admin login-->
    <table id="dreamer-table" class="table table-bordered">
        <thead class="table-dark">
        <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Account Type</th>
        </tr>
        </thead>
        <tbody>
        <?php
        //Print the results
        while ($row = mysqli_fetch_assoc($result)) {
            $userID = $row['userID'];
            $userName = $row['userName'];
            $userEmail = $row['userEmail'];
            $premium = $row['premium'];
            //Array for status pair of key and value
            $accountType = array(
                "0" => "General",
                "1" => "Premium");
            $statusString = '';
            foreach ($accountType as $id2 => $name) {//id2 key and $name is value
                $sel = ($id2 == $premium) ? "selected='selected'" : "";//condition
                $statusString .= "<option value='$id2' $sel>$name</option>";
            }
            echo "<tr>
                                  <td>$userID</td>
                                  <td>$userName</td>
                                  <td>$userEmail</td>
                                  <td>$premium</td>
                            </tr>";
        }
        ?>
        </tbody>
    </table>
    <a href="youthForm.php">Add a new dreamer</a>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
    $('#dreamer-table').DataTable({
        order: [1, 'desc'],//ordered the table as per the latest data
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function (row) {
                        var data = row.data();
                        return 'Details for ' + data[0] + ' ' + data[1];
                    }
                }),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                    tableClass: 'table'
                })
            }
        }
    });
    //able to change out side of data table model
    $('.status').on('change', function () {
        var status = $(this).val();
        var id = $(this).attr('data-id');
        // alert("Status: " + status + ", id: " + id);

        //*** "SLIM" version of JQuery does not support ajax!
        $.post("updateDreamerStatus.php", {status: status, id: id});
    });
    //about to change inside the data table model
    $(document).on( 'click', 'div.dtr-modal select', function () {
        $('.status').on('change', function () {
            var status = $(this).val();
            var id = $(this).attr('data-id');
            // alert("Status: " + status + ", id: " + id);
            //*** "SLIM" version of JQuery does not support ajax!
            $.post("updateDreamerStatus.php", {status: status, id: id});
        });
    } );
</script>
</body>
</html>

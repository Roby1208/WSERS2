<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
</head>
<body>
<?php
include_once "credentials.php";
?>
    <form name="form" method="post" action="">
        <label><strong>Select database</strong></label><br />
        <table border="0" width="60%">
        <tr>
        <?php
        $count = 0;
        $query = mysqli_query($connection,"SELECT * FROM ppl");
        foreach($query as $row){
         $count++;
        ?>
        <td width="3%">
        <select name="users">
            <option value=""></option>
        </select>
        value="<?php echo $row["First_name"]; ?>">
        </td>
        <td width="30%">
        <?php echo $row["Second_name"]; ?>
        </td>
        <?php
        if($count == 3) { // three items in a row
                echo '</tr><tr>';
                $count = 0;
            }
        } ?>
        </tr>
        </table>
        <input type="submit" name="submit" value="Submit">
        </form>
         
        <br />
        <?php echo $status; ?>  
</body>
</html>

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
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "someexample";
    $connection = mysqli_connect($servername, $username, $password, $database);
    ?>
    <form name="form" method="post" action="">
        <label><strong>Select your fruit</strong></label><br />
        <select name="selection">
            <?php
            $i = 0;
            $query = $connection->prepare("SELECT * FROM fullFruitsView");
            $query->execute();
            $result = $query->get_result();
            while ($row = $result->fetch_assoc()) {
                $i++;
            ?>
                <option value="<?php echo $row["Name"]; ?>" <?php
                                                            if (isset($_POST["selection"])) {
                                                                if ($row["Name"] == $_POST["selection"]) {
                                                                    echo "selected";
                                                                }
                                                            }
                                                            ?>><?php echo $row["Name"]; ?></option>
            <?php
            } ?>
        </select>
        <input type="submit" name="submit" value="Submit">
    </form>
    <table>
        <th>
        <td>Name</td>
        <td>Size</td>
        <td>Color</td>
        <td>Description</td>
        <td>Calories</td>
        <td>Price</td>
        </th>

        <?php

        $query = $connection->prepare("SELECT * FROM fullfruitsview WHERE Name=?");
        $query->bind_param("i", $_POST["selection"]);
        $query->execute();
        $result = $query->get_result();
        while ($row = $result->fetch_assoc()) {
        ?>
            <tr>
                <td><?php echo "name: " . $row["Name"]; ?></td>
                <td><?php echo "Size: " . $row["Size"]; ?></td>
                <td><?php echo "Color: " . $row["Color"]; ?></td>
                <td><?php echo "Description: " . $row["Description"]; ?></td>
                <td><?php echo "Calories: " . $row["Calories"]; ?></td>
                <td><?php echo "Price: " . $row["Price"]; ?></td>

            </tr>
    </table>
<?php
        }
?>
</body>

</html>
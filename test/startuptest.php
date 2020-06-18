<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "someExample";
$connection = mysqli_connect($servername, $username, $password, $database);
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<?php
if (isset($_POST["SaveButton"])) {
    $sqlUpdate = $connection->prepare("UPDATE Fruits SET Name=?, Size=?, Color=?, Description=?, Calories=?, Price=? WHERE FruitId=?");
    $sqlUpdate->bind_param(
        "siisiii",
        $_POST["fruitName"],
        $_POST["fruitSize"],
        $_POST["fruitColor"],
        $_POST["fruitDescription"],
        $_POST["fruitCalories"],
        $_POST["fruitPrice"],
        $_POST["fruitId"]
    );
    $sqlUpdate->execute();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>

<body>
    Please select a fruit to edit:
    <form action="startuptest.php" method="post">
        <select name="SelectedFruit">
            <?php
            $sqlStatement = $connection->prepare("SELECT * FROM Fruits");
            $sqlStatement->execute();
            $result = $sqlStatement->get_result();
            while ($row = $result->fetch_assoc()) { ?>
                <option value="<?php print $row["FruitId"]; ?>"> <?php print $row["Name"]; ?></option>
            <?php
            }
            ?>

            <input type="submit" value="Edit" />
    </form>
    <table>
        <tr>
            <th>Name</th>
            <th>Size</th>
            <th>Color</th>
            <th>Description</th>
            <th>Calories</th>
            <th>Price</th>
        </tr>
        <?php
        $sqlStatement = $connection->prepare("SELECT * FROM fullfruitsview");
        $sqlStatement->execute();
        $result = $sqlStatement->get_result();
        while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php print $row["Name"] ?></td>
                <td><?php print $row["SizeText"] ?></td>
                <td><?php print $row["ColorText"] ?></td>
                <td><?php print $row["Description"] ?></td>
                <td><?php print $row["Calories"] ?></td>
                <td><?php print $row["Price"] ?> &euro;</td>
            </tr>
        <?php
        }
        ?>
    </table>
    <?php
    if (isset($_POST["SelectedFruit"])) {
        print "We will display the edit form now";
        $sqlStatement = $connection->prepare("SELECT * FROM Fruits WHERE FruitId=?");
        $sqlStatement->bind_param("i", $_POST["SelectedFruit"]);
        $sqlStatement->execute();
        $result = $sqlStatement->get_result();
        $row = $result->fetch_assoc();
    ?> <form action="startuptest.php" method="post">
            <input name="fruitId" type="hidden" value="<?php print $_POST["SelectedFruit"]; ?>">
            Name of fruit: <input name="fruitName" value="<?php print $row["Name"]; ?>"> <br>
            Size of fruit: <select name="fruitSize"><br>
                <?php
                $sqlStatementSize = $connection->prepare("SELECT * FROM PossibleSizes");
                $sqlStatementSize->execute();
                $resultSize = $sqlStatementSize->get_result();
                while ($rowSize = $resultSize->fetch_assoc()) { ?>
                    <option value="<?php print $rowSize["SizeId"];  ?>" <?php if ($rowSize["SizeId"] == $row["Size"]) {
                                                                            print "selected";
                                                                        } ?>> <?php print $rowSize["SizeText"]; ?> </option>
                <?php }
                ?>
            </select> <br>
            Color of fruit: <select name="fruitColor"><br>
                <?php
                $sqlStatementColors = $connection->prepare("SELECT * FROM PossibleColors");
                $sqlStatementColors->execute();
                $resultColors = $sqlStatementColors->get_result();
                while ($rowColor = $resultColors->fetch_assoc()) { ?>
                    <option value="<?php print $rowColor["ColorId"];  ?>" <?php if ($rowColor["ColorId"] == $row["Color"]) {
                                                                                print "selected";
                                                                            } ?>> <?php print $rowColor["ColorText"]; ?> </option>
                <?php }
                ?>
            </select> <br>
            Description of fruit: <input name="fruitDescription" value="<?php print $row["Description"]; ?>"> <br>
            Calories: <input name="fruitCalories" value="<?php print $row["Calories"]; ?>"> <br>
            Price: <input name="fruitPrice" value="<?php print $row["Price"]; ?>"> <br>
            <input name="SaveButton" type="submit" value="Save">
        </form>
    <?php
    }
    ?>
</body>

</html>
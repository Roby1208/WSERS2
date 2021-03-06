<!DOCTYPE html>
<html>
<?php include_once "credentials.php"; ?>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>List of people in database</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
</head>

<body>
    <form action="countryuser.php" method="post">
        <select name="countrySelect" id="">
            <option value="0">No filter</option>
            <?php
            $query = $connection->prepare("SELECT * FROM countries");
            $query->execute();
            $result = $query->get_result();
            while ($row = $result->fetch_assoc()) { ?>
                <option value="<?php print $row["COUNTRY_ID"]; ?>" <?php if (isset($_POST["countrySelect"])) {
                                                                        if ($_POST["countrySelect"] == $row["COUNTRY_ID"]) {
                                                                            print "selected";
                                                                        }
                                                                    } ?>>
                    <?php print $row["COUNTRY_NAME"]; ?></option>

            <?php }
            ?>
        </select>
        <input type="submit" name="SelectCountry" value="Filter" />
    </form>
    List of people in the database: <br>
    <?php
    $user = 0;
    $displayAll = true;
    if (isset($_POST["countrySelect"])) {
        if ($_POST["countrySelect"] != 0) {
            $displayAll = false;
        }
    }
    if ($displayAll) {
        $sqlSelect = $connection->prepare("SELECT * FROM ppl");
    } else {
        $sqlSelect = $connection->prepare("SELECT * FROM ppl WHERE NATIONALITY=?");
        $sqlSelect->bind_param("i", $_POST["countrySelect"]);
    }
    $sqlSelect->execute();
    $result = $sqlSelect->get_result();
    while ($row = $result->fetch_assoc()) {
        print $row["First_Name"] . " ";
        print $row["Second_Name"] . "<br>";
    }
    ?>

</body>

</html>
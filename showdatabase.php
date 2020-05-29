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
        <select name="selection">
            <?php
            $count = 0;
            $query = $connection->prepare("SELECT * FROM pplcountriesadmin");
            $query->execute();
            $result = $query->get_result();
            while ($row = $result->fetch_assoc()) {
                $count++;
            ?>
                <option value="<?php echo $row["PERSON_ID"]; ?>" <?php
                                                                    if (isset($_POST["selection"])) {
                                                                        if ($row["PERSON_ID"] == $_POST["selection"]) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?php echo $row["UserName"]; ?></option>
            <?php

            } ?>
        </select>
        <input type="submit" name="submit" value="Submit">
    </form>
    <?php

    if (isset($_POST["selection"])) {
        echo "User Display : " . "<br>" . "The " . $_POST["selection"] . " user" . "<br>";
        $query = $connection->prepare("SELECT * FROM pplcountriesadmin WHERE PERSON_ID=?");
        $query->bind_param("i", $_POST["selection"]);
        $query->execute();
        $result = $query->get_result();
        if ($row = $result->fetch_assoc()) {
            echo "Firstname : " . $row["First_Name"] . "<br>";
            echo "Lastname : " . $row["Second_Name"] . "<br>";
            echo "Age : " . $row["Age"] . "<br>";
            echo "Nationality : " . $row["COUNTRY_NAME"] . "<br>";
            echo $row["UserType"];
        }
    }

    ?>
    <br />
</body>

</html>
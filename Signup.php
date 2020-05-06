<?php
include_once "sessionCheck.php";
?>

<html>

<body>
    <?php
    include_once "credentials.php";
    if (isset($_POST["Logout"])) {
        session_unset();
        session_destroy();
        print "You have been logged out";
    } elseif ($_SESSION["UserLogged"]) {
        print "you are already logged in";
    ?>
        <a href="Products.php">Go to our Products Page</a>
        <?php
    } elseif (
        isset($_POST["FirstName"]) &&
        isset($_POST["LastName"]) &&
        isset($_POST["Username"]) &&
        isset($_POST["Password"])
    ) {
        print "You are about to register .... but not yet<BR>";
        $isUserThere = $connection->prepare("SELECT * FROM ppl WHERE UserName=?");
        $isUserThere->bind_param("s", $_GET["Username"]);
        $isUserThere->execute();

        $result = $isUserThere->get_result();
        if ($result->num_rows > 0) {
            print "Your username is already taken ! <BR>";
        } else {

            $stmt = $connection->prepare("INSERT INTO ppl(First_Name,Second_Name,Age,UserName,Password,Nationality,UsrType) VALUES(?,?,?,?,?,?,?)");

            $hashedPassword = password_hash($_POST["Password"], PASSWORD_BCRYPT);
            $userType = 2;
            $stmt->bind_param(
                "ssissii",
                $_POST["FirstName"],
                $_POST["LastName"],
                $_POST["Age"],
                $_POST["Username"],
                $hashedPassword,
                $_POST["Country"],
                $userType
            );
            $stmt->execute();
            print "Yaaay you have registered. Check the database <BR>";
            $_SESSION["UserLogged"] = true;

            $newSelectStatement = $connection->prepare("SELECT PERSON_ID FROM ppl WHERE UserName=?");
            $newSelectStatement->bind_param("s", $_POST["Username"]);
            $newSelectStatement->execute();
            $resultingUser = $newSelectStatement->get_result();
            $rowCurrentId = $resultingUser->fetch_assoc();
            $_SESSION["CurrentUser"] = $rowCurrentId["PERSON_ID"];
        ?><a href="login.php">Go To the login page</a><br>
            <a href="Products.php">Go to our Protuct Page</a><?php
                                                            }
                                                        } else {
                                                                ?>
        <form action="Signup.php" method="post">
            First name: <input type="text" name="FirstName" required><br>
            Last name: <input type="text" name="LastName" required><br>
            Age: <input type="text" name="Age"><br>
            UserName: <input type="text" name="Username" required><br>
            Password: <input type="text" name="Password" required><br>

            <select name="Country">
                <?php
                                                            $stmt = $connection->prepare("SELECT * FROM COUNTRIES");
                                                            $stmt->execute();
                                                            $result = $stmt->get_result();

                                                            if ($result->num_rows > 0) {
                                                                // output data of each row
                                                                while ($row = $result->fetch_assoc()) {
                                                                    echo '<option value="' .
                                                                        $row["COUNTRY_ID"] .
                                                                        '">' .
                                                                        $row["COUNTRY_NAME"] .
                                                                        '</option>';
                                                                }
                                                            } else {
                                                                echo "0 results";
                                                            }
                                                            //$connection->close();
                ?>
            </select>
            <br>
            <input type="submit" name="Register" value="Register">
        </form>
    <?php
                                                        }
    ?>

</body>

</html>
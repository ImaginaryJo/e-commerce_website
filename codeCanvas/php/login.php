<?php
// Start a new session or resume the existing session
session_start();

// Include the database configuration and connection files
require 'database_connection/db_config.php';
require 'database_connection/db_connect.php';

// Check if the user is already logged in
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    echo "<h2>Welcome back to Code Canvas, " . $_SESSION["username"] . "!</h2>";
    echo '<a href="logout.php">Logout</a>';
    exit;
}

// Check if the form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows == 1){
        $stmt->bind_result($id, $username, $hashed_password);
        if($stmt->fetch()){
            if(password_verify($password, $hashed_password)){
                // Store data in session variables
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $id;
                $_SESSION["username"] = $username;

                // Display welcome message
                echo "<h2>Welcome to Code Canvas, " . $_SESSION["username"] . "!</h2>";
                echo '<a href="logout.php">Logout</a>';

            } else{
                // Display an error message if password is not valid
                echo "The password you entered was not valid.";
            }
        }
    } else{
        // Display an error message if username doesn't exist
        echo "No account found with that username.";
    }
    $stmt->close();
}
$conn->close();
?>

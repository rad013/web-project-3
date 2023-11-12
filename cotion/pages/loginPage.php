<?php

$dbHost = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "cotion";


$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $sql = "SELECT * FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            
            header("Location: homePage.html");
            exit;
        } else {
            
            alert("Incorrect password");
        }
    } else {
        
        alert("Email not found");
    }
}

function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/styles/loginStyle.css" />
    <title>Login</title>
  </head>
  <body>
    <img src="assets/cotion-logo.png" alt="logo" />
    <h1 class = "welcome">Welcome to Cotion</h1>

    <div class="form_container">
      <h1>Login</h1>
      <form method="post">
        <div>
          <label for="email">Email</label><br />
          <input type="email" id="email" name="email" />
        </div>
        <div>
          <label for="password">Password</label><br />
          <input type="password" id="password" name="password" />
        </div>

        <input class = "submit" type="submit" value="Login" />
      </form>
      <p>
        Don't have an account?
        <a href="registerPage.php">Sign up</a>
      </p>
    </div>

    <div class="footer">
      <h3>&copy; 2502021310 Muhammad Radityo Wicaksono</h3>
    </div>
  </body>
</html>

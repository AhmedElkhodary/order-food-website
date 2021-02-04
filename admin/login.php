<?php include('../config/CONSTANTS.php'); ?>

<?php

// Check if the user is already logged in, if yes then redirect him to dashboard page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location:" . SITEURL. "admin/index.php");
    exit;
}
 

 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
        
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, user_name, password FROM admin WHERE user_name = :username";
        
        if($stmt = $con->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Check if username exists, if yes then verify password
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $id = $row["id"];
                        $username = $row["user_name"];
                        $hashed_password = $row["password"];
                        if(md5($password) === $hashed_password){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to Dashboard page
                            header("location: index.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            }
            else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }
    
    // Close connection
    unset($con);
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/login.css">	
</head>
<body>
	
<div class="login" >
	<h1>Admin Login</h1>
    <form action="" method="post">
    	<input type="text" name="username" placeholder="Username"  autocomplete="off" />
        <input type="password" name="password" placeholder="Password"  />
        <button type="submit" name="submit" class="btn btn-primary btn-block btn-large">Login</button>
        <div style="text-align: center; padding: 8px; color: #ddd">
        	<?php
        		if(!empty($username_err)) {echo $username_err. "<br>";}
        		if(!empty($password_err)) {echo $password_err;}
        	?>
        </div>
    </form>
</div>	
</body>
</html>


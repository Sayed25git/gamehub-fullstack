<?php
session_start();
include "config.php";
if(!isset($_SESSION['captcha'])){
    $_SESSION['num1'] = rand(1,10);
    $_SESSION['num2'] = rand(1,10);
    $_SESSION['captcha'] = $_SESSION['num1'] + $_SESSION['num2'];
}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $captcha  = trim($_POST['captcha']);

    if((int)$captcha !== (int)$_SESSION['captcha']){
        $error = "Wrong captcha!";

        $_SESSION['num1'] = rand(1,10);
        $_SESSION['num2'] = rand(1,10);
        $_SESSION['captcha'] = $_SESSION['num1'] + $_SESSION['num2'];

    } else {

        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows == 1){

            $row = $result->fetch_assoc();

            if(password_verify($password, $row['password'])){

                $_SESSION['user'] = $row['username'];

                unset($_SESSION['captcha']);

                header("Location: index.php");
                exit();

            } else {
                $error = "Wrong password!";
            }

        } else {
            $error = "User not found!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background:#f2f2f2;">

<div style="width:400px; margin:100px auto; background:white; padding:30px; border-radius:10px;">

<h3 class="text-center">Login</h3>

<?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

<form method="POST">

<input type="text" name="username" class="form-control mb-3" placeholder="Username" required>

<input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

<label>What is <?php echo $_SESSION['num1']; ?> + <?php echo $_SESSION['num2']; ?> ?</label>
<input type="text" name="captcha" class="form-control mb-3" required>

<button class="btn btn-primary w-100">Login</button>

<p class="mt-3 text-center">
Don't have an account? <a href="register.php">Register here</a>
</p>

</form>

</div>

</body>
</html>
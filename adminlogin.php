<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="./Styles/style.adminlogin.css"/>
</head>
<body>

    <?php
    include './db/db.php';
    $successMessage = '';
    $errorMessage = '';
    ob_start();
    session_start();

    if (isset($_SESSION['email'])) {
        header('Location: admin.php');
    }

    if (isset($_POST['submit'])) {
        echo 'test';

        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);

        if ($email == '' || $password == '') {
            echo 'Fields empty';
        }
        $password = md5($password);

        echo $password;

        $query = "SELECT * FROM auth WHERE email = '$email' AND password='$password'";
        $find_user = mysqli_query($connection, $query);

        if (mysqli_num_rows($find_user) == 1) {
            echo 'yes';

            while ($row = mysqli_fetch_assoc($find_user)) {
                echo $email;
                $_SESSION['email'] = $row['email'];
                $_SESSION['loggedin'] = true;
            }
            $successMessage = 'Logged in Successfully';

            header('location:admin.php');
        } else {
            $errorMessage = 'Invalid credentials';
        }
    }
    ?>

   

    <section>
        <div class="form-div">
          
            <h1><img src="./images/user.png" height="100" width="100"/> Admin Login</h1>
            <?php
            include './alert.php';
            error_handler($errorMessage);
            success_handler($successMessage);
            ?>
            <form action="./adminlogin.php" method="POST">
              
                <input type="email" name="email" placeholder="Enter your email"/>
                <input type="password" name="password" placeholder="Enter your password"/>
                <br/>
                <button type="submit" name="submit">Submit</button>
            </form>
        </div>
        <div class="image-page">
            <div class="image-content-div">
                <div class="image-div">
                    <img src="./images/key.png"/>
                </div>
            </div>
            <div>
                <h2>Only Admin can login</h2>
            </div>
        </div>
    
    </section>
</body>
</html>
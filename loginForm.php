<?php

        session_start();

        require_once __DIR__.'/vendor/autoload.php';

        use Dotenv\Dotenv;

        $dotenv = Dotenv::createImmutable(__DIR__);

        $dotenv->safeLoad();

            $DB_HOST = $_ENV['DB_HOST'];
            $DB_PORT = $_ENV['DB_PORT'];
            $DB_NAME = $_ENV['DB_NAME'];
            $DB_USER = $_ENV['DB_USER'];
            $DB_PASSWORD = $_ENV['DB_PASSWORD'];

    try {
         $pdo = new PDO("mysql:host=$DB_HOST;port=$DB_PORT;dbname=$DB_NAME","$DB_USER","$DB_PASSWORD");
         $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    if(isset($_POST['loginBtn'])){


        $userEmail= $_POST['email'];
        $userPassword= $_POST['password'];

        $sql= $pdo->prepare("SELECT email, password FROM users_data WHERE email=:email");
        
        $sqlValues=['email'=>$userEmail];

        $sql->execute($sqlValues);

        $dbUserData= $sql->fetch(PDO::FETCH_ASSOC);
        
        if($dbUserData === false){
            
            echo 'Incorrect email/password!';
            
        }else{
            $isValidPassword = password_verify($userPassword, $dbUserData['password']);
            if($isValidPassword){
                

                $_SESSION['email']= $dbUserData['email'];
                $_SESSION['loggedSince']= time();

                echo 'Welcome back!';
                exit;
            }else{

                echo 'Incorrect email/password!';
            }
            
        }
    } 
    } catch (PDOException $e) {

        echo 'Error: '. $e->getMessage();
}    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   <link href="./styles.css" rel="stylesheet"/>
    <title>PHP practice</title>
</head>
<body>
    <?php
    echo "<h1>Hello</h1>","<h1>World</h1>";
    ?>

    <div class="d-flex flex-column justify-content-center align-items-center" id="signupContainer">
        <div>
            <h5>Login</h5>
        </div>
        <form action="loginForm.php" method="post" class="d-flex flex-column" id="formContainer">
           
      
        <label class="form-label">
            Email:
        </label>
        <input type="email" name="email" class="form-control"/>
        <label class="form-label">
            Password:
        </label>
        <input type="password" name="password" class="form-control"/>
        <button type="submit" name="loginBtn">Login</button>
    </form>
    <div class="d-flex">
        <p class="mx-1">Do not have an account?</p>
        <a href="./signupForm.php">Signup</a>
    </div>
</div>
</body>
</html>
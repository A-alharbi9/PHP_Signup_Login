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

        if(isset($_POST['signupBtn'])){

            $userFirstName= $_POST['firstName'];
            $userLastName= $_POST['lastName'];
            $userEmail= $_POST['email'];
            $userPassword= $_POST['password'];

            $passwordHash= password_hash($userPassword,PASSWORD_ARGON2I);  
        
            $alreadyExists= $pdo->prepare("SELECT * FROM users_data WHERE email=:email");
            $sql= $pdo->prepare("INSERT INTO users_data (firstName, lastName, email, password) VALUES (:firstName,:lastName,:email,:password)");

            $alreadyExistsSqlValues=['email'=>$userEmail];
            $sqlValues=['firstName'=>$userFirstName,'lastName'=>$userLastName,'email'=>$userEmail,'password'=>$passwordHash];
            
            $alreadyExists->execute($alreadyExistsSqlValues);
            $sql->execute($sqlValues);

            if($alreadyExists->rowCount()>0){
                echo 'User already exists!';
            }else{
                
                if($sql->rowCount()>0){

                    echo 'Success';
                    
                }else{

                    echo 'Fail';
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
            <h5>Sign up</h5>
        </div>
        <form action="signupForm.php" method="post" class="d-flex flex-column" id="formContainer">
            <div class="">
                <label class="form-label">
                    First name:
            </label>
            <input type="text" name="firstName" class="form-control"/>
        </div>
        <label class="form-label">
            Last name:
        </label>
        <input type="text" name="lastName" class="form-control"/>
        <label class="form-label">
            Email:
        </label>
        <input type="email" name="email" class="form-control"/>
        <label class="form-label">
            Password:
        </label>
        <input type="password" name="password" class="form-control"/>
        <button type="submit" name="signupBtn">Submit</button>
    </form>
    <div class="d-flex">
        <p class="mx-1">already have an account?</p>
        <a href="./loginForm.php">Login</a>
    </div>
</div>
</body>
</html>
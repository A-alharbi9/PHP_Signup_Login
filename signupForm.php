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

            
            
            $userFirstName= trim($_POST['firstName']);
            $userLastName= trim($_POST['lastName']);
            $userEmail= trim($_POST['email']);
            $userPassword= trim($_POST['password']);
            $userConfirmPassword= trim($_POST['confirmPassword']);

            if(empty($userFirstName)){

                $firstNameError = 'First name is required.';

            }else{

                if(!preg_match('/^[A-Za-z]+$/', $userFirstName)){
                    
                    $firstNameError = 'Invalid first name.';
                    
                }
            }
            if(empty($userLastName)){

                $lastNameError = 'Last name is required.';

            }else{

                if(!preg_match('/^[A-Za-z]+$/', $userLastName)){
                    
                    $lastNameError = 'Invalid last name.';
                    
                }
            }
            if(empty($userEmail)){
                
                 $emailError = 'Email is required.';

            }else{

                if(!preg_match('/([A-Za-z0-9]+@[A-Za-z0-9]+\.[A-Za-z]+)/', $userEmail)){
                    
                    $emailError = 'Invalid email.';
                    
                }
            }
            if(empty($userPassword)){
                
                $passwordError = 'Password is required.';
                
            }else{

                if(!preg_match('/^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{8,})\S$/', $userPassword)){
                    
                    $passwordError = 'Password must contain at least 1 captial letter, 1 small letter and 1 number.';
                    
                }
                
            }
            if(empty($userConfirmPassword)){

                $confirmPasswordError = 'confirm password is required.';
                
            } else{

                if($userConfirmPassword !== $userPassword){
                    
                    $confirmPasswordError = 'Passwords should match.';
                    
                }
            }    
                
            $errors = !isset($firstNameError) && !isset($lastNameError) && !isset($emailError) && !isset($passwordError)&& !isset($confirmPasswordError);
            
            if(!isset($firstNameError) && !isset($lastNameError) && !isset($emailError) && !isset($passwordError)&& !isset($confirmPasswordError)){

                $passwordHash= password_hash($userPassword,PASSWORD_ARGON2I);  
                
                $alreadyExists= $pdo->prepare("SELECT * FROM users_data WHERE email=:email");
                $sql= $pdo->prepare("INSERT INTO users_data (firstName, lastName, email, password) VALUES (:firstName,:lastName,:email,:password)");
                
                $alreadyExistsSqlValues=['email'=>$userEmail];
                $sqlValues=['firstName'=>$userFirstName,'lastName'=>$userLastName,'email'=>$userEmail,'password'=>$passwordHash];
                
                $alreadyExists->execute($alreadyExistsSqlValues);
                $sql->execute($sqlValues);
                
                if($alreadyExists->rowCount()>0){
                    $dbMessageResult = 'User already exists.';
                }else{
                    
                    if($sql->rowCount()>0){
                        
                        $dbMessageResult = 'Success';
                        
                    }else{
                        
                        $dbMessageResult = 'An error occured';

                        }
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
    <title>PHP signup/login</title>
</head>
<body>
    <?php
    echo "<h1 class='my-3' >Hello World</h1>";
    ?>
    
    <div class="d-flex flex-column justify-content-center align-items-center" id="signupContainer">
        <div>
            <h5>Sign up</h5>
        </div>
        <form action="signupForm.php" method="post" class="d-flex flex-column" id="formContainer">
           
                <?php if(isset($dbMessageResult)):
                    echo "<span class=' text-center text-danger font-weight-bold'>$dbMessageResult</span>";
                    endif
                ?>
            
            <div class="d-flex flex-column justify-content-center align-items-start m
            t-2">

                <label class="firstName mb-2" for="firstName">
                    First name:
                </label>
                <input type="text" name="firstName" class="form-control" value="<?php if($errors === false) { echo $userFirstName;} ?>"/> 

            </div>
           
                <?php if(isset($firstNameError)):
                    echo "<span class='text-danger font-weight-bold'>$firstNameError</span>";
                    endif
                ?>

            <div class="d-flex flex-column justify-content-start align-items-start">

            <label class="lastName mb-2" for="lastName">
                    Last name:
                </label>
                <input type="text" name="lastName" class="form-control" value="<?php if($errors === false) { echo $userLastName;} ?>"/>
                
            </div>

                <?php if(isset($lastNameError)):
                    echo "<span class='text-danger font-weight-bold'>$lastNameError</span>";
                    endif
                ?>

            <div class="d-flex flex-column justify-content-center align-items-start">

                <label class="form-label" for="email">
                    Email:
                </label>
                <input type="email" name="email" class="form-control" value="<?php if($errors === false) { echo $userEmail;} ?>"/>

            </div>
           
                <?php if(isset($emailError)):
                    echo "<span class='text-danger font-weight-bold'>$emailError</span>";
                    endif
                ?>

            <div class="d-flex flex-column justify-content-center align-items-start">
                
                <label class="form-label" for="password">
                    Password:
                </label>
                <input type="password" name="password" class="form-control" value="<?php if($errors === false) { echo $userPassword;} ?>"/>
                
            </div>

                <?php if(isset($passwordError)):
                    echo "<span class='text-danger font-weight-bold'>$passwordError</span>";
                    endif
                    ?>

            <div class="d-flex flex-column justify-content-center align-items-start">

                <label class="form-label" for="confirmPassword">
                    Confirm password:
                </label>
                <input type="password" name="confirmPassword" class="form-control" value="<?php if($errors === false) { echo $userConfirmPassword;} ?>"/>

            </div>

                <?php if(isset($confirmPasswordError)):
                    echo "<span class='text-danger font-weight-bold'>$confirmPasswordError</span>";
                    endif
                ?>

        <button type="submit" name="signupBtn">Submit</button>
    </form>
    <div class="d-flex">
        <p class="mx-1">already have an account?</p>
        <a href="./loginForm.php">Login</a>
    </div>
</div>
</body>
</html>
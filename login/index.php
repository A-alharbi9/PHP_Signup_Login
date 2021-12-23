<?php
    if(isset($_POST['loginBtn'])){
try {

    $userEmail= $_POST['email'];
    $userPassword= $_POST['password'];

    echo $userEmail.':'.$userPassword;
    echo '<br>.................</br>';
    echo var_dump($userEmail.':'.$userPassword);

    // $passwordHash= password_hash($userPassword,PASSWORD_ARGON2I);
        //code...
        $pdo = new PDO('mysql:host=localhost;port=3306;dbname=users','root','');
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        
        // $state=$pdo->prepare('select * from users_data ');
        $sql= $pdo->prepare("SELECT email, password FROM users_data WHERE email=:email");
        // $sql= $pdo->prepare("SELECT FROM users_data WHERE (email=?, password=?) VALUES (:firstName,:lastName,:email,:password)");

        //first way
        // $sql->bindParam(':firstName',$userFirstName);
        // $sql->bindParam(':lastName',$userLastName);
        // $sql->bindParam(':email',$userEmail);
        // $sql->bindParam(':password',$passwordHash);

        //second way
        $sqlValues=['email'=>$userEmail];

         echo '<br>.................</br>';
         echo var_dump($sqlValues);
         echo '<br>.................</br>';
        
        // $sql= "INSERT INTO users_data (firstName, lastName, email, password) VALUES ($userFirstName,$userLastName,$userEmail,$userPassword)";
        
        //first way
        // $sql->execute();
        
        //second way
        $sql->execute($sqlValues);

        $dbUserData= $sql->fetch(PDO::FETCH_ASSOC);
        // echo 'user: '. $dbUserData;
        // $test=$state->FetachAll(PDO::FETCH_ASSOC);
        
        if($dbUserData === false){
            
            echo 'Nooooooo!';
            
        }else{
            $isValidPassword = password_verify($userPassword, $dbUserData['password']);
            if($isValidPassword){
                
                echo 'Welcome back!';
            }else{

                echo 'Incorrect email/password!';
            }
            
        }
        
        // echo "Success ";
    } catch (PDOException $e) {
        //throw $th;
        echo 'Error: '. $e->getMessage();
        
    }
}else{
    
}
    
?>
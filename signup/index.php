<?php
    if(isset($_POST['signupBtn'])){
try {

    $userFirstName= $_POST['firstName'];
    $userLastName= $_POST['lastName'];
    $userEmail= $_POST['email'];
    $userPassword= $_POST['password'];

    $passwordHash= password_hash($userPassword,PASSWORD_ARGON2I);
        //code...
        $pdo = new PDO('mysql:host=localhost;port=3306;dbname=users','root','');
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        
        // $state=$pdo->prepare('select * from users_data ');
        $sql= $pdo->prepare("INSERT INTO users_data (firstName, lastName, email, password) VALUES (:firstName,:lastName,:email,:password)");

        //first way
        // $sql->bindParam(':firstName',$userFirstName);
        // $sql->bindParam(':lastName',$userLastName);
        // $sql->bindParam(':email',$userEmail);
        // $sql->bindParam(':password',$passwordHash);

        //second way
        $sqlValues=['firstName'=>$userFirstName,'lastName'=>$userLastName,'email'=>$userEmail,'password'=>$passwordHash];
        
        // $sql= "INSERT INTO users_data (firstName, lastName, email, password) VALUES ($userFirstName,$userLastName,$userEmail,$userPassword)";
        
        //first way
        // $sql->execute();
        
        //second way
        $sql->execute($sqlValues);
        // $test=$state->FetachAll(PDO::FETCH_ASSOC);
        
        // echo "Success ";
    } catch (PDOException $e) {
        //throw $th;
        echo 'Error: '. $e->getMessage();
        
    }
}else{
    
}
    
?>
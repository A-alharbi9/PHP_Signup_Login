<?php
$page = $_SERVER['PHP_SELF'];
$sec = "5";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   <link href="./styles.css" rel="stylesheet"/>
    <title>PHP practice</title>
</head>
<body>
    <?php
    echo "<h1>Hello</h1>","<h1>World</h1>";
    ?>
    
    <?php
    require_once "./signup/index.php";
    ?>
    <div class="d-flex flex-column justify-content-center align-items-center" id="signupContainer">
        <div>
            <h5>Sign up</h5>
        </div>
        <form action="#" method="post" class="d-flex flex-column" id="formContainer">
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
        <button type="submit">Submit</button>
    </form>
</div>
</body>
</html>
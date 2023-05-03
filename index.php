<?php


require "broker.php";
require "model/user.php";
session_start();

if (isset($_POST['username']) && isset($_POST['password'])) {
    $uname = $_POST['username'];
    $upass = $_POST['password'];
    
    $user = new User(1, $uname, $upass);
    $odg = User::logInUser($user, $conn);
    
    if (!empty($odg)) {
        $_SESSION['user_id'] = $odg['userID'];
        $_SESSION['user_name'] = $odg['username'];
        header('Location: home.php');
        exit();
    } else {
        echo "<script>alert('Korisnik ne postoji!')</script>";
    }

   
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css?<?php echo time(); ?>">
    <link href="https://www.dafontfree.net/embed/c3BlY2lmeS1wZXJzb25hbC1ub3JtYWwtYmxhY2smZGF0YS81Mi9zLzE1Njg5Ny9TcGVjaWZ5UEVSU09OQUwtTm9ybUJsYWNrLnR0Zg"
          rel="stylesheet" type="text/css"/>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Pocetna</title>
</head>

<body>
<header>
    <nav><a href="index.php" class="logo">Ananas</a>
    </nav>

</header>

<section class="heroSection">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <form action="#" method="post">
                    <h1 class="prijava">Prijava</h1>
                    <label class="username">Username</label>
                    <input type="text" name="username" class="form-control" required>
                    <br>
                    <label for="password" class="password">Password:</label>
                    <input type="password" name="password" class="form-control" required>
                    <button type="submit" name="submit">Prijava</button>
                </form>
            </div>
        </div>
    </div>
</section>


</body>

</html>
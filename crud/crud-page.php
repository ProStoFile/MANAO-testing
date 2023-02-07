<?php
session_start();
if (!isset($_SESSION['user'])) {
    if (!isset($_COOKIE['user'])) {
        header("location: ../login.php");
        exit();
    }
}

if (isset($_GET['logout'])) {
    unset($_SESSION['user']);
    if (isset($_COOKIE['user'])) {
        unset($_COOKIE['user']);
        setcookie('user', null, -1, '/');
        header("location: ../login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/crud-styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <script src="/script/script.js"></script>
    <title>CRUD</title>
</head>
<body onload="fetch();">
<h2>Hello <?php echo $_SESSION['user']; ?></h2>
<div class="link-to-login">
    <a href="?logout">Выйти из учетной записи</a>
</div>
<h2>CRUD операции над бд</h2>
<div id="msg" class="msg"></div>
<div id="result"></div>

<div class="link-to-account">
    <a href="../account.php">Назад</a>
</div>

</body>
</html>
<?php
session_start();
if (!$_SESSION['user']) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Профиль</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>


<body>
    <div class="container-fluid mt-2">
        <h2>Hello <?php echo $_SESSION['user']['name']; ?></h2>
        <form action="logout.php" method="post">
            <button class="btn btn-primary mt-5" type="submit">Logout</button>
        </form>
    </div>

</body>

</html>
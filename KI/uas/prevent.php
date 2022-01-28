<?php

if (isset($_POST['username'])) {
    $db = new PDO('mysql:host=localhost;dbname=sql_injection_test', 'root', '');

    $username = $_POST['username'];

    $user = $db->prepare("SELECT * FROM users WHERE username = :username");
    $user->execute([
        'username' => $username,
    ]);

    if ($user->rowCount()) {
        $result = $user->fetch(PDO::FETCH_OBJ);
        echo 'Username: ' . $username . '<br>';
        echo 'Nama: ' . $result->firstname . ' ' . $result->lastname;
        die();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prevent Injection Form</title>
</head>

<body>
    <form action="inject.php" method="post">
        <div>
            <label for="username">Username: </label>
            <input type="text" name="username" id="username">
            <input type="submit">
        </div>
    </form>
</body>

</html>
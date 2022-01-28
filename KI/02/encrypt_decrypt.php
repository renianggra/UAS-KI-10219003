<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];     // Password dari user
    $pKey = $_POST['privateKey'];       // Key dari user
    $usertext = $_POST['usertext'];     // Text dari user // $data
    $action = $_POST['action'];

    if (empty($password) || empty($pKey) || empty($usertext)) {
        header('Location: ./encrypt_decrypt.php');
        exit;
    } else {
        $encrypt_method = 'aes-128-cbc';                // $cipher_algo
        $key = hash('sha256', $password);               // $passphrase
        $iv = substr(hash('sha256', $pKey), 0, 16);     // $iv

        if ($action == 'encrypt') {
            $output = openssl_encrypt($usertext, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        }
        else if ($action == 'decrypt') {
            $usertext = base64_decode($usertext);
            $output = openssl_decrypt($usertext, $encrypt_method, $key, 0, $iv);
        }
        else {
            header('Location: ./encrypt_decrypt.php');
            exit;
        }
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

    <title>Enkripsi dan Dekripsi</title>

    <style>
        .success-text {
            margin-top: .25rem;
            font-size: .875em;
            color: #198754;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="my-5">
        <h2 class="fw-bold mb-3">Enkripsi &amp; Dekripsi</h2>
        <form action="./encrypt_decrypt.php" method="post">
            <div class="row mb-3">
                <div class="col">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="password" id="password" minlength="4" maxlength="30" value="<?php echo $password ?? null ?>" required>
                        <button class="btn btn-outline-secondary" type="button" id="pwdBtnGen" onclick="randomString('password', 4, 30)">Random</button>
                    </div>
                </div>
                <div class="col-4">
                    <label for="privateKey" class="form-label">Private Key</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="privateKey" id="privateKey" minlength="3" maxlength="10" value="<?php echo $pKey ?? null ?>" required>
                        <button class="btn btn-outline-secondary" type="button" id="keyBtnGen" onclick="randomString('privateKey', 3, 10)">Random</button>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="usertext" class="form-label">Text</label>
                <textarea class="form-control" name="usertext" id="usertext" rows="5" minlength="1" required><?php echo $output ?? null ?></textarea>
            </div>
            <div class="mt-3 text-end">
                <button type="submit" name="action" value="encrypt" class="btn btn-primary me-2">Enkripsi</button>
                <button type="submit" name="action" value="decrypt" class="btn btn-primary">Dekripsi</button>
            </div>
        </form>
    </div>
</div>
<script>
    function randomString($string, $min, $max) {
        const result = Math.random().toString(36).substring($min,$max);
        document.getElementById($string).value = result;
    }
</script>
</body>
</html>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $keyBits = $_POST['keyBits'];
    $keyType = $_POST['keyType'];

    $config = [
        // Config OpenSSL dari XAMPP
        'config' => 'C:/xampp/php/extras/openssl/openssl.cnf',

        // Ubah Default Config
        'default_md' => 'sha512',
        'private_key_bits' => intval($keyBits),
        'private_key_type' => intval($keyType),
    ];

// keypair
    $keypair = openssl_pkey_new($config);

// Private key
    openssl_pkey_export($keypair, $privKey, NULL, $config);

// Public key
    $publickey = openssl_pkey_get_details($keypair);
    $pubKey = $publickey["key"];
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

    <title>RSA Public &amp; Private Key</title>
</head>
<body>
<div class="container">
    <div class="my-5">
        <h2 class="fw-bold">Public &amp; Private Key</h2>
    </div>
    <div class="my-5">
        <form action="./pubprikey.php" method="POST">
            <div class="row row-cols-3">
                <div>
                    <label for="keyBits" class="form-label fw-bold">Key Bits</label>
                    <select class="form-select" name="keyBits">
                        <?php if(!empty($keyBits)){ echo '<option value="'.$keyBits.'" selected>'.$keyBits.'</option>'; } ?>
                        <optgroup label="Pilihan">
                            <option value="512">512</option>
                            <option value="1024">1024</option>
                            <option value="2048">2048</option>
                            <option value="4096">4096</option>
                        </optgroup>
                    </select>
                </div>
                <div>
                    <label for="keyType" class="form-label fw-bold">Key Type</label>
                    <select class="form-select" name="keyType">
                        <?php if(!empty($keyType)){ echo '<option value="'.$keyType.'" selected>'.$keyType.'</option>'; } ?>
                        <optgroup label="Pilihan">
                            <option value="0">OPENSSL_KEYTYPE_RSA</option>
                            <option value="1">OPENSSL_KEYTYPE_DSA</option>
                        </optgroup>
                    </select>
                </div>

                <div class="d-flex justify-content-center align-items-end">
                    <button type="submit" class="btn btn-primary">Generate Key</button>
                </div>
            </div>
        </form>
    </div>
    <div class="my-5">
        <div class="mb-5">
            <h4 class="mb-2">Private Key</h4>
            <textarea class="form-control font-monospace" rows="20"><?php echo $privKey ?? null ?></textarea>
        </div>
        <div>
            <h4 class="mb-2">Public Key</h4>
            <textarea class="form-control font-monospace" rows="20"><?php echo $pubKey ?? null ?></textarea>
        </div>
    </div>
</div>
</body>
</html>

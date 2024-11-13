<?php
require 'vendor/autoload.php';

use PhpXmlRpc\Client;
use PhpXmlRpc\Value;
use PhpXmlRpc\Request;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get values from the form input
    $a = isset($_POST['a']) ? intval($_POST['a']) : 0;
    $b = isset($_POST['b']) ? intval($_POST['b']) : 0;
    $c = isset($_POST['c']) ? intval($_POST['c']) : 0;

    // Create an XML-RPC client
    $client = new Client('http://localhost:8000');

    // Prepare parameters for the Penjumlahan function
    $params = [
        new Value($a, 'int'),
        new Value($b, 'int'),
        new Value($c, 'int'),
    ];

    // Create a request object
    $request = new Request('PrediksiGender', $params);

    // Send the request and get the result
    try {
        $response = $client->send($request);
        if ($response->faultCode()) {
            $result = "Error: " . $response->faultString();
        } else {
            $result = "Result: " . $response->value()->scalarval();
        }
    } catch (Exception $e) {
        $result = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XML-RPC Client</title>
</head>
<style>
    * {
        overflow: hidden;
    }

    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;900&display=swap');

    input {
        caret-color: red;
    }

    body {
        margin: 0;
        width: 100vw;
        height: 100vh;
        background-image: url('https://img.freepik.com/free-photo/social-media-background-twitte_135149-69.jpg?t=st=1731518648~exp=1731522248~hmac=ab1f4a339a1d6b8e815b29fb8ee1f7660a8371b62cf912d75acaca95c046d8e8&w=1380');
        display: flex;
        align-items: center;
        text-align: center;
        justify-content: center;
        place-items: center;
        overflow: hidden;
        font-family: poppins;
    }

    .container {
        position: relative;
        width: 350px;
        height: 500px;
        border-radius: 20px;
        padding: 40px;
        box-sizing: border-box;
        background: #ecf0f3;
        box-shadow: 14px 14px 20px #cbced1, -14px -14px 20px white;
    }

    .brand-logo {
        height: 100px;
        width: 100px;
        background: url("https://img.icons8.com/color/100/000000/twitter--v2.png");
        margin: auto;
        border-radius: 50%;
        box-sizing: border-box;
        box-shadow: 7px 7px 10px #cbced1, -7px -7px 10px white;
    }

    .brand-title {
        margin-top: 10px;
        font-weight: 900;
        font-size: 1.8rem;
        color: #1DA1F2;
        letter-spacing: 1px;
    }

    .inputs {
        text-align: left;
        margin-top: 30px;
    }

    label,
    input,
    button {
        display: block;
        width: 100%;
        padding: 0;
        border: none;
        outline: none;
        box-sizing: border-box;
    }

    label {
        margin-bottom: 4px;
    }

    label:nth-of-type(2) {
        margin-top: 12px;
    }

    input::placeholder {
        color: gray;
    }

    input {
        background: #ecf0f3;
        padding: 10px;
        padding-left: 20px;
        height: 50px;
        font-size: 14px;
        border-radius: 50px;
        box-shadow: inset 6px 6px 6px #cbced1, inset -6px -6px 6px white;
    }

    button {
        color: white;
        margin-top: 20px;
        background: #1DA1F2;
        height: 40px;
        border-radius: 20px;
        cursor: pointer;
        font-weight: 900;
        box-shadow: 6px 6px 6px #cbced1, -6px -6px 6px white;
        transition: 0.5s;
    }

    button:hover {
        box-shadow: none;
    }

    a {
        position: absolute;
        font-size: 8px;
        bottom: 4px;
        right: 4px;
        text-decoration: none;
        color: black;
        background: yellow;
        border-radius: 10px;
        padding: 2px;
    }

    h1 {
        position: absolute;
        top: 0;
        left: 0;
    }
</style>

<body>
    <div class="container">
        <form method="POST" id="form">
            <div class="brand-title">RPC Test</div>
            <div class="brand-title">"Prediksi Gender"</div>
            <div class="inputs">
                <label>Tinggi :</label>
                <input type="number" id="a" name="a" required>
                <label>Berat :</label>
                <input type="number" id="b" name="b" required>
                <label>Ukuran Sepatu :</label>
                <input type="number" id="c" name="c" required>
                <button type="submit">Mulai Prediksi</button>
            </div>
        </form>
    </div>

    <?php if (isset($result)): ?>
        <script>
            alert("<?= $result; ?>");
        </script>
    <?php endif ?>

</body>

</html>
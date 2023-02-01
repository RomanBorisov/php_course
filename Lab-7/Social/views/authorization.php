<?php

declare(strict_types=1);

/** @var Social\Http\ViewModels\AuthorizationViewModel $model */

use Social\AuthorizationService;

?>
<html lang="en">
<head>
    <style type="text/css">
        form {
            margin: 0 auto;
            width: 400px;
            padding: 1em;
            border: 1px solid #ccc;
            border-radius: 1em;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        form li + li {
            margin-top: 1em;
        }

        label {
            display: inline-block;
            width: 90px;
            text-align: right;
        }

        input,
        textarea {
            font: 1em sans-serif;
            width: 300px;
            box-sizing: border-box;
            border: 1px solid #999;
        }

        input:focus,
        textarea:focus {
            border-color: #000;
        }

        textarea {
            vertical-align: top;
            height: 5em;
        }

        .button {
            padding-left: 90px;
        }

        button {
            margin-left: 0.5em;
        }
    </style>
    <title>Sign In</title>
</head>
<body>
<?php
if (AuthorizationService::isAuthorized()) {
    echo "<h3> {$model->message}</h3>";
} else {
?>
<form name="authorization" method="POST" action="authorization">
    <ul>
        <li>
            <label for="username">Name:</label>
            <input type="text" name="name" id="username" required/>
        </li>
        <li>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required minlength="6"/>
        </li>
        <li class="button">
            <input type="submit" value="Sig in">
        </li>
    </ul>
</form>
</body>
</html>
<?php
} ?>

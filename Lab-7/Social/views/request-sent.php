<?php

declare(strict_types=1);

/** @var Social\Http\ViewModels\RequestSentViewModel $model */

?>
<html lang="en">
<head>
    <title>Request sent></title>
</head>
<body>
<a href="/">Home page</a>

<?php
if ($model->message !== null) {
    echo $model->message;
} else { ?>
    <p>
        Friendship request sent to <?php echo $model->name; ?>.
    </p>
<?php } ?>
</body>
</html>

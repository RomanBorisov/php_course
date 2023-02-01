<?php

declare(strict_types=1);

/** @var Social\Http\ViewModels\PostCreatedViewModel $model */

?>
<html lang="en">
<head>
    <title>Post created</title>
</head>
<body>
<a href="/">Home page</a>

<p>
    Post created by <?php echo $model->name; ?>.
</p>
<a href="/create-post">Create another one post</a>
</body>
</html>

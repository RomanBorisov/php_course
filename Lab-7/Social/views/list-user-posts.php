<?php

declare(strict_types=1);

/** @var Social\Http\ViewModels\UserPostsViewModel $model */

?>
<html lang="en">
<head>
    <title>My posts</title>
</head>
<body>
<a href="/">Home page</a>

<h3>My posts:</h3>
<ul>
    <?php
    foreach ($model->posts as $post) {
        ?>
        <li>
            Text: <strong><?php echo $post->text; ?></strong>
            <br>
            Likes: <strong><?php echo $post->numberLikes ?></strong>
            <a href="/remove-post?postId=<?php echo $post->id; ?>">Remove</a>,
            <a href="/like-post?postId=<?php echo $post->id; ?>">Like</a>
        </li>
    <?php } ?>
</ul>
<a href="/create-post">Create post</a>
</body>
</html>

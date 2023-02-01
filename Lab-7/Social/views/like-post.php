<?php

declare(strict_types=1);

header("Location: {$_SERVER['HTTP_REFERER']}", true, 303);
exit();

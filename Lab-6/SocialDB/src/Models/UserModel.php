<?php

declare(strict_types=1);

namespace SocialDB\Models;

class UserModel
{
    public int $id;
    public string $name;
    public int $gender;
    public string $dateOfBirth;
    public string $lastVisit;
    public bool $online;
}

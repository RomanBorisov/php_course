<?php

declare(strict_types=1);

namespace Social\Models;


class UserModel
{
    public int $id;
    public string $name;
    public bool $gender;
    public string $dateOfBirth;
    public string $lastVisit;
    public bool $online;
    public string $password;
}

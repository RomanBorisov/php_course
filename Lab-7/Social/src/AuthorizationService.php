<?php

declare(strict_types=1);

namespace Social;

use Social\DataAccess\PdoFactory;
use Social\DataAccess\UserRepository;

class AuthorizationService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        require_once __DIR__ . '/../public/bootstrap.php';

        $pdo = PdoFactory::createFromEnv();
        $this->userRepository = new UserRepository($pdo);
    }

    public function authorize(string $name, string $password): void
    {
        if ($this->userRepository->checkUserExist($this->userRepository->getIdByName($name))) {
            $user = $this->userRepository->getUserById($this->userRepository->getIdByName($name));

            if (password_verify($password, $user->password)) {
                session_start();
                $_SESSION['isAuthorized'] = true;
                $_SESSION['userName'] = $name;
                $_SESSION['userId'] = $user->id;
            } else {
                $_SESSION['isAuthorized'] = false;
                throw new \Exception('Invalid password');
            }
        }

        throw new \Exception('User with this name was not found');
    }

    public static function isAuthorized(): bool
    {
        return $_SESSION['isAuthorized'] ?? false;
    }

    public static function checkUserIsAuthorized(): void
    {
        if (!self::isAuthorized()) {
            throw new \Exception('User is not logged in');
        }
    }

    public static function getUserId(): int
    {
        return $_SESSION['userId'];
    }

    public static function getUserName(): string
    {
        return $_SESSION['userName'];
    }

    public static function exit(): void
    {
        $_SESSION = array();
        session_destroy();
    }
}

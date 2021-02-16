<?php

namespace Core\Auth;

use Core\DIContainer;
use Core\ErrorContainer\ErrorContainerTrait;

class Auth
{
    use ErrorContainerTrait;

    private static $instance;
    private $auth_service;

    private function __construct()
    {
        $db = DIContainer::i()->get('db');
        $this->auth_service = new \Delight\Auth\Auth($db);
    }

    public static function i(): self
    {
        if (!static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function createUser(string $username, string $password, string $email): int
    {
        return $this->auth_service->admin()->createUser($email, $password, $username);
    }

    public function login(string $username, string $password): bool {
        if ($this->auth_service->isLoggedIn()) {
            $this->addError('auth', 'User is already logged in');
            return false;
        }
        try {
            $this->auth_service->loginWithUsername($username, $password);
            return true;
        }
        catch (\Delight\Auth\UnknownUsernameException $e) {
            $this->addError('username', 'Wrong username');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            $this->addError('password', 'Wrong password');
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
            $this->addError('email', 'Email not verified');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            $this->addError('auth', 'Too many requests');
        }
        return false;
    }

    public function logout() {
        $this->auth_service->logOut();
    }

    public function getUser(): UserEntity
    {
        $is_guest = !$this->auth_service->isLoggedIn();
        $entity = new UserEntity($is_guest);
        if ($is_guest) {
            return $entity;
        }
        $entity->setId($this->auth_service->getUserId());
        $entity->setUsername($this->auth_service->getEmail());
        $entity->setEmail($this->auth_service->getUsername());
        return $entity;
    }
}
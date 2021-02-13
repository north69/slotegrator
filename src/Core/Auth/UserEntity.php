<?php

namespace Core\Auth;

class UserEntity implements \JsonSerializable
{
    private $id;
    private $username;
    private $email;

    private $is_guest;

    public function __construct(bool $is_guest)
    {
        $this->is_guest = $is_guest;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function isGuest(): bool
    {
        return $this->is_guest;
    }


    public function jsonSerialize()
    {
        if ($this->is_guest) {
            return null;
        }
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
        ];
    }
}
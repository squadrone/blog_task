<?php

namespace Project\Entities;

use Project\Application;
use Project\Services\QueryBuilder;

class User
{
    use QueryBuilder;

    private int $id = 0;
    private string $username;
    private string $password;
    private UserStatus $status = UserStatus::PENDING_CONFIRMATION;

    public function __construct()
    {
        $this->tableName = 'user';
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

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $this->$password;
    }

    public function getStatus(): UserStatus
    {
        return $this->status;
    }

    public function setStatus(UserStatus $status): void
    {
        $this->status = $status;
    }

    public function save(): bool {
        $connection = Application::getInstance()->getDatabase()->getConnection();
        $sql = "";
        $params = [];
        if ($this->id === 0) {
            $sql = $this->insertQuery(['username', 'password']);
            dump($sql);
            die;
            $params = [
                'username' => $this->username,
                'password' => $this->password,
            ];
        } else {
            $sql = $this->updateQuery(['username', 'password']);
            dump($sql);
            die;
            $params = [
                'username' => $this->username,
                'password' => $this->password,
            ];
        }
        $stmt = $connection->prepare($sql);
        return $stmt->execute($params) === true;
    }
}


<?php

namespace Database\DataAccess\Implementations;

use Database\DataAccess\Interfaces\UserDAO;
use Database\DatabaseManager;
use Models\DataTimeStamp;
use Models\User;

class UserDAOImpl implements UserDAO
{
    public function create(User $user, string $password): bool
    {
        if ($user->getId() !== null) throw new \Exception('Cannot create a user with an existing ID. id: ' . $user->getId());

        $mysqli = DatabaseManager::getMysqliConnection();

        $query = "INSERT INTO users (username, email, password, company) VALUES (?, ?, ?, ?)";

        $result = $mysqli->prepareAndExecute(
            $query,
            'ssss',
            [
                $user->getUsername(),
                $user->getEmail(),
                password_hash($password, PASSWORD_DEFAULT), // store the hashed password
                $user->getCompany()
            ]
        );

        if (!$result) return false;

        $user->setId($mysqli->insert_id);

        return true;
    }

    public function update(User $user, string $password, ?string $emailConfirmedAt): bool
    {
        if ($user->getId() === null) throw new \Exception('The specified user has no ID.');
       
        $mysqli = DatabaseManager::getMysqliConnection();

        $query = 
        <<<SQL
            INSERT INTO users (id, username, email, password, email_confirmed_at, company)
            VALUES (?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE id = ?,
            username = VALUES(username), 
            email = VALUES(email),
            password = VALUES(password),
            email_confirmed_at = VALUES(email_confirmed_at),
            company = VALUES(company);
        SQL;

        $result = $mysqli->prepareAndExecute(
            $query,
            'isssssi',
            [
                $user->getId(),
                $user->getUsername(),
                $user->getEmail(),
                $password,
                $emailConfirmedAt,
                $user->getCompany(),
                $user->getId()
            ]
        );
       
        if (!$result) return false;

        $user->setEmailConfirmedAt($emailConfirmedAt);
        error_log("get_Email_At : ".$user->getEmailConfirmedAt());

        return true;
    }

    private function getRawById(int $id): ?array{
        $mysqli = DatabaseManager::getMysqliConnection();

        $query = "SELECT * FROM users WHERE id = ?";

        $result = $mysqli->prepareAndFetchAll($query, 'i', [$id])[0] ?? null;

        if ($result === null) return null;

        return $result;
    }

    private function getRawByEmail(string $email): ?array{
        $mysqli = DatabaseManager::getMysqliConnection();

        $query = "SELECT * FROM users WHERE email = ?";

        $result = $mysqli->prepareAndFetchAll($query, 's', [$email])[0] ?? null;

        if ($result === null) return null;
        return $result;
    }

    private function rawDataToUser(array $rawData): User{
        return new User(
            username: $rawData['username'],
            email: $rawData['email'],
            id: $rawData['id'],
            company: $rawData['company'] ?? null,
            emailConfirmedAt: $rawData['email_confirmed_at'] ?? null,
            timeStamp: new DataTimeStamp($rawData['created_at'], $rawData['updated_at'])
        );
    }

    public function getById(int $id): ?User
    {
        $userRaw = $this->getRawById($id);
        if($userRaw === null) return null;

        return $this->rawDataToUser($userRaw);
    }

    public function getByEmail(string $email): ?User
    {
        $userRaw = $this->getRawByEmail($email);
        if($userRaw === null) return null;

        return $this->rawDataToUser($userRaw);
    }

    public function getHashedPasswordById(int $id): ?string
    {
        return $this->getRawById($id)['password']??null;
    }
}
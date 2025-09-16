<?php
namespace Models;

use Core\Model;

class User extends Model {
    public function create($login, $password) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (login, password_hash) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$login, $passwordHash]);
    }

    public function findByLogin($login) {
        $sql = "SELECT * FROM users WHERE login = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$login]);
        return $stmt->fetch();
    }

    public function findAllExcept($exceptUserId) {
    $sql = "SELECT id, login FROM users WHERE id != ? ORDER BY login";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$exceptUserId]);
    return $stmt->fetchAll();
}
public function findById($id)
{
    $sql = "SELECT id, login FROM users WHERE id = ?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch();
}
}
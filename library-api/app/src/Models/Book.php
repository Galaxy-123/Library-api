<?php
namespace Models;

use Core\Model;

class Book extends Model {
    public function findByUserId($user_id) {
        $sql = "SELECT id, title, created_at FROM books WHERE user_id = ? AND deleted_at IS NULL ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    }
    
    public function findById($id) {
        $sql = "SELECT * FROM books WHERE id = ? AND deleted_at IS NULL";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($user_id, $title, $content) {
        $sql = "INSERT INTO books (user_id, title, content) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$user_id, $title, $content]);
    }
    
    public function softDelete($id) {
        $sql = "UPDATE books SET deleted_at = NOW() WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    public function update($id, $title, $content) {
        $sql = "UPDATE books SET title = ?, content = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$title, $content, $id]);
    }
    public function findDeletedByUserId($user_id) {
    $sql = "SELECT id, title, created_at, deleted_at 
            FROM books 
            WHERE user_id = ? AND deleted_at IS NOT NULL 
            ORDER BY deleted_at DESC";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$user_id]);
    return $stmt->fetchAll();
}

    public function restore($id) {
    $sql = "UPDATE books SET deleted_at = NULL WHERE id = ?";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([$id]);
}
public function deleteForever($id) {
    $sql = "DELETE FROM books WHERE id = ?";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([$id]);
}
}
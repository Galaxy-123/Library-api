<?php
namespace Models;

use Core\Model;

class SharedAccess extends Model {
    public function grantAccess($ownerId, $guestId) {
        $sql = "INSERT INTO shared_access (owner_id, guest_id) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        try {
            return $stmt->execute([$ownerId, $guestId]);
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function getSharedUsers($ownerId) {
        $sql = "SELECT u.id, u.login 
                FROM shared_access sa 
                JOIN users u ON sa.guest_id = u.id 
                WHERE sa.owner_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$ownerId]);
        return $stmt->fetchAll();
    }

    public function hasAccess($ownerId, $guestId) {
        $sql = "SELECT COUNT(*) as count 
                FROM shared_access 
                WHERE owner_id = ? AND guest_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$ownerId, $guestId]);
        $result = $stmt->fetch();
        return $result['count'] > 0;
    }

    public function getAccessibleLibraries($guestId) {
        $sql = "SELECT u.id, u.login 
                FROM shared_access sa 
                JOIN users u ON sa.owner_id = u.id 
                WHERE sa.guest_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$guestId]);
        return $stmt->fetchAll();
    }
    public function revokeAccess($ownerId, $guestId)
{
    $sql = "DELETE FROM shared_access WHERE owner_id = ? AND guest_id = ?";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([$ownerId, $guestId]);
}
}
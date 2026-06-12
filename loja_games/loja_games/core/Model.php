<?php
abstract class Model {
    protected PDO $db;
    protected string $table = '';
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    public function findAll(): array {
        return $this->db->query("SELECT * FROM {$this->table} ORDER BY id DESC")->fetchAll();
    }
    public function findById(int $id): array|false {
        $s = $this->db->prepare("SELECT * FROM {$this->table} WHERE id=?");
        $s->execute([$id]);
        return $s->fetch();
    }
    public function delete(int $id): bool {
        $s = $this->db->prepare("DELETE FROM {$this->table} WHERE id=?");
        return $s->execute([$id]);
    }
    public function count(): int {
        return (int) $this->db->query("SELECT COUNT(*) FROM {$this->table}")->fetchColumn();
    }
}

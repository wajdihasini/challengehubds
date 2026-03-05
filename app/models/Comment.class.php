<?php

class Comment {
    private ?int $id_comm = null;
    private int $id_sub;
    private int $id_user;
    private string $content;
    private string $created_at;

    private $conn;
    private $table = "comments";

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    // Getters
    public function getIdComm(): ?int     { return $this->id_comm; }
    public function getIdSub(): int       { return $this->id_sub; }
    public function getIdUser(): int      { return $this->id_user; }
    public function getContent(): string  { return $this->content; }
    public function getCreatedAt(): string { return $this->created_at; }

    // Setters
    public function setIdSub(int $val): void      { $this->id_sub = $val; }
    public function setIdUser(int $val): void     { $this->id_user = $val; }
    public function setContent(string $val): void { $this->content = $val; }

    // 🔹 Ajouter un commentaire
    public function create($id_sub, $id_user, $content) {
        $query = "INSERT INTO " . $this->table . " 
                  (id_sub, id_user, content) 
                  VALUES (:id_sub, :id_user, :content)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_sub', $id_sub);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':content', $content);

        return $stmt->execute();
    }

    // 🔹 Récupérer commentaires submission
    public function getBySubmission($id_sub) {
        $query = "SELECT c.*, u.nom, u.prenom 
                  FROM " . $this->table . " c
                  JOIN users u ON c.id_user = u.id
                  WHERE c.id_sub = :id_sub
                  ORDER BY c.id_comm DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_sub', $id_sub);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔹 Supprimer commentaire
    public function delete($id_comm) {
        $query = "DELETE FROM " . $this->table . " 
                  WHERE id_comm = :id_comm";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_comm', $id_comm);

        return $stmt->execute();
    }

    // 🔹 Récupérer un commentaire par ID
    public function getById($id_comm) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_comm = :id_comm";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_comm', $id_comm);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        $c = new self();
        $c->id_comm    = (int)$row['id_comm'];
        $c->id_sub     = (int)$row['id_sub'];
        $c->id_user    = (int)$row['id_user'];
        $c->content    = $row['content'];
        $c->created_at = $row['created_at'];

        return $c;
    }

    public function getAll() {
        $query = "SELECT c.*, u.email as user_email, s.id_ch 
                  FROM " . $this->table . " c
                  JOIN users u ON c.id_user = u.id
                  JOIN submissions s ON c.id_sub = s.id_sub
                  ORDER BY c.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
<?php

class Submission {
    private ?int $id_sub = null;
    private int $id_ch;
    private int $id_user;
    private string $description;
    private ?string $image;
    private string $submitted_at;

    private $conn;
    private $table = "submissions";

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    // Getters
    public function getIdSub(): ?int      { return $this->id_sub; }
    public function getIdCh(): int        { return $this->id_ch; }
    public function getIdUser(): int       { return $this->id_user; }
    public function getDescription(): string { return $this->description; }
    public function getImage(): ?string    { return $this->image; }
    public function getSubmittedAt(): string  { return $this->submitted_at; }

    // Setters
    public function setIdCh(int $val): void          { $this->id_ch = $val; }
    public function setIdUser(int $val): void        { $this->id_user = $val; }
    public function setDescription(string $val): void { $this->description = $val; }
    public function setImage(?string $val): void      { $this->image = $val; }

    // 🔹 Ajouter une submission
    public function create($id_ch, $id_user, $description, $image) {
        $query = "INSERT INTO " . $this->table . " 
                  (id_ch, id_user, description, image) 
                  VALUES (:id_ch, :id_user, :description, :image)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_ch', $id_ch);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image);

        return $stmt->execute();
    }

    // 🔹 Récupérer toutes les submissions avec les infos liées (pour l'admin)
    public function getAll() {
        $query = "SELECT s.*, u.email as user_email 
                  FROM " . $this->table . " s
                  JOIN users u ON s.id_user = u.id
                  ORDER BY s.id_sub DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔹 Récupérer une submission par ID
    public function getById($id_sub) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_sub = :id_sub";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_sub', $id_sub);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        $s = new self();
        $s->id_sub      = (int)$row['id_sub'];
        $s->id_ch       = (int)$row['id_ch'];
        $s->id_user     = (int)$row['id_user'];
        $s->description = $row['description'];
        $s->image        = $row['image'];
        $s->submitted_at = $row['submitted_at'];

        return $s;
    }

    // 🔹 Récupérer les participations d'un défi avec le nombre de votes
    public function getByChallenge($id_ch) {
        $query = "SELECT s.*, COUNT(v.id_vote) as vote_count, u.nom as user_nom, u.prenom as user_prenom
                  FROM " . $this->table . " s
                  LEFT JOIN votes v ON s.id_sub = v.submission_id
                  LEFT JOIN users u ON s.id_user = u.id
                  WHERE s.id_ch = :id_ch
                  GROUP BY s.id_sub
                  ORDER BY vote_count DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_ch', $id_ch);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔹 Mettre à jour une submission
    public function update($id_sub, $description, $image) {
        $query = "UPDATE " . $this->table . " 
                  SET description = :description, image = :image 
                  WHERE id_sub = :id_sub";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':id_sub', $id_sub);

        return $stmt->execute();
    }

    // 🔹 Supprimer une submission
    public function delete($id_sub) {
        $query = "DELETE FROM " . $this->table . " WHERE id_sub = :id_sub";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_sub', $id_sub);

        return $stmt->execute();
    }

    // 🔹 Récupérer le classement des meilleures participations
    public function getRanking($limit = 10) {
        $query = "SELECT s.*, COUNT(v.id_vote) as vote_count, u.nom as user_nom, u.prenom as user_prenom, c.titre as challenge_titre
                  FROM " . $this->table . " s
                  LEFT JOIN votes v ON s.id_sub = v.submission_id
                  LEFT JOIN users u ON s.id_user = u.id
                  LEFT JOIN challenges c ON s.id_ch = c.id
                  GROUP BY s.id_sub
                  ORDER BY vote_count DESC
                  LIMIT :limit";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
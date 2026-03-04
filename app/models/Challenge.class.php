<?php

class Challenge {
    private int $id;
    private int $user_id;
    private string $titre;
    private string $description;
    private string $categorie;
    private string $date_limite;
    private ?string $image_path;
    private string $created_at;

    // Getters
    public function getId(): int                { return $this->id; }
    public function getUserId(): int            { return $this->user_id; }
    public function getTitre(): string          { return $this->titre; }
    public function getDescription(): string    { return $this->description; }
    public function getCategorie(): string      { return $this->categorie; }
    public function getDateLimite(): string     { return $this->date_limite; }
    public function getImagePath(): ?string     { return $this->image_path; }
    public function getCreatedAt(): string      { return $this->created_at; }

    // Setters
    public function setUserId(int $val): void          { $this->user_id = $val; }
    public function setTitre(string $val): void        { $this->titre = $val; }
    public function setDescription(string $val): void  { $this->description = $val; }
    public function setCategorie(string $val): void    { $this->categorie = $val; }
    public function setDateLimite(string $val): void   { $this->date_limite = $val; }
    public function setImagePath(?string $val): void   { $this->image_path = $val; }

    public static function create(array $data, int $userId): bool {
        $pdo = Database::getInstance()->getConnection();

        $sql = "INSERT INTO challenges 
                (user_id, titre, description, categorie, date_limite, image_path)
                VALUES (:user_id, :titre, :description, :categorie, :date_limite, :image_path)";

        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':user_id'     => $userId,
            ':titre'       => $data['titre'],
            ':description' => $data['description'],
            ':categorie'   => $data['categorie'],
            ':date_limite' => $data['date_limite'],
            ':image_path'  => $data['image_path'] ?? null,
        ]);
    }

    public static function update(int $id, array $data, int $userId): bool {
        $pdo = Database::getInstance()->getConnection();

        $sql = "UPDATE challenges 
                SET titre       = :titre,
                    description = :description,
                    categorie   = :categorie,
                    date_limite = :date_limite,
                    image_path  = :image_path
                WHERE id = :id AND user_id = :user_id";

        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':id'          => $id,
            ':user_id'     => $userId,
            ':titre'       => $data['titre'],
            ':description' => $data['description'],
            ':categorie'   => $data['categorie'],
            ':date_limite' => $data['date_limite'],
            ':image_path'  => $data['image_path'] ?? null,
        ]);
    }

    public static function delete(int $id, ?int $userId = null): bool {
        $pdo = Database::getInstance()->getConnection();

        if ($userId !== null) {
            $sql = "DELETE FROM challenges WHERE id = :id AND user_id = :user_id";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([
                ':id'      => $id,
                ':user_id' => $userId
            ]);
        } else {
            $sql = "DELETE FROM challenges WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([':id' => $id]);
        }
    }

    public static function findById(int $id): ?Challenge {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM challenges WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        if (!$row) return null;

        $c = new self();
        $c->id          = (int)$row['id'];
        $c->user_id     = (int)$row['user_id'];
        $c->titre       = $row['titre'];
        $c->description = $row['description'];
        $c->categorie   = $row['categorie'];
        $c->date_limite = $row['date_limite'];
        $c->image_path  = $row['image_path'];
        $c->created_at  = $row['created_at'];

        return $c;
    }

    public static function findAll(?string $search = null, ?string $category = null, string $sort = 'newest'): array {
        $pdo = Database::getInstance()->getConnection();
        
        $sql = "SELECT c.*, COUNT(v.id_vote) as vote_count 
                FROM challenges c
                LEFT JOIN submissions s ON c.id = s.id_ch
                LEFT JOIN votes v ON s.id_sub = v.submission_id
                WHERE 1=1";
        
        $params = [];

        if ($search) {
            $sql .= " AND (c.titre LIKE :search OR c.description LIKE :search)";
            $params[':search'] = '%' . $search . '%';
        }

        if ($category) {
            $sql .= " AND c.categorie = :category";
            $params[':category'] = $category;
        }

        $sql .= " GROUP BY c.id";

        if ($sort === 'popular') {
            $sql .= " ORDER BY vote_count DESC";
        } else {
            $sql .= " ORDER BY c.created_at DESC";
        }
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $results = [];

        foreach ($stmt->fetchAll() as $row) {
            $c = new self();
            $c->id          = (int)$row['id'];
            $c->user_id     = (int)$row['user_id'];
            $c->titre       = $row['titre'];
            $c->description = $row['description'];
            $c->categorie   = $row['categorie'];
            $c->date_limite = $row['date_limite'];
            $c->image_path  = $row['image_path'];
            $c->created_at  = $row['created_at'];
            $results[] = $c;
        }
        return $results;
    }
}
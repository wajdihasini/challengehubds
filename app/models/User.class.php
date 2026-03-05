<?php

class User extends Model {
    private ?int $id = null;
    private string $nom;
    private string $prenom;
    private string $email;
    private string $sexe;
    private string $date_naissance;
    private string $adresse;
    private string $password;
    private string $role;
    private string $created_at;

    private $table = "users";

    
    public function getId(): ?int             { return $this->id; }
    public function getNom(): string          { return $this->nom; }
    public function getPrenom(): string       { return $this->prenom; }
    public function getEmail(): string        { return $this->email; }
    public function getSexe(): string         { return $this->sexe; }
    public function getDateNaissance(): string { return $this->date_naissance; }
    public function getAdresse(): string      { return $this->adresse; }
    public function getPassword(): string     { return $this->password; }
    public function getRole(): string         { return $this->role; }
    public function getCreatedAt(): string    { return $this->created_at; }

    
    public function setNom(string $val): void           { $this->nom = $val; }
    public function setPrenom(string $val): void        { $this->prenom = $val; }
    public function setEmail(string $val): void         { $this->email = $val; }
    public function setSexe(string $val): void          { $this->sexe = $val; }
    public function setDateNaissance(string $val): void { $this->date_naissance = $val; }
    public function setAdresse(string $val): void       { $this->adresse = $val; }
    public function setPassword(string $val): void      { $this->password = $val; }
    public function setRole(string $val): void          { $this->role = $val; }

    public function create($data) {
        $sql = "INSERT INTO {$this->table}
                (nom, prenom, email, sexe, date_naissance, adresse, password, role)
                VALUES (:nom, :prenom, :email, :sexe, :date_naissance, :adresse, :password, :role)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':nom' => $data['nom'],
            ':prenom' => $data['prenom'],
            ':email' => $data['email'],
            ':sexe' => $data['sexe'],
            ':date_naissance' => $data['date_naissance'],
            ':adresse' => $data['adresse'],
            ':password' => password_hash($data['password'], PASSWORD_DEFAULT),
            ':role' => $data['role'] ?? 'user'
        ]);
    }

    public function findForLogin($nom, $prenom, $email) {
        $sql = "SELECT * FROM {$this->table}
                WHERE nom = :nom AND prenom = :prenom AND email = :email
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        $u = new self();
        $u->id             = (int)$row['id'];
        $u->nom            = $row['nom'];
        $u->prenom         = $row['prenom'];
        $u->email          = $row['email'];
        $u->sexe           = $row['sexe'];
        $u->date_naissance = $row['date_naissance'];
        $u->adresse        = $row['adresse'];
        $u->password       = $row['password'];
        $u->role           = $row['role'];
        $u->created_at     = $row['created_at'];

        return $u;
    }

    public function update($id, $data) {
        $fields = "nom=:nom, prenom=:prenom, email=:email, sexe=:sexe, date_naissance=:date_naissance, adresse=:adresse";
        $params = [
            ':nom'=>$data['nom'],
            ':prenom'=>$data['prenom'],
            ':email'=>$data['email'],
            ':sexe'=>$data['sexe'],
            ':date_naissance'=>$data['date_naissance'],
            ':adresse'=>$data['adresse'],
            ':id'=>$id
        ];

        if (isset($data['role'])) {
            $fields .= ", role=:role";
            $params[':role'] = $data['role'];
        }

        $sql = "UPDATE {$this->table} SET $fields WHERE id=:id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute($params);
    }

    public function isAdmin($userId) {
        $stmt = $this->db->prepare("SELECT role FROM {$this->table} WHERE id = :id");
        $stmt->execute([':id' => $userId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row && $row['role'] === 'admin';
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute([':id'=>$id]);
    }

    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email=:email");
        $stmt->execute([':email'=>$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findAll() {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

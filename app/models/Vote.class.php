<?php

class Vote {
    private ?int $id_vote = null;
    private int $user_id;
    private int $submission_id;
    private string $voted_at;

    private $conn;
    private $table = "votes";

    public function __construct($db){
        $this->conn = $db;
    }

    // Getters
    public function getIdVote(): ?int      { return $this->id_vote; }
    public function getUserId(): int      { return $this->user_id; }
    public function getSubmissionId(): int { return $this->submission_id; }
    public function getVotedAt(): string    { return $this->voted_at; }

    // Setters
    public function setUserId(int $val): void       { $this->user_id = $val; }
    public function setSubmissionId(int $val): void { $this->submission_id = $val; }

    public function addVote($user_id, $submission_id){
        $query = "INSERT INTO " . $this->table . " (user_id, submission_id)
                  VALUES (:user_id, :submission_id)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':submission_id', $submission_id);

        return $stmt->execute();
    }

    public function checkUserVote($user_id, $submission_id){
        $query = "SELECT * FROM " . $this->table . "
                  WHERE user_id = :user_id 
                  AND submission_id = :submission_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':submission_id', $submission_id);

        $stmt->execute();

        return $stmt->rowCount();
    }

    public function countVotes($submission_id){
        $query = "SELECT COUNT(*) as total 
                  FROM " . $this->table . "
                  WHERE submission_id = :submission_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':submission_id', $submission_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll() {
        $query = "SELECT v.*, u.email as user_email, s.id_ch 
                  FROM " . $this->table . " v
                  JOIN users u ON v.user_id = u.id
                  JOIN submissions s ON v.submission_id = s.id_sub
                  ORDER BY v.voted_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id_vote) {
        $query = "DELETE FROM " . $this->table . " WHERE id_vote = :id_vote";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':id_vote' => $id_vote]);
    }
}
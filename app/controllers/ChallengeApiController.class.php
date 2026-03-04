<?php

class ChallengeApiController extends ApiController {
    
    /**
     * GET /api/challenges
     * Returns a list of all challenges.
     */
    public function list() {
        $search = $_GET['search'] ?? null;
        $category = $_GET['category'] ?? null;
        $sort = $_GET['sort'] ?? 'newest';

        $challenges = Challenge::findAll($search, $category, $sort);
        
        $data = array_map(function($c) {
            return [
                'id' => $c->getId(),
                'user_id' => $c->getUserId(),
                'titre' => $c->getTitre(),
                'description' => $c->getDescription(),
                'categorie' => $c->getCategorie(),
                'date_limite' => $c->getDateLimite(),
                'image_path' => $c->getImagePath(),
                'created_at' => $c->getCreatedAt()
            ];
        }, $challenges);

        $this->jsonSuccess('Challenges retrieved successfully', $data);
    }

    /**
     * GET /api/challenge?id=X
     * Returns details of a specific challenge.
     */
    public function view() {
        $id = (int)($_GET['id'] ?? 0);
        
        if ($id <= 0) {
            $this->jsonError('Invalid challenge ID');
        }

        $challenge = Challenge::findById($id);

        if (!$challenge) {
            $this->jsonError('Challenge not found', 404);
        }

        $data = [
            'id' => $challenge->getId(),
            'user_id' => $challenge->getUserId(),
            'titre' => $challenge->getTitre(),
            'description' => $challenge->getDescription(),
            'categorie' => $challenge->getCategorie(),
            'date_limite' => $challenge->getDateLimite(),
            'image_path' => $challenge->getImagePath(),
            'created_at' => $challenge->getCreatedAt()
        ];

        $this->jsonSuccess('Challenge details retrieved successfully', $data);
    }
}

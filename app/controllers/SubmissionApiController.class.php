<?php

class SubmissionApiController extends ApiController {
    
    /**
     * GET /api/submission/stats?id=X
     * Returns vote count and comment count for a submission.
     */
    public function stats() {
        $id = (int)($_GET['id'] ?? 0);
        
        if ($id <= 0) {
            $this->jsonError('Invalid submission ID');
        }

        $submissionModel = new Submission();
        $submission = $submissionModel->getById($id);
        if (!$submission) {
            $this->jsonError('Submission not found', 404);
        }

        $voteModel = new Vote(Database::getInstance()->getConnection());
        $voteResult = $voteModel->countVotes($id);
        $voteCount = $voteResult['total'] ?? 0;

        $commentModel = new Comment();
        $comments = $commentModel->getBySubmission($id);

        $this->jsonSuccess('Stats retrieved successfully', [
            'id_sub' => $id,
            'vote_count' => $voteCount,
            'comment_count' => count($comments)
        ]);
    }

    /**
     * GET /api/submissions/ranking
     * Returns the global ranking in JSON.
     */
    public function ranking() {
        $submissionModel = new Submission();
        $ranking = $submissionModel->getRanking();
        
        $this->jsonSuccess('Ranking retrieved successfully', $ranking);
    }
}

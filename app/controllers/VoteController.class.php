<?php

class VoteController {

    private $vote;

    public function __construct($db){
        $this->vote = new Vote($db);
    }

    public function vote(){
        if(!isset($_SESSION['user_id'])){
            header("Location: index.php?url=login");
            exit();
        }

        $user_id = (int)$_SESSION['user_id'];
        $submission_id = (int)($_GET['id'] ?? 0);

        // Fetch submission to check owner
        $submissionModel = new Submission();
        $submission = $submissionModel->getById($submission_id);

        if($submission && (int)$submission->getIdUser() === $user_id){
            header("Location: index.php?url=submission/view&id=" . $submission_id . "&msg=self_vote");
            exit();
        }

        // check if user already voted
        if($this->vote->checkUserVote($user_id, $submission_id) > 0){
            header("Location: index.php?url=submission/view&id=" . $submission_id . "&msg=already_voted");
            exit();
        }

        // add vote
        if($this->vote->addVote($user_id, $submission_id)){
            header("Location: index.php?url=submission/view&id=" . $submission_id . "&msg=voted");
        } else {
            header("Location: index.php?url=submission/view&id=" . $submission_id . "&msg=error");
        }
        exit();
    }
}
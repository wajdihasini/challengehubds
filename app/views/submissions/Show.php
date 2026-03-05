<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="mb-4">
            <a href="index.php?url=challenges" class="btn btn-link link-primary p-0 text-decoration-none fw-bold small">
                <i class="bi bi-arrow-left me-1"></i> Retour au défi
            </a>
        </div>

        <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4 <?php 
                echo (strpos($_GET['msg'], 'error') !== false || $_GET['msg'] === 'self_vote' || $_GET['msg'] === 'auth_error') 
                    ? 'alert-danger' 
                    : 'alert-success'; 
            ?>" role="alert">
                <div class="d-flex align-items-center">
                    <?php if (strpos($_GET['msg'], 'error') !== false || $_GET['msg'] === 'self_vote' || $_GET['msg'] === 'auth_error'): ?>
                        <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                    <?php else: ?>
                        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <?php endif; ?>
                    <span>
                        <?php 
                            if ($_GET['msg'] === 'voted') echo "Votre vote a été enregistré !";
                            elseif ($_GET['msg'] === 'already_voted') echo "Vous avez déjà voté pour cette participation.";
                            elseif ($_GET['msg'] === 'self_vote') echo "Vous ne pouvez pas voter pour votre propre participation.";
                            elseif ($_GET['msg'] === 'auth_error') echo "Action non autorisée.";
                            elseif ($_GET['msg'] === 'error') echo "Une erreur est survenue.";
                        ?>
                    </span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if ($submission) : ?>
            <div class="row g-5">
                <div class="col-md-6">
                    <div class="card border-0 shadow-lg rounded-5 overflow-hidden sticky-top" style="top: 100px; transform: rotate(-1deg);">
                        <?php if(!empty($submission->getImage())) : ?>
                            <img src="<?= ltrim(htmlspecialchars($submission->getImage()), '/'); ?>" class="img-fluid w-100" alt="Participation Image">
                        <?php else: ?>
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                                <i class="bi bi-image text-muted opacity-25" style="font-size: 5rem;"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="ps-md-4">
                        <span class="badge bg-primary-subtle text-primary text-uppercase fw-black tracking-widest mb-3" style="font-size: 0.7rem; letter-spacing: 0.1em;">
                            Participation #<?= htmlspecialchars($submission->getIdSub()); ?>
                        </span>
                        <h1 class="display-6 fw-black text-dark mb-4">L'œuvre et son contexte</h1>
                        
                        <div class="d-flex align-items-center gap-2 mb-5">
                            <div class="btn btn-primary rounded-4 fw-black py-2 px-4 shadow-sm border-0 d-flex align-items-center">
                                <i class="bi bi-hand-thumbs-up-fill me-2"></i>
                                <?= $voteCount ?> Votes
                            </div>
                            
                            <?php 
                            $isAuthor = isset($_SESSION['user_id']) && (int)$_SESSION['user_id'] === (int)$submission->getIdUser();
                            if (!$isAuthor): ?>
                                <?php if ($hasVoted): ?>
                                    <button disabled class="btn btn-success-subtle border-success-subtle text-success rounded-4 fw-black py-2 px-4 d-flex align-items-center">
                                        <i class="bi bi-check-lg me-2"></i> Déjà voté
                                    </button>
                                <?php else: ?>
                                    <a href="index.php?url=vote&id=<?= $submission->getIdSub() ?>&ch=<?= $submission->getIdCh() ?>" class="btn btn-outline-primary rounded-4 fw-black py-2 px-4 shadow-sm transform-active d-flex align-items-center">
                                        <i class="bi bi-heart me-2"></i> Voter
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>

                        <div class="card border-0 border-start border-primary border-5 rounded-4 shadow-sm bg-white p-4 mb-5 shadow-hover transition">
                            <p class="mb-0 fs-5 text-secondary fst-italic">
                                "<?= nl2br(htmlspecialchars($submission->getDescription())); ?>"
                            </p>
                        </div>

                        <div class="pt-5 border-top border-light">
                            <h3 class="h4 fw-black text-dark mb-4 d-flex align-items-center">
                                <i class="bi bi-chat-dots text-primary me-2"></i> Commentaires
                            </h3>

                            <?php if (!empty($comments)) : ?>
                                <div class="d-grid gap-3 mb-4">
                                    <?php foreach ($comments as $comment) : ?>
                                        <div class="card border-0 bg-light rounded-4 p-4 position-relative group-hover-actions shadow-sm">
                                            <p class="text-dark mb-3"><?= htmlspecialchars($comment['content']); ?></p>
                                            <div class="d-flex align-items-center justify-content-between mt-auto">
                                                <span class="text-muted fw-bold text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.05em;">
                                                    Posté par <?= htmlspecialchars($comment['prenom'] . ' ' . $comment['nom']); ?>
                                                </span>
                                                <?php 
                                                $isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
                                                if ((isset($_SESSION['user_id']) && (int)$_SESSION['user_id'] === (int)$comment['id_user']) || $isAdmin): ?>
                                                    <a href="index.php?url=submission/deleteComment&id=<?= $comment['id_comm']; ?>&sub=<?= $submission->getIdSub(); ?>" 
                                                       onclick="return confirm('Supprimer ?')" 
                                                       class="text-danger opacity-75 hover-opacity-100 transition small">
                                                        <i class="bi bi-trash3"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else : ?>
                                <div class="card border-0 border-dashed bg-light text-center py-5 rounded-4 mb-4">
                                    <p class="text-muted mb-0 small fst-italic">Aucun commentaire pour le moment.</p>
                                </div>
                            <?php endif; ?>

                            <div class="mt-4">
                                <form action="index.php?url=submission/comment" method="POST">
                                    <input type="hidden" name="submission_id" value="<?= $submission->getIdSub(); ?>">
                                    <div class="position-relative">
                                        <textarea name="content" required placeholder="Votre avis constructif..." 
                                                  class="form-control rounded-4 p-4 border-light shadow-sm focus-ring" 
                                                  style="resize: none; height: 120px;"></textarea>
                                        <button type="submit" class="btn btn-primary rounded-4 px-4 py-2 position-absolute shadow fw-black" 
                                                style="bottom: 15px; right: 15px; font-size: 0.75rem;">
                                            ENVOYER
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <div class="text-center py-5">
                <i class="bi bi-search display-3 text-muted mb-4 d-block"></i>
                <h3 class="fw-bold text-muted fst-italic">Oups, cette participation a disparu...</h3>
                <a href="index.php?url=challenges" class="btn btn-primary rounded-pill px-4 mt-3">Retour aux défis</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>

<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="row justify-content-center mt-5">
    <div class="col-md-6 col-lg-5">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <h2 class="fw-black text-dark">Connexion</h2>
                    <p class="text-secondary small">Accédez à votre espace ChallengeHub.</p>
                </div>

                <?php if(!empty($errors)): ?>
                    <div class="alert alert-danger rounded-3 border-0 small mb-4">
                        <?php foreach($errors as $e) echo "<p class='mb-1'><i class='bi bi-exclamation-circle me-1'></i> $e</p>"; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="index.php?url=loginAction">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Email</label>
                        <input type="email" name="email" required placeholder="votre@email.com" class="form-control rounded-3 py-2">
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-dark">Mot de passe</label>
                        <input type="password" name="password" required class="form-control rounded-3 py-2">
                    </div>

                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-primary btn-lg rounded-3 fw-bold py-3 shadow">
                            Se connecter
                        </button>
                    </div>

                    <p class="text-center small text-muted mb-0">
                        Pas encore de compte ? <a href="index.php?url=register" class="text-primary fw-bold text-decoration-none">S'inscrire gratuitement</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
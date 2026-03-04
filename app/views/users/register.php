<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <h2 class="fw-black text-dark">Créer un compte</h2>
                    <p class="text-secondary small">Rejoignez la communauté ChallengeHub dès aujourd'hui.</p>
                </div>

                <?php if(!empty($errors)): ?>
                    <div class="alert alert-danger rounded-3 border-0 small mb-4">
                        <?php foreach($errors as $e) echo "<p class='mb-1'><i class='bi bi-exclamation-circle me-1'></i> $e</p>"; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="index.php?url=registerAction">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">Nom</label>
                            <input type="text" name="nom" required class="form-control rounded-3 py-2">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">Prénom</label>
                            <input type="text" name="prenom" required class="form-control rounded-3 py-2">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Email</label>
                        <input type="email" name="email" required class="form-control rounded-3 py-2">
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">Sexe</label>
                            <select name="sexe" required class="form-select rounded-3 py-2">
                                <option value="M">Homme</option>
                                <option value="F">Femme</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">Date de naissance</label>
                            <input type="date" name="date_naissance" required class="form-control rounded-3 py-2">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Adresse</label>
                        <textarea name="adresse" required rows="2" class="form-control rounded-3"></textarea>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">Mot de passe</label>
                            <input type="password" name="password" required class="form-control rounded-3 py-2">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">Confirmation</label>
                            <input type="password" name="confirm_password" required class="form-control rounded-3 py-2">
                        </div>
                    </div>

                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-primary btn-lg rounded-3 fw-bold py-3 shadow">
                            S'inscrire
                        </button>
                    </div>

                    <p class="text-center small text-muted mb-0">
                        Déjà inscrit ? <a href="index.php?url=login" class="text-primary fw-bold text-decoration-none">Se connecter</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-7">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-body p-4 p-md-5">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h1 class="h3 fw-black text-dark mb-1">Modifier le profil</h1>
                        <p class="text-muted small mb-0">Mettez à jour vos informations personnelles.</p>
                    </div>
                    <a href="index.php?url=profile" class="btn btn-link link-primary p-0 text-decoration-none fw-bold small d-flex align-items-center">
                        <i class="bi bi-arrow-left me-1"></i> Retour au profil
                    </a>
                </div>

                <form method="POST" action="index.php?url=update-profile">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label text-uppercase fw-black text-muted small tracking-widest mb-2">Nom</label>
                            <input type="text" name="nom" value="<?= htmlspecialchars($user->getNom()) ?>" required class="form-control rounded-3 p-3 border-light shadow-sm focus-ring" placeholder="Nom">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-uppercase fw-black text-muted small tracking-widest mb-2">Prénom</label>
                            <input type="text" name="prenom" value="<?= htmlspecialchars($user->getPrenom()) ?>" required class="form-control rounded-3 p-3 border-light shadow-sm focus-ring" placeholder="Prénom">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-uppercase fw-black text-muted small tracking-widest mb-2">Email</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($user->getEmail()) ?>" required class="form-control rounded-3 p-3 border-light shadow-sm focus-ring bg-light" placeholder="Email" readonly>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label text-uppercase fw-black text-muted small tracking-widest mb-2">Sexe</label>
                            <select name="sexe" class="form-select rounded-3 p-3 border-light shadow-sm focus-ring">
                                <option value="M" <?= $user->getSexe()=='M'?'selected':'' ?>>Homme</option>
                                <option value="F" <?= $user->getSexe()=='F'?'selected':'' ?>>Femme</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-uppercase fw-black text-muted small tracking-widest mb-2">Date de naissance</label>
                            <input type="date" name="date_naissance" value="<?= htmlspecialchars($user->getDateNaissance()) ?>" required class="form-control rounded-3 p-3 border-light shadow-sm focus-ring">
                        </div>
                    </div>

                    <div class="mb-4 text-start">
                        <label class="form-label text-uppercase fw-black text-muted small tracking-widest mb-2">Adresse</label>
                        <textarea name="adresse" rows="3" class="form-control rounded-3 p-3 border-light shadow-sm focus-ring" placeholder="Votre adresse..."><?= htmlspecialchars($user->getAdresse()) ?></textarea>
                    </div>

                    <div class="pt-4 border-top border-light d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary rounded-4 py-3 px-5 fw-black text-uppercase shadow-sm tracking-widest">
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>

<?php require_once __DIR__ . '/../../layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="mb-4">
            <h1 class="h2 fw-bold text-dark mb-1">Modifier l'utilisateur</h1>
            <p class="text-secondary small">Mettez à jour les informations de profil et les permissions.</p>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
            <form action="index.php?url=admin/user/edit&id=<?php echo $user->getId(); ?>" method="POST">
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <input type="text" name="nom" id="nom" value="<?php echo htmlspecialchars($user->getNom()); ?>" class="form-control form-control-lg rounded-3 border-light shadow-sm bg-light" placeholder="Nom">
                    </div>

                    <div class="col-md-6">
                        <input type="text" name="prenom" id="prenom" value="<?php echo htmlspecialchars($user->getPrenom()); ?>" class="form-control form-control-lg rounded-3 border-light shadow-sm bg-light" placeholder="Prénom">
                    </div>

                    <div class="col-12">
                        <label for="email" class="form-label small fw-bold text-muted text-uppercase">Email</label>
                            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user->getEmail()); ?>" class="form-control form-control-lg rounded-end-3 border-light shadow-sm bg-light" placeholder="email@exemple.com">
                    </div>

                    <div class="col-md-4">
                        <select name="sexe" id="sexe" class="form-select form-select-lg rounded-3 border-light shadow-sm bg-light">
                            <option value="M" <?php echo $user->getSexe()==='M'?'selected':''; ?>>Homme</option>
                            <option value="F" <?php echo $user->getSexe()==='F'?'selected':''; ?>>Femme</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <input type="date" name="date_naissance" id="date_naissance" value="<?php echo $user->getDateNaissance(); ?>" class="form-control form-control-lg rounded-3 border-light shadow-sm bg-light">
                    </div>

                    <div class="col-md-4">
                        <select name="role" id="role" class="form-select form-select-lg rounded-3 border-light shadow-sm bg-light fw-bold text-primary">
                            <option value="user" <?php echo $user->getRole()==='user'?'selected':''; ?>>User (Normal)</option>
                            <option value="admin" <?php echo $user->getRole()==='admin'?'selected':''; ?>>ADMIN</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <textarea name="adresse" id="adresse" rows="3" class="form-control form-control-lg rounded-3 border-light shadow-sm bg-light" placeholder="Adresse complète"><?php echo htmlspecialchars($user->getAdresse()); ?></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                    <a href="index.php?url=admin/users" class="btn btn-lg btn-light rounded-3 px-4 small fw-bold text-muted">Annuler</a>
                    <button type="submit" class="btn btn-lg btn-primary rounded-3 px-4 small fw-bold shadow-sm">
                        <i class="bi bi-check2-circle me-1"></i> Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../layout/footer.php'; ?>

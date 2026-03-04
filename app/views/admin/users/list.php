<?php require_once __DIR__ . '/../../layout/header.php'; ?>

<div class="mb-5">
    <h1 class="h2 fw-bold text-dark mb-1">Utilisateurs</h1>
    <p class="text-secondary small">Liste complète de tous les utilisateurs inscrits sur ChallengeHub.</p>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="px-4 py-3 border-0 small text-uppercase fw-bold text-muted">ID</th>
                    <th class="px-3 py-3 border-0 small text-uppercase fw-bold text-muted">Nom & Prénom</th>
                    <th class="px-3 py-3 border-0 small text-uppercase fw-bold text-muted">Email</th>
                    <th class="px-3 py-3 border-0 small text-uppercase fw-bold text-muted">Rôle</th>
                    <th class="px-4 py-3 border-0 small text-uppercase fw-bold text-muted text-end">Actions</th>
                </tr>
            </thead>
            <tbody class="border-top-0">
                <?php foreach ($users as $u): ?>
                <tr>
                    <td class="px-4 py-3 small fw-bold text-dark"><?php echo $u['id']; ?></td>
                    <td class="px-3 py-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm rounded-circle bg-primary-subtle text-primary fw-bold d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                <?= strtoupper(substr($u['prenom'], 0, 1) . substr($u['nom'], 0, 1)) ?>
                            </div>
                            <span class="small fw-medium"><?php echo htmlspecialchars($u['nom'] . ' ' . $u['prenom']); ?></span>
                        </div>
                    </td>
                    <td class="px-3 py-3 small text-secondary"><?php echo htmlspecialchars($u['email']); ?></td>
                    <td class="px-3 py-3">
                        <span class="badge rounded-pill <?php echo $u['role'] === 'admin' ? 'bg-primary-subtle text-primary' : 'bg-light text-secondary'; ?> px-3 small">
                            <?php echo ucfirst($u['role']); ?>
                        </span>
                    </td>
                    <td class="px-4 py-3 text-end">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="index.php?url=admin/user/edit&id=<?php echo $u['id']; ?>" class="btn btn-sm btn-outline-primary rounded-3 px-3">
                                <i class="bi bi-pencil"></i> <span class="d-none d-md-inline ms-1">Modifier</span>
                            </a>
                            <a href="index.php?url=admin/user/delete&id=<?php echo $u['id']; ?>" class="btn btn-sm btn-outline-danger rounded-3 px-3" onclick="return confirm('Confirmer la suppression ?')">
                                <i class="bi bi-trash"></i> <span class="d-none d-md-inline ms-1">Supprimer</span>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../../layout/footer.php'; ?>

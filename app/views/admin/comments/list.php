<?php require_once __DIR__ . '/../../layout/header.php'; ?>

<div class="mb-5">
    <h1 class="h2 fw-bold text-dark mb-1">Modération des Commentaires</h1>
    <p class="text-secondary small">Gérez les interactions sur les participations.</p>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="px-4 py-3 border-0 small text-uppercase fw-bold text-muted">ID</th>
                    <th class="px-3 py-3 border-0 small text-uppercase fw-bold text-muted">Auteur</th>
                    <th class="px-3 py-3 border-0 small text-uppercase fw-bold text-muted">Contenu</th>
                    <th class="px-4 py-3 border-0 small text-uppercase fw-bold text-muted text-end">Actions</th>
                </tr>
            </thead>
            <tbody class="border-top-0">
                <?php foreach ($comments as $c): ?>
                <tr>
                    <td class="px-4 py-3 small fw-bold text-dark"><?php echo $c['id_comm']; ?></td>
                    <td class="px-3 py-3">
                        <div class="small fw-medium text-dark"><?php echo htmlspecialchars($c['user_email']); ?></div>
                        <div class="text-muted" style="font-size: 0.7rem;">Sub #<?php echo $c['id_sub']; ?></div>
                    </td>
                    <td class="px-3 py-3 small text-secondary italic">
                        <div class="text-truncate" style="max-width: 300px;">
                            "<?php echo htmlspecialchars($c['content']); ?>"
                        </div>
                    </td>
                    <td class="px-4 py-3 text-end">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="index.php?url=submission/view&id=<?php echo $c['id_sub']; ?>" class="btn btn-sm btn-outline-primary rounded-3 px-3">
                                <i class="bi bi-eye"></i> <span class="d-none d-md-inline ms-1">Voir</span>
                            </a>
                            <a href="index.php?url=admin/comment/delete&id=<?php echo $c['id_comm']; ?>" class="btn btn-sm btn-outline-danger rounded-3 px-3" onclick="return confirm('Confirmer la suppression ?')">
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

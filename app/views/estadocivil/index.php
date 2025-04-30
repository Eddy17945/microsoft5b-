<?php
$content = ob_get_clean();
?>

<div class="d-flex justify-content-between mb-4">
    <h2>Listado de Estados Civiles</h2>
    <a href="/public/index.php?controller=estadocivil&action=create" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nuevo Estado Civil
    </a>
</div>

<table class="table table-striped table-hover">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Descripción</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($estadosCiviles as $estadoCivil): ?>
        <tr>
            <td><?= htmlspecialchars($estadoCivil['id_estadocivil'] ?? '') ?></td>
            <td><?= htmlspecialchars($estadoCivil['descripcion'] ?? '') ?></td>
            <td>
                <a href="/public/index.php?controller=estadocivil&action=view&id=<?= $estadoCivil['id_estadocivil'] ?>" class="btn btn-sm btn-info">
                    <i class="bi bi-eye"></i>
                </a>
                <a href="/public/index.php?controller=estadocivil&action=edit&id=<?= $estadoCivil['id_estadocivil'] ?>" class="btn btn-sm btn-warning">
                    <i class="bi bi-pencil"></i>
                </a>
                <form action="/public/index.php?controller=estadocivil&action=delete&id=<?= $estadoCivil['id_estadocivil'] ?>" method="POST" style="display: inline;">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php ?>
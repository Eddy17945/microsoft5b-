<?php

if (ob_get_level() == 0) ob_start();
?>

<div class="container">
    <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $_SESSION['error'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $_SESSION['success'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <div class="d-flex justify-content-between mb-4">
        <h2>Listado de Sexos</h2>
        <a href="/public/index.php?controller=sexo&action=create" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nuevo Sexo
        </a>
    </div>

    <?php if (isset($sexos) && count($sexos) > 0): ?>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sexos as $sexo): ?>
            <tr>
                <td><?= htmlspecialchars($sexo['id_sexo'] ?? '') ?></td>
                <td><?= htmlspecialchars($sexo['descripcion'] ?? '') ?></td>
                <td>
                    <a href="/public/index.php?controller=sexo&action=view&id=<?= $sexo['id_sexo'] ?>" class="btn btn-sm btn-info">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="/public/index.php?controller=sexo&action=edit&id=<?= $sexo['id_sexo'] ?>" class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="/public/index.php?controller=sexo&action=delete&id=<?= $sexo['id_sexo'] ?>" method="POST" style="display: inline;">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este registro?')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <div class="alert alert-info">No hay registros disponibles.</div>
    <?php endif; ?>
</div>

<?php

?>
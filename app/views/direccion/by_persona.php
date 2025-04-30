<?php
$content = ob_get_clean();

?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Direcciones de <?= htmlspecialchars($persona['nombre'] . ' ' . $persona['apellido']) ?></h4>
    <a href="/public/index.php?controller=direccion&action=create&id_persona=<?= $persona['id_persona'] ?>" class="btn btn-sm btn-success">
        <i class="bi bi-plus-circle"></i> Agregar Dirección
    </a>
</div>

<?php if (!empty($direcciones)): ?>
<table class="table table-sm table-bordered">
    <thead>
        <tr>
            <th>Calle</th>
            <th>Ciudad</th>
            <th>Estado</th>
            <th>Código Postal</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($direcciones as $direccion): ?>
        <tr>
            <td><?= htmlspecialchars($direccion['calle'] ?? '') ?></td>
            <td><?= htmlspecialchars($direccion['ciudad'] ?? '') ?></td>
            <td><?= htmlspecialchars($direccion['estado'] ?? '') ?></td>
            <td><?= htmlspecialchars($direccion['codigo_postal'] ?? '') ?></td>
            <td>
                <a href="/public/index.php?controller=direccion&action=edit&id=<?= $direccion['id_direccion'] ?>" class="btn btn-sm btn-warning">
                    <i class="bi bi-pencil"></i>
                </a>
                <form action="/public/index.php?controller=direccion&action=delete&id=<?= $direccion['id_direccion'] ?>" method="POST" style="display: inline;">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta dirección?')">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<div class="alert alert-info">No hay direcciones registradas para esta persona</div>
<?php endif; ?>

<?php  ?>
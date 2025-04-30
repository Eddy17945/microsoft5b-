<?php
$content = ob_get_clean();

?>

<div class="d-flex justify-content-between mb-4">
    <h2>Listado de Direcciones</h2>
    <a href="/public/index.php?controller=direccion&action=create" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nueva Dirección
    </a>
</div>

<table class="table table-striped table-hover">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Persona</th>
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
            <td><?= htmlspecialchars($direccion['id_direccion'] ?? '') ?></td>
            <td><?= htmlspecialchars(($direccion['nombre'] ?? '') . ' ' . ($direccion['apellido'] ?? '')) ?></td>
            <td><?= htmlspecialchars($direccion['calle'] ?? '') ?></td>
            <td><?= htmlspecialchars($direccion['ciudad'] ?? '') ?></td>
            <td><?= htmlspecialchars($direccion['estado'] ?? '') ?></td>
            <td><?= htmlspecialchars($direccion['codigo_postal'] ?? '') ?></td>
            <td>
                <a href="/public/index.php?controller=direccion&action=view&id=<?= $direccion['id_direccion'] ?>" class="btn btn-sm btn-info">
                    <i class="bi bi-eye"></i>
                </a>
                <a href="/public/index.php?controller=direccion&action=edit&id=<?= $direccion['id_direccion'] ?>" class="btn btn-sm btn-warning">
                    <i class="bi bi-pencil"></i>
                </a>
                <form action="/public/index.php?controller=direccion&action=delete&id=<?= $direccion['id_direccion'] ?>" method="POST" style="display: inline;">
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

<?php  ?>
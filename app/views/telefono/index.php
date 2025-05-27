<?php
// Asegurarse de que se está capturando el output buffer
if (ob_get_level() == 0) ob_start();
?>

<div class="container">
    <h1>Listado de Teléfonos</h1>
    
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Teléfonos</h4>
        <a href="<?= BASE_URL ?>index.php?controller=telefono&action=create" class="btn btn-sm btn-success">
            <i class="bi bi-plus-circle"></i> Agregar Teléfono
        </a>
    </div>

    <?php if (isset($telefonos) && count($telefonos) > 0): ?>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Número</th>
                <th>Tipo</th>
                <th>Persona</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($telefonos as $telefono): ?>
            <tr>
                <td><?= htmlspecialchars($telefono['numero']) ?></td>
                <td><?= htmlspecialchars($telefono['tipo']) ?></td>
                <td><?= htmlspecialchars($telefono['nombre'] . ' ' . $telefono['apellido']) ?></td>
                <td>
                    <a href="<?= BASE_URL ?>index.php?controller=telefono&action=view&id=<?= $telefono['id_telefono'] ?>" class="btn btn-sm btn-info">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="<?= BASE_URL ?>index.php?controller=telefono&action=edit&id=<?= $telefono['id_telefono'] ?>" class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="<?= BASE_URL ?>index.php?controller=telefono&action=delete&id=<?= $telefono['id_telefono'] ?>" method="POST" style="display: inline;">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este teléfono?')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <div class="alert alert-info">No hay teléfonos registrados</div>
    <?php endif; ?>
</div>

<?php

?>
<?php
// Asegurarse de que se está capturando el output buffer
if (ob_get_level() == 0) ob_start();
?>

<h4><?= isset($_GET['id_persona']) ? 'Agregar Teléfono' : 'Agregar Nuevo Teléfono' ?></h4>

<form action="/public/index.php?controller=telefono&action=store<?= isset($_GET['id_persona']) ? '&id_persona='.$_GET['id_persona'] : '' ?>" method="POST">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
    
    <?php if (!isset($_GET['id_persona'])): ?>
    <div class="mb-3">
        <label for="id_persona" class="form-label">Persona</label>
        <select class="form-select" id="id_persona" name="id_persona" required>
            <option value="">Seleccione una persona</option>
            <?php foreach ($personas as $persona_item): ?>
            <option value="<?= $persona_item['id_persona'] ?>"><?= htmlspecialchars($persona_item['nombre'] . ' ' . $persona_item['apellido']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <?php else: ?>
    <!-- Si venimos desde la vista de persona, mostramos el nombre pero enviamos el ID como hidden -->
    <div class="mb-3">
        <label class="form-label">Persona</label>
        <input type="text" class="form-control" value="<?= htmlspecialchars($persona->nombre . ' ' . $persona->apellido) ?>" readonly>
        <input type="hidden" name="id_persona" value="<?= $id_persona ?>">
    </div>
    <?php endif; ?>
    
    <div class="mb-3">
        <label for="numero" class="form-label">Número</label>
        <input type="text" class="form-control" id="numero" name="numero" required>
    </div>
    
    <div class="mb-3">
        <label for="tipo" class="form-label">Tipo</label>
        <select class="form-select" id="tipo" name="tipo" required>
            <option value="">Seleccione...</option>
            <option value="Móvil">Móvil</option>
            <option value="Casa">Casa</option>
            <option value="Trabajo">Trabajo</option>
            <option value="Otro">Otro</option>
        </select>
    </div>
    
    <button type="submit" class="btn btn-primary">Guardar</button>
    <?php if (isset($_GET['id_persona'])): ?>
    <a href="/public/index.php?controller=persona&action=view&id=<?= $_GET['id_persona'] ?>" class="btn btn-secondary">Cancelar</a>
    <?php else: ?>
    <a href="/public/index.php?controller=telefono&action=index" class="btn btn-secondary">Cancelar</a>
    <?php endif; ?>
</form>
<?php

?>
<?php
// Asegurarse de que se está capturando el output buffer
if (ob_get_level() == 0) ob_start();
?>

<h4>Editar Teléfono</h4>

<form action="<?= BASE_URL ?>index.php?controller=telefono&action=update&id=<?= $this->telefono->id_telefono ?>" method="POST">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
    
    <div class="mb-3">
        <label for="numero" class="form-label">Número</label>
        <input type="text" class="form-control" id="numero" name="numero" value="<?= htmlspecialchars($this->telefono->numero) ?>" required>
    </div>
    
    <div class="mb-3">
        <label for="tipo" class="form-label">Tipo</label>
        <select class="form-select" id="tipo" name="tipo" required>
            <option value="">Seleccione...</option>
            <option value="Móvil" <?= $this->telefono->tipo == 'Móvil' ? 'selected' : '' ?>>Móvil</option>
            <option value="Casa" <?= $this->telefono->tipo == 'Casa' ? 'selected' : '' ?>>Casa</option>
            <option value="Trabajo" <?= $this->telefono->tipo == 'Trabajo' ? 'selected' : '' ?>>Trabajo</option>
            <option value="Otro" <?= $this->telefono->tipo == 'Otro' ? 'selected' : '' ?>>Otro</option>
        </select>
    </div>
    
    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="<?= BASE_URL ?>index.php?controller=persona&action=view&id=<?= $this->telefono->id_persona ?>" class="btn btn-secondary">Cancelar</a>
</form>

<?php

?>
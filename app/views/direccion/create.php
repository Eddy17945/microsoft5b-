<?php
$content = ob_get_clean();
?>

<h4>Agregar Nueva Dirección</h4>

<form action="<?= BASE_URL ?>index.php?controller=direccion&action=store<?= isset($_GET['id_persona']) ? '&id_persona='.$_GET['id_persona'] : '' ?>" method="POST">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
    
    <?php if (!isset($_GET['id_persona'])): ?>
    <div class="mb-3">
        <label for="id_persona" class="form-label">Persona</label>
        <select class="form-select" id="id_persona" name="id_persona" required>
            <option value="">Seleccione una persona</option>
            <?php foreach ($personas as $persona): ?>
            <option value="<?= $persona['id_persona'] ?>"><?= htmlspecialchars($persona['nombre'] . ' ' . $persona['apellido']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <?php endif; ?>
    
    <div class="mb-3">
        <label for="calle" class="form-label">Calle</label>
        <input type="text" class="form-control" id="calle" name="calle" required>
    </div>
    
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="ciudad" class="form-label">Ciudad</label>
            <input type="text" class="form-control" id="ciudad" name="ciudad" required>
        </div>
        <div class="col-md-6">
            <label for="estado" class="form-label">Estado/Provincia</label>
            <input type="text" class="form-control" id="estado" name="estado" required>
        </div>
    </div>
    
    <div class="mb-3">
        <label for="codigo_postal" class="form-label">Código Postal</label>
        <input type="text" class="form-control" id="codigo_postal" name="codigo_postal">
    </div>
    
    <button type="submit" class="btn btn-primary">Guardar</button>
    <?php if (isset($_GET['id_persona'])): ?>
    <a href="<?= BASE_URL ?>index.php?controller=persona&action=view&id=<?= $_GET['id_persona'] ?>" class="btn btn-secondary">Cancelar</a>
    <?php else: ?>
    <a href="<?= BASE_URL ?>index.php?controller=direccion&action=index" class="btn btn-secondary">Cancelar</a>
    <?php endif; ?>
</form>

<?php ?>
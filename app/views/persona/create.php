<?php
// Asegurarse de que existen las variables necesarias
$sexos = $sexos ?? [];
$estadosCiviles = $estadosCiviles ?? [];
?>

<h2>Crear Nueva Persona</h2>

<form action="/public/index.php?controller=persona&action=store" method="POST">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
    
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="nombre" name="nombre" required>
    </div>
    
    <div class="mb-3">
        <label for="apellido" class="form-label">Apellido</label>
        <input type="text" class="form-control" id="apellido" name="apellido" required>
    </div>
    
    <div class="mb-3">
        <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento">
    </div>
    
    <div class="mb-3">
        <label for="id_sexo" class="form-label">Sexo</label>
        <select class="form-select" id="id_sexo" name="id_sexo" required>
            <option value="">Seleccione...</option>
            <?php foreach ($sexos as $sexo): ?>
                <option value="<?= $sexo['id_sexo'] ?>"><?= htmlspecialchars($sexo['descripcion']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div class="mb-3">
        <label for="id_estadocivil" class="form-label">Estado Civil</label>
        <select class="form-select" id="id_estadocivil" name="id_estadocivil" required>
            <option value="">Seleccione...</option>
            <?php foreach ($estadosCiviles as $estado): ?>
                <option value="<?= $estado['id_estadocivil'] ?>"><?= htmlspecialchars($estado['descripcion']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="/public/index.php?controller=persona&action=index" class="btn btn-secondary">Cancelar</a>
</form>
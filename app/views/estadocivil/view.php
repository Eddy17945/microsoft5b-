<!-- APP_PATH/views/estadocivil/view.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de Estado Civil</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4>Detalles del Estado Civil</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>ID:</strong> <?php echo $this->estadoCivil->id_estadocivil; ?></p>
                        <p><strong>Descripción:</strong> <?php echo $this->estadoCivil->descripcion; ?></p>
                        
                        <div class="mt-3">
                            <a href="index.php?controller=estadocivil&action=edit&id=<?php echo $this->estadoCivil->id_estadocivil; ?>" class="btn btn-primary">Editar</a>
                            <a href="index.php?controller=estadocivil&action=index" class="btn btn-secondary">Volver</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
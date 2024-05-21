<?php
require_once('./php_librarys/bd.php');

$futbolistas = selectFutbolistas();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FUTBOLISTAS</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <!-- Header con botón Añadir -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Futbolistas</h1>
            <button type="button" class="btn btn-success" onclick="window.location.href='futbolista.php'">
                <i class="fas fa-plus"></i> Añadir
            </button>
        </div>

        <div class="row">
            <?php
            if (is_array($futbolistas) && !empty($futbolistas)) {
                foreach ($futbolistas as $futbolista) { 
                    // Convertir las competiciones en un array
                    $competiciones = explode(', ', $futbolista['competiciones_jugadas']);
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $futbolista['nombre']; ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted">Equipo: <?php echo $futbolista['equipo_nombre']; ?></h6>
                                <p class="card-text">
                                    <strong>Competiciones:</strong>
                                    <ul>
                                        <?php foreach ($competiciones as $competicion) { ?>
                                            <li><?php echo $competicion; ?></li>
                                        <?php } ?>
                                    </ul>
                                </p>
                            </div>
                            <div class="card-footer d-flex justify-content-between">
                                <button type="button" class="btn btn-primary" onclick="window.location.href='futbolistaput.php?id=<?php echo $futbolista['id']; ?>'">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                                <form action="./php_controllers/futbolistaController.php" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este futbolista?');">
                                    <input type="hidden" name="id" value="<?php echo $futbolista['id']; ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php }
            } else { ?>
                <div class="col-12">
                    <div class="alert alert-warning" role="alert">
                        No se encontraron futbolistas.
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Font Awesome JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</body>

</html>

<style>
    body{
        background-image: url(./img/futbol.png);
    }

    h1{
        color: white;
    }
</style>
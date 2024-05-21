<?php
require_once('./php_librarys/bd.php');

$equipos = selectEquipos();
$competiciones = selectCompeticiones();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Futbolista</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Añadir Futbolista</h1>
        <form action="./php_controllers/futbolistaController.php" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre del Futbolista</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="id_equipo">Equipo</label>
                <select class="form-control" id="id_equipo" name="id_equipo" required>
                    <option value="">Seleccione un equipo</option>
                    <?php foreach ($equipos as $equipo) { ?>
                        <option value="<?php echo $equipo['id']; ?>"><?php echo $equipo['nombre']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label>Competiciones</label><br>
                <?php foreach ($competiciones as $competicion) { ?>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="competicion_<?php echo $competicion['id']; ?>" name="competiciones[]" value="<?php echo $competicion['id']; ?>">
                        <label class="form-check-label" for="competicion_<?php echo $competicion['id']; ?>"><?php echo $competicion['nombre']; ?></label>
                    </div>
                <?php } ?>
            </div>
            <input type="hidden" name="action" value="insert">
            <button type="submit" class="btn btn-success">Añadir Futbolista</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.amazonaws.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

<style>
    body{
        background-image: url(./img/futbol.png);
    }

    h1{
        color: white;
    }

    form{
        color: white;
    }
</style>

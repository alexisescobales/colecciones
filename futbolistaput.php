<?php
require_once('./php_librarys/bd.php');

// Obtener el ID del futbolista de la URL
$id = $_GET['id'];

// Obtener los datos del futbolista
$futbolista = getFutbolistaById($id);

// Obtener los equipos y competiciones
$equipos = selectEquipos();
$competiciones = selectCompeticiones();

// Obtener las competiciones del futbolista
$futbolistaCompeticiones = getFutbolistaCompeticiones($id);

// Helper function to check if a competition is selected
function isChecked($competicionId, $futbolistaCompeticiones) {
    foreach ($futbolistaCompeticiones as $competicion) {
        if ($competicion['id'] == $competicionId) {
            return true;
        }
    }
    return false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Futbolista</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Editar Futbolista</h1>
        <form action="./php_controllers/futbolistaController.php" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre del Futbolista</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $futbolista['nombre']; ?>" required>
            </div>
            <div class="form-group">
                <label for="id_equipo">Equipo</label>
                <select class="form-control" id="id_equipo" name="id_equipo" required>
                    <option value="">Seleccione un equipo</option>
                    <?php foreach ($equipos as $equipo) { ?>
                        <option value="<?php echo $equipo['id']; ?>" <?php echo $equipo['id'] == $futbolista['id_equipo'] ? 'selected' : ''; ?>>
                            <?php echo $equipo['nombre']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="competiciones">Competiciones</label>
                <?php foreach ($competiciones as $competicion) { ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="competiciones[]" value="<?php echo $competicion['id']; ?>" <?php echo isChecked($competicion['id'], $futbolistaCompeticiones) ? 'checked' : ''; ?>>
                        <label class="form-check-label"><?php echo $competicion['nombre']; ?></label>
                    </div>
                <?php } ?>
            </div>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="action" value="update">
            <button type="submit" class="btn btn-success">Guardar Cambios</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php

function openBd()
{
    $servername = "localhost";
    $username = "root";
    $password = "mysql";

    // Create connection
    $conexion = new PDO("mysql:host=$servername;dbname=colecciones", $username, $password);

    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexion->exec("set names utf8");

    return $conexion;
}

function closeBd()
{
    return null;
}

function selectFutbolistas() {
    $conexion = openBd();

    // Consulta SQL modificada para obtener también las competiciones de cada futbolista
    $sentenciaText = "SELECT futbolista.id, futbolista.nombre, equipo.nombre AS equipo_nombre, GROUP_CONCAT(competiciones.nombre SEPARATOR ', ') AS competiciones_jugadas
                      FROM futbolista 
                      LEFT JOIN equipo ON futbolista.id_equipo = equipo.id
                      LEFT JOIN futbolista_competicion ON futbolista.id = futbolista_competicion.id_futbolista
                      LEFT JOIN competiciones ON futbolista_competicion.id_competicion = competiciones.id
                      GROUP BY futbolista.id";

    $sentencia = $conexion->prepare($sentenciaText);
    $sentencia->execute();

    $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $conexion = closeBd();

    return $resultado;
}


function insertFutbolista($nombre, $id_equipo, $competiciones) {
    try {
        $conexion = openBd();
        
        // Insertar el futbolista en la tabla futbolista
        $sentenciaText = "INSERT INTO futbolista (nombre, id_equipo) VALUES (:nombre, :id_equipo)";
        $sentencia = $conexion->prepare($sentenciaText);
        $sentencia->bindParam(':nombre', $nombre);
        $sentencia->bindParam(':id_equipo', $id_equipo);
        $sentencia->execute();
        
        // Obtener el ID del futbolista recién insertado
        $id_futbolista = $conexion->lastInsertId();
        
        // Insertar las competiciones del futbolista en la tabla relacional
        foreach ($competiciones as $competicion_id) {
            $sentenciaText = "INSERT INTO futbolista_competicion (id_futbolista, id_competicion) VALUES (:id_futbolista, :id_competicion)";
            $sentencia = $conexion->prepare($sentenciaText);
            $sentencia->bindParam(':id_futbolista', $id_futbolista);
            $sentencia->bindParam(':id_competicion', $competicion_id);
            $sentencia->execute();
        }
        
        $conexion = closeBd();
    } catch (PDOException $e) {
        echo "Error al insertar futbolista: " . $e->getMessage();
    }
}

function deleteFutbolista($id) {
    try {
        $conexion = openBd();

        // Eliminar las asociaciones en la tabla relacional
        $sentenciaText = "DELETE FROM futbolista_competicion WHERE id_futbolista = :id";
        $sentencia = $conexion->prepare($sentenciaText);
        $sentencia->bindParam(':id', $id);
        $sentencia->execute();

        // Eliminar el futbolista
        $sentenciaText = "DELETE FROM futbolista WHERE id = :id";
        $sentencia = $conexion->prepare($sentenciaText);
        $sentencia->bindParam(':id', $id);
        $sentencia->execute();

        $conexion = closeBd();
    } catch (PDOException $e) {
        echo "Error al eliminar futbolista: " . $e->getMessage();
    }
}
function getFutbolistaById($id) {
    $conexion = openBd();
    
    $sentenciaText = "SELECT * FROM futbolista WHERE id = :id";
    $sentencia = $conexion->prepare($sentenciaText);
    $sentencia->bindParam(':id', $id, PDO::PARAM_INT);
    $sentencia->execute();
    
    $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
    
    $conexion = closeBd();
    
    return $resultado;
}

function getFutbolistaCompeticiones($id) {
    $conexion = openBd();
    
    $sentenciaText = "SELECT competiciones.id, competiciones.nombre 
                      FROM competiciones
                      JOIN futbolista_competicion ON competiciones.id = futbolista_competicion.id_competicion
                      WHERE futbolista_competicion.id_futbolista = :id";
    $sentencia = $conexion->prepare($sentenciaText);
    $sentencia->bindParam(':id', $id, PDO::PARAM_INT);
    $sentencia->execute();
    
    $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    
    $conexion = closeBd();
    
    return $resultado;
}

function updateFutbolista($id, $nombre, $id_equipo, $competiciones) {
    try {
        $conexion = openBd();

        // Actualizar el futbolista en la tabla futbolista
        $sentenciaText = "UPDATE futbolista SET nombre = :nombre, id_equipo = :id_equipo WHERE id = :id";
        $sentencia = $conexion->prepare($sentenciaText);
        $sentencia->bindParam(':nombre', $nombre);
        $sentencia->bindParam(':id_equipo', $id_equipo);
        $sentencia->bindParam(':id', $id, PDO::PARAM_INT);
        $sentencia->execute();

        // Eliminar las competiciones actuales del futbolista
        $sentenciaText = "DELETE FROM futbolista_competicion WHERE id_futbolista = :id_futbolista";
        $sentencia = $conexion->prepare($sentenciaText);
        $sentencia->bindParam(':id_futbolista', $id, PDO::PARAM_INT);
        $sentencia->execute();

        // Insertar las nuevas competiciones del futbolista en la tabla relacional
        foreach ($competiciones as $competicion_id) {
            $sentenciaText = "INSERT INTO futbolista_competicion (id_futbolista, id_competicion) VALUES (:id_futbolista, :id_competicion)";
            $sentencia = $conexion->prepare($sentenciaText);
            $sentencia->bindParam(':id_futbolista', $id, PDO::PARAM_INT);
            $sentencia->bindParam(':id_competicion', $competicion_id, PDO::PARAM_INT);
            $sentencia->execute();
        }

        $conexion = closeBd();
    } catch (PDOException $e) {
        echo "Error al actualizar futbolista: " . $e->getMessage();
    }
}

function selectEquipos() {
    $conexion = openBd();
    
    $sentenciaText = "SELECT * FROM equipo";
    $sentencia = $conexion->prepare($sentenciaText);
    $sentencia->execute();
    
    $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    
    $conexion = closeBd();
    
    return $resultado;
}

function selectCompeticiones() {
    $conexion = openBd();
    
    $sentenciaText = "SELECT * FROM competiciones";
    $sentencia = $conexion->prepare($sentenciaText);
    $sentencia->execute();
    
    $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    
    $conexion = closeBd();
    
    return $resultado;
}





?>

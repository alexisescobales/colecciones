<?php

require_once ('../php_librarys/bd.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        switch ($action) {
            case 'insert':
                if (isset($_POST['nombre'], $_POST['id_equipo'], $_POST['competiciones'])) {
                    insertFutbolista($_POST['nombre'], $_POST['id_equipo'], $_POST['competiciones']);
                }
                break;
            case 'delete':
                if (isset($_POST['id'])) {
                    deleteFutbolista($_POST['id']);
                }
                break;
            case 'update':
                if (isset($_POST['id'], $_POST['nombre'], $_POST['id_equipo'], $_POST['competiciones'])) {
                    updateFutbolista($_POST['id'], $_POST['nombre'], $_POST['id_equipo'], $_POST['competiciones']);
                }
                break;
        }
    }

    header('Location: ../index.php');
    exit();
}

?>
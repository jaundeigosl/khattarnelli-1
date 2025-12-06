<?php
include_once "../paths.php";
include_once "../modelos/modelo_productos.php";

$action = $_GET['action'] ?? 'view_dashboard';
$offset = (int) ($_GET['offset'] ?? 0);      
$limit  = 15;                                

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    die("Error: Método no permitido. Solo se acepta GET.");
}

switch ($action) {

    case 'view_dashboard':
        try {

            $productos = obtener_datos_productos($offset, $limit);
            
            $status = $_GET['status'] ?? '';
            $message = $_GET['message'] ?? '';
            $action_performed = $_GET['action'] ?? '';
            
            include_once "../admin_pages/dashboard/dashboard.php";
            
        } catch (Exception $e) {
            http_response_code(500);
            die("Error al cargar el dashboard: " . $e->getMessage());
        }
        break;

    case 'load_more':
        try {
            $nuevos_productos = obtener_datos_productos($offset, $limit);

            header('Content-Type: application/json');
            echo json_encode(['status' => 'success', 'data' => $nuevos_productos]);
            
            exit;
            
        } catch (Exception $e) {

            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            exit;
        }

    default:
        http_response_code(404);
        die("Acción solicitada no encontrada.");
}


?>
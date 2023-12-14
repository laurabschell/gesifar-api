<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('content-type: application/json; charset=utf-8');
require 'estadisticasModel.php';
$estadisticasModel= new estadisticasModel();
switch($_SERVER['REQUEST_METHOD']){ 
    case 'GET':
        $respuesta = (!isset($_GET['chartId'])) ? $estadisticasModel->getEstadisticas() : $estadisticasModel->getEstadisticas($_GET['chartId']);
        echo json_encode($respuesta);
    break;

    break;
}


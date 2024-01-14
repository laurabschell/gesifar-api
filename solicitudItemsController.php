<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('content-type: application/json; charset=utf-8');
require 'solicitudItemsModel.php';
$solicitudItemsModel= new solicitudItemsModel();
switch($_SERVER['REQUEST_METHOD']){ 
    case 'GET':
        $respuesta = (!isset($_GET['id_solicitud'])) ? $solicitudItemsModel->getItems() : $solicitudItemsModel->getItems($_GET['id_solicitud']);
        echo json_encode($respuesta);
    break;

}


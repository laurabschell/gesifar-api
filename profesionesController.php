<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('content-type: application/json; charset=utf-8');
require 'profesionesModel.php';
$profesionesModel= new profesionesModel();
switch($_SERVER['REQUEST_METHOD']){ 
    case 'GET':
        $respuesta = (!isset($_GET['id'])) ? $profesionesModel->getprofesiones() : $profesionesModel->getprofesiones($_GET['id']);
        echo json_encode($respuesta);
    break;

    break;
}


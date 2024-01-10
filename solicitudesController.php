<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('content-type: application/json; charset=utf-8');
require 'solicitudesModel.php';
$solicitudesModel= new solicitudesModel();
switch($_SERVER['REQUEST_METHOD']){ 
    case 'GET':
        $respuesta = (!isset($_GET['id'])) ? $solicitudesModel->getSolicitudes() : $solicitudesModel->getSolicitudes($_GET['id']);
        echo json_encode($respuesta);
    break;

    case 'POST':
        $_POST= json_decode(file_get_contents('php://input',true));
        if(!isset($_POST->fecha) || is_null($_POST->fecha) || empty(trim($_POST->fecha))){
            $respuesta= ['error','Debe indicar la Fecha'];
        }
        else{
            $respuesta = $solicitudesModel->saveSolicitudes($_POST->responsable, $_POST->profesional,$_POST->area, $_POST->fecha, $_POST->estado,$_POST->rows );
        }
        echo json_encode($respuesta);
    break;

    case 'PUT':
        $_PUT= json_decode(file_get_contents('php://input',true));
        if(!isset($_PUT->id) || is_null($_PUT->id) || empty(trim($_PUT->id))){
            $respuesta= ['error','El ID no debe estar vacío'];
        }
        else if(!isset($_PUT->responsable) || is_null($_PUT->responsable) || empty(trim($_PUT->responsable))){
            $respuesta= ['error','Debe indicar el responsable'];
        }
        else if(!isset($_PUT->profesional) || is_null($_PUT->profesional) || empty(trim($_PUT->profesional))){
            $respuesta= ['error','Debe indicar la profesional'];
        }
        else if(!isset($_PUT->area) || is_null($_PUT->area) || empty(trim($_PUT->area))){
            $respuesta= ['error','Debe indicar la area'];
        }
        else if(!isset($_PUT->fecha) || is_null($_PUT->fecha) || empty(trim($_PUT->fecha))){
            $respuesta= ['error','Debe indicar la Fecha de Vencimiento'];
        }
        else if(!isset($_PUT->estado) || is_null($_PUT->estado) || empty(trim($_PUT->estado))){
            $respuesta= ['error','Debe indicar la estado'];
        }
        else if(!isset($_PUT->json) || is_null($_PUT->json) || empty(trim($_PUT->json))){
            $respuesta= ['error','Debe indicar la json'];
        }
        else{
            $respuesta = $solicitudesModel->updateSolicitudes($_PUT->id,$_PUT->$responsable,$_PUT->profesional,$_PUT->area,$_PUT->fecha,$_PUT->estado, $_PUT->json);
        }
        echo json_encode($respuesta);
    break;

    case 'DELETE';
        $_DELETE= json_decode(file_get_contents('php://input',true));
        if(!isset($_DELETE->id) || is_null($_DELETE->id) || empty(trim($_DELETE->id))){
            $respuesta= ['error','El ID de la solicitud no debe estar vacío'];
        }
        else{
            $respuesta = $solicitudesModel->deleteSolicitudes($_DELETE->id);
        }
        echo json_encode($respuesta);
    break;
}


<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('content-type: application/json; charset=utf-8');
require 'materialesModel.php';
$materialesModel= new materialesModel();
switch($_SERVER['REQUEST_METHOD']){
    case 'GET':
        $respuesta = (!isset($_GET['id'])) ? $materialesModel->getMateriales() : $materialesModel->getMateriales($_GET['id']);
        echo json_encode($respuesta);
    break;

    case 'POST':
        $_POST= json_decode(file_get_contents('php://input',true));
        if(!isset($_POST->tipo) || is_null($_POST->tipo) || empty(trim($_POST->tipo))){
            $respuesta= ['error','Debe indicar el tipo de material '];
        }
        else if(!isset($_POST->forma) || is_null($_POST->forma) || empty(trim($_POST->forma)) ){
            $respuesta= ['error','Debe indicar la Forma Farmaceutica'];
        }
        else if(!isset($_POST->presentacion) || is_null($_POST->presentacion) || empty(trim($_POST->presentacion))){
            $respuesta= ['error','Debe indicar la Presentación'];
        }
        else if(!isset($_POST->fecha_venc) || is_null($_POST->fecha_venc) || empty(trim($_POST->fecha_venc))){
            $respuesta= ['error','Debe indicar la Fecha de Vencimiento'];
        }
        /*else if(!isset($_POST->fecha_venc) || is_null($_POST->fecha_venc) || empty(trim($_POST->fecha_venc))){
            $respuesta= ['error','La Fecha de Vencimiento debe ser mayor a hoy'];
        }*/
        else{
            $respuesta = $materialesModel->saveMateriales($_POST->tipo, $_POST->forma,$_POST->presentacion,$_POST->fecha_venc);
        }
        echo json_encode($respuesta);
    break;

    case 'PUT':
        $_PUT= json_decode(file_get_contents('php://input',true));
        if(!isset($_PUT->id) || is_null($_PUT->id) || empty(trim($_PUT->id))){
            $respuesta= ['error','El ID del Material no debe estar vacío'];
        }
        else if(!isset($_PUT->tipo) || is_null($_PUT->tipo) || empty(trim($_PUT->tipo))){
            $respuesta= ['error','Debe indicar el Tipo de Material'];
        }
        else if(!isset($_PUT->forma) || is_null($_PUT->forma) || empty(trim($_PUT->forma)) || strlen($_PUT->forma) > 80){
            $respuesta= ['error','Debe indicar la Forma Farmaceutica'];
        }
        else if(!isset($_PUT->presentacion) || is_null($_PUT->presentacion) || empty(trim($_PUT->presentacion))){
            $respuesta= ['error','Debe indicar la Presentacion'];
        }
        else if(!isset($_PUT->fecha_venc) || is_null($_PUT->fecha_venc) || empty(trim($_PUT->fecha_venc)) || strlen($_PUT->fecha_venc) > 200){
            $respuesta= ['error','Debe indicar la Fecha de Vencimiento'];
        }
        else{
            $respuesta = $materialesModel->updateMateriales($_PUT->id,$_PUT->tipo,$_PUT->forma,$_PUT->presentacion,$_PUT->fecha_venc);
        }
        echo json_encode($respuesta);
    break;

    case 'DELETE';
        $_DELETE= json_decode(file_get_contents('php://input',true));
        if(!isset($_DELETE->id) || is_null($_DELETE->id) || empty(trim($_DELETE->id))){
            $respuesta= ['error','El ID del material no debe estar vacío'];
        }
        else{
            $respuesta = $materialesModel->deleteMateriales($_DELETE->id);
        }
        echo json_encode($respuesta);
    break;
}


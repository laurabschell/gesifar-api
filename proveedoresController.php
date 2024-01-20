<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('content-type: application/json; charset=utf-8');
require 'proveedoresModel.php';
$proveedoresModel= new proveedoresModel();
switch($_SERVER['REQUEST_METHOD']){
    case 'GET':
        $respuesta = (!isset($_GET['id'])) ? $proveedoresModel->getProveedores() : $proveedoresModel->getProveedores($_GET['id']);
        echo json_encode($respuesta);
    break;

    case 'POST':
        $_POST= json_decode(file_get_contents('php://input',true));
        if(!isset($_POST->cuit) || is_null($_POST->cuit) || empty(trim($_POST->cuit)) || strlen($_POST->cuit) > 80){
            $respuesta= ['error','El CUIT del proveedor no debe estar vacío'];
        }
        else if(!isset($_POST->razon_social) || is_null($_POST->razon_social) || empty(trim($_POST->razon_social)) || strlen($_POST->razon_social) > 150){
            $respuesta= ['error','La razon_social del proveedor no debe estar vacío'];
        }
        else if(!isset($_POST->email) || is_null($_POST->email) || empty(trim($_POST->email)) || strlen($_POST->email) > 150){
            $respuesta= ['error','El email del proveedor no debe estar vacío'];
        }
        else if(!isset($_POST->contacto) || is_null($_POST->contacto) || empty(trim($_POST->contacto))){
            $respuesta= ['error','El contacto no debe estar vacío'];
        }
        else{
            $respuesta = $proveedoresModel->saveProveedores($_POST->cuit, $_POST->razon_social,$_POST->email,$_POST->contacto, $_POST->direccion,);
        }
        echo json_encode($respuesta);
    break;

    case 'PUT':
        $_PUT= json_decode(file_get_contents('php://input',true));
        if(!isset($_PUT->id) || is_null($_PUT->id) || empty(trim($_PUT->id))){
            $respuesta= ['error','El ID del proveedor no debe estar vacío'];
        }
        else if(!isset($_PUT->cuit) || is_null($_PUT->cuit) || empty(trim($_PUT->cuit))){
            $respuesta= ['error','El CUIT del proveedor no debe estar vacío'];
        }
        else if(!isset($_PUT->razon_social) || is_null($_PUT->razon_social) || empty(trim($_PUT->razon_social)) || strlen($_PUT->razon_social) > 80){
            $respuesta= ['error','El razon_social del proveedor no debe estar vacío'];
        }
        else if(!isset($_PUT->email) || is_null($_PUT->email) || empty(trim($_PUT->email)) || strlen($_PUT->email) > 80){
            $respuesta= ['error','El email del proveedor no debe estar vacío'];
        }
        else if(!isset($_PUT->direccion) || is_null($_PUT->direccion) || empty(trim($_PUT->direccion)) || strlen($_PUT->direccion) > 150){
            $respuesta= ['error','La direccion del proveedor no debe estar vacío'];
        }
        else if(!isset($_PUT->contacto) || is_null($_PUT->contacto) ){
            $respuesta= ['error','El contacto del proveedor no debe estar vacío'];
        }
        else{
            $respuesta = $proveedoresModel->updateProveedores($_PUT->id,$_PUT->cuit,$_PUT->razon_social,$_PUT->email,$_PUT->telefono,$_PUT->direccion,$_PUT->contacto);
        }
        echo json_encode($respuesta);
    break;

    case 'DELETE';
        $_DELETE= json_decode(file_get_contents('php://input',true));
        if(!isset($_DELETE->id) || is_null($_DELETE->id) || empty(trim($_DELETE->id))){
            $respuesta= ['error','El ID del proveedor no debe estar vacío'];
        }
        else{
            $respuesta = $proveedoresModel->deleteProveedores($_DELETE->id);
        }
        echo json_encode($respuesta);
    break;
}


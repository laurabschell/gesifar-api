<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('content-type: application/json; charset=utf-8');
require 'responsablesModel.php';
$responsablesModel= new responsablesModel();
switch($_SERVER['REQUEST_METHOD']){
    case 'GET':
        $respuesta = (!isset($_GET['id'])) ? $responsablesModel->getResponsables() : $responsablesModel->getResponsables($_GET['id']);
        echo json_encode($respuesta);
    break;

    case 'POST':
        $_POST= json_decode(file_get_contents('php://input',true));
        if(!isset($_POST->dni) || is_null($_POST->dni) || empty(trim($_POST->dni)) || strlen($_POST->dni) > 80){
            $respuesta= ['error','El dni del profesional no debe estar vacío'];
        }
        else if(!isset($_POST->nombre) || is_null($_POST->nombre) || empty(trim($_POST->nombre)) || strlen($_POST->nombre) > 150){
            $respuesta= ['error','El nombre del personal no debe estar vacío'];
        }
        else if(!isset($_POST->apellido) || is_null($_POST->apellido) || empty(trim($_POST->apellido)) || strlen($_POST->apellido) > 150){
            $respuesta= ['error','El apellido del personal no debe estar vacío'];
        }
        else if(!isset($_POST->turno) || is_null($_POST->turno) || empty(trim($_POST->turno))){
            $respuesta= ['error','El turno no debe estar vacío'];
        }
        else{
            $respuesta = $responsablesModel->saveResponsables($_POST->dni, $_POST->nombre,$_POST->apellido,$_POST->telefono,$_POST->direccion,$_POST->turno);
        }
        echo json_encode($respuesta);
    break;

    case 'PUT':
        $_PUT= json_decode(file_get_contents('php://input',true));
        if(!isset($_PUT->id) || is_null($_PUT->id) || empty(trim($_PUT->id))){
            $respuesta= ['error','El ID del responsable no debe estar vacío'];
        }
        else if(!isset($_PUT->dni) || is_null($_PUT->dni) || empty(trim($_PUT->dni))){
            $respuesta= ['error','El DNI del responsable no debe estar vacío'];
        }
        else if(!isset($_PUT->nombre) || is_null($_PUT->nombre) || empty(trim($_PUT->nombre)) || strlen($_PUT->nombre) > 80){
            $respuesta= ['error','El nombre del responsable no debe estar vacío'];
        }
        else if(!isset($_PUT->apellido) || is_null($_PUT->apellido) || empty(trim($_PUT->apellido)) || strlen($_PUT->apellido) > 80){
            $respuesta= ['error','El apellido del responsable no debe estar vacío'];
        }
        else if(!isset($_PUT->telefono) || is_null($_PUT->telefono) || empty(trim($_PUT->telefono)) || strlen($_PUT->telefono) > 150){
            $respuesta= ['error','El telefono del responsable no debe estar vacío'];
        }
        else if(!isset($_PUT->turno) || is_null($_PUT->turno) ){
            $respuesta= ['error','El turno del responsable no debe estar vacío'];
        }
        else{
            $respuesta = $responsablesModel->updateResponsables($_PUT->id,$_PUT->dni,$_PUT->nombre,$_PUT->apellido,$_PUT->telefono,$_PUT->direccion,$_PUT->turno);
        }
        echo json_encode($respuesta);
    break;

    case 'DELETE';
        $_DELETE= json_decode(file_get_contents('php://input',true));
        if(!isset($_DELETE->id) || is_null($_DELETE->id) || empty(trim($_DELETE->id))){
            $respuesta= ['error','El ID del responsable no debe estar vacío'];
        }
        else{
            $respuesta = $responsablesModel->deleteResponsables($_DELETE->id);
        }
        echo json_encode($respuesta);
    break;
}


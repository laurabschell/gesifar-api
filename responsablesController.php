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
        $respuesta = (!isset($_GET['id'])) ? $responsablesModel->getresponsables() : $responsablesModel->getresponsables($_GET['id']);
        echo json_encode($respuesta);
    break;

    case 'POST':
        $_POST= json_decode(file_get_contents('php://input',true));
        if(!isset($_POST->name) || is_null($_POST->nombre) || empty(trim($_POST->name)) || strlen($_POST->nombre) > 150){
            $respuesta= ['error','El nombre del personal no debe estar vacío'];
        }
        else if(!isset($_POST->apellido) || is_null($_POST->apellido) || empty(trim($_POST->apellido)) || strlen($_POST->apellido) > 150){
            $respuesta= ['error','El apellido del personal no debe estar vacío'];
        }
        else{
            $respuesta = $personalModel->saveResponsables($_POST->name,$_POST->lastname);
        }
        echo json_encode($respuesta);
    break;

}


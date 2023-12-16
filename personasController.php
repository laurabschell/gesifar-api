<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('content-type: application/json; charset=utf-8');
require 'personasModel.php';
$personasModel= new personasModel();
switch($_SERVER['REQUEST_METHOD']){
    case 'GET':
        $respuesta = (!isset($_GET['id'])) ? $personasModel->getPersonas() : $personasModel->getPersonas($_GET['id']);
        echo json_encode($respuesta);
    break;

    case 'POST':
        $_POST= json_decode(file_get_contents('php://input',true));
        if(!isset($_POST->name) || is_null($_POST->name) || empty(trim($_POST->name)) || strlen($_POST->name) > 150){
            $respuesta= ['error','El nombre del personal no debe estar vacío'];
        }
        else if(!isset($_POST->lastname) || is_null($_POST->lastname) || empty(trim($_POST->lastname)) || strlen($_POST->lastname) > 150){
            $respuesta= ['error','El apellido del personal no debe estar vacío'];
        }
        else{
            $respuesta = $personalModel->savePersonas($_POST->name,$_POST->lastname);
        }
        echo json_encode($respuesta);
    break;

}


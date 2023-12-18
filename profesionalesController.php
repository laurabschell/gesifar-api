<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('content-type: application/json; charset=utf-8');
require 'profesionalesModel.php';
$profesionalesModel= new profesionalesModel();
switch($_SERVER['REQUEST_METHOD']){
    case 'GET':
        $respuesta = (!isset($_GET['id'])) ? $profesionalesModel->getProfesionales() : $profesionalesModel->getProfesionales($_GET['id']);
        echo json_encode($respuesta);
    break;

    case 'POST':
        $_POST= json_decode(file_get_contents('php://input',true));
        if(!isset($_POST->dni) || is_null($_POST->dni) || empty(trim($_POST->dni)) || strlen($_POST->dni) > 80){
            $respuesta= ['error','El dni del profesional no debe estar vacío'];
        }
        else if(!isset($_POST->nombre) || is_null($_POST->nombre) || empty(trim($_POST->nombre)) || strlen($_POST->nombre) > 150){
            $respuesta= ['error','El nombre del profesional no debe estar vacío'];
        }
        else if(!isset($_POST->apellido) || is_null($_POST->apellido) || empty(trim($_POST->apellido)) || strlen($_POST->apellido) > 150){
            $respuesta= ['error','El apellido del profesional no debe estar vacío'];
        }
        else if(!isset($_POST->profesion) || is_null($_POST->profesion) || empty(trim($_POST->profesion)) || strlen($_POST->profesion) > 150){
            $respuesta= ['error','La profesion del profesional no debe estar vacío'];
        }
        else if(!isset($_POST->area) || is_null($_POST->area) || empty(trim($_POST->area)) || strlen($_POST->area) > 200){
            $respuesta= ['error','El area del profesional no debe estar vacío'];
        }
        else{
            $respuesta = $profesionalesModel->saveProfesionales($_POST->dni, $_POST->nombre,$_POST->apellido,$_POST->profesion,$_POST->area);
        }
        echo json_encode($respuesta);
    break;

    case 'PUT':
        $_PUT= json_decode(file_get_contents('php://input',true));
        if(!isset($_PUT->id) || is_null($_PUT->id) || empty(trim($_PUT->id))){
            $respuesta= ['error','El ID del producto no debe estar vacío'];
        }
        else if(!isset($_PUT->dni) || is_null($_PUT->dni) || empty(trim($_PUT->dni))){
            $respuesta= ['error','El dni del profesional no debe estar vacío'];
        }
        else if(!isset($_PUT->nombre) || is_null($_PUT->nombre) || empty(trim($_PUT->nombre)) || strlen($_PUT->nombre) > 80){
            $respuesta= ['error','El nombre del profesional no debe estar vacío'];
        }
        else if(!isset($_PUT->apellido) || is_null($_PUT->apellido) || empty(trim($_PUT->apellido)) || strlen($_PUT->apellido) > 80){
            $respuesta= ['error','El apellido del profesional no debe estar vacío'];
        }
        else if(!isset($_PUT->profesion) || is_null($_PUT->profesion) || empty(trim($_PUT->profesion)) || strlen($_PUT->profesion) > 150){
            $respuesta= ['error','La descripción del profesional no debe estar vacío'];
        }
        else if(!isset($_PUT->area) || is_null($_PUT->area) || empty(trim($_PUT->area)) || strlen($_PUT->area) > 200){
            $respuesta= ['error','El area del profesional no debe estar vacío'];
        }
        else{
            $respuesta = $profesionalesModel->updateProfesionales($_PUT->id,$_PUT->dni,$_PUT->nombre,$_PUT->apellido,$_PUT->profesion,$_PUT->area);
        }
        echo json_encode($respuesta);
    break;

    case 'DELETE';
        $_DELETE= json_decode(file_get_contents('php://input',true));
        if(!isset($_DELETE->id) || is_null($_DELETE->id) || empty(trim($_DELETE->id))){
            $respuesta= ['error','El ID del producto no debe estar vacío'];
        }
        else{
            $respuesta = $profesionalesModel->deleteProfesionales($_DELETE->id);
        }
        echo json_encode($respuesta);
    break;
}


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
        if(!isset($_POST->DNI) || is_null($_POST->DNI) || empty(trim($_POST->DNI)) || strlen($_POST->DNI) > 80){
            $respuesta= ['error','El DNI del profesional no debe estar vacío'];
        }
        else if(!isset($_POST->name) || is_null($_POST->name) || empty(trim($_POST->name)) || strlen($_POST->name) > 150){
            $respuesta= ['error','El nombre del profesional no debe estar vacío'];
        }
        else if(!isset($_POST->lastname) || is_null($_POST->lastname) || empty(trim($_POST->lastname)) || strlen($_POST->lastname) > 150){
            $respuesta= ['error','El apellido del profesional no debe estar vacío'];
        }
        else if(!isset($_POST->profesion) || is_null($_POST->profesion) || empty(trim($_POST->profesion)) || strlen($_POST->profesion) > 150){
            $respuesta= ['error','La profesion del profesional no debe estar vacío'];
        }
        else if(!isset($_POST->area) || is_null($_POST->area) || empty(trim($_POST->area)) || strlen($_POST->area) > 200){
            $respuesta= ['error','El area del profesional no debe estar vacío'];
        }
        else{
            $respuesta = $profesionalesModel->saveProfesionales($_POST->DNI, $_POST->name,$_POST->lastname,$_POST->profesion,$_POST->area);
        }
        echo json_encode($respuesta);
    break;

    case 'PUT':
        $_PUT= json_decode(file_get_contents('php://input',true));
        if(!isset($_PUT->id) || is_null($_PUT->id) || empty(trim($_PUT->id))){
            $respuesta= ['error','El ID del producto no debe estar vacío'];
        }
        else if(!isset($_PUT->DNI) || is_null($_PUT->DNI) || empty(trim($_PUT->DNI))){
            $respuesta= ['error','El DNI del profesional no debe estar vacío'];
        }
        else if(!isset($_PUT->name) || is_null($_PUT->name) || empty(trim($_PUT->name)) || strlen($_PUT->name) > 80){
            $respuesta= ['error','El nombre del profesional no debe estar vacío'];
        }
        else if(!isset($_PUT->lastname) || is_null($_PUT->lastname) || empty(trim($_PUT->lastname)) || strlen($_PUT->lastname) > 80){
            $respuesta= ['error','El apellido del profesional no debe estar vacío'];
        }
        else if(!isset($_PUT->profesion) || is_null($_PUT->profesion) || empty(trim($_PUT->profesion)) || strlen($_PUT->profesion) > 150){
            $respuesta= ['error','La descripción del profesional no debe estar vacío'];
        }
        else if(!isset($_PUT->area) || is_null($_PUT->area) || empty(trim($_PUT->area)) || strlen($_PUT->area) > 200){
            $respuesta= ['error','El area del profesional no debe estar vacío'];
        }
        else{
            $respuesta = $profesionalesModel->updateProfesionales($_PUT->id,$_PUT->DNI,$_PUT->lastname,$_PUT->name,$_PUT->profesion,$_PUT->area);
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

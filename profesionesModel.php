<?php
class profesionesModel{
    public $conexion;
    public function __construct(){
        $this->conexion = new mysqli('localhost','root','','gesifar-api');
        mysqli_set_charset($this->conexion,'utf8');
    }

    public function getprofesiones($id=null){
        $where = ($id == null) ? "" : " WHERE id='$id'";
        $profesiones=[];
        $sql="SELECT * FROM profesiones ".$where;
        
        $registros = mysqli_query($this->conexion,$sql);
        while($row = mysqli_fetch_assoc($registros)){
            array_push($profesiones,$row);
        }
        return $profesiones;
    }

}


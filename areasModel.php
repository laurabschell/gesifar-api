<?php
class areasModel{
    public $conexion;
    public function __construct(){
        $this->conexion = new mysqli('localhost','root','','gesifar-api');
        mysqli_set_charset($this->conexion,'utf8');
    }

    public function getAreas($id=null){
        $where = ($id == null) ? "" : " WHERE id='$id'";
        $areas=[];
        $sql="SELECT * FROM areas ".$where;
        
        $registros = mysqli_query($this->conexion,$sql);
        while($row = mysqli_fetch_assoc($registros)){
            array_push($areas,$row);
        }
        return $areas;
    }

}


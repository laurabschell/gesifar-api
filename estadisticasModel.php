<?php
class estadisticasModel{
    public $conexion;
    public function __construct(){
        $this->conexion = new mysqli('localhost','root','','gesifar-api');
        mysqli_set_charset($this->conexion,'utf8');
    }

    public function getEstadisticas($chartId){
        //$where = ($id == null) ? "" : " WHERE id='$id'";
        $column = ($chartId==1) ? "area":"profesion";
        $estadisticas=[];
        $sql="SELECT ROW_NUMBER() OVER () AS id, 
        count(*) as cant, ".$column." as descripcion
        FROM profesionales group by ".$column;
        
        $registros = mysqli_query($this->conexion,$sql);
        while($row = mysqli_fetch_assoc($registros)){
            array_push($estadisticas,$row);
        }
        return $estadisticas;
    }

    
}


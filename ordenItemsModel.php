<?php
class ordenItemsModel{
    public $conexion;
    public function __construct(){
        $this->conexion = new mysqli('localhost','root','','gesifar-api');
        mysqli_set_charset($this->conexion,'utf8');
    }

    public function getItems($id_orden=null){
        $where = " WHERE id_orden='$id_orden'";
        $items=[];
        $sql="SELECT material, cantidad FROM detalle_orden ".$where;
        $registros = mysqli_query($this->conexion,$sql);
        while($row = mysqli_fetch_assoc($registros)){
            array_push($items,$row);
        }
        return $items;
    }

}


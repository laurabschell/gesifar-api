<?php
class ordenesModel{
    public $conexion;
    public function __construct(){
        $this->conexion = new mysqli('localhost','root','','gesifar-api');
        mysqli_set_charset($this->conexion,'utf8');
    }

    public function getOrdenes($id=null){
        $where = ($id == null) ? "" : " WHERE id='$id'";
        $ordenes=[];
        $sql="SELECT * FROM ordenes ".$where;
        $registros = mysqli_query($this->conexion,$sql);
        while($row = mysqli_fetch_assoc($registros)){
            array_push($ordenes,$row);
        }
        return $ordenes;
    }

    public function saveOrdenes($responsable, $proveedor, $fecha, $estado, $rows){
        $valida = $this->validateOrdenes($responsable, $proveedor, $fecha, $estado);
        $resultado=['error','Ya existe un material con los mismos datos'];       
        $json = json_encode($rows);                
        if(count($valida)==0){          
            $sql="call saveOrden('$responsable','$proveedor','$fecha', '$estado','$json')";
            mysqli_query($this->conexion,$sql);
            $resultado=['success','Registro exitoso '];
        }
        return $resultado;
    }

    public function updateOrdenes($id, $responsable, $proveedor, $fecha, $estado, $rows){
        $existe= $this->getOrdenes($id);
        $resultado=['error','No existe una orden con el id '.$id];
        $json = json_encode($rows); 
        if(count($existe)>0){
            $valida = $this->validateOrdenes($id);
            $resultado=['error','Ya existe una orden con los mismos datos'];
            if(count($valida)==0){
                $sql="call updateOrden('$id','$responsable','$proveedor', '$fecha', '$estado','$json')";
                mysqli_query($this->conexion,$sql);
                $resultado=['success','Datos actualizados'];
            }
        }
        return $resultado;
    }

    public function deleteOrdenes($id){
        $valida = $this->getOrdenes($id);
        $resultado=['error', 'No existe una orden con el id '.$id];
        if(count($valida)>0){
            $sql="call deleteOrden('$id')";
            mysqli_query($this->conexion,$sql);
            $resultado=['success','Orden eliminada'];
        }
        return $resultado;
    }
  
    public function validateOrdenes($id){
        $ordenes=[];
        /*$sql="SELECT * FROM ordenes 
            WHERE id<>'$id' ";
        $registros = mysqli_query($this->conexion,$sql);
        while($row = mysqli_fetch_assoc($registros)){
            array_push($ordenes,$row);
        }*/
        return $ordenes;
    }
}


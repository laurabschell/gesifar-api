<?php
class materialesModel{
    public $conexion;
    public function __construct(){
        $this->conexion = new mysqli('localhost','root','','gesifar-api');
        mysqli_set_charset($this->conexion,'utf8');
    }

    public function getMateriales($id=null){
        $where = ($id == null) ? "" : " WHERE id='$id'";
        $materiales=[];
        $sql="SELECT * FROM materiales ".$where;
         
        $registros = mysqli_query($this->conexion,$sql);
        while($row = mysqli_fetch_assoc($registros)){
            array_push($materiales,$row);
        }
        return $materiales;
    }

    public function saveMateriales($nombre, $tipo, $forma, $presentacion, $fecha_venc){
        $valida = $this->validateMateriales(0, $nombre, $tipo,$forma,$presentacion, $fecha_venc);
        $resultado=['error','Ya existe un material con los mismos datos'];
        if(count($valida)==0){
            $sql="INSERT INTO materiales(nombre, tipo, forma, presentacion, fecha_venc) VALUES('$nombre','$tipo','$forma','$presentacion', '$fecha_venc')";
            
            mysqli_query($this->conexion,$sql);
            $resultado=['success','Registro exitoso'];
        }
        return $resultado;
    }

    public function updateMateriales($id, $nombre, $tipo, $forma, $presentacion, $fecha_venc){
        $existe= $this->getMateriales($id);
        $resultado=['error','No existe un material con el id '.$id];
        if(count($existe)>0){
            $valida = $this->validateMateriales($id, $nombre, $tipo, $forma, $presentacion, $fecha_venc);
            $resultado=['error','Ya existe un material con los mismos datos'];
            if(count($valida)==0){
                $sql="UPDATE materiales SET nombre='$nombre',tipo='$tipo', forma= '$forma', presentacion='$presentacion',fecha_venc='$fecha_venc' 
                    WHERE id='$id' ";
                mysqli_query($this->conexion,$sql);
                $resultado=['success','Datos actualizados'];
            }
        }
        return $resultado;
    }
    
    public function deleteMateriales($id){
        $valida = $this->getMateriales($id);
        $resultado=['error', 'No existe un material con el id '.$id];
        if(count($valida)>0){
            $sql="DELETE FROM materiales 
            WHERE id='$id' ";
            mysqli_query($this->conexion,$sql);
            $resultado=['success','Material eliminado'];
        }
        return $resultado;
    }
    
    public function validateMateriales($id, $nombre, $tipo, $forma, $presentacion, $fecha_venc){
        $materiales=[];
        $sql="SELECT * FROM materiales 
            WHERE nombre='$nombre' 
            AND tipo='$tipo' 
            AND forma='$forma' 
            AND presentacion='$presentacion' 
            AND fecha_venc='$fecha_venc' ";
        $sql.= " AND id<>'$id'";
        $registros = mysqli_query($this->conexion,$sql);
        while($row = mysqli_fetch_assoc($registros)){
            array_push($materiales,$row);
        }
        return $materiales;
    }
}


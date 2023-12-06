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
        //SELECT DATE_FORMAT("2017-06-15", "%M %d %Y");
        //$sql="SELECT id, tipo, forma, presentacion, DATE_FORMAT(fecha_venc, '%Y-%m-%d') FROM materiales ".$where;
        
        $registos = mysqli_query($this->conexion,$sql);
        while($row = mysqli_fetch_assoc($registos)){
            array_push($materiales,$row);
        }
        return $materiales;
    }

    public function saveMateriales($tipo,$forma,$presentacion, $fecha_venc){
        $valida = $this->validateMateriales($tipo,$forma,$presentacion, $fecha_venc);
        $resultado=['error','Ya existe un material con los mismos datos'];
        if(count($valida)==0){
            $sql="INSERT INTO materiales(tipo, forma, presentacion, fecha_venc) VALUES('$tipo','$forma','$presentacion', '$fecha_venc')";
            //STR_TO_DATE("10/17/2021", "%m/%d/%Y")
/*$sql="INSERT INTO materiales(tipo, forma, presentacion, fecha_venc) VALUES('$tipo','$forma','$presentacion', STR_TO_DATE($fecha_venc, '%Y/%m/%d'))";
*/
            mysqli_query($this->conexion,$sql);
            $resultado=['success','Registro exitoso'];
        }
        return $resultado;
    }

    public function updateMateriales($id, $tipo,$forma,$presentacion, $fecha_venc){
        $existe= $this->getMateriales($id);
        $resultado=['error','No existe un material con el id '.$id];
        if(count($existe)>0){
            $valida = $this->validateMateriales($tipo,$forma, $presentacion, $fecha_venc);
            $resultado=['error','Ya existe un material con los mismos datos'];
            if(count($valida)==0){
                $sql="UPDATE materiales SET tipo='$tipo', forma= '$forma', presentacion='$presentacion',fecha_venc='$fecha_venc' 
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
    
    public function validateMateriales($tipo,$forma,$presentacion, $fecha_venc){
        $materiales=[];
        $sql="SELECT * FROM materiales 
            WHERE tipo='$tipo' 
            AND forma='$forma' 
            AND presentacion='$presentacion' 
            AND fecha_venc='$fecha_venc' ";
        $registos = mysqli_query($this->conexion,$sql);
        while($row = mysqli_fetch_assoc($registos)){
            array_push($materiales,$row);
        }
        return $materiales;
    }
}


<?php
class solicitudesModel{
    public $conexion;
    public function __construct(){
        $this->conexion = new mysqli('localhost','root','','gesifar-api');
        mysqli_set_charset($this->conexion,'utf8');
    }

    public function getSolicitudes($id=null){
        $where = ($id == null) ? "" : " WHERE id='$id'";
        $solicitudes=[];
        $sql="SELECT * FROM solicitudes ".$where;
        //SELECT DATE_FORMAT("2017-06-15", "%M %d %Y");
        //$sql="SELECT id, tipo, forma, presentacion, DATE_FORMAT(fecha_venc, '%Y-%m-%d') FROM solicitudes ".$where;
        
        $registos = mysqli_query($this->conexion,$sql);
        while($row = mysqli_fetch_assoc($registos)){
            array_push($solicitudes,$row);
        }
        return $solicitudes;
    }

    public function saveSolicitudes($persona, $profesional, $area, $fecha, $estado){
        $valida = $this->validateSolicitudes($persona,$profesional,$area, $fecha, $estado);
        $resultado=['error','Ya existe un material con los mismos datos'];
        if(count($valida)==0){
            $sql="INSERT INTO solicitudes(personal_resp, profesional_solicitante, area, fecha, estado) 
            VALUES('$persona','$profesional','$area', '$fecha', '$estado')";
            
            mysqli_query($this->conexion,$sql);
            $resultado=['success','Registro exitoso'];
        }
        return $resultado;
    }

    
    public function deleteSolicitudes($id){
        $valida = $this->getSolicitudes($id);
        $resultado=['error', 'No existe un material con el id '.$id];
        if(count($valida)>0){
            $sql="DELETE FROM solicitudes 
            WHERE id='$id' ";
            mysqli_query($this->conexion,$sql);
            $resultado=['success','Material eliminado'];
        }
        return $resultado;
    }
    
    public function validateSolicitudes($persona, $profesional, $area, $fecha, $estado){
        $solicitudes=[];
        $sql="SELECT * FROM solicitudes 
            WHERE personal_resp='$persona' 
            AND profesional_solicitante='$profesional' 
            AND area='$area' 
            AND fecha='$fecha' ";
        $registros = mysqli_query($this->conexion,$sql);
        while($row = mysqli_fetch_assoc($registros)){
            array_push($solicitudes,$row);
        }
        return $solicitudes;
    }
}


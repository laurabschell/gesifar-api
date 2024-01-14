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
        $registos = mysqli_query($this->conexion,$sql);
        while($row = mysqli_fetch_assoc($registos)){
            array_push($solicitudes,$row);
        }
        return $solicitudes;
    }

    public function saveSolicitudes($responsable, $profesional, $area, $fecha, $estado, $rows){
        $valida = $this->validateSolicitudes($responsable, $profesional, $area, $fecha, $estado);
        $resultado=['error','Ya existe un material con los mismos datos'];       
        $json = json_encode($rows);                
        if(count($valida)==0){          
            $sql="call saveSolicitud('$responsable','$profesional','$area', '$fecha', '$estado','$json')";
            mysqli_query($this->conexion,$sql);
            $resultado=['success','Registro exitoso '];
        }
        return $resultado;
    }

    public function updateSolicitudes($id, $responsable, $profesional, $area, $fecha, $estado, $rows){
        $existe= $this->getSolicitudes($id);
        $resultado=['error','No existe una solicitud con el id '.$id];
        $json = json_encode($rows); 
        if(count($existe)>0){
            $valida = $this->validateSolicitudes($id);
            $resultado=['error','Ya existe una solicitud con los mismos datos'];
            if(count($valida)==0){
                $sql="call updateSolicitud('$id','$responsable','$profesional','$area', '$fecha', '$estado','$json')";
                mysqli_query($this->conexion,$sql);
                $resultado=['success','Datos actualizados'];
            }
        }
        return $resultado;
    }

    public function deleteSolicitudes($id){
        $valida = $this->getSolicitudes($id);
        $resultado=['error', 'No existe una solicitud con el id '.$id];
        if(count($valida)>0){
            $sql="call deleteSolicitud('$id')";
            mysqli_query($this->conexion,$sql);
            $resultado=['success','Solicitud eliminada'];
        }
        return $resultado;
    }
  
    public function validateSolicitudes($id){
        $solicitudes=[];
        /*$sql="SELECT * FROM solicitudes 
            WHERE id<>'$id' ";
        $registros = mysqli_query($this->conexion,$sql);
        while($row = mysqli_fetch_assoc($registros)){
            array_push($solicitudes,$row);
        }*/
        return $solicitudes;
    }
}


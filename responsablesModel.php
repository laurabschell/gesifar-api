<?php
class responsablesModel{
    public $conexion;
    public function __construct(){
        $this->conexion = new mysqli('localhost','root','','gesifar-api');
        mysqli_set_charset($this->conexion,'utf8');
    }

    public function getResponsables($id=null){
        $where = ($id == null) ? "" : " WHERE id='$id'";
        $responsables=[];
        $sql="SELECT * FROM personal_resp ".$where;      
        $registros = mysqli_query($this->conexion,$sql);
        while($row = mysqli_fetch_assoc($registros)){
            array_push($responsables,$row);
        }
        return $responsables;
    }

    public function saveResponsables($DNI, $nombre, $apellido, $telefono, $direccion, $turno){
        $valida = $this->validateResponsables(0,$nombre,$apellido);
        $resultado=['error','Ya existe un responsable con los mismos datos'];
        if(count($valida)==0){
            $sql="INSERT INTO personal_resp(DNI, nombre, apellido, telefono, direccion, turno) VALUES('$DNI','$nombre','$apellido', '$telefono','$direccion', '$turno')";
            mysqli_query($this->conexion,$sql);
            $resultado=['success','Registro exitoso'];
        }
        return $resultado;
    }

    public function updateResponsables($id, $DNI,$nombre,$apellido, $telefono, $direccion, $turno){
        $existe= $this->getResponsables($id);
        $resultado=['error','No existe un responsable con el id '.$id];
        if(count($existe)>0){
            $valida = $this->validateResponsables($id, $nombre, $apellido);
            $resultado=['error','Ya existe un responsable con los mismos datos'];
            if(count($valida)==0){
                $sql="UPDATE personal_resp SET DNI='$DNI', nombre= '$nombre', apellido='$apellido',telefono='$telefono',direccion='$direccion',turno='$turno' WHERE id='$id' ";
                mysqli_query($this->conexion,$sql);
                $resultado=['success','Datos actualizados'];
            }
        }
        return $resultado;
    }

    public function deleteResponsables($id){
        $valida = $this->getResponsables($id);
        $resultado=['error', 'No existe un responsable con el id '.$id];
        if(count($valida)>0){
            $sql="DELETE FROM personal_resp WHERE id='$id' ";
            mysqli_query($this->conexion,$sql);
            $resultado=['success','Responsable eliminado'];
        }
        return $resultado;
    }

    /*public function validateResponsables($id, $DNI, $nombre, $apellido, $telefono, $direccion, $turno){*/
    public function validateResponsables($id, $nombre, $apellido){
        
        $responsables=[];
        $sql="SELECT * FROM personal_resp 
        WHERE nombre='$nombre' AND apellido='$apellido' ";
        $sql.= " AND id<>'$id'";
        $registros = mysqli_query($this->conexion,$sql);
        while($row = mysqli_fetch_assoc($registros)){
            array_push($responsables,$row);
        }
        return $responsables;
    }
}


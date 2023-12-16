<?php
class profesionalesModel{
    public $conexion;
    public function __construct(){
        $this->conexion = new mysqli('localhost','root','','gesifar-api');
        mysqli_set_charset($this->conexion,'utf8');
    }

    public function getProfesionales($id=null){
        $where = ($id == null) ? "" : " WHERE id='$id'";
        $profesionales=[];
        $sql="SELECT * FROM profesionales ".$where;
        $registros = mysqli_query($this->conexion,$sql);
        while($row = mysqli_fetch_assoc($registros)){
            array_push($profesionales,$row);
        }
        return $profesionales;
    }

    public function saveProfesionales($DNI,$nombre,$apellido, $profesion, $area){
        $valida = $this->validateProfesionales(0,$DNI,$name,$lastname, $profesion, $area);
        $resultado=['error','Ya existe un profesional con los mismos datos'];
        if(count($valida)==0){
            $sql="INSERT INTO profesionales(DNI, nombre, apellido, profesion, area) VALUES('$DNI','$nombre','$apellido', '$profesion', '$area')";
            mysqli_query($this->conexion,$sql);
            $resultado=['success','Registro exitoso'];
        }
        return $resultado;
    }

    public function updateProfesionales($id, $DNI,$nombre,$apellido, $profesion, $area){
        $existe= $this->getProfesionales($id);
        $resultado=['error','No existe un profesional con el id '.$id];
        if(count($existe)>0){
            $valida = $this->validateProfesionales($id,$DNI,$nombre,$apellido, $profesion, $area);
            $resultado=['error','Ya existe un profesional con los mismos datos'];
            if(count($valida)==0){
                $sql="UPDATE profesionales SET DNI='$DNI', nombre= '$nombre', apellido='$apellido',profesion='$profesion',area='$area' WHERE id='$id' ";
                mysqli_query($this->conexion,$sql);
                $resultado=['success','Datos actualizados'];
            }
        }
        return $resultado;
    }
    
    public function deleteProfesionales($id){
        $valida = $this->getProfesionales($id);
        $resultado=['error', 'No existe un profesional con el id '.$id];
        if(count($valida)>0){
            $sql="DELETE FROM profesionales WHERE id='$id' ";
            mysqli_query($this->conexion,$sql);
            $resultado=['success','Profesional eliminado'];
        }
        return $resultado;
    }
    
    public function validateProfesionales($id,$DNI,$name,$lastname, $profesion, $area){
        $profesionales=[];
        $sql="SELECT * FROM profesionales WHERE DNI='$DNI' AND nombre='$nombre' AND apellido='$apellido' AND profesion='$profesion' AND area='$area' ";
        $sql.= " AND id<>'$id'";
        $registros = mysqli_query($this->conexion,$sql);
        while($row = mysqli_fetch_assoc($registros)){
            array_push($profesionales,$row);
        }
        return $profesionales;
    }
}


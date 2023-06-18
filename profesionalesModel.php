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
        $registos = mysqli_query($this->conexion,$sql);
        while($row = mysqli_fetch_assoc($registos)){
            array_push($profesionales,$row);
        }
        return $profesionales;
    }

    public function saveProfesionales($DNI,$name,$lastname, $profesion, $area){
        $valida = $this->validateProfesionales($DNI,$name,$lastname, $profesion, $area);
        $resultado=['error','Ya existe un profesional con los mismos datos'];
        if(count($valida)==0){
            $sql="INSERT INTO profesionales(DNI, name, lastname, profesion, area) VALUES('$DNI','$name','$lastname', '$profesion', '$area')";
            mysqli_query($this->conexion,$sql);
            $resultado=['success','Registro exitoso'];
        }
        return $resultado;
    }

    public function updateProfesionales($id, $DNI,$name,$lastname, $profesion, $area){
        $existe= $this->getProfesionales($id);
        $resultado=['error','No existe un profesional con el id '.$id];
        if(count($existe)>0){
            $valida = $this->validateProfesionales($DNI,$name,$lastname, $profesion, $area);
            $resultado=['error','Ya existe un profesional con los mismos datos'];
            if(count($valida)==0){
                $sql="UPDATE profesionales SET DNI='$DNI', name= '$name', lastname='$lastname',profesion='$profesion',area='$area' WHERE id='$id' ";
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
    
    public function validateProfesionales($DNI,$name,$lastname, $profesion, $area){
        $profesionales=[];
        $sql="SELECT * FROM profesionales WHERE DNI='$DNI' AND name='$name' AND lastname='$lastname' AND profesion='$profesion' AND area='$area' ";
        $registos = mysqli_query($this->conexion,$sql);
        while($row = mysqli_fetch_assoc($registos)){
            array_push($profesionales,$row);
        }
        return $profesionales;
    }
}


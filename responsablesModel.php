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

    public function saveResponsables($name, $lastname){
        $valida = $this->validateResponsable(0,$nombre,$apellido);
        $resultado=['error','Ya existe un personal con los mismos datos'];
        if(count($valida)==0){
            $sql="INSERT INTO personal_resp(nombre, apellido) VALUES('$nombre','$apellido')";
            mysqli_query($this->conexion,$sql);
            $resultado=['success','Registro exitoso'];
        }
        return $resultado;
    }

    public function validateResponsables($id, $nombre, $apellido){
        $responsables=[];
        $sql="SELECT * FROM personal_resp WHERE nombre='$nombre' AND apellido='$apellido' ";
        $sql.= " AND id<>'$id'";
        $registros = mysqli_query($this->conexion,$sql);
        while($row = mysqli_fetch_assoc($registros)){
            array_push($personal,$row);
        }
        return $responsables;
    }
}


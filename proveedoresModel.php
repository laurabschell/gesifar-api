<?php
class proveedoresModel{
    public $conexion;
    public function __construct(){
        $this->conexion = new mysqli('localhost','root','','gesifar-api');
        mysqli_set_charset($this->conexion,'utf8');
    }

    public function getProveedores($id=null){
        $where = ($id == null) ? "" : " WHERE id='$id'";
        $proveedores=[];
        $sql="SELECT * FROM proveedores ".$where;      
        $registros = mysqli_query($this->conexion,$sql);
        while($row = mysqli_fetch_assoc($registros)){
            array_push($proveedores,$row);
        }
        return $proveedores;
    }

    public function saveProveedores($cuit, $razon_social, $email, $direccion, $contacto){
        $valida = $this->validateProveedores(0,$cuit);
        $resultado=['error','Ya existe un proveedor con los mismos datos'];
        if(count($valida)==0){
            $sql="INSERT INTO proveedores(cuit, razon_social, email, direccion, contacto) VALUES('$cuit','$razon_social','$email', '$direccion','$contacto')";
            mysqli_query($this->conexion,$sql);
            $resultado=['success','Registro exitoso'];
        }
        return $resultado;
    }

    public function updateProveedores($id, $CUIT, $razon_social, $email, $direccion, $contacto){
        $existe= $this->getProveedores($id);
        $resultado=['error','No existe un proveedor con el id '.$id];
        if(count($existe)>0){
            $valida = $this->validateProveedores($id, $CUIT, $razon_social);
            $resultado=['error','Ya existe un responsable con los mismos datos'];
            if(count($valida)==0){
                $sql="UPDATE proveedores SET CUIT='$CUIT', razon_social= '$razon_social', email='$email', direccion='$direccion',contacto='$contacto' WHERE id='$id' ";
                mysqli_query($this->conexion,$sql);
                $resultado=['success','Datos actualizados'];
            }
        }
        return $resultado;
    }

    public function deleteProveedores($id){
        $valida = $this->getProveedores($id);
        $resultado=['error', 'No existe un proveedor con el id '.$id];
        if(count($valida)>0){
            $sql="DELETE FROM proveedores WHERE id='$id' ";
            mysqli_query($this->conexion,$sql);
            $resultado=['success','Proveedor eliminado'];
        }
        return $resultado;
    }

    public function validateProveedores($id, $CUIT){
        
        $proveedores=[];
        $sql="SELECT * FROM proveedores
        WHERE CUIT='$CUIT' ";
        $sql.= " AND id<>'$id'";
        $registros = mysqli_query($this->conexion,$sql);
        while($row = mysqli_fetch_assoc($registros)){
            array_push($proveedores,$row);
        }
        return $proveedores;
    }
}


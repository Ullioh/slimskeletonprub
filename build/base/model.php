<?php
namespace ReplaceNamespace;
ReplaceUse;

class ReplaceName extends InitModel{
    private $db;
    private $table = 'tabla_use';
    private $column = array(inserted);
    private $column_select = array(shown);
    private $column_update = array(edited);
    private $column_filter = array(filteruse);
    private $url;

    public function __CONSTRUCT()
    {
        $CONFIG_G = new ConfigGlobal();
        $this->url = $CONFIG_G->getServer();
        parent::__construct(array(
            "table"             =>  $this->table,
            "column"            =>  $this->column,
            "column_select"     =>  $this->column_select,
            "column_update"     =>  $this->column_update,
            "column_filter"     =>  $this->column_filter,
            "column_status"     =>  status_delete
        ));
        $this->db = Database::StartUp();
    }

    // public function test($data){
    //     try {
    //         $sql = "SELECT * FROM $this->table WHERE id = ".$data['id'];  
    //         $stm = $this->db->prepare($sql);
    //         $stm->execute();

    //         return $stm->fetch();
    //     } catch(Exception $e){
    //         return $e;
    //     }
    // }

    // public function testInsert($data){
    //     try{
    //         $sql= "INSERT INTO $this->table(email, clave, nombre, cedula, ocupacion, empresa, rif, direccion, id_estado, id_subzona, ciudad, telefono, celular, fecha_nacimiento, status) 
    //         VALUE(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    //         $this->db->prepare($sql)->execute(array(
    //             $data['email'],
    //             $data['clave'],
    //             $data['nombre'],
    //             $data['cedula'],
    //             $data['ocupacion'],
    //             $data['empresa'],
    //             $data['rif'],
    //             $data['direccion'],
    //             $data['id_estado'],
    //             $data['id_subzona'],
    //             $data['ciudad'],
    //             $data['telefono'],
    //             $data['celular'],
    //             $data['fecha_nacimiento'],
    //             1,
    //         ));
    //         $id = $this->db->lastInsertId();

    //         $data = $id;

    //         return $data;
    //     }catch(Exception $e){
    //         return $e;
    //     }
    // }

}
?>
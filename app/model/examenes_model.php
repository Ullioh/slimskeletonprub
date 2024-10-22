<?php
namespace App\Model;
use App\Lib\Database;
use App\Config\ConfigGlobal;
use App\Config\InitModel;

class ExamenesModel extends InitModel{
    private $db;
    private $table = 'examenes';
    private $column = array("nombre","descripcion");
    private $column_select = array("id","nombre","descripcion");
    private $column_update = array("nombre","descripcion");
    private $column_filter = array("nombre","descripcion");
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
            "column_status"     =>  array(
                "name"      =>  "status",
                "deleted"   =>  0
            )
        ));
        $this->db = Database::StartUp();
    }
}
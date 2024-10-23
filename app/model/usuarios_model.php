<?php
namespace App\Model;
use App\Lib\Database;
use App\Config\ConfigGlobal;
use App\Config\InitModel;

class UsuariosModel extends InitModel{
    private $db;
    private $table = 'users';
    private $column = array("user","password");
    private $column_select = array("id","user","password");
    private $column_update = array("user","password");
    private $column_filter = array("user");
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
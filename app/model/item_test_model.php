<?php
namespace App\Model;
use App\Lib\Database;
use App\Config\ConfigGlobal;
use App\Config\InitModel;

class ItemTestModel extends InitModel{
    private $db;
    private $table = 'item_test';
    private $column = array("id_test","item");
    private $column_select = array("id","id_test","item");
    private $column_update = array("id_test","item");
    private $column_filter = array("id_test","item");
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
            "column_status"     =>  null
        ));
        $this->db = Database::StartUp();
    }
}
?>
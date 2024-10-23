<?php
namespace App\Config;
use App\Lib\Database;
use App\Config\ConfigGlobal;

class InitModel{
    private $db;
    private $table = '';
    private $col = [];
    private $col_temp = [];
    private $col_select = [];
    private $col_filter = [];
    private $col_update = [];
    private $col_status = [];
    private $orderBySql = "";
    private $groupBySql = "";
    private $limitSql = "";
    private $whereSql = "";
    private $inner = "";

    public function __CONSTRUCT($table)
    {
        $this->db = Database::StartUp();
        $CONFIG_G = new ConfigGlobal();
        $this->table = $table['table'];
        $this->col = $table['column'];
        $this->col_temp = $table['column'];
        $this->col_select = $table['column_select'];
        $this->col_filter = $table['column_filter'];
        $this->col_update = $table['column_update'];
        $this->col_status = $table['column_status'];
        $this->init();
    }

    private function init(){
        for ($i=0; $i < count($this->col); $i++) { 
            $this->col[$i] = $this->table.".".$this->col[$i];
        }
        if($this->col_select){
            for ($i=0; $i < count($this->col_select); $i++) { 
                $this->col_select[$i] = $this->table.".".$this->col_select[$i];
            }
        }
        if($this->col_filter){
            for ($i=0; $i < count($this->col_filter); $i++) { 
                $this->col_filter[$i] = $this->table.".".$this->col_filter[$i];
            }
        }
        if($this->col_status){
            $this->col_status['name'] = $this->table.".".$this->col_status['name'];
        }
    }

    public function getTable(){
        return $this->table;
    }

    public function getCol(){
        return $this->col;
    }
    
    public function getColSelect(){
        return $this->col_select;
    }

    public function first(){
        try {
            $sql = "SELECT ".implode(",",$this->col_select)." FROM $this->table $this->inner  
            WHERE ".$this->whereSql.$this->getDelete()." ".$this->orderBySql;
            $stm = $this->db->prepare($sql);
            $stm->execute();

            return $stm->fetch();
        } catch(Exception $e){
            return $e;
        }
    }

    public function get($id){
        try {
            $sql = "SELECT ".implode(",",$this->col_select)." FROM $this->table $this->inner WHERE id = $id ".$this->getDelete().$this->whereSql.$this->groupBySql.$this->orderBySql.$this->limitSql;
            $stm = $this->db->prepare($sql);
            $stm->execute();

            return $stm->fetch();
        } catch(Exception $e){
            return $e;
        }
    }

    public function getBy($data){
        try {
            $filter = $this->getDataNotRelation($data);
            $this->whereSql = empty($this->whereSql) ? "":" and ".$this->whereSql;

            $sql = "SELECT ".implode(",",$this->col_select)." FROM $this->table $this->inner WHERE (".implode("and",$filter[0]).") ".$this->getDelete().$this->whereSql.$this->groupBySql.$this->orderBySql.$this->limitSql;  
            $stm = $this->db->prepare($sql);
            $stm->execute($filter[1]);

            return $stm->fetch();
        } catch(Exception $e){
            return $e;
        }
    }

    public function getAllBy($data){
        try {
            $filter = $this->getDataNotRelation($data);

            $sql = "SELECT ".implode(",",$this->col_select)." FROM $this->table $this->inner WHERE (".implode("and",$filter[0]).") ".$this->getDelete().$this->whereSql." ".$this->groupBySql.$this->orderBySql.$this->limitSql;  
            $stm = $this->db->prepare($sql);
            $stm->execute($filter[1]);

            return $stm->fetchAll();
        } catch(Exception $e){
            return $e;
        }
    }
    
    public function getAll(){
        try {
            if(empty($this->getDeleteWithoutWhere())){
                $getDelete = "";
            }else{
                if(empty($this->whereSql)){
                    $getDelete = $this->getDeleteWithoutWhere();
                }else{
                    $getDelete = " and ".$this->getDeleteWithoutWhere();
                }
            }
            $sql = "SELECT ".implode(",",$this->col_select)." FROM $this->table $this->inner  
            WHERE ".$this->whereSql.$getDelete." ".$this->groupBySql." ".$this->orderBySql.$this->limitSql;  
            $stm = $this->db->prepare($sql);
            $stm->execute();

            return $stm->fetchAll();
        } catch(Exception $e){
            return $e;
        }
    }

    public function getPagination($data){
        $lim = $data['limit'];
        $pos = ($data['position']*$data['limit']);
        $sea = $data['search'];
        return [
            "rows"  =>  $this->getPaginationRows($lim,$pos,$sea),
            "count" =>  $this->getPaginationCount($lim,$pos,$sea) ? $this->getPaginationCount($lim,$pos,$sea)->total:0
        ];
    }

    private function getPaginationRows($lim,$pos,$sea){
        try {
            $filter = implode(" like '%$sea%' or ",$this->col_filter)." like '%$sea%'";
            $getDelete = empty($this->getDeleteWithoutWhere()) ? "":$this->getDeleteWithoutWhere()." and ";
            $this->whereSql = empty($this->whereSql) ? "":" and ".$this->whereSql;
            $sql = "SELECT ".implode(",",$this->col_select)." FROM $this->table $this->inner WHERE 
            ".$getDelete." ($filter) ".$this->whereSql." $this->groupBySql $this->orderBySql limit $pos,$lim"; 
            // echo $sql;
            $stm = $this->db->prepare($sql);
            $stm->execute();

            return $stm->fetchAll();
        } catch(Exception $e){
            return $e;
        }
    }

    private function getPaginationCount($lim,$pos,$sea){
        try {
            $filter = implode(" like '%$sea%' or ",$this->col_filter)." like '%$sea%'";
            $getDelete = empty($this->getDeleteWithoutWhere()) ? "":$this->getDeleteWithoutWhere()." and ";
            $sql = "SELECT count($this->table.id) as total FROM $this->table $this->inner WHERE 
            ".$getDelete." ($filter) ".$this->whereSql." ".$this->groupBySql; 
            $stm = $this->db->prepare($sql);
            $stm->execute();

            return $stm->fetch();
        } catch(Exception $e){
            return $e;
        }
    }

    public function insert($dataaAsociative){
        $data = $this->getData($dataaAsociative,$this->col_temp);
        try {
            $inter = [];
            $insertArray = [];
            foreach ($this->col as $i => $value) {
                $inter[]="?";
            }
            $sql = "INSERT INTO $this->table(".implode(",",$this->col).") 
                VALUES(".implode(",",$inter).")";
            $this->db->prepare($sql)->execute($data);

            $id = $this->db->lastInsertId();

            return $id;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function update($dataaAsociative){
        $data = $this->getData($dataaAsociative,$this->col_update);
        $data[] = $dataaAsociative["id"];
        try {
            $sql = "UPDATE $this->table SET 
                ".implode(" = ?, ",$this->col_update)." = ?
                WHERE id = ?";
            $this->db->prepare($sql)->execute($data);

            $id = $data[count($data)-1];

            return $id;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function updateOnly($dataaAsociative){
        $data = $this->getDataNotRelation($dataaAsociative['data']);
        $data[1][] = $dataaAsociative["id"];
        try {
            $sql = "UPDATE $this->table SET 
                ".implode(" , ",$data[0])."
                WHERE id = ?";
            $this->db->prepare($sql)->execute($data[1]);

            $id = $dataaAsociative;

            return $id;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function delete($id){
        try {
            if($this->getColumnDelete()){
                $sql = "UPDATE $this->table SET ".$this->col_status['name']." = '".$this->col_status['deleted']."' WHERE id = $id";
            }else{
                $sql = "DELETE FROM $this->table WHERE id = $id";
            }

            $this->db->prepare($sql)->execute();

            return true;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function deleteBy($data){
        try {
            $filter = $this->getDataNotRelation($data);

            if($this->getColumnDelete()){
                $sql = "UPDATE $this->table SET ".$this->col_status['name']." = '".$this->col_status['deleted']."' WHERE ".implode("and",$filter[0]);
            }else{
                $sql = "DELETE FROM $this->table WHERE ".implode("and",$filter[0]);
            }

            $this->db->prepare($sql)->execute($filter[1]);

            return true;
        } catch (Exception $e) {
            return $e;
        }
    }

    private function getData($data,$comparative){
        $result = [];
        foreach ($comparative as $i => $value) {
            if(isset($data[$value])){
                $result[] = $data[$value];
            }else{
                $result[] = null;
            }
        }
        return $result;
    }

    private function getDataNotRelation($data){
        $filter = [];
        $dataFilter = []; 
        foreach ($data as $i => $value) {
            $filter[]=" $i = ? ";
            $dataFilter[]=$value;
        }

        return [$filter, $dataFilter];
    }

    private function getColumnDelete(){
        if($this->col_status){
            return true;
        }else{
            return false;
        }
    }

    private function getDelete(){
        if($this->col_status){
            return " and ".$this->col_status['name']." <> '".$this->col_status['deleted']."'";
        }else{
            return "";
        }
    }

    private function getDeleteWithoutWhere(){
        if($this->col_status){
            return " ".$this->col_status['name']." <> '".$this->col_status['deleted']."'";
        }else{
            return "";
        }
    }

    public function orderBy($data){
        $tempSql = [];
        foreach ($data as $key => $value) {
            $tempSql[]=$value; 
        }
        if($tempSql){
            $this->orderBySql = " ORDER BY ". implode(", ",$tempSql);
        }
        return $this;
    }

    public function groupBy($data){
        if(!empty($data)){
            $this->groupBySql = " GROUP BY ". $data;
        }
        return $this;
    }

    public function limit($data){
        if(!empty($data)){
            $this->limitSql = " limit ". $data;
        }
        return $this;
    }

    public function where($data){
        if(!empty($data)){
            if(empty($this->whereSql)){
                $this->whereSql = " (".$data.")";
            }else{
                $this->whereSql = $this->whereSql." and (".$data.")";
            }
        }
        return $this;
    }

    public function andWhere($data){
        if(!empty($data)){
            if(empty($this->whereSql)){
                $this->whereSql = " (".$data.")";
            }else{
                $this->whereSql = $this->whereSql." and (".$data.")";
            }
        }
        return $this;
    }

    public function orWhere($data){
        if(!empty($data)){
            if(empty($this->whereSql)){
                $this->whereSql = " (".$data.")";
            }else{
                $this->whereSql = $this->whereSql." or (".$data.")";
            }
        }
        return $this;
    }

    public function select($data){
        $this->col_select = $data;
        return $this;
    }

    public function innerJoin($class,$on){
        $table_join = $class->getTable();
        $this->col_select = array_merge($this->col_select,$class->getColSelect());
        $this->inner = $this->inner."INNER JOIN $table_join on $on ";
        return $this;
    }

    public function leftJoin($class,$on){
        $table_join = $class->getTable();
        $this->col_select = array_merge($this->col_select,$class->getColSelect());
        $this->inner = $this->inner."LEFT JOIN $table_join on $on ";
        return $this;
    }

    public function rightJoin($class,$on){
        $table_join = $class->getTable();
        $this->col_select = array_merge($this->col_select,$class->getColSelect());
        $this->inner = $this->inner."RIGHT JOIN $table_join on $on ";
        return $this;
    }

}

?>
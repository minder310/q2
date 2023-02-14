<?php
date_default_timezone_set("Asia/Tiapie");
session_start();

function($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
};

class DB{
    private $dns="mysql=localhost:local;charset=utf8;dbname=db14";
    private $root="root";
    private $pw="";
    private $db;
    private $table;
    private function __construct($table){
        $this->table=$table;
        $this->db=new PDO($this->dns,$this->root,$this->pw);
    }
    private function ArrayToSql($array){
        foreach($array as $key => $value){
            $tmp[]=" `$key` = '$value' ";
        }
        return $tmp;
    }
    // 查詢的兩個指令。
    public function find($id){
        $sql=" select * from '$this->table' ";
        if(is_array($id)){
            $tmp=$this->ArrayToSql($id);
            $sql=$sql." where ".join(" && ",$tmp);
        }else{
            $sql=$sql." where `id` = '$id'";
        }
        return $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);
    }
    public function all(...$arg){
        $sql="select * from '$this->table' ";
        if(isset($arg[0])){
            if(is_array($arg[0])){
                $tmp=$this->ArrayToSql($arg[0]);
                $sql=$sql." where ".join(" && ",$tmp);
            }else{
                $sql=$sql.$arg[0];
            }
        }
        if(isset($arg[1])){
            $sql=$sql.$arg[1];
        }
    }
    // 刪除的function
    public function del($array){
        $sql=" delete  from `$this->table` ";
        if(is_array($array)){
            $tmp=$this->ArrayToSql($array);
            $sql=$sql." where ".join(" && ",$tmp);
        }else{
            $sql=$sql." where `id` = '$array' ";
        }
        return $this->db->exec($sql);
    }
    public function Update($array){
        if(isset($array['id'])){
            $id=$array['id'];
            unset($array['id']);
            $tmp=$this->ArrayToSql($array);
            $sql="update `$this->table` set ".join(" && ",$tmp)." where `id` = '$id'";
        }else{
            $sql="insert into `$this->table` (`";
            $key=array_keys($array);
            $sql=$sql.join("`,`", $key)."`) values ('".join("','",$array)."')";
        }
        return $this->db->exec($sql);

    }
    private function math($math,...$arg){
        switch($math){
            case 'count':
                $sql ="select count(*) from $this->table";
                break;
            default:
                $col=$arg[0];
                $sql="select $math($col) from $this->table";
        }
                                        //SQL聚合函數，輸出用指令。
        return $this->db->query($sql)->fetchColumn();
    }
    // 統計總共有多少資料。
    public function count(...$arg){
        return $this("count",...$arg);
    }
    // 哪個表格加總。
    public function sum($col,...$arg){
        return $this->math("sum",$col,...$arg);
    }
    // 取最大值。
    public function max($col,...$arg){
        return $this->math("max",$col,...$arg);
    }
    // 取最小值
    public function min($col,...$arg){
        return $this->math("min",$col,...$arg);
    }
    // 平均值
    public function avg($col,...$arg){
        return $this->math("avg",$col,...$arg);
    }

}


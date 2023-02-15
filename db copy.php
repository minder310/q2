<?php
                        // 這邊好像台北英文有錯。
date_default_timezone_set("Asia/Taipei");
session_start();

function dd($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

class DB{
    private $dns="mysql:host=localhost;charset=utf8;dbname=db14";
    private $root="root";
    private $pw="";
    private $table;
    private $db;
    // 進入後自動執行
    public function __construct($table)
    {
        $this->table=$table;
        $this->db=new PDO($this->dns,$this->root,$this->pw);
    } 
    // 文字拆解
    private function ArrayToSql($array){
        foreach($array as $key => $value){
            $tmp[]=" `$key` = '$value' ";
        }
        return $tmp;
    }
    // 輸入
    public function InPut($data){
        if(isset($data['id'])){
            // 這邊是更新資料。
            $id=$data['id'];
            unset($data['id']);
            $tmp=$this->ArrayToSql($data);
            $sql="update `$this->table` set ".join(",".$tmp)." where `id` = '$id'";
        }else{
            // 這邊是直接新增資料。
            $key=array_keys($data);
            $sql="insert into `$this->table` ( `".join("`,`",$key)."` ) values ('".join("','",$data)."')";
        }
        dd($sql);
        return $this->db->exec($sql);
    }
    // 輸出
    // 輸出一個
    public function Show($id){
        if(is_array($id)){
            $tmp=$this->ArrayToSql($id);
            $sql="select * from $this->table where ".join(" && ",$tmp);
        }else{
            $sql="select * from $this->table where `id` = '$id'";
        }
        dd($sql);
        return $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);
    }
    // 輸出所有
    public function all(...$arg){
        $sql="select * from $this->table";
        if(isset($arg[0])){
            if(is_array($arg[0])){
                $tmp=$this->ArrayToSql($arg[0]);
                $sql="select * from $this->table where ".join(" && ",$tmp);
            }else{
                $sql="select * from $this->table ".$arg[0];
            }
        }
        if(isset($arg[1])){
            $sql=$sql . $arg[1];
        };
        return $this->db->query($sql)->fetchall(PDO::FETCH_ASSOC);
    }
    // 刪除
    public function del($id){
        $sql="delete from $this->table where ";
        if(is_array($id)){
            $tmp=$this->ArrayToSql($id);
            $sql=$sql.join("&&",$id);
        }else{
            $sql=$sql." `id` = '$id'";
        }
        return $this->db->exec($sql);
    }
    // 數學
    private function math($math,...$arg){
        switch($math){
            case "count":
                // 只輸出資料總量。
                $sql="select count(*) from $this->table";
                if(isset($arg[0])){
                    $con=$arg[0];
                }
                break;
                default:
                // 只輸出，數學函式。
                $col=$arg[0];
                if(isset($arg[1])){
                    $con=$arg[1];
                }
                $sql="select $math($col) from $this->table";
        }
        if(isset($con)){
            if(is_array($con)){
                $tmp=$this->ArrayToSql($con);
                            // 符合哪些條件才輸出。
                $sql=$sql." where ".join(" && ",$tmp);
            }else{
                        // 後面是打直接要的功能。
                dd($sql);
                $sql=$sql.$con;
                dd($sql);
            }
        }
        dd($sql);
        // 這邊要背起來。
        return $this->db->query($sql)->fetchColumn();
    }
    // 其他數學公式
    public function count(...$arg){
        return $this->math("count",...$arg);
    }
    public function mix($col,...$arg){
        return $this->math("mix",$col,...$arg);
    }
    public function max($col,...$arg){
        return $this->math("max",$col,...$arg);
    }
    public function svg($col,...$arg){
        return $this->math("svg",$col,...$arg);
    }
    public function sum($col,...$arg){
        return  $this->math("sum",$col,...$arg);
    }
}
$news=new DB("news");

// dd($news->all());
echo $news->sum("id");
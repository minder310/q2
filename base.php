<?php
date_default_timezone_set("Asia/Taipei");
session_status();

function dd($input)
{
    echo "<pre>";
    print_r($input);
    echo "</pre>";
};

function to($url){
    header("location",$url);
}

class DB
{
    private $dsn = "mysql:host=localhost;charset=utf8;dbname=db14";
    private $root = "root";
    private $password = "";
    private $table;
    private $pdo;
    public $type=[
        1=>'健康新知',
        2=>'菸害防制',
        3=>'癌症治療',
        4=>'慢性病預防'
    ];

    // 宣告啟動class時自動啟動。
    public function __construct($table)
    {
        // 帶入table並且class內的table=帶入$TAble。
        $this->table = $table;
        // 宣告連結資料庫。
        $this->pdo = new PDO($this->dsn, $this->root, $this->password);
    }

    // class內部function。
    // 參數內容必須是key-value型態陣列。
    // 每一個陣列元素會轉為字串，並暫時存入tmp陣列中。
                                    // 輸入的資料是["key值"=>"value值"]。
    private function arrayToSqlArray($array)
    {
        // 將key值與value值分開來並且，轉成$key=$value，並轉成陣列。
        foreach ($array as $key => $value) {
            $tmp[] = "`$key`='$value'";
        }
        return $tmp;
    }

                    //math(執行的種類，輸入的資料。) 
    private function math($math, ...$arg)
    {
        // 使用swithch來判斷方法，不同的聚合函式。
        // 這邊得math
        switch ($math) {
                // 要是math==count會跑以下計算。
            case 'count':
                // 計算count(*)所有資料數量，from 我們選擇的table。
                $sql = "select count(*) from $this->table";
                if (isset($arg[0])) {
                    $con = $arg[0];
                }
                // echo "0";
                // dd($sql);
                break;
                // 要是都不是會跑以下計算。
            default:
                $col = $arg[0];
                if (isset($arg[1])) {
                    $con = $arg[1];
                }
            //            帶入的功能。 從$this->table表單中。
             $sql="select $math($col) from $this->table";
            //  echo "1";
            //  dd($sql);
        }
        // 如果參數式這列，則要做字串的轉換後代入到sql語法字串中。
        if (isset($con)) {
            if (is_array($con)) {
                $tmp = $this->arrayToSqlArray($con);
                $sql = $sql . " where " . join("&&", $tmp);
            } else {
                $sql = $sql . $con;
            }
            // echo "2";
            // dd($sql);
        }
        // echo "3";
        // dd($sql);
                                    // fetchcolumn將結果，儲存在行回傳。是字串。
        return $this->pdo->query($sql)->fetchColumn();
    }
    // 這邊還沒看懂
    public function count(...$arg){
        return $this->math('count',...$arg);
    }
    public function sum($col,...$arg){
        return $this->math('sum',$col,...$arg);
    }
    // $type,max(sh=1,)
    public function max($col,...$arg){
        return $this->math('max',$col,...$arg);
    }
    public function min($col,...$arg){
        return $this->math('min',$col,...$arg);
    }
    public function avg($col,...$arg){
        return $this->math('avg',$col,...$arg);
    }
    // 需要解析。

    // 搜尋你要的全部資料。
    public function all(...$arg)
    {
        // 如果沒有輸入值，直接輸出，整張表單。
        $sql = "select * from $this->table";

        // 如果$arg內有帶值。執行以下程式碼。
        if (isset($arg[0])) {
            // 如果是陣列執行以下程式碼。
            if (is_array($arg[0])) {
                // 轉換陣列key=value的形式。
                $tmp = $this->arrayToSqlArray($arg[0]);
                // 將sql合並加上條件。
                $sql = $sql . " where" . join(" && ", $tmp);
            } else {
                // 如果不是陣列的時候。
                $sql = $sql . $arg[0];
            }
        }
        // 如果第二個參數存在。
        if (isset($arg[1])) {
            $sql = $sql . $arg[1]; //串接SQL字串。
        }
        dd($sql);
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    // 以下是搜尋單筆資料，可以與all合併成一個公式即可。
    // 查詢符合條件的單筆資料。
    // 預設是查詢id輸入id號碼即可，如果是陣列就要[key值=>value值]。
    public function find($id)
    {
        $sql = "select * from $this->table ";

        if (is_array($id)) {
            $tmp = $this->arrayToSqlArray($id);
            // 同時符合什麼條件，才會輸出。
            $sql = $sql . " where " . join(" && ", $tmp);
        } else {
            $sql = $sql . " where `id` = '$id' ";
        }
        // dd($sql);
                                        // 輸出一個數列。或格子。
        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }
    // 刪除資料table->del($id)-刪除資料。
    // 預設是id輸入id號碼即可，如果是陣列就要[key值=>value值]。
    public function del($id)
    {

        $sql = "delete from $this->table ";

        if (is_array($id)) {
            $tmp = $this->arrayToSqlArray($id);
            $sql = $sql . " where " . join(" && ", $tmp);
        } else {
            $sql = $sql . " where `id`='$id'";
        }
        dd($sql);
        return $this->pdo->exec($sql);
    }
    // 新增/更新資料。
    public function save($array){
        if(isset($array['id'])){
            // 更新判斷，要是裡面有id即為更新原有資料所以會跑更新。
            $id=$array['id'];
            // 刪除array陣列中的id選項，為自動生成值，所以存入時要做刪除。
            unset($array['id']);
            // 透過$this->arrayToSqlArray($array);將陣列轉換成字串。
            $tmp=$this->arrayToSqlArray($array);
            $sql="update $this->table set ".join(",",$tmp)." where `id`='$id'";
        }else{
            // 這邊是沒有id而id是自動生成，所以，這邊是新增資料。
            // 新增資料。
            // 將key值，提取出來做成一個，陣列。
            $cols=array_keys($array);
            $sql="insert into $this->table (`".join("`,`",$cols)."`)
                                     values('".join("','",$array)."')";       
            
        }
        dd($sql);
        return $this->pdo->exec($sql);
    }
    public function q($sql){
        // 
        $dsn="mysql:host=localhost;charset=utf8;dbname=db14";
        $pdo=new PDO($dsn,'root','');
        return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
$user=new DB("user");
$total=new DB("total");
$news=new DB("news");
$que=new DB("que");
$log=new DB("log");

if(!isset($_SESSION['total'])){
    // 
    $today=$total->find(['date'=>date("Y-m-d")]);
    // 如果$today==0,null，或是不存在。
    if(empty($today)){
        // 沒有今天的資料->更新
        $today=['date'=>date("Y-m-d"),'total'=>1];
    }else{
        $today['total']++;
    }
    // 更新日期儲存進
    $total->save($today);
    $_SESSION['total']=1;
}

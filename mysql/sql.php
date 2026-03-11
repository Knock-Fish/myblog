<?php
// 引入初始化文件，连接数据库
include_once(__DIR__.'/init.php');
// mysql语句函数
function sql($sql,$sql_type=NULL){
    $pdo = get_pdo();
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    // 如果是select语句，则根据$sql_typ选择的类型返回值
    if($sql_type == "data"){
        // 以数组形式返回查询的数据
        $data_arr = [];
        while($user = $stmt->fetch(PDO::FETCH_ASSOC)){
            array_push($data_arr,$user);
        }
        return $data_arr;
    }elseif($sql_type == "recordCount"){
        // 返回查询结果的数量
        $count = $stmt->rowCount();
        return $count;
    }
}
?>
<?php
include_once(__DIR__.'/sql.php');
// 接口
function getAdmin() {
    // 拼接接口参数，将接口返回出去
    $json_data = ["code"=>"0","msg"=>"成功","data"=>sql('select * from admin;','data')];
    echo json_encode($json_data);
}
getAdmin()
?>
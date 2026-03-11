<?php
include_once(__DIR__.'/sql.php');
// 接口
function getClassify() {
    // 拼接接口参数，将接口返回出去
    $json_data = ["code"=>"0","msg"=>"成功","data"=>sql('select * from classify;','data')];
    echo json_encode($json_data);
}
getClassify()
?>
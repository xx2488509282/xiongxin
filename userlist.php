<?php
header('Content-type:text/html;charset=utf-8');

$type=$_GET['type'];
$page=$_GET['page'];
$name=$_GET['name'];
$age=$_GET['age'];
$sex=$_GET['sex'];
$phone=$_GET['phone'];
$userId=$_GET['id'];


//链接数据库
$link=mysqli_connect('localhost','auth','123456','gp03');
if(!$link){
    echo '{"err":0,"msg":"链接失败"}';
    die();
};

if($type==='page'){
    $all_sql='select * from autho';
    $all_res=mysqli_query($link,$all_sql);
    $total=mysqli_affected_rows($link);
    $start=($page-1)*8;
    $page_sql="select * from autho order by id limit $start,8";
    $page_res=mysqli_query($link,$page_sql);
    $page_all=mysqli_fetch_all($page_res,1);
    $data=json_encode($page_all);
    if( count($page_all)>0){
        echo '{"err":1,"msg":"成功获取导数据","page":'.$total.',"data":'.$data.'}';
    }else{
        echo '{"err":0,"msg":"没有数据"}';
    }
}else if($type==='updata'){
    $updata_sql="update autho set name='$name',sex='$sex',age=$age,phone=$phone where id=$userId";
    $updata_res=mysqli_query($link,$updata_sql);
    $updata_total=mysqli_affected_rows($link);
    if( $updata_total>0){
        echo '{"err":1,"msg":"编辑成功"}';
    }else{
        echo '{"err":0,"msg":"编辑失败"}';
}
}else if($type==='addData'){
    // $id_sql='select * from autho';
    // $id_res=mysqli_query($link,$all_sql);
    // $id_total=mysqli_affected_rows($link);
    $addData_sql="INSERT INTO autho (name,sex,age,phone) VALUES ('$name','$sex','$age','$phone')";
    $addData_res=mysqli_query($link,$addData_sql);
    $addData_total=mysqli_affected_rows($link);
    echo "$addData_total";
    if( $addData_total>0){
        echo '{"err":1,"msg":"添加成功"}';
    }else{
        echo '{"err":0,"msg":"添加失败"}';
}
}else if($type==='deleteData'){
    $delete_sql="delete from autho where id='$userId'";
    $delete_res=mysqli_query($link,$delete_sql);
    $delete_todal=mysqli_affected_rows($link);
    if($delete_todal>0){
        echo '{"err":1,"msg"："删除成功"}';
    }else{
        echo '{"err":0,"msg"："删除失败"}';
    }
}
   
?>
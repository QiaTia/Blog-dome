<?php
/*
 * @Author: QiaTia
 * @Description: 心情日记后台
 * @Date: 2019-04-06 18:20:12
 * @LastEditTime: 2019-05-26 12:05:30
 */

header('Content-type: application/json; charset=UTF-8');
header("Access-Control-Allow-Origin: *");
include_once '../public/sql.php';
$pageSize = 12;
date_default_timezone_set('PRC');
$time=date("Y-m-d H:i:s",time());

/**
 * @description: 添加心情状态
 * @param { addMode } 
 * @return: jsonp
 */
if(isset($_REQUEST['diary'])){
	$data = array();
	$articles = array();
	$data['time'] = $time;
	$t = 0;
	/**
 * @description: 添加心情日记
 * @param {diary, addMode} 
 * @return: jsonp
 */
	if(isset($_REQUEST['addMode'])){
		$stmt = $conn->prepare("INSERT INTO `MoodDiary` (`time`, `text`, `mood`) VALUES (? ,? ,?);");
    $text= $_REQUEST['diary'];
    $mood= $_REQUEST['addMode'];
    try{
      $stmt->bind_param('sss',$time, $text, $mood);
      $stmt->execute();
      $articles['msg'] = 'Success!';
      $articles['code'] = '200';
    }catch (PDOException $e) {
      $articles['msg'] = 'Fail! '.$e->getMessage();
      $articles['code'] = '500';
    }
  }
 /**
  * @description: 
  * @param {type} 
  * @return: 
  */ 
	else{
		$limit = (isset($_REQUEST['diary'])?$_REQUEST['diary'] - 1:0) * $pageSize;
		$res = $conn->query("SELECT * FROM `MoodDiary` ORDER BY `time` DESC LIMIT $limit, $pageSize;");
		while($info = $res->fetch_assoc()){
			array_push($articles,$info);
			$t++;
		}
	}
	$data['count'] = $t;
	$data['data'] = $articles;
	$data['code'] = 200;
	die(json_encode($data));
}
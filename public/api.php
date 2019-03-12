<?php
header('Content-type: application/json; charset=UTF-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods","POST, GET, PUT, OPTIONS, DELETE, PATCH");
include_once '../public/sql.php';
include_once '../public/data.php';
$pageSize = 12;
date_default_timezone_set('PRC');
$time=date("Y-m-d H:i:s",time());
/*
* $ip = $_SERVER["REMOTE_ADDR"];
* 
*
*/

/*
* 文章内容查询
* 需要 传入  article 整型 文章id
* 返回  josn 数据
*/
if(isset($_REQUEST['article'])){
  $id = $_REQUEST['article'];
  $sql="SELECT * FROM os WHERE `id` = '$id'";//查询表
  $result = $conn->query($sql);
  $info = $result->fetch_assoc();
  $info['reply'] = $conn->query("SELECT * FROM  `reply` WHERE  `conid` ='".$info['id']."'")->num_rows;
  $info['flow'] = $flow = $info['flow']+1;
  $sql="UPDATE `os` SET `flow` = '$flow' WHERE `id` = '$id'";
  // $sql = "UPDATE `os` SET `flow` = 'flow' + 1 WHERE `id` = '$id'";
  $conn->query($sql);
  print_r(json_encode($info));
}

/*
* 按时间分页检索文章 
* 需要 传入  articles 整型 页码
* 返回  josn 数据
*/
if(isset($_REQUEST['articles'])){
  $page = $_REQUEST['articles'];
  $totalPage = ceil($conn->query("SELECT * FROM  `os`")->num_rows / $pageSize);
  if($page > $totalPage) die('null');
  $limit = ($page-1) * $pageSize;
  $sql="SELECT * FROM `os` ORDER BY `time` DESC LIMIT $limit , $pageSize";//查询表
  $res = $conn->query($sql);
  $articles = array();
  while($info = $res->fetch_assoc()){
    $content_01 = $info["con"];
    $content_02 = htmlspecialchars_decode($content_01);
    $content_03 = str_replace("&nbsp;","",$content_02);
    $contents = strip_tags($content_03);
    $con = mb_substr($contents, 0, 130,"utf-8");
    $info['contents'] =  $con.'...';;
    $info['con'] = '';
    $info['reply'] = $conn->query("SELECT * FROM  `reply` WHERE  `conid` ='".$info['id']."'")->num_rows;
    array_push($articles,$info);
  }
  print_r(json_encode($articles));
}

/*
* 按关键字检索文章 
* 需要 传入  search 字符串 标签名 
*           page 整型 页码
* 返回  josn 数据
*/
if(isset($_REQUEST['search'])){
  $s = $_REQUEST['search'];
  //$page = $_REQUEST['page'];
  $totalPage = ceil($conn->query("SELECT * FROM  `os` WHERE `title` like '%$s%'")->num_rows / $pageSize);
  if($page > $totalPage) die('null');
  $sql = "SELECT * FROM  `os` WHERE `title` like '%$s%' ORDER BY `id` DESC";// LIMIT ".$limit." , ".$pageSize;
  $res = $conn->query($sql);
  $articles = array();
  while($info = $res->fetch_assoc()){
    $content_01 = $info["con"];
    $content_02 = htmlspecialchars_decode($content_01);
    $content_03 = str_replace("&nbsp;","",$content_02);
    $contents = strip_tags($content_03);
    $con = mb_substr($contents, 0, 130,"utf-8");
    $info['contents'] =  $con.'...';;
    $info['con'] = '';
    $info['reply'] = $conn->query("SELECT * FROM  `reply` WHERE  `conid` ='".$info['id']."'")->num_rows;
    array_push($articles,$info);
  }
  print_r(json_encode($articles));
}

/*
* 按标签分页检索文章 
* 需要 传入  tag 字符串 标签名 
*           page 整型 页码
* 返回  josn 数据
*/
if(isset($_REQUEST['tag'])){
  $s = $_REQUEST['tag'];
  $page = $_REQUEST['page'];
  $limit = ($page-1) * $pageSize;
  $totalPage = ceil($conn->query("SELECT * FROM  `os` WHERE `tag` = '$s'")->num_rows / $pageSize);
  $sql = "SELECT * FROM  `os` WHERE `tag` = '$s' ORDER BY `id` DESC LIMIT ".$limit." , ".$pageSize;
  if($page > $totalPage) die('null');
  $res = $conn->query($sql);
  $articles = array();
  while($info = $res->fetch_assoc()){
    $content_01 = $info["con"];
    $content_02 = htmlspecialchars_decode($content_01);
    $content_03 = str_replace("&nbsp;","",$content_02);
    $contents = strip_tags($content_03);
    $con = mb_substr($contents, 0, 130,"utf-8");
    $info['contents'] =  $con.'...';
    $info['con'] = '';
    $info['reply'] = $conn->query("SELECT * FROM  `reply` WHERE  `conid` ='".$info['id']."'")->num_rows;
    array_push($articles,$info);
  }
  print_r(json_encode($articles));
}

/*
* 从banner数据表中查询最新的10条数据
* 需要 传入 banner 可为空字符串
* 返回  josn 数据
*/
if(isset($_REQUEST['banner'])){
  $res = $conn->query('SELECT *  FROM  `banner` ORDER BY `id` DESC  LIMIT 0 , 10');
  $articles = array();
  while ($banner = $res->fetch_assoc()) {
    $banner['href'] = '';
    $banner['src'] = $banner['img-src'];
    $banner['img-src'] = '';
    array_push($articles, $banner);
  }
  print_r(json_encode($articles));
}

/*
* 最热12篇文章查询
* 需要 传入 hotArticle 可为空字符串
* 返回  josn 数据
*/
if(isset($_REQUEST['hotArticle'])){
  $sql = "SELECT * FROM  `os` ORDER BY  `flow` DESC LIMIT 0 , 12";
  $res = $conn->query($sql);
  $articles = array();
  while($info = $res->fetch_assoc()){
    $content_01 = $info["con"];
    $content_02 = htmlspecialchars_decode($content_01);
    $content_03 = str_replace("&nbsp;","",$content_02);
    $contents = strip_tags($content_03);
    $con = mb_substr($contents, 0, 130,"utf-8");
    $info['contents'] =  $con.'...';;
    $info['con'] = '';
    $info['reply'] = $conn->query("SELECT * FROM  `reply` WHERE  `conid` ='".$info['id']."'")->num_rows;
    array_push($articles,$info);
  }
  print_r(json_encode($articles));
}

/*
* 最新12条评论
* 需要 传入 newReply 可为空字符串
* 返回  josn 数据
*/
if(isset($_REQUEST['newReply'])){
  $sql = "SELECT * FROM  `reply` ORDER BY  `reply`.`time` DESC LIMIT 0 , 12";
  $res = $conn->query($sql);
  $articles = array();
  while($info = $res->fetch_assoc()){
    $userid = $info['userid']; 
    $rest = $conn->query("select * from `user` where id = $userid")->fetch_assoc();
    $info['avatar'] = $rest['coer'];
    $info['userName'] = $rest['name'];
    array_push($articles,$info);
  }
  print_r(json_encode($articles));
}

/*
* 评论检索
* 需要 传入 replyList 文章的id
* 返回 josn 数据
*/
if(isset($_REQUEST['replyList'])){
  $i = $_REQUEST['replyList'];
  $sql = "SELECT * FROM  `reply` WHERE `conid` = '$i' LIMIT 0 , 12";
  $res = $conn->query($sql);
  $articles = array();
  while($info = $res->fetch_assoc()){
    $userid = $info['userid']; 
    $rest = $conn->query("select * from `user` where id = $userid")->fetch_assoc();
    $info['avatar'] = $rest['coer'];
    $info['userName'] = $rest['name'];
    array_push($articles,$info);
  }
  print_r(json_encode($articles));
}

/*
* 文章回复功能
* 需要POST传入 reply conId
* 返回  josn 数据
*/
if(isset($_REQUEST['reply'])){
  $conId = $_REQUEST['conId'];
  $reply = $_REQUEST['reply'];
  $name = $_REQUEST['Rname'];
  $email = $_REQUEST['Remail'];
  $info = array();
  $info['status'] = 200;
  $info['info']= '回复成功!';
  $info['time']= $time;
  session_start();
  if(!isset($_SESSION['userName'])){
    if($name==''){
      $info['error']= '请输入呢称!'.$name;
      $info['status'] = 501;
      die(json_encode($info));
    }
    else if($email==''){
      $info['error']= '请输入邮箱!';
      $info['status'] = 502;
      die(json_encode($info));
    }
    else{
      $result = $conn -> query("SELECT * FROM  `user` WHERE `name` = '$name'");
      $num = $result->num_rows;
      if($num == 0) {
        // 账户注册
        $pw = md5(123456);
        if($name == ''||$mail == '') {
          $info['error']= '必填字段不能为空！';
          $info['status'] = 500;
          die(json_encode($info));
        }
        // $result = $conn -> query("SELECT * FROM  `user` WHERE `name` = '$name'");
        // $num = $result->num_rows;
        // if($num >= 1) return '用户名已存在，请跟换后重试！';
        $sql = "INSERT INTO `user` (`name`, `pw`, `email`, `date`) VALUES ('$name', '$pw', '$email', '$time');";
        if(!$conn -> query($sql)){
          // $mailtitle = '欢迎加入ACG58社区';
          // $mailcontent = '<h3>ACG58社区欢迎你'.$name.'的加入</h3><p>以下是你的账号信息，请务必牢记</p>'.$name .$email;
          // sendMail($email,$mailtitle,$mailcontent);
          $info['error']= '未知错误 sql';
          $info['status'] = 500;
          die(json_encode($info));
        }
      }
      // 账户检验登陆
      $result=$conn->query("SELECT * FROM `user` WHERE `name` ='$name' and `email` = '$email'"); 
      $num=$result->num_rows;
      if($num == 0) {
        $info['error']= '请检查邮箱与用户呢称是否填写错误!';
        $info['status'] = 500;
        die(json_encode($info));
      };
      $Uinfo=$result->fetch_assoc();
      SESSION_start();
      $_SESSION['userName']=$Uinfo['name'];
      $_SESSION['userId']=$Uinfo['id'];
      if($Uinfo['vip']==99) $_SESSION['vip']='admin';
      else $_SESSION['vip']=$Uinfo['vip'];
      $id = $Uinfo['id'];
      if(!$conn->query("UPDATE `user` SET `login_date`= '$time'  WHERE id=$id")){
        $info['error']= 'Unknown Error! DB';
        $info['status'] = 500;
        die(json_encode($info));
      }
      // if(loginEmail($name, $mail)!=200){      }
      
    }
  }
  // if(!isset($_SESSION['userName'])){
  //   $info['error']= '请先登录!';
  //   $info['status'] = 400;
  //   die(json_encode($info));
  // }
  if($reply==''){
    $info['error']= '请输入回复内容!';
    $info['status'] = 400;
    die(json_encode($info));
  }
  $userId = $_SESSION['userId'];
  $time = date("Y-m-d H:i:s",time());
  $sql = "INSERT INTO `reply` (`userid`, `conid`, `con`, `time`) VALUES ('$userId', '$conId', '$reply', '$time');";
  if(!$conn->query($sql)){
    $info['error']= '未知错误!';
    $info['status'] = 400;
    die(json_encode($info));
  }
  else die(json_encode($info));
}

/*
* 验证码生成存储
* 需要POST传入 sendCode
* 返回  josn 数据
*/
if(isset($_REQUEST['sendCode'])){
  $email = $_REQUEST['sendCode'];
  $info = array();
  $info['status'] = 200;
  $info['info']= '验证码已发送 请注意查收!';
  $info['time']= $time;
  $result = $conn -> query("SELECT * FROM  `user` WHERE `email` = '$email'");
  $num = $result->num_rows;
  if($num == 0) {
    // 邮箱检验是否存在数据库
    $info['error']= '该邮箱尚未注册, 请点击左下角新账户进行注册!';
    $info['status'] = 500;
    die(json_encode($info));
  }
  session_start();
  if(!isset($_SESSION['infoCode'])){
    // 验证码不存在
    //生成验证码
    $_SESSION['infoCode'] = $code = rand(1000,9999);
    // 邮件发送验证码
    $mailtitle = '来自QiaTia`小站的提示';
    $mailcontent = '你本次登陆的验证码为:<b>'.$code.'</b>';
    sendMail($email,$mailtitle,$mailcontent);
  }else{
    // 已经生成验证码  取出验证码
    $code = $_SESSION['infoCode'];
    // 重新发送验证码
    $mailtitle = '来自QiaTia`小站的提示';
    $mailcontent = '<h3>你本次登陆的验证码为: <b>'.$code.'</b></h3>';
    sendMail($email,$mailtitle,$mailcontent);
  }
  die(json_encode($info));
}

/*
* 邮箱登陆
* 需要POST传入 loginEmail code
* 返回  josn 数据
*/
if(isset($_REQUEST['loginEmail'])){
  $email = $_REQUEST['loginEmail'];
  $code = $_REQUEST['code'];
  $info = array();
  $info['status'] = 200;
  $info['info']= '登陆成功!';
  $info['time']= $time;
  $result = $conn -> query("SELECT * FROM  `user` WHERE `email` = '$email'");
  $num = $result->num_rows;
  if($num == 0) {
    // 邮箱检验是否存在数据库
    $info['error']= '该邮箱不存在, 请点击左下角`新 账 户`进行注册!';
    $info['status'] = 500;
    die(json_encode($info));
  }
  session_start();
  if(!isset($_SESSION['infoCode'])){
    // 验证码不存在
    $info['error']= '请先获取验证码 !';
    $info['status'] = 500;
    die(json_encode($info));
  }else{
    // 验证码比对 确认后登陆
    if($code != $_SESSION['infoCode']){
      $info['error']= '你输入的验证码不正确 !';
      $info['status'] = 500;
      die(json_encode($info));
    }else{
      // 确认登陆
      $Uinfo=$result->fetch_assoc();
      $info['userName'] = $_SESSION['userName'] = $Uinfo['name'];
      $info['userId'] = $_SESSION['userId'] = $Uinfo['id'];
      if($Uinfo['vip']==99) $_SESSION['vip']='admin';
      else $_SESSION['vip']=$Uinfo['vip'];
      $id = $Uinfo['id'];
      if(!$conn->query("UPDATE `user` SET `login_date`= '$time'  WHERE id=$id")){
        $info['error']= 'Unknown Error! DB';
        $info['status'] = 500;
        die(json_encode($info));
      }
    }
  }
  die(json_encode($info));
}

/*
* 获取登陆用户信息
* 需要POST传入 loginUserInfo
* 返回  josn 数据
*/
if(isset($_REQUEST['loginUserInfo'])){
  session_start();
  //$i= $_REQUEST['loginUserInfo']!=''?$_REQUEST['loginUserInfo']:$_SESSION['userId'];
  $i = isset($_SESSION['userId'])?$_SESSION['userId']:$_REQUEST['loginUserInfo'];
  $info = array();
  $info['time']= $time;
  if($i==''){
    $info['status'] = 300;
    $info['error'] = '尚未登陆';
    die(json_encode($info));
  }
  $info['status'] = 200;
  $result = $conn -> query("SELECT * FROM  `user` WHERE `id` = '$i'");
  $user = $result->fetch_assoc();
  $user['pw'] = '******';
  $info['info'] = $user;
  die(json_encode($info));
}

/*
* 用户注销登陆 清除$_SESSION
* 需要POST传入 userLogout
* 返回  josn 数据
*/
if(isset($_REQUEST['userLogout'])){
  session_start();
  $info = array();
  $info['time']= $time;
  if($_SESSION['userId']==''){
    $info['status'] = 300;
    $info['error'] = '尚未登陆';
    die(json_encode($info));
  }
  session_destroy();
  $info['status'] = 200;
  $info = 'Success !';
  die(json_encode($info));
}
// 邮箱登陆实现
function loginEmail($name, $mail){
  $result=$conn->query("SELECT * FROM `user` WHERE `name` ='$name' and `email` = '$email'"); 
  $num=$result->num_rows;
  if($num == 0) return 600;
  $info=$result->fetch_assoc();
  SESSION_start();
  $_SESSION['userName']=$info['name'];
  $_SESSION['userId']=$info['id'];
  if($info['vip']==99) $_SESSION['vip']='admin';
  else $_SESSION['vip']=$info['vip'];
  $id = $info['id'];
  // if( $cookie == 'is'){
  //   $_COOKIE['userName'] = $info['name'];
  //   $_COOKIE['userId'] = $info['id'];
  //   $_COOKIE['vip'] = '0';
  // }
  if($conn->query("UPDATE `user` SET `login_date`= '$time'  WHERE id=$id")){
    return 200;
    /*$mailtitle = '你的账号'.$name.'登陆提醒--ACG58';
    $mailcontent = '你的账号'.$name.'于'.$time.'成功登陆ACG58社区';
    sendMail($info['email'],$mailtitle,$mailcontent);*/
  }
}

// 账户密码登陆实现
function loginPw($name, $mail){
  // $cookie = isset($_POST['cookie'])?$_POST['cookie']:null;
	if($name==""||$pw=="") return "错误,账号或密码不能为空!";
	$result = $conn -> query("SELECT * FROM  `user` WHERE `name` = '$name'");
	$num = $result->num_rows;
	if($num == 0) return '用户名不存在，请先注册！';
	$result=$conn->query("SELECT * FROM `user` WHERE `name` ='$name' and `pw` = '$pw'"); 
	$num=$result->num_rows;
	if($num == 0) return '密码不正确，请检查后重试！';
	$info=$result->fetch_assoc();
	SESSION_start();
	$_SESSION['userName']=$info['name'];
	$_SESSION['userId']=$info['id'];
	if($info['vip']==99) $_SESSION['vip']='admin';
	else $_SESSION['vip']=$info['vip'];
	$id = $info['id'];
	// if( $cookie == 'is'){
	// 	$_COOKIE['userName'] = $info['name'];
	// 	$_COOKIE['userId'] = $info['id'];
	// 	$_COOKIE['vip'] = '0';
	// }
	if($conn->query("UPDATE `user` SET `login_date`= '$time'  WHERE id=$id")){
		/*$mailtitle = '你的账号'.$name.'登陆提醒--ACG58';
		$mailcontent = '你的账号'.$name.'于'.$time.'成功登陆ACG58社区';
		sendMail($info['email'],$mailtitle,$mailcontent);*/
    return 200;
  }else{
    return '未知错误 sql';
  }
}

function mailSignUp($name, $mail){
  //code..
  $pw = md5(123456);
	if($name == ''||$mail == '') return '必填字段不能为空！';
	$result = $conn -> query("SELECT * FROM  `user` WHERE `name` = '$name'");
	// $num = $result->num_rows;
	// if($num >= 1) return '用户名已存在，请跟换后重试！';
	$sql = "INSERT INTO `user` (`name`, `pw`, `email`, `date`) VALUES ('$name', '$pw', '$email', '$time');";
	if($conn -> query($sql)){
		// $mailtitle = '欢迎加入ACG58社区';
		// $mailcontent = '<h3>ACG58社区欢迎你'.$name.'的加入</h3><p>以下是你的账号信息，请务必牢记</p>'.$name .$email;
		// sendMail($email,$mailtitle,$mailcontent);
		return '200';
	}else{
		return '未知错误 sql';
	}
}

//邮件推送服务
function sendMail($smtpemailto,$mailtitle,$mailcontent){
	//使用方法  
	$post_data = array(  
	  'toemail' => $smtpemailto,  
	  'title' => $mailtitle,
	  'content' => $mailcontent
	);  
	send_post('https://www.qiatia.cn/tools/Email/pushSevice.php', $post_data);  
  //echo "成功！";
}

// function send_post($url, $post_data) {  
//    post 请求实现
//   $postdata = http_build_query($post_data);  
//   $options = array(  
//     'http' => array(  
//       'method' => 'POST',  
//       'header' => 'Content-type:application/x-www-form-urlencoded',  
//       'content' => $postdata,  
//       'timeout' => 15 * 60 // 超时时间（单位:s）  
//     )  
//   );  
//   $context = stream_context_create($options);  
//   $result = file_get_contents($url, false, $context);  
  
//   return $result;  
// }
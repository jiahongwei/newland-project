<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>考勤系统管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script src="<?php echo $this->_baseUrl?>/static/attendance/jquery/jquery-2.1.4.min.js"></script>
<script src="<?php echo $this->_baseUrl?>/static/js/My97DatePicker/WdatePicker.js"></script>
<script src="<?php echo $this->_baseUrl?>/static/attendance/jquery/jquery.js"></script>
<script src="<?php echo $this->_baseUrl?>/static/attendance/jquery/jquery.validate.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_baseUrl?>/static/attendance/css/attendance.css">
</head>
<script type="text/javascript">
</script>
<body>
	<div class="head">
    <div style="background:url(attendance.png);width:100%;height:100%">
          <!-- <img src="asset.png" style="width:100%;height:170px;"> -->
        <div class="logininfo">
          <span class="welcome">
          	<img src="<?php echo $this->_baseUrl?>/static/attendance/images/user_edit.png" align="absmiddle"> 欢迎, <em><?php echo $this->_admini['userName']?></em>
          </span> 
          <a href="<?php 
          if($this->_admini['type'] == 'admin') {echo $this->createUrl('adminLogin/ownerUpdate');}
          if($this->_admini['type'] == 'teacher'){echo $this->createUrl('teacherLogin/ownerUpdate');}
          if($this->_admini['type'] == 'student'){echo $this->createUrl('studentLogin/ownerUpdate');}
          if($this->_admini['type'] == 'exe_teacher'){echo $this->createUrl('exeTeacherLogin/ownerUpdate');}
          ?>">修改密码</a>
     	</div>
    </div>
	</div>
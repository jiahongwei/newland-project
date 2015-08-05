
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>能源管理</title>
<meta charset="utf-8">
<meta content="IE=edge" http-equiv="X-UA-Compatible">
<meta content="initial-scale=1.0, width=device-width" name="viewport">
</head>
<script src="<?php echo $this->_baseUrl?>/static/asset/jquery/jquery-2.1.4.min.js"></script>
<script src="<?php echo $this->_baseUrl?>/static/js/My97DatePicker/WdatePicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_baseUrl?>/static/attendance/css/attendance.css">

<script>
  $(document).ready(function(){

    if($("#analyseType").val()=="5"){
      $("#6").show();
      $("#7").show();
      $("#time").hide();
      $("#month").show();
      
    }else if($("#analyseType").val()=="6"){
      $("#6").show();
      $("#7").hide();
      $("#time").hide();
      $("#month").hide();
      
    }
    else{
      $("#6").hide();
      $("#7").hide();
      $("#time").show();
      $("#month").hide();
    }
    $("#type1").click(function(){
      $("#6").hide();
      $("#7").hide();
      $("#time").show();
      $("#month").hide();
      
    });
    $("#type2").click(function(){
      $("#6").hide();
      $("#7").hide();
      $("#time").show();
      $("#month").hide();
      
    });
    $("#type3").click(function(){
      $("#6").hide();
      $("#7").hide();
      $("#time").show();
      $("#month").hide();
      
    });
     $("#type4").click(function(){
      
      $("#6").hide();
      $("#7").hide();
      $("#time").show();
      $("#month").hide();
      // $("#time").hide();
    });
    $("#type5").click(function(){
      $("#6").show();
      $("#7").show();
      $("#time").hide();
      $("#month").show();
      
    });

    $("#type6").click(function(){
      $("#6").show();
      $("#7").hide();
      $("#time").hide();
      $("#month").hide();
      
    });
    
    });
</script>
<body>
<center>
	<div class="head">
    <div style="background:url(energy.png);width:100%;height:100%;">
      <div class="logininfo">
          <span class="welcome">
              <div class="logininfo"><span class="welcome"><img src="<?php echo $this->_baseUrl?>/static/admin/images/user_edit.png" align="absmiddle"> 欢迎,</span><a href="<?php echo $this->createUrl('public/logout')?>" target="_top">退出登录</a> </div>
          </span>
      </div>
	   </div>
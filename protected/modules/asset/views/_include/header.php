<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>资产管理系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script src="<?php echo $this->_baseUrl?>/static/asset/jquery/jquery-2.1.4.min.js"></script>
<script src="<?php echo $this->_baseUrl?>/static/js/My97DatePicker/WdatePicker.js"></script>
<script src="<?php echo $this->_baseUrl?>/static/asset/jquery/jquery.js"></script>
<script src="<?php echo $this->_baseUrl?>/static/asset/jquery/jquery.validate.js"></script>
<script src="<?php echo $this->_baseUrl?>/static/asset/jquery/tinybox.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_baseUrl?>/static/asset/css/asset.css">
<object
  id="ssuapi"
  classid="clsid:A4413B7A-CAD9-4566-82DD-5D5B6521510F"
  style="display:none;"
  >
</object>
</head>
<script type="text/javascript">
  function query(){
      try
      {
        var result = ssuapi.connect("COM3");
        var tagID = ssuapi.readTID();
        // alert(tagID);
        if (tagID!='read failed'&&tagID!='unconnected') {
          document.getElementById("text").value=tagID;
        };
        // alert("111");
        
        // tag.value=tagID;
        // $("#RFID").attr("value",tagID);
        // $("#RFID").val(tagID);
        var result = ssuapi.disconnect();

      }
      catch (e)
      {
        alert(e);
      }
    }
    function doReset(){  
    for(i=0;i<document.all.tags("input").length;i++){  
        if(document.all.tags("input")[i].type=="text"){  
            document.all.tags("input")[i].value="";  
        }  
      }  
    } 

   var data1;
  function submit1(){ 
    try{
      $.getJSON(
        "num.txt?t="+new Date(),
        function(data){
          $.each(data, function(k, v) {
            if (k=='RFID') {
              data1=v;
            }
          })
      })
      // alert(data1);
      document.getElementById("text").value = data1;
      }catch(e){
        alert(e);
      }
  }

  function readUSR()
    {
      try
      {
        var result = ssuapi.connect("COM3");
        var tag = ssuapi.readUSR();
        var q = "<?php echo 'q1222'; ?>";
        $("#message").html(q);
        // alert(tag);
        var result = ssuapi.disconnect();
      }
      catch (e)
      {
        alert(e);
      }
    }
   function writeUSR()
    {
        var result = ssuapi.connect("COM3");
        var content = $("#assetName").val()+'\n'+$("#specification").val();
        var result = ssuapi.writeUSR(content);
        var result = ssuapi.disconnect("COM3");
    }
    
</script>
<body>
<div class="head">
    <div style="background:url(asset.png);width:100%;height:100%;">
      <div class="logininfo"><span class="welcome"><img src="<?php echo $this->_baseUrl?>/static/attendance/images/user_edit.png" align="absmiddle"> 欢迎, <em><?php echo $this->_admini['userName']?></em> </span> <a href="<?php echo $this->createUrl('public/logout')?>" target="_top">退出登录</a></div>
          <!-- <img src="asset.png" style="width:100%;height:170px;"> -->
    </div>
<!--    <div class="logo"><img src="logo.jpg"></div>
    <div class="header">
      资产管理系统
    </div> -->
  </div>
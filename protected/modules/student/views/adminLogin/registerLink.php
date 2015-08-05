<!-- 与人脸识别机的链接 -->
<!DOCTYPE html>
<html>
<head>
    <title>注册系统登录</title>
	<style>
	    body{text-align:center;}
	</style>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script src="<?php echo $this->_baseUrl?>/static/attendance/jquery/jquery-2.1.4.min.js"></script>
   
    <object id="sdkobj" classid="CLSID:8BCD4411-D055-4DAF-BAA6-2942DDD370E0"
	    width="0" height="0">
    </object>
	<script for="sdkobj" event="OnEventCErrorNotify(strDevSn, lOpCode, lUserData, lExtendParam, lErrorCode, strErrorDesc)">
        alert("error: " + strDevSn + "  code: " + lErrorCode + "  desc: " + strErrorDesc);
	</script>
		
	<script  for="sdkobj" event="OnEventCConnect(strDevSn, lOpCode, lUserData, lExtendParam, strIP, lPort)">
	    window.snNumber = strDevSn;
	</script>
	<script  for="sdkobj" event="OnEventCGenPhotoAndFeature(strDevSn, lOpCode, lUserData, lExtendParam, lUserID, strCardNo, lFeatureLen, strBase64FeatureData, lPhotoType, lPhotoLen, strBase64PhotoData)"> 
        window.photo = strBase64PhotoData;
	    window.feature = strBase64FeatureData;
	</script>
			
	<script>
        var strSn = "";
        window.photo = "";      
		function Connect()
		{
		
			try
			{
				var ipAdress = document.getElementById("ip").value;
			    var name = document.getElementById("userName").value;
			    var key = document.getElementById("userPassword").value;
                strSn = sdkobj.C_Connect(ipAdress, 30001, name, key);   //start to connect device        
       
				if (strSn == "")
			    {
                    alert("连接失败!");
                } 
			    else
			    {
					window.open("<?php echo  $this->createUrl('adminLogin/register');?>")
				}
			}catch(e)
			{
				alert(e);
			}
			
			
        }
		
				
		function Disconnect() 
		{
			try
			{
				document.getElementById("sdkobj");
			    document.getElementById("userPassword").value = "";
                alert(sdkobj.C_DisConnect(snNumber)+"断开连接成功");   //connect the device          
			}catch(e)
			{
				alert(e);
			}       
		}
		
		
		function GetPhotoAndFeature() 
		{
			try
			{				
				sdkobj.C_GeneratePhotoAndFeature(snNumber , 0);
				
			}catch(e)
			{
				alert(e);
			}
		}
		function check(){
			var ip= document.getElementById("ip").value;
			alert();
		}
    </script>
 
</head>

<body>
	<center>
    <div class="container">
	    <div class="head" >
            <h1 >学生信息注册系统 </h1>
		</div>
		<br>			
		<hr>
		<div class="title">
		    <h2>考勤机连接:</h2>	
		</div>
		<div>
		<form name="" action="" method="post">
		<table>
			<tr>
				<td>sn:<input type="text" name="deviceSn" value="<?php echo $data['sn'];?>" /></td>
			</tr>
			<tr>
				<td>ip:<input type="text" value="<?php echo $data['ip'];?>" id= "ip" disabled="true"></td>
			</tr>
			<tr>
				<td><input type="submit" value = "验证"></td>
			</tr>
			<tr>
				<td>账号:<input id="userName" type="text" value = "admin" /></td>
			</tr>
			<tr>
				<td>密码:<input id="userPassword" type="password" value = "88888888" /></td>
			</tr>
			<tr>
				<td><input id="connect" type="button" value="登录" onclick="Connect()" /></td>
				<td><input id="disconnect" type="button" value="退出" onclick="Disconnect()" /></td>
			</tr>
		<hr>
		</table>
		</form>				
	</div>
	<hr>
	<div>
		<input type="button" value="返回" onclick="javascript:window.location.href='<?php echo  $this->createUrl('adminLogin/index');?>'">
	</div>
    </center>
</body>
</html>


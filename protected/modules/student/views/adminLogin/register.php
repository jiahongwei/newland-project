<html>
<head>
    <title>学生信息注册</title>
	<style>
	    body{text-align:center;}
	</style>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script src="<?php echo $this->_baseUrl?>/static/attendance/jquery/jquery-2.1.4.min.js"></script>
   
	<script>
	//获取考勤机的传来的图片字符串，并将该字符串转换为图片信息显示到界面上
	 	function  Get(){
			
				var photo_1 = opener.photo;
	            var feature_1 = opener.feature;
	            document.getElementById("student_Photo").value = photo_1;
		        document.getElementById("student_Feature").value = feature_1;
		        document.getElementById("img").src = "\data:image/png;base64,"+ photo_1;//show photo
			    opener.photo ="";
			    opener.feature ="";
			
		}

	</script>

   
    <script>
    // 获取班级的学生学号，并将学生学号显示
 	$(document).ready(function(){
 		var o = document.getElementById("selectID");
 		<?php
 			foreach ($data as $key => $value) {
 		?>
 			var a = <?php echo $value['stuId'];?>;
 			o.add(new Option(a,a));
 		<?php
 			}
 		?>
 	})
 	</script>
</head>
<body>	
     <div class="container">
	    <div class="head" >
            <h2 >学生信息注册系统 </h2>
		</div>
		<div class="title_2">
		      <b id="infor">学生信息:</b>
		</div><br>
	    <div class="body">
		    <div class="classInfor">
		       <form name="s1" action="" method="post" id="classID">			 
		            请输入班级号:<input id="calss_No" type="text" name="classId" value="<?php echo $classId;?>" size="4" required>						
			        <input id="getclassNo"  type="submit" name="getClassMember" value="确定" onclick="QueryStudent();">
					<br><br>			 
                </form>
		    </div><br>
	        <div class="registerInfor">
		        <form name="s2" action="" method="post">
				    <div class="studentID" >
		                学号:<select id="selectID" name="stuId">
		                </select>		         			     
		                照片信息:<input id="student_Photo" type="hidden" name="studentPhoto"  />				   			      
				        特征值:<input id="student_Feature" type="hidden" name="studentFeature" />			     
			            <input id="upload" type="submit" name="upLoad" value="上传">
				    </div>
		        </form> 
			</div>
		</div><br>
		<div class="button_2">   
		    <div class="button_2_1">
		        <input id="takePhoto" type="button" value="拍照" onclick="opener.GetPhotoAndFeature()" />
		        <input id="getInfo" type="button" value="获取" onclick="Get();" />
			</div>
		</div><br>
		<div class="imgPart" >
		    <img id="img" src=""  border="1" /></image>
		</div>
		<div>
			<input type="button" value="返回" onclick="javascript:window.location.href='<?php echo  $this->createUrl('adminLogin/index');?>'">
		</div>
	</div>
</body>
</html>


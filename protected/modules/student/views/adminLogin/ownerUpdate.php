<?php echo $this->renderPartial('/_include/header')?>
<?php echo $this->renderPartial('/_include/left')?>
<script>
	// 对密码进行验证，判断密码与确认密码是否相同
	 function valid(){
     	var pas = document.getElementById("password").value;
     	var re_psa = document.getElementById("re_password").value;
	    if(pas!=re_psa){
	       alert("两次密码不同");
	       return false;
	    }
	    return true;
	}
</script>
	<div class="right rightContent">
		<center>
		<div style="height:50px;margin-top:30px;">修改密码</div>
	       <form name="" action="" method="post">
	       <table class="addForm">
	       	<tr>
	       		<td>教师编号</td>
	       		<td><?php echo $data['id'] ?></td>
	       	</tr>
	       	<tr>
	       		<td>用户名:</td>
	       		<td><?php echo $data['name'] ?></td>
	       	</tr>
	       	<tr>
	       		<td>密码:</td>
	       		<td><input type="password" name="password" id="password" oninput="setCustomValidity('')" oninvalid="setCustomValidity('密码不能为空')"  required></td>
	       	</tr>
	       	<tr>
	       		<td>再次确认密码:</td>
	       		<td><input type="password" name="re_password" id="re_password"  oninput="setCustomValidity('')" oninvalid="setCustomValidity('确认密码不能为空')"  required></td>
	       	</tr>
	       	<tr>
	       		<td><input type="submit" value="提交" class="button1" onclick="return valid();" style="width:80px;"></td>
	       		<td><input type="reset" value="重置" class="button1" style="width:80px;"></td>
	       	</tr>
	       </table>
	       </form>
		</center>
	</div>
<?php echo $this->renderPartial('/_include/footer')?>
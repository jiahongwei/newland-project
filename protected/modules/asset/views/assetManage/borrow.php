<?php echo $this->renderPartial('/_include/header')?>
<?php echo $this->renderPartial('/_include/left')?>
<script>
 $(document).ready(function(){
 	$("#hello").click(function() {
	 	$.getJSON(
	        "num.txt?t="+new Date(),
	       	function(data){
	            $.each(data, function(k, v) {
	                if (k=='assetId') {
	                	$("#consume_id").attr("value",v);
	                }
	            })
	    })
    });
 });

 $(document).ready(function(){
 	$("#RFID").click(function() {
	 	$.getJSON(
	        "num.txt?t="+new Date(),
	       	function(data){
	            $.each(data, function(k, v) {
	                if (k=='RFID') {
	                	$("#text").attr("value",v);
	                }
	            })
	    })
    });
 });
</script>
<div class="right rightContent">
	<center>
	<div style="height:80px;"></div>
	<form action="" method="post" id="borrowForm" onsubmit="return check()">
			<table class="addForm">
				<tr>
					<?php //echo var_dump($_REQUEST['applyId']); ?>
					<th>资产名称:</th>
					<td><?php echo $assetName;?></td>
				</tr>
				<tr>
					<th>资产规格:</th>
					<td><?php echo $specification;?></td>
				</tr>
				<tr>
					<th>库存总数:</th>
					<td><?php echo $totalNum;?></td>
				</tr>
				<?php if($type=="static"){ ?>
				<tr>
			        <th>RFID编号:</th>
			        <td ><input type="text" value="<?php echo $RFID?>" name="assetId" id="text" style="width:300px;"></td>
			        <td><input type="button" id="RFID" value="扫描" onclick="query();" class="button" style="width:75px;height:20px;font-size:13px;"></td>
				</tr>
				<?php }else{ ?>
				<tr>
			        <th>资产编号:</th>
			        <td ><input type="text" value="<?php echo $assetId?>" id="consume_id" name="assetId" oninput="setCustomValidity('')" oninvalid="setCustomValidity('资产编号不能为空')" required></td>
			        <td><input type="button" value="扫描" id="hello" class="button" style="width:75px;height:20px;font-size:13px;"></td>
				</tr>
				<?php } ?>
				<tr >
					<th>借出人编号:</th>

					<td><input type="text" name="userId" id="userId" pattern="\d{1,15}" oninput="setCustomValidity('')" oninvalid="setCustomValidity('学号格式不正确')" value="<?php echo $_REQUEST['stuId'];?>" required /></td>
				</tr>
				<tr>
					<th>借出人姓名:</th>
					<td><input type="text" name="userName" id="userName" oninput="setCustomValidity('')" oninvalid="setCustomValidity('借出人姓名不能为空')" value="<?php echo $_REQUEST['stuName'];?>" required /></td>
				</tr>
				<tr>
					<th>借出人手机号:</th>
					<td><input type="text" name="userTeleNum" id="userTeleNum" pattern="^1(3|5|8|7)\d{9}$" oninvalid="setCustomValidity('手机号码格式不正确')" oninput="setCustomValidity('')" pattern="\d{11}" oninvalid="setCustomValidity('请输入正确的手机号(11位)')" value="<?php echo $_REQUEST['stuTelNum'];?>" required /></td>
				</tr>
				<tr>
					<th>借出日期:</th>
					<?php date_default_timezone_set('UTC');?>
					<td><input type="text" name="borrowTime" id="borrowTime" value="<?php echo date('Y-m-d');?>" autocomplete="off" onclick="WdatePicker()" required /></td>
				</tr>
			</table>
		<div>
			<p><input type="submit" name="subBorrow" value="确认借出" class="button1" /></p>
			<?php if($_REQUEST['flog']==1){?>
			<a href="<?php echo  $this->createUrl('/asset/assetApply/index')?>">返回</a>
			<?php } elseif ($_REQUEST['flog']==2) {?>
				<a href="<?php echo  $this->createUrl('/asset/assetManage/search')?>">返回</a>
			
			<?php }else{?>
			<a href="<?php echo  $this->createUrl('findAll')?>">返回</a>
			<?php }?>
		</div>
	</form>
	</center>
	</div>
<?php echo $this->renderPartial('/_include/footer')?>
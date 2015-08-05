<script>
function initTab(name,cursel){
	cursel=cursel;
	for(var i=1; i<=links_len; i++){
		var menu = document.getElementById(name+i);
		if(i==cursel){
			menu.className="off";
		}
		else{
			menu.className="";
		}
	}
}
var name='one';
var cursel=1;
var links_len;
onload=function(){
	var links = document.getElementById("tab").getElementsByTagName('li');
	links_len=links.length;
	cursel=document.getElementById("flag").value;
	initTab(name,cursel);
}
$(document).ready(function(){
	$("#manage").css("display","none");
	$("#statistic").css("display","none");
	$("#one1").click(function(){
		$("#manage").toggle();
	})
	$("#one6").click(function(){
		$("#statistic").toggle();
	})
});
</script>
<body>
	<div class="left" id="tab">
		<div class="menu">
			<ul>
				<li id="one1" onclick="showList();">管理</li>
				<ul id="manage">
					<li id="teacher" onclick="javascript:window.location.href='<?php echo  $this->createUrl('adminLogin/teacherManageFindAll');?>'">教师管理</li>
					<li id="student" onclick="javascript:window.location.href='<?php echo  $this->createUrl('adminLogin/studentManageFindAll');?>'">学生管理</li>
					<li id="equ" onclick="javascript:window.location.href='<?php echo  $this->createUrl('adminLogin/equManageFindAll');?>'">设备管理</li>
				</ul>
				<li id="one2" onclick="javascript:window.location.href='<?php echo  $this->createUrl('adminLogin/courseManageFindAll');?>'">课程查询</li>
				<li id="one3" onclick="javascript:window.location.href='<?php echo  $this->createUrl('adminLogin/absentFindAll');?>'">考勤查询</li>
				<li id="one6" onclick="showList();">考勤数据统计</li>
				<ul id="statistic">
					<li class="asset" id="teacher" onclick="javascript:window.location.href='<?php echo  $this->createUrl('teaStaShow/sumDetail');?>'">总体数据查看</li>
					<li class="consume" id="student" onclick="javascript:window.location.href='<?php echo  $this->createUrl('teaStaShow/index');?>'">单个数据查看</li>
				</ul>
				<li id="one4" onclick="javascript:window.location.href='<?php echo  $this->createUrl('adminLogin/registerLink');?>'">注册</li>
				<li id="one5" onclick="javascript:window.location.href='http://localhost/cms_new/index.php'">退出登录</li>
			</ul>
		</div>
	</div>
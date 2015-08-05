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
	$("#one1").click(function(){
		$("#manage").toggle();
	})
});
</script>
	<div class="left" id="tab">
		<div class="menu">
			<ul>
				<li id="one1" onclick="javascript:window.location.href='<?php echo  $this->createUrl('exeTeacherLogin/absentQuery');?>'">考勤查询</li>
				<li id="one2" onclick="javascript:window.location.href='<?php echo  $this->createUrl('exeTeacherLogin/applyQuery');?>'">请假审批</li>
				<li id="one3" onclick="javascript:window.location.href='http://localhost/cms_new/index.php'">退出登录</li>
			</ul>
		</div>
	</div>
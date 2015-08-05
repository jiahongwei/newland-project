<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title>进入界面</title>

<link rel="stylesheet" type="text/css" href="<?php echo $this->_baseUrl?>/static/asset/css/style.css" media="all">

</head>
<body>
<div class="title">
  <h1>智慧校园</h1>
</div>
<div class="slider">
  <ul class="clearfix"> 
    <li><a href="http://localhost/cms_new/index.php#bg1" ondblclick="javascript:location.href='http://localhost/cms_new/index.php?r=asset/public/login'">资产管理</a></li>
    <li><a href="http://localhost/cms_new/index.php#bg2" ondblclick="javascript:location.href='http://localhost/cms_new/index.php?r=energy/main'">能源管理</a></li>
    <li><a href="http://localhost/cms_new/index.php#bg3" ondblclick="javascript:location.href='http://localhost/cms_new/index.php?r=student/public/login'">考勤管理</a></li>
    <li><a href="http://localhost/cms_new/index.php#bg4" ondblclick="javascript:location.href='#'">智能家居管理</a></li>
  </ul>
</div>
<img src="../../../images/bg1.jpg">
<a href="http://localhost/cms_new/index.php?r=asset/public/login"><img src="<?php echo $this->_baseUrl?>/themes/default/images/bg1.jpg" class="bg slideLeft" id="bg1"></a>
<a href="http://localhost/cms_new/index.php?r=energy/main"><img src="<?php echo $this->_baseUrl?>/themes/default/images/bg2.jpg" class="bg slideBottom" id="bg2"></a>
<a href="http://localhost/cms_new/index.php?r=student/public/login"><img src="<?php echo $this->_baseUrl?>/themes/default/images/bg3.jpg" class="bg zoomIn" id="bg3"></a> 
<a href="#"><img src="<?php echo $this->_baseUrl?>/themes/default/images/bg4.jpg" class="bg zoomOut" id="bg4"></a> 
</body>
</html>
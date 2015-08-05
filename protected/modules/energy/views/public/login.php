<!DOCTYPE html>

<head>
<meta charset="utf-8">
<title>资产管理系统-登陆</title>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_baseUrl?>/static/admin/css/login-style.css" />
<script type="text/javascript" language="javascript">
    if (top != self) {
        window.top.location.href = location;
    }
</script>
</head>
<body>
<center>
  <div style="height:130px;"></div>
  <div class="log_body">
    <div class="log_in">
      <?php $form=$this->beginWidget('CActiveForm', array('id'=>'login-wrap','enableAjaxValidation'=>true,)); ?>
      <dl>
        <dd><input type="text" name="id" value="用户名" class="input-password" onblur="if(this.value==''){this.value='用户名';}" onclick="if(this.value='用户名'){this.value='';}"><?php echo $form->error($model,'id'); ?> </dd>
        <dd><input type="text" name="password" value="密码" class="input-password" onblur="if(this.value==''){this.value='密码';this.type='password';}" onclick="if(this.value='用户名'){this.value='';this.type='password';}"><?php echo $form->error($model,'password'); ?> </dd>
        <dd>
          <input type="submit" name="login" class="input-login" value=""/>
          <input type="reset" name="login" class="input-reset" value=""/>
        </dd>
      </dl>
      <?php $this->endWidget(); ?>
    </div>
  </div>
</center>
</body>
</html>
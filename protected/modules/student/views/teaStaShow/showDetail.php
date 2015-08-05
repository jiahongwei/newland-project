<?php echo $this->renderPartial('/_include/header')?>
<input type="hidden" value="6" id="flag"/>
<?php echo $this->renderPartial('/_include/left')?>
<div class="right">
<center>
<?php //var_dump($data);?>
<?php if (file_exists($name)):?>
  <img id="pic" src="<?php echo $name ?>">
  <!-- <img src="Histogrm.png"> -->
<?php endif;?>
<div>
	<a href="<?php echo $this->createUrl('sumDetail') ?>">返回</a>
</div>
</center>

</div>

<?php echo $this->renderPartial('/_include/footer')?>
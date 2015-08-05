<?php echo $this->renderPartial('/_include/header')?>
<?php echo $this->renderPartial('/_include/left')?>


<script type="text/javascript">
 
</script>

<input type="hidden" value="1" id="flag"/>
<div style="height:3%;"></div>
<div class="right rightContent">
<center>
  <form name="" action="" method="post">
  <div style="height:230px;">
    <table class="content_list">
      <tr class="s1">
        <td>资产编号</td>
        <td>名称</td>
        <td>规格</td>
        <td>状态</td>
        <td>入库时间</td>
        <td>单价</td>
        <td>存储仓库</td>
        <td>允许带出</td>
        <td>借出人电话</td>
        <?php if($type=="static") {?>
        <td>更新</td>
        <?php }else{?>
        <td align="center">查看二维码</td>
        <?php } ?>
        <td>删除</td>
      </tr>
      <?php
        if (is_array ( $data )) {
          foreach ( $data as $value ) {
        ?>
      <tr class="tb_header">
        <td><?php if($type=="static"){echo $value['RFID'];}else{ $data = $value;
        $content = "assetId:".$value['assetId'].";assetName:".$value['assetName'].";specification:".$value['specification'].";Price:".$value['price'].";storageId:".$value['storageId'].";outPrm:".$value['outPrm'].";brwPhone:".$value['brwPhone'].";state:".$value['state'].";inTime:".$value['inTime'].";";
        $display = $value['assetId'].'/'.$value['assetName'].'/'.$value['specification'];
        echo $assetId=$value['assetId'];}?></td>
        <td><?php echo $value['assetName'];?></td>
        <td><?php echo $value['specification'];?></td>
        <td><?php if($value['state']=="in"){echo "存储中";}else{echo "借出";}?></td>
        <td><?php echo $value['inTime'];?></td>
        <td><?php echo $value['Price'];?></td>
        <td><?php echo $value['storageId'];?></td>
        <td><?php if($value['outPrm']=="y"){echo "允许";}else{echo "不允许";}?></td>
        <td><?php echo $value['brwPhone'];?></td>
        <?php if($type=="static") {?>
        <td><a href="<?php echo  $this->createUrl('update',array('RFID'=>$value['RFID']))?>"><img align="absmiddle" src="/cms_new/static/admin/images/update.png"></a></td>
        <?php }else{?>
        <td align="center"><a href="#" id="picShow"><img align="absmiddle" src="/cms_new/static/admin/images/barcode.png"></a></td>
        <?php } ?>
        <td><a href="<?php if($type=="static"){echo  $this->createUrl('delete',array('RFID'=>$value['RFID']));}else{echo  $this->createUrl('deleteConsume',array('assetId'=>$value['assetId']));}?>" onclick="return confirm('确定要删除吗?')"><img align="absmiddle" src="/cms_new/static/admin/images/delete.png"></a></td>
      </tr>
      <?php }} ?>
    </table>
  </div>
  <div style="height:40px;">
          <?php
          $this->widget ( 'CLinkPager', array (
              'header' => '',
              'firstPageLabel' => '首页',
              'lastPageLabel' => '末页',
              'prevPageLabel' => '上一页',
              'nextPageLabel' => '下一页',
              'pages' => $pages,
              'maxButtonCount' => 8 
          ) );
          ?>
    </div>
    <div style="height:20px;width:350px;">
      <a href="<?php echo  $this->createUrl('findAll')?>">返回</a>
    </div>
  </form>
  </center>
  </div>
<?php echo $this->renderPartial('/_include/footer')?>
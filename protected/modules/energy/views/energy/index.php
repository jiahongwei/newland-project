<?php echo $this->renderPartial('/_include/header')?>
<div style="height:500px;">
<center>
  <div style="height:10px;" ></div>
  <form action="" method="post"  enctype="multipart/form-data" id="addForm" name="form">
    <select name="analyseType" id="analyseType">
      <option value="1" id="type1" <?php if($analyseType=="1"){echo "selected";} ?>>按能耗最高查询</option>
      <option value="2" id="type2" <?php if($analyseType=="2"){echo "selected";} ?>>按能耗最低查询</option>
      <option value="3" id="type3" <?php if($analyseType=="3"){echo "selected";} ?>>按房间能耗查询</option>
      <option value="4" id="type4" <?php if($analyseType=="4"){echo "selected";} ?>>按能耗百分比查询</option>
      <option value="5" id="type5" <?php if($analyseType=="5"){echo "selected";} ?>>资产能耗走势对比查询</option>
      <option value="6" id="type6" <?php if($analyseType=="6"){echo "selected";} ?>>资产能耗动态查看</option>

    </select>
    <input type="text" id="6" placeholder="请输入资产名称" name="assetName" value="<?php if($judge==1)echo $assetName;?>">
    <input type="text" id="7" placeholder="请输入资产名称" name="assetName2" value="<?php if($judge==1)echo $assetName2;?>">
    <label id="time" style="font-size:12px; ">
    开始日期：<input type="text" name="inTime" id="inTime" onclick="WdatePicker()"  value="<?php echo $inTime;?>" required="required" >
    截至日期：<input type="text" name="outTime" id="outTime" onclick="WdatePicker()"  value="<?php echo $outTime;?>" required="required">
    </label>
    <select name="month" id="month">
    <?php switch ((int)date('m')) {
      case 12:?>
            <option value="12" id="type17" <?php if($month=="12"){echo "selected";} ?>>12月</option>
      <?php case 11:?>
            <option value="11" id="type16" <?php if($month=="11"){echo "selected";} ?>>11月</option>
      <?php case 10: ?>
            <option value="10" id="type15" <?php if($month=="10"){echo "selected";} ?>>10月</option>
      <?php case 9: ?>
            <option value="09" id="type14" <?php if($month=="09"){echo "selected";} ?>>9月</option>
      <?php case 8: ?>
            <option value="08" id="type13" <?php if($month=="08"){echo "selected";} ?>>8月</option>
      <?php case 7: ?>
            <option value="07" id="type12" <?php if($month=="07"){echo "selected";} ?>>7月</option>
      <?php case 6: ?>
            <option value="06" id="type11" <?php if($month=="06"){echo "selected";} ?>>6月</option>
      <?php case 5: ?>
            <option value="05" id="type10" <?php if($month=="05"){echo "selected";} ?>>5月</option>
      <?php case 4: ?>
            <option value="04" id="type9" <?php if($month=="04"){echo "selected";} ?>>4月</option>
      <?php case 3: ?>
            <option value="03" id="type8" <?php if($month=="03"){echo "selected";} ?>>3月</option>
      <?php case 2: ?>
            <option value="02" id="type7" <?php if($month=="02"){echo "selected";} ?>>2月</option>
      <?php case 1: ?>
            <option value="01" id="type6" <?php if($month=="01"){echo "selected";} ?>>1月</option>
      
    <?php }?>
    </select>
    <input type="submit" value="查询" name="analyseQuery" class="button" style="height:23px">
  </table>
  </form>
<?php if($flog==6&&$judge==1): ?>
  <script language="JavaScript">
    function myrefresh(){
    //载入页面
      document.form.submit();
    }
    //这个就是定时器
    setTimeout('myrefresh()',4000); 
</script>
<?php endif;?>
<?php if (file_exists($name)):?>
  <img id="pic" src="<?php echo $name ?>">
  <!-- <img src="Histogrm.png"> -->
<?php endif;?>
</div>
<?php echo $this->renderPartial('/_include/footer')?>


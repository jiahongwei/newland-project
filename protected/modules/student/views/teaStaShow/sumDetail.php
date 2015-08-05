<?php echo $this->renderPartial('/_include/header')?>
<input type="hidden" value="6" id="flag"/>
<?php echo $this->renderPartial('/_include/left')?>
<div class="right">
<center>
<?php //var_dump($data);?>
  <form name="" action="" method="post">
	<div style="height:40px; width:400px;">
		<select name="queryType" id="queryType">
			<option value="queryById" <?php if($type=="queryById"){echo "selected";} ?>>课程编号查询</option>
			<option value="queryByName" <?php if($type=="queryByName"){echo "selected";} ?> >按课程名字查询</option>
			<option value="queryByTeaName" id="queryByTeaName" <?php if($type=="queryByTeaName"){echo "selected";} ?> >按老师名称查询</option>
		</select>
		<input name="content" type="text" id="content" value="<?php echo $content?>" />
		<!-- <input type="button" value="扫描" id="queryRFID">  -->
		<input name="" type="submit" value="查询" /> 
	</div>
	<table  class="content_list">
	  <tr class="s1">
	    <td>课程编号</td>
	    <td>课程名</td>
	    <td>任课老师</td>
	    <td>老师编号</td>
	    <td>平均到课率</td>
	    <td>详细信息</td>
	  </tr>
	  <?php foreach ($data as $key=>$value){?>
	  <tr>
	    <td><?php echo $value['courseId']; ?></td>
	    <td><?php echo $value['courseName']; ?></td>
	    <td><?php echo $value['teacherName'];?></td>
	    <td><?php echo $value['teacherId'];?></td>
	    <td><?php echo $rate[$key];?></td>
	    <td><a href="<?php echo  $this->createUrl('showDetail',array('courseId'=>$value['courseId'],'teacherId'=>$value['teacherId']))?>">详细信息</a></td>
	  </tr>
	  <?php }?>
	  </table>
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
  </form>
</center>
</div>

<?php echo $this->renderPartial('/_include/footer')?>
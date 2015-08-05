<?php echo $this->renderPartial('/_include/header')?>
<?php echo $this->renderPartial('/_include/student_left')?>
<input type="hidden" value="3" id="flag"/>
  <div class="right">
    <center>
      <div style="height:50px;"></div>
        <form name="" action="" method="post">
        <div>
          <table border="0px" cellspacing="0px" class="addForm">
            <tr>
              <td>课程名称:</td>
              <td><?php echo $data['courseName'];?></td>
            </tr>
            <tr>
              <td>上课时间:</td>
               <td><?php echo $data['classDate'];?></td>
            </tr>
            <tr>
              <td>学生学号:</td>
              <td><?php echo $stuId;?></td>
            </tr>
            <tr>
              <td>请假原因:</td>
              <td><input type="text" name="reason" oninput="setCustomValidity('')" oninvalid="setCustomValidity('请填写请假原因')" required></td>
            </tr>
          </table>
        </div>
        <div>
          <p><input type="submit" value="提交" class="button1"></p>
          <a href="<?php echo  $this->createUrl('courseDetail',array ('courseId' => $data['courseId'],'courseName' => $data['courseName']))?>">返回</a>
        </div>
        </form>
      </center>
  </div>
<?php echo $this->renderPartial('/_include/footer')?>
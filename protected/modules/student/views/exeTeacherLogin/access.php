<?php echo $this->renderPartial('/_include/header')?>
<?php echo $this->renderPartial('/_include/exe_teacher_left')?>
<input type="hidden" value="2" id="flag"/>
  <div class="right">
    <center>
      <div style="height:50px;"></div>
        <form name="" action="" method="post">
        <div>
          <table border="0px" cellspacing="0px" class="addForm">
            <tr>
              <td>课程名称:</td>
              <td><?php echo $data[0]['courseName'];?></td>
            </tr>
            <tr>
              <td>上课时间:</td>
               <td><?php echo $data[0]['classDate'];?></td>
            </tr>
            <tr>
              <td>学生学号:</td>
              <td><?php echo $data[0]['stuId'];?></td>
            </tr>
            <tr>
              <td>请假原因:</td>
              <td><?php echo $data[0]['reason'];?></td>
            </tr>
          </table>
        </div>
        <div>
          <p><input type="submit" value="同意" name="approve" class="button1" onclick="return confirm('确定同意请假吗？')">&nbsp;&nbsp;&nbsp;<input type="submit" value="不同意" name="approve" class="button1" onclick="return confirm('确定不同意请假吗？')"></p>
          <a href="<?php echo  $this->createUrl('applyQuery')?>">返回</a>
        </div>
        </form>
      </center>
  </div>
<?php echo $this->renderPartial('/_include/footer')?>
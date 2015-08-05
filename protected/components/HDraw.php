<?php
/**
* @author 赵军 
* 用来画数据统计柱状图，条形图，饼图
*/
define(BAR_COLOR,"#d8a82c:1.2");
define(SHADOW,"#7a7a7a@0.4");
define(ENERGY, '#22381e');
define(RAND, 100000000);
define(X_FONT, 10);
class HDraw
{

	
	public static function HistogramShow($data_x,$data_y,$x_title="",$y_title="",$graph_title="",$max_y)
	{

		//柱状图生成函数
		$graph = new Graph(LENHSIZE,HEISIZE,"auto"); //创建画布
		// $graph->SetScale('textlin');  // 设置y轴的值   这里是0到60
		if ($max_y>1) {
			// echo var_dump('sdfsfs');
		}
		$graph->SetScale("textlin");
		$graph->yscale->ticks->Set($max_y/2,1); 
		$graph->yaxis->HideTicks(true,true);
		$graph->yaxis->scale->SetGrace(20);
		$graph->SetBox(false);
	 
		//创建画布阴影
		$graph->SetShadow();
		$graph->img->SetMargin(LEFT,RIGHT,UP,DOWN);
		// $graph->img->SetMargin(40,30,30,50);//设置显示区左、右、上、下距边线的距离，单位为像素
		$bplot = new BarPlot($data_y);//创建一个矩形的对象
		
		

		// $bplot->SetFillColor("red"); //设置柱形图的颜色
		// $graph->xaxis->title->SetColor('black');
		// $graph->doshadow=true;
		$graph->InitializeFrameAndMargin();
		// $graph->SetBackgroundGradient();
		// $bplot->SetFillGradient(array(50,50,200));
		
		$graph->Add($bplot);//将柱形图添加到图像中
		// $graph->SetColor(BAR_COLOR);
		$bplot->SetColor(BAR_COLOR);
		$bplot->SetFillColor(BAR_COLOR);
		$bplot->SetWidth(25);
		// $bplot->SetFillGradient("#4B0082","white",GRAD_LEFT_REFLECTION);
		// $bplot->Set3D();

		// $graph->SetMarginColor("lightblue");//设置画布背景色为淡蓝色
		$graph->title->Set($graph_title);//创建标题"借出次数统计结果(按借出次数由由低到高排列)"
		$graph->xaxis->SetTickLabels($data_x); //设置X坐标轴文字
		$bplot->SetShadow(SHADOW);//设置阴影效果
		// $graph->xaxis->SetColor('black');
		// $graph->title->SetMargin(10);

		// $graph->yaxis->SetTickLabels(range(0, 6));
		$bplot->value->Show();
		if ($max_y<1) {
			$bplot->value->SetFormat('%0.4f');
		}
		else
		{
			$bplot->value->SetFormat('%d');//在柱形图中显示格式化的评选结果

		}
		$graph->xaxis->title->Set($x_title);
		$graph->yaxis->title->Set($y_title);
		// $graph->xaxis->SetTextTickInterval($y_title,0.2);
		$graph->xaxis->title->setFont(FF_SIMSUN);
		$graph->yaxis->title->setFont(FF_SIMSUN);
		$graph->title->setFont(FF_SIMSUN,FS_BOLD,GRAGHSIZE);//设置字体
		$graph->xaxis->setFont(FF_SIMSUN,FS_BOLD,X_FONT); //设置字体
		$graph->xaxis->SetLabelAngle(45);

		// $graph->Stroke();//输出矩形图表
		$num = rand(0,RAND);
		// echo var_dump($num);
		$name = "Histogrm".$num.".png";
		session_start();
		$_SESSION["name"]=$name; 
		// echo var_dump($_SESSION["name"]);
	 	$graph->Stroke($name);
	 	return $name;
	}


	public static function pieShow($piedata,$piename,$title)
	{
		//饼状图生成
		$graph = new PieGraph(LENHSIZE,HEISIZE);//设置画布尺寸
		$graph->img->SetMargin(LEFT,RIGHT,UP,DOWN);
		$graph->SetShadow();
		$graph->title->set($title);
		$graph->title->SetFont(FF_SIMSUN,FS_BOLD,GRAGHSIZE);
		$num = count($piedata);

		//如果个数大于10则用2D显示，否则用3D显示
		if (num<10) {
			$pieplot = new PiePlot3D($piedata);
		}
		else{
			$pieplot = new PiePlot($piedata);
		}
		
		$pieplot->setCenter(0.4);
		$pieplot->SetLegends($piename);
		$graph->legend->SetColumns(1);

		$pieplot->value->Show();
		$graph->legend->SetPos(0.01,0.01,'right','right');//设置图例显示属性
		$graph->legend->setFont(FF_SIMSUN,FS_BOLD,GRAGHSIZE-6);
		$graph->Add($pieplot);

		//借出次数最多物品突出显示
		$max = max($piedata);
		foreach ($piedata as $key => $value) {
			if ($value ==$max) {
				$pieplot->ExplodeSlice( $key );
			}
		}

		// $graph->AddText(new text("jhgjhs"),false);
		// $pieplot->ExplodeSlice( 0 );
		$num = rand(0,RAND);
		// echo var_dump($num);
		$name = "Histogrm".$num.".png";
		session_start();
		$_SESSION["name"]=$name;
		// echo var_dump($name);
	 	$graph->Stroke($name);
		return $name;
	}
	
	public static function linerShow($data_x,$data_y,$x_title="",$y_title="",$graph_title="")
	{

		$graph = new Graph(LENHSIZE,HEISIZE,"auto");        //创建画布
        $graph->img->SetMargin(LEFT,60,UP,DOWN);          //设置统计图所在画布的位置，左边距50、右边距40、上边距30、下边距40，单位为像素
        $graph->img->SetAntiAliasing();         //设置折线的平滑状态
        $graph->SetScale("textlin");         //设置刻度样式
        $graph->SetShadow();           //创建画布阴影

        $graph->xgrid->Show();
        $graph->title->Set($graph_title); //设置标题
  		$graph->title->SetFont(FF_SIMSUN,FS_BOLD,GRAGHSIZE);      //设置标题字体
        $graph->SetMarginColor("lightblue");       //设置画布的背景颜色为淡蓝色
        $graph->yaxis->title->SetFont(FF_SIMSUN,FS_BOLD);    //设置Y轴标题的字体
        $graph->xaxis->SetPos("min");
        $graph->yaxis->HideZeroLabel();

        // $graph->ygrid->SetFill(true,'#EFEFEF@0.5','#BBCCFF@0.5');
        // $a=array("1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月");   //X轴
        $graph->xaxis->SetTickLabels($data_x);         //设置X轴
        $graph->xaxis->SetFont(FF_SIMSUN);         //设置X坐标轴的字体
        $graph->yscale->SetGrace(20); 
        // $graph->xaxis->SetTextLabelInterval(4);
   
        $p1 = new LinePlot($data_y);          //创建折线图对象
        $p1->mark->SetType(MARK_FILLEDCIRCLE);       //设置数据坐标点为圆形标记
        $p1->mark->SetFillColor("black");         //设置填充的颜色
        $p1->mark->SetWidth(3);           //设置圆形标记的直径为4像素
        $graph->Add($p1);            //在统计图上绘制折线
        		$graph->InitializeFrameAndMargin();
        $p1->SetColor("black");           //设置折形颜色为蓝色
        // $graph->Add($p1);  
        
        $num = rand(0,RAND);
		// echo var_dump($num);
		$name = "Histogrm".$num.".png";
		session_start();
		$_SESSION["name"]=$name;
		// echo var_dump($name);
	 	$graph->Stroke($name);
	 	return $name;

	}

	public static function liner2Show($data_x,$data_y,$data2_y,$x_title,$y_title,$graph_title)
	{

		$graph = new Graph(LENHSIZE,HEISIZE,"auto");        //创建画布
        $graph->img->SetMargin(80,60,UP,DOWN);          //设置统计图所在画布的位置，左边距50、右边距40、上边距30、下边距40，单位为像素
        $graph->img->SetAntiAliasing();         //设置折线的平滑状态
        $graph->SetScale("textlin");         //设置刻度样式
        $graph->SetShadow();           //创建画布阴影
        $graph->xgrid->Show();
        $graph->title->Set($graph_title); //设置标题
  		$graph->title->SetFont(FF_SIMSUN,FS_BOLD,GRAGHSIZE);      //设置标题字体
        $graph->SetMarginColor("lightblue");       //设置画布的背景颜色为淡蓝色
        $graph->yaxis->title->SetFont(FF_SIMSUN,FS_BOLD);    //设置Y轴标题的字体
        $graph->xaxis->SetPos("min");
        $graph->yaxis->HideZeroLabel();
        // $graph->ygrid->SetFill(true,'#EFEFEF@0.5','#BBCCFF@0.5');
        // $a=array("1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月");   //X轴
        $graph->xaxis->SetTickLabels($data_x);         //设置X轴
        $graph->xaxis->SetFont(FF_SIMSUN);         //设置X坐标轴的字体
        $graph->yscale->SetGrace(20); 
        if (count($data_y)>4) {
        	$graph->xaxis->SetTextLabelInterval(4);
        }
        
   		if (!empty($data_y)) {
   			$p1 = new LinePlot($data_y);          //创建折线图对象
	        $p1->mark->SetType(MARK_FILLEDCIRCLE);       //设置数据坐标点为圆形标记
	        $p1->mark->SetFillColor("black");         //设置填充的颜色
	        $p1->mark->SetWidth(3);           //设置圆形标记的直径为4像素
	        
	        $graph->Add($p1);            //在统计图上绘制折线
	        $p1->SetColor("black");           //设置折形颜色为蓝色
   		}
        

        

        if (!empty($data2_y)) {
        	$p2 = new LinePlot($data2_y);          //创建折线图对象
	        $p2->mark->SetType(MARK_FILLEDCIRCLE);       //设置数据坐标点为圆形标记
	        $p2->mark->SetFillColor("red");         //设置填充的颜色
	        $p2->mark->SetWidth(3);           //设置圆形标记的直径为4像素
	        
	        $graph->Add($p2);$p2->SetColor("red"); 
        }



        if (!empty($data2_y)&&!empty($data_y)) {
        	// echo "sds";
        	// echo var_dump($_POST['assetName']);
        	$p1->SetLegend($_POST['assetName']);
			$p2->SetLegend($_POST['assetName2']);
			$graph->legend->SetLayout(LEGEND_HOR);
			$graph->legend->setFont(FF_SIMSUN,FS_BOLD,GRAGHSIZE-5);
			$graph->legend->Pos(0.4,0.95,"center","bottom");
        }

        $graph->InitializeFrameAndMargin();
        $graph->xaxis->SetLabelAngle(45);
         
        $num = rand(0,RAND);
		// echo var_dump($num);
		$name = "Histogrm".$num.".png";
		session_start();
		$_SESSION["name"]=$name;
		// echo var_dump($name);
	 	$graph->Stroke($name);
	 	return $name;

	}


	public static function horizontalBarShow($data_x,$data_y,$x_title,$y_title,$graph_title,$max_y)
	{
		// $graph = new Graph($width,$height);
		$graph = new Graph(LENHSIZE,400,"auto"); 
		$graph->SetScale('textlin');
		$graph->yaxis->scale->SetGrace(20);
		$top = 60;
		$bottom = 30;
		$left = 80;
		$right = 30;
		$graph->Set90AndMargin($left,$right,$top,$bottom);		// $graph->img->SetMargin(LEFT,RIGHT,UP,DOWN); 
		// // Nice shadow
		$graph->SetShadow();
		 
		// Setup labels
		// $lbl = array("Andrew\nTait","Thomas\nAnderssen","Kevin\nSpacey","Nick\nDavidsson",
		// "David\nLindquist","Jason\nTait","Lorin\nPersson");
		$graph->xaxis->SetTickLabels($data_x);
		 
		// Label align for X-axis
		$graph->xaxis->SetLabelAlign('right','center','right');
		 
		// Label align for Y-axis
		$graph->yaxis->SetLabelAlign('center','bottom');
		// $graph->yaxis->setFont(FF_SIMSUN);
		$graph->title->SetFont(FF_SIMSUN,FS_BOLD,GRAGHSIZE);
		// Titles
		$graph->title->Set($graph_title);
        $graph->xaxis->SetFont(FF_SIMSUN);         //设置X坐标轴的字体
		// Create a bar pot
		$bplot = new BarPlot($data_y);
		
		
		$graph->Add($bplot);
		// $bplot->SetFillColor(BAR_COLOR);
		$bplot->SetColor(BAR_COLOR);
		$bplot->SetFillColor(BAR_COLOR);
		$bplot->SetShadow(SHADOW);
		$bplot->SetWidth(0.5);
		// $bplot->SetYMin(1990);
		$bplot->SetWidth(25);
		$num = rand(0,RAND);
		$graph->InitializeFrameAndMargin();
		// echo var_dump($num);
		$name = "Histogrm".$num.".png";
		session_start();
		$_SESSION["name"]=$name;
		// echo var_dump($name);
	 	$graph->Stroke($name);
	 	return $name;
		
	}

	public static function liner3Show($data_x,$data_y,$x_title,$y_title,$graph_title)
	{
		// echo var_dump($data_x);
		// echo var_dump($data_y);
		$graph = new Graph(LENHSIZE,HEISIZE);        //创建画布
        $graph->img->SetMargin(LEFT,80,UP,DOWN);          //设置统计图所在画布的位置，左边距50、右边距40、上边距30、下边距40，单位为像素
        // $graph->yscale->ticks->Set($max_y/2,1);
        $graph->img->SetAntiAliasing();         //设置折线的平滑状态
        $graph->SetScale("textlin",210,230);         //设置刻度样式
        $graph->SetShadow();           //创建画布阴影
        $graph->xgrid->Show();
        $line = new PlotLine(HORIZONTAL,220,"red",2);//设置红色警戒线
        $line->SetLegend("警戒线");
        $graph->legend->setFont(FF_SIMSUN,FS_BOLD,GRAGHSIZE-5);
        $graph->AddLine($line,false);
        $graph->title->Set($graph_title); //设置标题
  		$graph->title->SetFont(FF_SIMSUN,FS_BOLD,GRAGHSIZE);      //设置标题字体
        $graph->SetMarginColor("lightblue");       //设置画布的背景颜色为淡蓝色
        $graph->yaxis->title->SetFont(FF_SIMSUN,FS_BOLD);    //设置Y轴标题的字体
        $graph->xaxis->SetPos("min");
        // $graph->yaxis->HideZeroLabel();
        // $graph->ygrid->SetFill(true,'#EFEFEF@0.5','#BBCCFF@0.5');
        // $a=array("1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月");   //X轴
        $graph->xaxis->SetTickLabels($data_x);         //设置X轴
        $graph->xaxis->SetFont(FF_SIMSUN);         //设置X坐标轴的字体
        // $graph->yscale->SetGrace(20); 
			
        $p1 = new LinePlot($data_y);          //创建折线图对象
        $p1->mark->SetType(MARK_FILLEDCIRCLE);       //设置数据坐标点为圆形标记
        $p1->mark->SetFillColor("black");         //设置填充的颜色
        $p1->mark->SetWidth(3);           //设置圆形标记的直径为3像素
        $p1->SetColor("blue"); 

        // $p1->SetYMin(0);
        $graph->Add($p1);

        $graph->InitializeFrameAndMargin();

		$num = rand(0,RAND);
		// echo var_dump($num);
		$name = "Histogrm".$num.".png";
		session_start();
		$_SESSION["name"]=$name;
		// echo var_dump($name);
	 	$graph->Stroke($name);
	 	return $name;
	}


/***************************删除历史图片******************************/
	public static function deletePic()
	{
		$fname = 'Histogrm';
		$a=glob("$fname*.png");
		if (!empty($a)) {
			foreach ($a as $key => $value) {
				if (file_exists($value))
  				unlink($value);
			}
			
		}
	}

	public static function deleteQRCode()
	{
		$fname = 'qrCode/finalQRCode';
		$a=glob("$fname*.jpeg");
		if (!empty($a)) {
			foreach ($a as $key => $value) {
				if (file_exists($value))
  				unlink($value);
			}
			
		}
	}


}





?>
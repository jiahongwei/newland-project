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
class Statistics extends HDraw
{//考勤部分统计图函数

    static public $color = array(
	        'black',
	        'blue',
	        'orange',
	        'darkgreen',
	        'red',
	        'AntiqueWhite3',
	        'aquamarine3',
	        'azure4',
	        'brown',
	        'cadetblue3',
	        'chartreuse4',
	        'chocolate',
	        'darkblue',
	        'darkgoldenrod3',
	        'darkorchid3',
	        'darksalmon',
	        'darkseagreen4',
	        'deepskyblue2',
	        'dodgerblue4',
	        'gold3',
	        'hotpink',
	        'lawngreen',
	        'lightcoral',
	        'lightpink3',
	        'lightseagreen',
	        'lightslateblue',
	        'mediumpurple',
	        'olivedrab',
	        'orangered1',
	        'peru',
	        'slategray',
	        'yellow4',
	        'springgreen2');


/***************************************绘制雷达图************************************/
	public Static function radarPlot()
	{
		
	}




/****************************************画折线图*************************************/
	public static function linerShow($data_x,$data_y,$graph_title="",$x_title="",$y_title="")
	{

		$graph = new Graph(LENHSIZE,HEISIZE,"auto");        //创建画布
        $graph->img->SetMargin(LEFT,60,UP,DOWN);          //设置统计图所在画布的位置，左边距50、右边距40、上边距30、下边距40，单位为像素
        $graph->img->SetAntiAliasing();         //设置折线的平滑状态
        $graph->SetScale("textlin",0,1);         //设置刻度样式
        $graph->SetShadow();           //创建画布阴影
        $graph->title->Set($graph_title); //设置标题
  		$graph->title->SetFont(FF_SIMSUN,FS_BOLD,GRAGHSIZE);      //设置标题字体
        $graph->SetMarginColor("lightblue");       //设置画布的背景颜色为淡蓝色
        $graph->yaxis->title->SetFont(FF_SIMSUN,FS_BOLD);    //设置Y轴标题的字体
        $graph->xaxis->SetPos("min");
        $graph->yaxis->HideZeroLabel();
		$graph->xaxis->SetTickLabels($data_x);         //设置X轴
        $graph->xaxis->SetFont(FF_SIMSUN);         //设置X坐标轴的字体
        $graph->yscale->SetGrace(20); 

        $p1 = new LinePlot($data_y);          //创建折线图对象
        $p1->mark->SetType(MARK_FILLEDCIRCLE);       //设置数据坐标点为圆形标记
        $p1->mark->SetFillColor("black");         //设置填充的颜色
        $p1->mark->SetWidth(3);           //设置圆形标记的直径为4像素

        $graph->Add($p1);            //在统计图上绘制折线
        $graph->xaxis->SetLabelAngle(45);
        $graph->InitializeFrameAndMargin();
        $p1->SetColor("black");           //设置折形颜色为蓝色
		$graph->xgrid->Show();

        $num = rand(0,RAND);
		$name = "Histogrm".$num.".png";
		session_start();
		$_SESSION["name"]=$name;
		$graph->Stroke($name);
	 	return $name;

	}



/******************************画柱状图*************************************/
	public static function HistogramShow($data_x,$data_y,$max_y,$graph_title="",$x_title="",$y_title="")
	{

		//柱状图生成函数
		$graph = new Graph(LENHSIZE,HEISIZE,"auto"); //创建画布
		// $graph->SetScale('textlin');  // 设置y轴的值   这里是0到60
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
		$graph->InitializeFrameAndMargin();
		
		$graph->Add($bplot);//将柱形图添加到图像中
		$bplot->SetColor(BAR_COLOR);
		$bplot->SetFillColor(BAR_COLOR);
		$bplot->SetWidth(25);
		$graph->title->Set($graph_title);//创建标题"借出次数统计结果(按借出次数由由低到高排列)"
		$graph->xaxis->SetTickLabels($data_x); //设置X坐标轴文字
		$bplot->SetShadow(SHADOW);//设置阴影效果
		$bplot->value->Show();
		if ($max_y<=1) {
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

		$num = rand(0,RAND);
		$name = "Histogrm".$num.".png";
		session_start();
		$_SESSION["name"]=$name; 
		$graph->Stroke($name);
	 	return $name;
	}


/*********************************多条折线图***************************************/
	public static function linerMoreShow($data,$x_num,$legend,$data_x,$max_y,$graph_title="",$x_title="",$y_title="")
	{
		
		$graph = new Graph(LENHSIZE,HEISIZE,"auto");        //创建画布
        $graph->img->SetMargin(LEFT,60,UP,DOWN);          //设置统计图所在画布的位置，左边距50、右边距40、上边距30、下边距40，单位为像素
        $graph->img->SetAntiAliasing();         //设置折线的平滑状态
        $graph->SetScale("textlin",0,1);         //设置刻度样式
        $graph->SetShadow();           //创建画布阴影
        $graph->title->Set($graph_title); //设置标题
  		$graph->title->SetFont(FF_SIMSUN,FS_BOLD,GRAGHSIZE);      //设置标题字体
        $graph->SetMarginColor("lightblue");       //设置画布的背景颜色为淡蓝色
        $graph->yaxis->title->SetFont(FF_SIMSUN,FS_BOLD);    //设置Y轴标题的字体
        $graph->xaxis->SetPos("min");
        $graph->yaxis->HideZeroLabel();
		$graph->xaxis->SetTickLabels($data_x);         //设置X轴
        $graph->xaxis->SetFont(FF_SIMSUN);         //设置X坐标轴的字体
        $graph->yscale->SetGrace(20);
		foreach ($data as $key => $value) {
			$p1 = new LinePlot($value);          //创建折线图对象
			$graph->Add($p1);            //在统计图上绘制折线
			$p1->mark->SetType(MARK_FILLEDCIRCLE);
	        $p1->mark->SetFillColor(Statistics::$color[$key]);         //设置填充的颜色
	        $p1->mark->SetWidth(3);           //设置圆形标记的直径为4像素
	        $p1->SetLegend($legend[$key]);
	        $p1->SetColor(Statistics::$color[$key]);           //设置折形颜色为蓝色
	        $p1->SetCenter();
		}

		$graph->xaxis->setFont(FF_SIMSUN,FS_BOLD,X_FONT); //设置字体
		$graph->xgrid->Show();
		if ($x_num>10) {
			$graph->xaxis->SetLabelAngle(45);
		}
	    $graph->InitializeFrameAndMargin();
		$graph->legend->SetFrameWeight(1);
		$graph->legend->SetColor('#4E4E4E','#00A78A');
		$graph->legend->SetMarkAbsSize(8);
		$graph->legend->setFont(FF_SIMSUN,FS_BOLD,GRAGHSIZE-6);

		$num = rand(0,RAND);
		$name = "Histogrm".$num.".png";
		session_start();
		$_SESSION["name"]=$name; 
		$graph->Stroke($name);
	 	return $name;
	}


}





?>
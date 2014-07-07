<!--DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ansi" />
<title></title>
<style>
</style>
</head>
<body>
<div id="container">
<p> Optimization </p>
    <form method="post" action="index.php" name="data" id="data"> 
	<b> Accuracy for each variable:</b></br> 
        <label for="qs">s:</label><input type="text" name="qs" value="5" id="qs"> &nbsp;
        <label for="qv">v:</label><input type="text" name="qv" value="1" id="qv"> &nbsp;
        <label for="ql">L:</label><input type="text" name="ql" value="4" id="ql"> &nbsp;
        <label for="qd">d:</label><input type="text" name="qd" value="4" id="qd"> &nbsp;
        <label for="qd0">D0:</label><input type="text" name="qd0" value="10" id="qd0"><br>  		
		<b> Popularion:</b></br>
		<label for="popsize">Population size:</label><input type="text" name="popsize" value="1000" id="popsize"><br>
	    <input type="submit" name="start" id="start" value="Start">  
    </form>  
<br />
</form>
</div-->

<!DOCTYPE HTML>
<html style="height:100%;">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<style>
</style>
</head>
<body style="height:97%;">
	<table width="100%" style="height:100%;" cellpadding="5" border="1">
		<tr>
			<td style="background-image: url(gene.jpg);" colspan="2"> <h3 style="font-family: calibri; color:white"> Многопараметрическая оптимизация при помощи генетического алгоритма </h3></td>
		</tr>
		<tr>
			<td width="50%"> Функуция 1 - резмер зерна металла </br>
			<img src="form1.png" align="center">
			
			</td>
			<td> Функуция 2 - производительность </br>
			<img src="form2.png" align="center">
			</td>
		</tr>
		<tr>
			<td colspan="2">Где s - подача; v - скорость резания; L - длина заготовки; d - диаметр заготовки; D0 - исходный резмер зерна; A - показатель свойств материала</td>
		</tr>
		<tr>
			<!--td colspan="2">
				<table width="80%"  border="2">
					<tr>
						<td> </td>
						<td> L, м</td>
						<td> d, м</td>
						<td> D0, м</td>
						<td> s, м</td>
						<td> v, м</td>
					</tr>
					<tr>
						<td> min </td>
						<td> 0.1</td>
						<td> 0.01</td>
						<td> 0.2E-7</td>
						<td> 1E-5</td>
						<td> 2.5</td>
					</tr>
					<tr>
						<td> max </td>
						<td> 0.5</td>
						<td> 0.1</td>
						<td> 2.5E-7</td>
						<td> 10.23E-3</td>
						<td> 100</td>
					</tr>
				</table-->				
			</td>
		</tr>
		<tr height="100%">
			<td style="vertical-align:top; width:50%;"> <b style="font: 14pt sans-serif;">Введите начальные параметры для генетического алгоритма:</b></br>
				<form method="post" action="index.php" name="data" id="data"> 
					<b> Точность результата по каждой переменной до q знака после запятой:</b> </br> 
						<label style="padding-left:30px" for="qs"> &nbsp;&nbsp; s:</label><input type="text" name="qs" value="5" id="qs"> </br>
						<label style="padding-left:30px" for="qv"> &nbsp;&nbsp; v:</label><input type="text" name="qv" value="1" id="qv"> </br>
						<label style="padding-left:30px" for="ql"> &nbsp;&nbsp; L:</label><input type="text" name="ql" value="4" id="ql"> </br>
						<label style="padding-left:30px" for="qd"> &nbsp;&nbsp; d:</label><input type="text" name="qd" value="4" id="qd"> </br>
						<label style="padding-left:30px" for="qd0">D0:</label><input type="text" name="qd0" value="10" id="qd0"><br>  		
						<b> Размер популяции:</b></br>
						<label for="popsize">Особей:</label><input type="text" name="popsize" value="1000" id="popsize"><br>
						<input type="submit" name="start" id="start" value="Старт алгоритма">  
					</form> 			
			</td>
			<td style="vertical-align:top; width:50%; word-warp:normal"><b style="font: 14pt sans-serif;">Результаты вычислений:</b></br>
<? /*echo "Good beginning! "; ?></br><?*/
	set_time_limit ( 1000 );

if(!empty($_POST['qs']) && !empty($_POST['qv']) && !empty($_POST['ql']) && !empty($_POST['qd']) && !empty($_POST['qd0']) && !empty($_POST['popsize']))
{

	$mins = 0.00001;
	$maxs = 0.01023;
	$minv = 2.5;
	$maxv = 100;
	$minl = 0.1;
	$maxl = 0.5;
	$mind = 0.01;
	$maxd = 0.1;
	$mind0 = 0.2e-7;
	$maxd0 = 2.5e-7;
	//шаг сетки по каждой переменной
	
	$qs = $_POST['qs'];
	$qv = $_POST['qv'];
	$ql = $_POST['ql'];
	$qd = $_POST['qd'];
	$qd0 = $_POST['qd0'];
	
	$popsize = $_POST['popsize'];
	
	/*$qs = 5;
	$qv = 1;
	$ql = 4;
	$qd = 4;
	$qd0 = 10;*/
	
	/*$qs = 3;
	$qv = -1;
	$ql = 1;
	$qd = 2;
	$qd0 = 8;*/
	
	
	//длины хромосом, шаг-------------------------------------------------------------------------------------ДЛИНЫ ГЕНОВ
	
	$Ls = ceil(log((($maxs-$mins)*pow(10,$qs)+1),2));
	$hs = (($maxs-$mins)/(pow(2,$Ls)-1));
	$ns = ($maxs-$mins)/$hs;
	
	$Lv = ceil(log((($maxv-$minv)*pow(10,$qv)+1),2));
	$hv = (($maxv-$minv)/(pow(2,$Lv)-1));
	$nv = ($maxv-$minv)/$hv;
	
	$Ll = ceil(log((($maxl-$minl)*pow(10,$ql)+1),2));
	$hl = (($maxl-$minl)/(pow(2,$Ll)-1));
	$nl = ($maxl-$minl)/$hl;
	
	$Ld = ceil(log((($maxd-$mind)*pow(10,$qd)+1),2));
	$hd = (($maxd-$mind)/(pow(2,$Ld)-1));
	$nd = ($maxd-$mind)/$hd;
	
	$Ld0 = ceil(log((($maxd0-$mind0)*pow(10,$qd0)+1),2));
	$hd0 = (($maxd0-$mind0)/(pow(2,$Ld0)-1));
	$nd0 = ($maxd0-$mind0)/$hd0;
	
	echo "  Точность qs = $qs; длина гена Ls = $Ls; шаг по s = $hs; сетка = $ns точек; " ; ?></br><?
	echo "  Точность qv = $qv; длина гена Lv = $Lv; шаг по v = $hv; сетка = $nv точек;" ; ?></br><?	
	echo "  Точность ql = $ql; длина гена Ll = $Ll; шаг по l = $hl; сетка = $nl точек;" ; ?></br><?
	echo "  Точность qd = $qd; длина гена Ld = $Ld; шаг по d = $hd; сетка = $nd точек;" ; ?></br><?
	echo "  Точность qd0 = $qd0; длина гена Ld0 = $Ld0; шаг по d0 = $hd0; сетка = $nd0 точек;" ; ?></br><?

	//одеяло
	/*
	$c_pop_x = 10;
	$c_pop_y = 200;
	
	$popsize = $c_pop_x*$c_pop_y;
	
	for ( $i = 1; $i<=$c_pop_x; $i++)
		{ $cx[$i] = $mins+((($maxs - $mins)/($c_pop_x+1))*$i); }
		
	for ( $i = 1; $i<=$c_pop_y; $i++)
		{ $cy[$i] = $minv+((($maxv - $minv)/($c_pop_y+1))*$i); }
		
	//print_r($cx);
	//print_r($cy);
	
	//начальная популяция
	$i = 1;
	$k = 1;
	while ($i<=$popsize)
	{
		for ( $j = 1; $j<=($c_pop_y); $j++)
		{
			$inds[$i] = $cx[$k];
			$i++;
		}
		$k++;
	}
		
	$i = 1;
	while ($i<=$popsize)
	{
		for ( $j = 1; $j<=($c_pop_x); $j++)
		{
			for ( $k = 1; $k<=($c_pop_y); $k++)
			{
				$indv[$i] = $cy[$k];
				$i++;
			}
		}

	}
	*/
	//случайная начальная популяция-------------------------------------------------------------------------------НАЧАЛЬНАЯ ПОПУЛЯЦИЯ
	
	//$popsize = 1000;
	echo "Популяция = $popsize особей" ; ?></br></br><?
	
	for ( $i = 1; $i<=$popsize; $i++)
	{
	//для первой функции
		$inds[$i] = (rand($mins*100000,$maxs*100000))/100000;
		$indv[$i] = (rand($minv*10,$maxv*10))/10;
		$indl[$i] = (rand($minl*10,$maxl*10))/10;
		$indd[$i] = (rand($mind*100,$maxd*100))/100;
		$indd0[$i] = (rand($mind0*100000000,$maxd0*100000000))/100000000;
	//для второй функции
		$inds1[$i] = (rand($mins*100000,$maxs*100000))/100000;
		$indv1[$i] = (rand($minv*10,$maxv*10))/10;
		$indl1[$i] = (rand($minl*10,$maxl*10))/10;
		$indd1[$i] = (rand($mind*100,$maxd*100))/100;
		$indd01[$i] = (rand($mind0*100000000,$maxd0*100000000))/100000000;
		
	}
	/*print_r($inds); ?></br><?
	print_r($indv); ?></br><?*/
	//$totalfitold = 0;
	
	$totalfit = 1;
	$totalold = 0;
	
	$totalfit1 = 1;
	$totalold1 = 0;
	$br = 0;
	
	$a = 10.12E-14;
	/*$l = 0.5;
	$d = 0.01;
	$d0 = 0.00000002; */   //0.00000025 0.00000002
	
	//старт алгоритма--------------------------------------------------------------------------------------------------------------------ЦИКЛ
	
	?> <div style = 'overflow: scroll; width: 700px; height: 100px;'> <?
	while ( $br < 50)
	{
	//фитнесс - функция !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!------------------------------------------------------------------ФИТНЕСС
	
	$totalfitold = $totalfit;
	$totalfitold1 = $totalfit1;
	$sumfit = 0;
	$sumfit1 = 0;
	for ( $i = 1; $i<=$popsize; $i++)
	{
		
		//$fitness[$i] = 1/($inds[$i]*$indv[$i]);
		//первая
		$fitness[$i] = sqrt(pow($indd0[$i],2)+$a*((pi()*$indd[$i]*$indl[$i])/($inds[$i]*$indv[$i])));
		//$fitness[$i] =sqrt ( pow(0.00000002,2) + ($a*pi()*0.01*0.1)/(0.00001*2.5));
		//вторая
		$fitness1[$i] = 1/($inds1[$i]*$indv1[$i]);
			
		$sumfit = $sumfit + $fitness[$i];
		$sumfit1 = $sumfit1 + $fitness1[$i];
	}
	$totalfit = $sumfit/$popsize;
	$totalfit1 = $sumfit1/$popsize;
	
	echo "function 1 = $totalfit ;   function 2 = $totalfit1 "; ?></br><?
    //$br++;
	if ($totalfitold1 == $totalfit1) $br++; else $br = 0;
	
	/*echo "фитнесс-функции каждой переменной:"; ?></br><?
	print_r($fitness); ?></br><?*/
	
	//создание хромосом----------------------------------------------------------------------------------------------------БИНАРИЗАЦИЯ ГЕНОВ
	for ( $i = 1; $i<=$popsize; $i++)
	{
		/*$sr[$i] = ceil(($inds[$i] - $mins)/$hs);
        $chroms[$i] = sprintf( "%0".$Ls."d", decbin( $sr[$i] ));
		$vr[$i] = ceil(($indv[$i] - $minv)/$hv);
		$chromv[$i] = sprintf( "%0".$Lv."d", decbin( $vr[$i] ));*/
		//для первой популяции
		$sr[$i] = ceil(($inds[$i] - $mins)/$hs);
        $chroms[$i] = str_pad(decbin($sr[$i]), $Ls, '0', STR_PAD_LEFT);		
		$vr[$i] = ceil(($indv[$i] - $minv)/$hv);
        $chromv[$i] = str_pad(decbin($vr[$i]), $Lv, '0', STR_PAD_LEFT);
		$lr[$i] = ceil(($indl[$i] - $minl)/$hl);
        $chroml[$i] = str_pad(decbin($lr[$i]), $Ll, '0', STR_PAD_LEFT);
		$dr[$i] = ceil(($indd[$i] - $mind)/$hd);
        $chromd[$i] = str_pad(decbin($dr[$i]), $Ld, '0', STR_PAD_LEFT);
		$d0r[$i] = ceil(($indd0[$i] - $mind0)/$hd0);
        $chromd0[$i] = str_pad(decbin($d0r[$i]), $Ld0, '0', STR_PAD_LEFT);
		//для второй популяции
		$sr1[$i] = ceil(($inds1[$i] - $mins)/$hs);
        $chroms1[$i] = str_pad(decbin($sr1[$i]), $Ls, '0', STR_PAD_LEFT);		
		$vr1[$i] = ceil(($indv1[$i] - $minv)/$hv);
        $chromv1[$i] = str_pad(decbin($vr[$i]), $Lv, '0', STR_PAD_LEFT);
		$lr1[$i] = ceil(($indl1[$i] - $minl)/$hl);
        $chroml1[$i] = str_pad(decbin($lr1[$i]), $Ll, '0', STR_PAD_LEFT);
		$dr1[$i] = ceil(($indd1[$i] - $mind)/$hd);
        $chromd1[$i] = str_pad(decbin($dr1[$i]), $Ld, '0', STR_PAD_LEFT);
		$d0r1[$i] = ceil(($indd01[$i] - $mind0)/$hd0);
        $chromd01[$i] = str_pad(decbin($d0r1[$i]), $Ld0, '0', STR_PAD_LEFT);
		
	}
	/*echo "хромосомы:"; ?></br><?
	print_r($chroms); ?></br><?
	print_r($chromv); ?></br><?*/
	
	//перевод фитнесс-фций в положительные
	
	/*
	$sumplus = 0;
	$fitmin = min($fitness);
	for ( $i = 1; $i<=$popsize; $i++)
	{
		$fitplus[$i] = $fitness[$i]+(2*abs($fitmin));
		$sumplus = $sumplus + $fitplus[$i];
	}
	$totalfitplus = $sumplus/$popsize;
	
	echo " минимальный: $fitmin"; ?></br><?
	echo " положит. популяция";
	print_r ($fitplus); ?></br><?
	//echo "  $sumplus  ";
	//echo "### $totalfitplus ###";
	//echo " fmin: $fitmin";
	*/
	/*
	$fitmin = min($fitness);
	for ( $i = 1; $i<=$popsize; $i++)
	{
		$fitplus[$i] = $fitness[$i]-$fitmin;
		$sumplus = $sumplus + $fitplus[$i];
	}
	$totalfitplus = $sumplus/$popsize;
	
	/*echo " минимальный: $fitmin"; ?></br><?
	echo " положит. популяция";
	print_r ($fitplus); ?></br><?*/
	
	//рулетка   !!!!!!!!!!!!! НЕ РАБОТАЕТ ДЛЯ МИНИМИЗАЦИИ!!! !!!!!!!!!!!!!!!!!!!!!!!!!!
	
	/*
	for ( $i = 1; $i<=$popsize; $i++)
		{
			$chanse[$i] = ($fitplus[$i]/$sumplus)*100;
			$sector[$i] = $chanse[$i]+$sector[$i-1];
		}
	   /*echo "вероятности:"; ?></br><?
	    print_r($chanse); ?></br><?*/
	   /*print_r($sector); ?></br><?*/
	/*
	for ( $i = 1; $i<=$popsize/2; $i++)
		{
			$random1 = rand(0,100000)/1000;
			$random2 = rand(0,100000)/1000;
			//echo "*$random*  ";
			for ( $j = 1; $j<=$popsize; $j++)
			{
				if (($random1 <= $sector[$j]) && ($random1 > $sector[$j-1]))
				{
					$mom[$i] = $j;
				}
				if (($random2 <= $sector[$j]) && ($random2 > $sector[$j-1]))
				{
					$dad[$i] = $j;
				}
			}
		}
		
	*/	
	/*echo "родительские особи:" ?></br><?
	print_r($mom); ?></br><?
	print_r($dad); ?></br><?*/
	
	//турнирный отбор-------------------------------------------------------------------------------------------------------------------ОТБОР
	
	for ( $i = 1; $i<=$popsize*2; $i++)     //   popsize*2 ??????????????????
		{
		
			$random1 = rand(1,$popsize);
			$random2 = rand(1,$popsize);
			if ($fitness[$random1] < $fitness[$random2])
			$mom[$i] = $random1;
			else
			$mom[$i] = $random2;
			
			$random3 = rand(1,$popsize);
			$random4 = rand(1,$popsize);
			if ($fitness1[$random3] < $fitness1[$random4])
			$dad[$i] = $random3;
			else
			$dad[$i] = $random4;
			
		/*
			$numbers[$i] = $i;
			
			$random1 = rand(1,$popsize);
			$random2 = rand(1,$popsize);
			if ($fitness[$random1] < $fitness[$random2])
			{
				$momchroms[$i] = $chroms[$random1];	
				$momchromv[$i] = $chromv[$random1];	
				$momchroml[$i] = $chroml[$random1];	
				$momchromd[$i] = $chromd[$random1];	
				$momchromd0[$i] = $chromd0[$random1];
			}
			else
			{
				$momchroms[$i] = $chroms[$random2];	
				$momchromv[$i] = $chromv[$random2];	
				$momchroml[$i] = $chroml[$random2];	
				$momchromd[$i] = $chromd[$random2];	
				$momchromd0[$i] = $chromd0[$random2];
			}
			
			$random3 = rand(1,$popsize);
			$random4 = rand(1,$popsize);
			
			if ($fitness[$random3] < $fitness[$random4])
			{
				$dadchroms[$i] = $chroms1[$random3];	
				$dadchromv[$i] = $chromv1[$random3];	
				$dadchroml[$i] = $chroml1[$random3];	
				$dadchromd[$i] = $chromd1[$random3];	
				$dadchromd0[$i] = $chromd01[$random3];
			}
			else
			{
				$dadchroms[$i] = $chroms1[$random4];	
				$dadchromv[$i] = $chromv1[$random4];	
				$dadchroml[$i] = $chroml1[$random4];	
				$dadchromd[$i] = $chromd1[$random4];	
				$dadchromd0[$i] = $chromd01[$random4];
			}	*/	
			
		}
	
	/*
	$pools = array_merge ($momchroms, $dadchroms);
	$poolv = array_merge ($momchromv, $dadchromv);
	$pooll = array_merge ($momchroml, $dadchroml);
	$poold = array_merge ($momchromd, $dadchromd);
	$poold0 = array_merge ($momchromd0, $dadchromd0);
	shuffle($numbers);
	array_chunk($numbers, $popsize/2);*/
	
	//кроссовер---------------------------------------------------------------------------------------------------------------------------СКРЕЩИВАНИЕ
	//$split = ceil(min($Ls, $Lv)/2);
	$split = rand(1,min($Ls, $Lv));
	//echo " sp: $split ";
	
	//скрещиваются обе популяции
	for ( $i = 1; $i<=$popsize; $i++)
	{
		
		$scross1mom = substr($chroms[$mom[$i]],0,$split);
		$scross2mom = substr($chroms[$mom[$i]],$split);
		$scross1dad = substr($chroms1[$dad[$i]],0,$split);
		$scross2dad = substr($chroms1[$dad[$i]],$split);
		
		$nextgens[$i] = $scross1mom.$scross2dad;
		$nextgens1[$i] = $scross1dad.$scross2mom;
		
		$vcross1mom = substr($chromv[$mom[$i]],0,$split);
		$vcross2mom = substr($chromv[$mom[$i]],$split);
		$vcross1dad = substr($chromv1[$dad[$i]],0,$split);
		$vcross2dad = substr($chromv1[$dad[$i]],$split);
		
		$nextgenv[$i] = $vcross1mom.$vcross2dad;
		$nextgenv1[$i] = $vcross1dad.$vcross2mom;
		
		$lcross1mom = substr($chroml[$mom[$i]],0,$split);
		$lcross2mom = substr($chroml[$mom[$i]],$split);
		$lcross1dad = substr($chroml1[$dad[$i]],0,$split);
		$lcross2dad = substr($chroml1[$dad[$i]],$split);
		
		$nextgenl[$i] = $lcross1mom.$lcross2dad;
		$nextgenl1[$i] = $lcross1dad.$lcross2mom;
		
		$dcross1mom = substr($chromd[$mom[$i]],0,$split);
		$dcross2mom = substr($chromd[$mom[$i]],$split);
		$dcross1dad = substr($chromd1[$dad[$i]],0,$split);
		$dcross2dad = substr($chromd1[$dad[$i]],$split);
		
		$nextgend[$i] = $dcross1mom.$dcross2dad;
		$nextgend1[$i] = $dcross1dad.$dcross2mom;
		
		$d0cross1mom = substr($chromd0[$mom[$i]],0,$split);
		$d0cross2mom = substr($chromd0[$mom[$i]],$split);
		$d0cross1dad = substr($chromd01[$dad[$i]],0,$split);
		$d0cross2dad = substr($chromd01[$dad[$i]],$split);
		
		$nextgend0[$i] = $d0cross1mom.$d0cross2dad;
		$nextgend01[$i] = $d0cross1dad.$d0cross2mom;
		
	}
	
		//мутация-----------------------------------------------------------------------------------------------------------------------------МУТАЦИЯ
	/*
	for ( $i = 1; $i<=$popsize; $i++)
	{
		//для первой подпопуляции
		$spls = str_split($nextgens[$i]);
		for ($j=0; $j< $Ls; $j++)
		{
			if (rand(1,100)<2)
			{
			if ($spls[$j] == 0) $spls[$j] = 1; else $spls[$j] = 0;
			}
		}
		$nextgens[$i] = implode($spls);
		
		$splv = str_split($nextgenv[$i]);
		for ($j=0; $j< $Lv; $j++)
		{
			if (rand(1,100)<2)
			{
			if ($splv[$j] == 0) $splv[$j] = 1; else $splv[$j] = 0;
			}
		}
		$nextgenv[$i] = implode($splv);
		
		$spll = str_split($nextgenl[$i]);
		for ($j=0; $j< $Ll; $j++)
		{
			if (rand(1,100)<2)
			{
			if ($spll[$j] == 0) $spll[$j] = 1; else $spll[$j] = 0;
			}
		}
		$nextgenl[$i] = implode($spll);
		
		$spld = str_split($nextgend[$i]);
		for ($j=0; $j< $Ld; $j++)
		{
			if (rand(1,100)<2)
			{
			if ($spld[$j] == 0) $spld[$j] = 1; else $spld[$j] = 0;
			}
		}
		$nextgend[$i] = implode($spld);
		
		$spld0 = str_split($nextgend0[$i]);
		for ($j=0; $j< $Ld0; $j++)
		{
			if (rand(1,100)<2)
			{
			if ($spld0[$j] == 0) $spld0[$j] = 1; else $spld0[$j] = 0;
			}
		}
		$nextgend0[$i] = implode($spld0);
		
		//для второй подпопуляции
		$spls1 = str_split($nextgens1[$i]);
		for ($j=0; $j< $Ls; $j++)
		{
			if (rand(1,100)<2)
			{
			if ($spls1[$j] == 0) $spls1[$j] = 1; else $spls1[$j] = 0;
			}
		}
		$nextgens1[$i] = implode($spls1);
		
		$splv1 = str_split($nextgenv1[$i]);
		for ($j=0; $j< $Lv; $j++)
		{
			if (rand(1,100)<2)
			{
			if ($splv1[$j] == 0) $splv1[$j] = 1; else $splv1[$j] = 0;
			}
		}
		$nextgenv1[$i] = implode($splv1);
		
		$spll1 = str_split($nextgenl1[$i]);
		for ($j=0; $j< $Ll; $j++)
		{
			if (rand(1,100)<2)
			{
			if ($spll1[$j] == 0) $spll1[$j] = 1; else $spll1[$j] = 0;
			}
		}
		$nextgenl1[$i] = implode($spll1);
		
		$spld1 = str_split($nextgend1[$i]);
		for ($j=0; $j< $Ld; $j++)
		{
			if (rand(1,100)<2)
			{
			if ($spld1[$j] == 0) $spld1[$j] = 1; else $spld1[$j] = 0;
			}
		}
		$nextgend1[$i] = implode($spld1);
		
		$spld01 = str_split($nextgend01[$i]);
		for ($j=0; $j< $Ld0; $j++)
		{
			if (rand(1,100)<2)
			{
			if ($spld01[$j] == 0) $spld01[$j] = 1; else $spld01[$j] = 0;
			}
		}
		$nextgend01[$i] = implode($spld01);
		
	}*/
	
	//замена старой популяции на новую-----------------------------------------------------------------------------------------------СМЕНА ПОКОЛЕНИЯ
	for ( $i = 1; $i<=$popsize; $i++)
	{
	//для первой
		$chroms[$i] = $nextgens[$i];
		$chromv[$i] = $nextgenv[$i];
		$chroml[$i] = $nextgenl[$i];
		$chromd[$i] = $nextgend[$i];
		$chromd0[$i] = $nextgend0[$i];
	//для второй
		$chroms1[$i] = $nextgens1[$i];
		$chromv1[$i] = $nextgenv1[$i];
		$chroml1[$i] = $nextgenl1[$i];
		$chromd1[$i] = $nextgend1[$i];
		$chromd01[$i] = $nextgend01[$i];
	}
	//print_r($chroms);
	//print_r($chromv);
	
	//восстановление десятичных значений-----------------------------------------------------------------------------------------------В ДЕСЯТИЧНЫЕ
	
	for ( $i = 1; $i<=$popsize; $i++)
	{
	//для первой популяции
		$sr[$i] = bindec($chroms[$i]);
		$inds[$i] = $mins+$sr[$i]*$hs;
		
		$vr[$i] = bindec($chromv[$i]);
		$indv[$i] = $minv+$vr[$i]*$hv;
		
		$lr[$i] = bindec($chroml[$i]);
		$indl[$i] = $minl+$lr[$i]*$hl;
		
		$dr[$i] = bindec($chromd[$i]);
		$indd[$i] = $mind+$dr[$i]*$hd;
		
		$d0r[$i] = bindec($chromd0[$i]);
		$indd0[$i] = $mind0+$d0r[$i]*$hd0;
	//для второй популяции
		$sr1[$i] = bindec($chroms1[$i]);
		$inds1[$i] = $mins+$sr1[$i]*$hs;
		
		$vr1[$i] = bindec($chromv1[$i]);
		$indv1[$i] = $minv+$vr1[$i]*$hv;
		
		$lr1[$i] = bindec($chroml1[$i]);
		$indl1[$i] = $minl+$lr1[$i]*$hl;
		
		$dr1[$i] = bindec($chromd1[$i]);
		$indd1[$i] = $mind+$dr1[$i]*$hd;
		
		$d0r1[$i] = bindec($chromd01[$i]);
		$indd01[$i] = $mind0+$d0r1[$i]*$hd0;

	}
	//print_r($inds);
	//print_r($indv);
	
		//РїСЂРёСЃРїРѕСЃРѕР±Р»РµРЅРЅРѕСЃС‚СЊ РїРѕРїСѓР»СЏС†РёРё 2
	
	/*$sumfit = 0;
	for ( $i = 1; $i<=$popsize; $i++)
	{
		$fitness[$i] = (pow($inds[$i],2))-(pow($indv[$i],2));
		$sumfit = $sumfit + $fitness[$i];
	}
	$totalfit = $sumfit/$popsize;
	echo "### $totalfit ###";*/
	}
	
	?></div><?
	
	//----------------------------------------------------------------------------------------------------------------------------ВЫВОД РЕЗУЛЬТАТА
	$minimum = min($fitness);
	$minimum1 = min($fitness1);
	echo "Минимум функции 1 :  $minimum "; ?>&nbsp;&nbsp;&nbsp;<?
	echo "Минимум функции 2 :  $minimum1 "; ?></br></br><?
	for ($i = 1; $i<$popsize; $i++)
	{
		if ($fitness[$i] == $minimum)
		{
			echo "s = $inds[$i];"; ?>&nbsp;&nbsp;&nbsp;<?
			echo "v = $indv[$i];"; ?>&nbsp;&nbsp;&nbsp;<?
			echo "l = $indl[$i];"; ?>&nbsp;&nbsp;&nbsp;<?
			echo "d =  $indd[$i];"; ?>&nbsp;&nbsp;&nbsp;<?
			echo "D0 = $indd0[$i];"; ?></br><?
			break;
		}

	}
	for ($i = 1; $i<$popsize; $i++)
	{
		if ($fitness1[$i] == $minimum1)
		{
			echo "s2 = $inds1[$i];"; ?>&nbsp;&nbsp;&nbsp;<?
			echo "v2 = $indv1[$i];"; ?></br><?
			break;
		}
	}
	/*$f = ((-2*pow(3.191983,3)+6*pow(3.191983,2)+6*3.191983+10)*sin(log(0.653097)*exp(3.191983)));
	echo "  %%% $f %%%";*/
}

unset ($_POST);
?>
		</td>
		</tr>		
	</table>
</body>
</html>
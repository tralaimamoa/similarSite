<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "­//W3C//DTD XHTML 1.0 Frameset//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1­frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<title>CHECK SIMILARITE SKU</title>
<meta charset='utf-8'/>
<head>
<link rel="stylesheet" type="text/css" href="AnalyseStyleForChrome.css" />
<link rel="stylesheet" type="text/css" href="AnalyseStyleForFirefox.css" />
<script language=javascript type="text/javascript" src="analyseJS.js"></script>
</head>
<body>
<input id='reduire' type='button' onclick="ouvrirFermerSpoiler();" value="Check similarité"/>
<a id='manuelle' href="README.pdf" target="_blank">MANUELLE D' UTILISATION</a>
<a id='giskard' href="http://10.10.10.53:8080/giskard/login" target="_blank">GISKARD</a>
<a class="changeUser "href="login.php">SE CONNECTER</a>
<img id="loader" src="images/load.gif"/>
<div id='box'>
	<form method="post" action='analyse.php'onsubmit="voirChargement();">
		<h1> CHECK SIMILARITE SKUS</h1>
	<div class='formulaire'>
			<div class='siteName'>
			SITE 1 : <input name="siteName1" type="text" >
			SITE 2 : <input name="siteName2" type="text" >
			</div>
			<fieldset class='option'>
			<legend> Options </legend>
			Résultat: <input class='champs' name="limit" type="number" style="width: 45px;text-align: right;">
			Limite 1 <input id= "limit1" class='champs' name="nbreOffreAnalyser1" type="number" style="width: 60px;text-align: right;">
			Limite 2 <input id= "limit2" class='champs' name="nbreOffreAnalyser2" type="number" style="width: 60px;text-align: right;">
			Vivant <input id= "vivant" class='champs' name="deleted" type="checkbox">
			</fieldset>
	<div class='field'>
		<fieldset class='site1'>
			<legend> Plateforme pour SITE 1  </legend>
			<table style='color:white'>		
				<tr><td class='check'>DE </td> <td class='check'><input type="checkbox" name="platform1[]" value="prde-wv4mys01.workit.fr,workit_de_v4"/> </td></tr>
				<tr><td class='check'>UK </td> <td class='check'><input type="checkbox" name="platform1[]" value="pruk-wv4mys00.workit.fr:3306,workit_uk_v4"/> </td></tr>
				<tr><td class='check'>IT </td> <td class='check'> <input type="checkbox" name="platform1[]" value="prit-wv4mys00.workit.fr:3306,workit_it_v4"> </td></tr>
				<tr><td class='check'>FR </td> <td class='check'><input type="checkbox" name="platform1[]" value="prfr-wv4mys00.workit.fr:3306,workit_bgb_v4"> </td></tr>
				<tr><td class='check'>II </td> <td class='check'> <input type="checkbox" name="platform1[]" value="prii-wv4mys01.workit.fr:3306,workit_ii_v4"> </td></tr>
				<tr><td class='check'>FA </td> <td class='check'> <input type="checkbox" name="platform1[]" value="prfa-wv4mys00.workit.fr:3306,workit_fashion_v4"> </td></tr>
				<tr><td class='check'>ADHOC </td> <td class='check'> <input type="checkbox" name="platform1[]" value="prad-wv4mys01.workit.fr:3306,workit_adhoc_v4"> </td></tr>				
			</table>
		</fieldset>	
		<fieldset class='site2'>
			<legend> Plateforme pour SITE 2 </legend>
			<table style='color:white'>		
				<tr><td class='check'>DE </td> <td class='check'><input type="checkbox" name="platform2[]" value="prde-wv4mys01.workit.fr,workit_de_v4"/> </td></tr>
				<tr><td class='check'>UK </td> <td class='check'><input type="checkbox" name="platform2[]" value="pruk-wv4mys00.workit.fr:3306,workit_uk_v4"/> </td></tr>
				<tr><td class='check'>IT </td> <td class='check'> <input type="checkbox" name="platform2[]" value="prit-wv4mys00.workit.fr:3306,workit_it_v4"> </td></tr>
				<tr><td class='check'>FR </td> <td class='check'><input type="checkbox" name="platform2[]" value="prfr-wv4mys00.workit.fr:3306,workit_bgb_v4"> </td></tr>
				<tr><td class='check'>II </td> <td class='check'> <input type="checkbox" name="platform2[]" value="prii-wv4mys01.workit.fr:3306,workit_ii_v4"> </td></tr>
				<tr><td class='check'>FA </td> <td class='check'> <input type="checkbox" name="platform2[]" value="prfa-wv4mys00.workit.fr:3306,workit_fashion_v4"> </td></tr>
				<tr><td class='check'>ADHOC </td> <td class='check'> <input type="checkbox" name="platform2[]" value="prad-wv4mys01.workit.fr:3306,workit_adhoc_v4"> </td></tr>
			</table>
		</fieldset>	
	</div>		
		<input class='ok' type="submit" name="submit" value="OK"/>
	</div>
</div>
	
	<?php
	error_reporting(0); 
	findSimilarity();
	?>
	
<?php
	function connectToBdd($user,$password,$host,$dbName){
		try {
			return new PDO('mysql:host=' . $host . ';dbname=' . $dbName . ';charset=utf8', $user, $password);
		}
		catch(Exception $e){
			//$error = $e->getMessage();
			?>
			<input class='error' type='button' value="<?php echo 'Accès refusé pour user [' . $user . '], Verifier svp votre login ou mot de passe !!! :)'?>"/>	
<?php			
		}
	}
	function getInformationFromBDD($user,$password,$host1,$host2,$dbName1,$dbName2,$siteName1,$siteName2,$limit,$nbreOffreAnalyser1,$nbreOffreAnalyser2,$supprimE){
		$sid1 = array();
		$sid2 = array();
		$bdd1 = connectToBdd($user,$password,$host1,$dbName1);
		$querySID1 = 'select id from sites where title=\''. $siteName1 .'\';';
		$reponseSID1 = $bdd1->query($querySID1);		
		while($sidA = $reponseSID1->fetch()){
			$sid1 = $sidA;
		}
		if(isNotBlank($supprimE)){
			$query1 = 'select distinct internalref, productpath,title,imagepath,deleted from site_products where deleted=false and sid=' . $sid1[0] . ' LIMIT ' . $nbreOffreAnalyser1 ;
		} else {
			$query1 = 'select distinct internalref, productpath,title,imagepath,deleted from site_products where sid=' . $sid1[0] . ' LIMIT ' . $nbreOffreAnalyser1 ;
		}	
		$reponse1 = $bdd1->query($query1);
		
		$bdd2 = connectToBdd($user,$password,$host2,$dbName2);
		$querySID2 = 'select id from sites where title=\''. $siteName2 .'\';';
			$reponseSID2 = $bdd2->query($querySID2);		
		while($sidB = $reponseSID2->fetch()){
			$sid2 = $sidB;
		}	
		if(isNotBlank($supprimE)){	
			$query2 = 'select distinct internalref, productpath,title,imagepath,deleted from site_products where deleted=false and sid=' . $sid2[0]  . ' LIMIT ' . $nbreOffreAnalyser2;	
		} else {
			$query2 = 'select distinct internalref, productpath,title,imagepath,deleted from site_products where sid=' . $sid2[0]  . ' LIMIT ' . $nbreOffreAnalyser2;
		}		
		$reponse2 = $bdd2->query($query2);
				
		$data1 = array();
		$data2 = array();
				
		while($donnees1 = $reponse1->fetch()){
				$data1[] = $donnees1;				
			}
		while($donnees2 = $reponse2->fetch()){
				$data2[] = $donnees2;					
			}
?>		 				
	<table id='dateResultSimilarity'>
	<thead'>
		<tr class='resultEntete'>
			<th class='resultEntete'></th>
			<th class='resultEntete'>SKU</th>
			<th class='resultEntete'>Image</th>
			<th class='resultEntete'></th>
			<th class='resultEntete'><?php echo $siteName1 . ' - SID: ' . $sid1[0]?> </th>
			<th class='resultEntete'>Image</th>
			<th class='resultEntete'></th>
			<th class='resultEntete'><?php echo $siteName2 . ' - SID: ' . $sid2[0]?></th>
		</tr>
	</thead>
	<tbody class='resultBody'>
<?php
	$nbreOffre = 0;
	$tab = "";
	for ($i = 0; $i < sizeOf($data1); $i++){		
		for ($j = 0; $j < sizeOf($data2); $j++){
			$skuData1 = $data1[$i][0];
			$skuData2 = $data2[$j][0];
			if (isNotBlank($skuData1) && isNotBlank($skuData2) && $skuData1 == $skuData2){
				$productPathData1 = $data1[$i][1];
				$productPathData2 = $data2[$j][1];
				if ($productPathData1 != $productPathData2){
						$nbreOffre++;
						if($nbreOffre <= $limit){
						$titleData1 = $data1[$i][2];
						$titleData2 = $data2[$j][2];
						$imagePath1 = $data1[$i][3];
						$imagePath2 = $data2[$j][3];
						$stat1 = $data1[$i][4];
						$stat2 = $data2[$j][4];
?>
		<tr>
			<td ><?php echo $nbreOffre;?></td>
			<td class='sku'><?php echo $skuData1;?>
			</td>		
			<td class='sourceCode'>
				<img id='image' src="<?php echo $imagePath1?>" onmouseover="zoom(this)" onmouseout="deZoomer(this)"/>				
			</td>
			<td class='etat'>
			<a href='<?php echo $productPathData1;?>' target="_blank">
			<?php 			
			if ($stat1 == 0){
				echo 'V';
			} else {
				echo 'S';
			}
			?>
			</a>
			</td>	
			<td><?php echo $titleData1;?></td>
			
			<td class='sourceCode'>
			 <img id='image' src="<?php echo $imagePath2?>" onmouseover="zoom(this)" onmouseout="deZoomer(this)"/>
			</td>
			<td class='etat'>
			<a href='<?php echo $productPathData2;?>' target="_blank">
			<?php
			if ($stat2 == 0){
				echo 'V';
			} else {
				echo 'S';
			}
			?>
			</a>
			</td>		
			<td><?php echo $titleData2;?></td>
		</tr>
<?php		
						} else {
							break;
						}
						
					}
				} 
			}			
		}
?>

	</tbody>
	</table> 
</form>
<?php			
			$reponse1->closeCursor();
			$reponse2->closeCursor();
}
	
	function findSimilarity()
	{
		// On prolonge la session
		session_start();
		// On teste si la variable de session existe et contient une valeur
		if(empty($_SESSION['login']) && empty($_SESSION['password'])) {
		  // Si inexistante ou nulle, on redirige vers le formulaire de login
		  header('Location: login.php');		  
		  exit();
		}
		$user = $_SESSION['login'];
		$password = $_SESSION['password'];
		if (isNotBlank($_POST['platform1']) && isNotBlank($_POST['platform2'])&& isNotBlank($_POST['siteName1']) && isNotBlank($_POST['siteName2']))
			{
				$platformChecked1 = $_POST['platform1'];
				$platformChecked2 = $_POST['platform2'];
				$host1 = '';
				$dbName1 = '';
				$value1 = explode(",",$platformChecked1[0]);
				$value2 = explode(",",$platformChecked2[0]); 
				
				$host1 = $value1[0];
				$dbName1 = $value1[1];
				$host2 = $value2[0];
				$dbName2 = $value2[1];
				$siteName1 = $_POST['siteName1'];
				$siteName2 = $_POST['siteName2'];
				$limit = $_POST['limit'];
				$nbreOffreAnalyser1 = $_POST['nbreOffreAnalyser1'];
				$nbreOffreAnalyser2 = $_POST['nbreOffreAnalyser2'];
				$supprimE = $_POST['deleted'];				
				echo getInformationFromBDD($user,$password,$host1,$host2,$dbName1,$dbName2,$siteName1,$siteName2,$limit,$nbreOffreAnalyser1,$nbreOffreAnalyser2,$supprimE);			
			}
	}
	function isNotBlank($objet){
		return isset($objet) &&  $objet!=null;
	}
	function contains($str,$strToFind){
		return strpos($str, $strToFind) !== FALSE;
	}
	?>
</body>
</html>
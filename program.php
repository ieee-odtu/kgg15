<!--
/*
Copyright (C) 2015  Baskın Burak Şenbaşlar

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 3
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/
-->
<!doctype html>
<html>
<head>
	<meta charset="utf8"/>
	<title>Kampüs Gelişim Günleri 2015</title>
	<link rel="stylesheet" href="inc/bootstrap/css/bootstrap.min.css">
	<script src="inc/jquery.js"></script>
	<script src="inc/bootstrap/js/bootstrap.min.js"></script>
	<script>
		$(document).ready(function(){
			window.setTimeout('location.reload()',10000);
		});
	</script>
	<!--<meta name="viewport" content="width=device-width"-->
</head>
<body>
<?php
function generateprogram($gun)
{
	include "db.php";
	$res=$conn->query("SELECT * FROM oturumlar WHERE zaman LIKE '$gun%'",PDO::FETCH_ASSOC);
	$oturumlar=array();	
	$butunZamanlar=array();
	$butunSalonlar=array();
	foreach($res as $ins)
	{
		$zaman=explode("_",$ins['zaman']);
		$zaman=$zaman[1]."-".$zaman[2];
		$ins['zaman']=$zaman;
		array_push($oturumlar,$ins);
		array_push($butunZamanlar,$ins['zaman']);
		array_push($butunSalonlar,$ins['salon']);
	}
	$butunZamanlar=array_keys(array_flip($butunZamanlar));
	$butunSalonlar=array_keys(array_flip($butunSalonlar));
	sort($butunZamanlar);
	sort($butunSalonlar);
	?>
		<div><h1 class="text-center">Kampüs Gelişim Günleri 2015 <?php echo $gun; ?> Mart Programı</h1></div>
		<div class=""><table class="table" style="width:80%;margin:0 auto;position:relative;top:50px;font-size:17px">
	<?php
		echo "<tr>";
		echo "<th>#</th>";
		for($i=0;$i<count($butunSalonlar);$i++)
		{
			if($butunSalonlar[$i]=='KK')
				echo "<th>Kemal Kurdaş Salonu</th>";
			else
				echo "<th>".$butunSalonlar[$i]." Salonu</th>";
		}	
		for($i=0;$i<count($butunZamanlar);$i++)
		{
			echo "<tr>";
			echo "<td>".$butunZamanlar[$i]."</td>";
			for($j=0;$j<count($butunSalonlar);$j++)
			{
				echo "<td>";
				for($k=0;$k<count($oturumlar);$k++)
				{
					if($oturumlar[$k]['salon']==$butunSalonlar[$j] && $oturumlar[$k]['zaman']==$butunZamanlar[$i])
					{
						echo "<span style=\"font-weight:bold\">".$oturumlar[$k]['oturum_isim']."</span> / ".$oturumlar[$k]['veren_isim'];
						break;
					}
				}
				echo "</td>";
			}
			echo "</tr>";
		}
	?>
		</table></div>
	<?php
}
?>
<?php
	if(isset($_GET['gun']) && !empty($_GET['gun']))
	{
		switch($_GET['gun'])
		{
			case '2':
			case '3':
			case '4':
				generateprogram($_GET['gun']);
				break;
			default:
				echo "bad boy.that is what you are.";
				die();
		}
	}
	else
	{
		?>
		<form action="program.php" method="get">
			<select type="text" name="gun">
				<option value="2">2 Mart</option>
				<option value="3">3 Mart</option>
				<option value="4">4 Mart</option>
			</select>
			<input type="submit" value="Ayarla"/>
		</form>
		<?php
	}
?>
</body>
</html>

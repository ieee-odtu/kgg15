<?php
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
	session_start();
	if(@$_SESSION['auth']!='kapi' && @$_SESSION['auth']!='admin')die();
?>
<!doctype html>
<html>
<head>
<meta charset="utf8"/>
<title>Kampüs Gelişim Günleri 2015</title>
<style>
body
{
	background-color:white;
	background-image:url(img/agac.png);
	background-size:60%;
	background-repeat:no-repeat;
	background-position:right 50px;
}
</style>
</head>
<body>
<h1 style="color:black;font-family:Helvetica,sans-serif;margin:20px">Kampüs Gelişim Günleri 2015</h1>
<?php
	if(isset($_GET['salon']))
	{
		switch($_GET['salon'])
		{
			case 'A':
			case 'B':
			case 'D':
			case 'E':
			case 'F':
			case 'G':
			case 'H':
			case 'KK':
				processHall($_GET['salon']);
				break;
			default:
				echo "are you trying to fuck me?";
				break;
		}
	}
	else
	{
		?>
			<form action="kapi.php" method="get">
				<div style="width:600px;position:relative;top:150px">
				<select style="display:block;margin:0 auto;-moz-appearance: none;border:none;color:black;font-weight:bold;height:auto;width:400px;text-align:center;font-size:30px;padding:20px;margin-bottom:5px" name="salon">
					<option value="KK">Kemal Kurdaş Salonu</option>
					<option value="A">A Salonu</option>
					<option value="B">B Salonu</option>
					<option value="D">D Salonu</option>
					<option value="E">E Salonu</option>
					<option value="F">F Salonu</option>
					<option value="G">G Salonu</option>
					<option value="H">H Salonu</option>
				</select>
				<select style="display:block;margin:0 auto;-moz-appearance: none;border:none;color:black;font-weight:bold;height:auto;width:400px;text-align:center;font-size:30px;padding:20px;margin-bottom:5px" name="gun">
					<option value="2">2 Mart</option>
					<option value="3">3 Mart</option>
					<option value="4">4 Mart</option>				
				</select>
				<input style="border-radius:5px;width:300px;height:50px;background-color:rgba(12,34,56,0.5);border:none;color:white;font-weight:bold;display:block;margin:0 auto;" type="submit" value="Ayarla"/></div>
			</form>
		<?php
	}
?>
<?php
function processHall($salon)
{
	include "db.php";
	if((string)(int)$_GET['gun'] != $_GET['gun'])die();
	$gun=$_GET['gun']."_";
	$res=$conn->query("SELECT * FROM oturumlar WHERE salon='$salon' AND zaman LIKE '$gun%'",PDO::FETCH_ASSOC);
	//echo $res->rowCount();
	?>
	<form action="kapi.php?salon=<?php echo $salon; ?>&gun=<?php echo (int)$gun; ?>" method="post">
		<div style="width:900px">
		<select style="overflow:scroll;display:block;margin:0 auto;-moz-appearance: none;border:none;background:transparent;color:black;font-weight:bold;height:auto;width:900px;text-align:center;font-size:18px;padding:20px" name="oturumid">
		<?php
			foreach($res as $ins)
			{
				
				$zmn=explode('_',$ins['zaman']);
				echo "<option id=\"".$ins['id']."\" value=\"".$ins['id']."\">";
				echo $zmn[1]."-".$zmn[2]." ".$ins['oturum_isim']." / ".$ins['veren_isim'];
				echo "</option>";
			}
		?>
		</select>
		<input id="asdqwe" style="display:block;margin:0 auto;" autocomplete="off" type="text" name="katilimciid"/>
		<input type="hidden" name="check" value="adamkatiliyor"/></div>
	<!--	<input type="submit" value="ekle"/> -->
	</form>
<div style="position:relative;top:100px;margin:30px">
<p style="color:black;font-size:30px">
<?php
	if(isset($_POST['check']) && $_POST['check']=="adamkatiliyor")
	{
		include "db.php";
		$res=$conn->query("select isim from katilimcilar where id=".(int)$_POST['katilimciid'],PDO::FETCH_ASSOC);
		if($res->rowCount()==1)
		{
			$conn->query("insert into katilimci_oturum (katilimciid,oturumid) values (".(int)$_POST['katilimciid'].",".(int)$_POST['oturumid'].")");
			foreach($res as $ins)
			{
				echo "Hoşgeldiniz,<br/><span style=\"font-size:50px\">";
				echo $ins['isim']."</span>";
			}
		}
		else
		{
			echo "bi sıkıntı var.";
		}
	}
?>
<?php
}
?>
</p>
</div>
<script src="inc/jquery.js"></script>
<script>
$(document).ready(function(){
	$("#<?php echo $_POST['oturumid']; ?>").attr("selected","selected");
	$("#asdqwe").focus();
});
</script>
</body>
</html>

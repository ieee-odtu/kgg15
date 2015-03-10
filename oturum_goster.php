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
	include "db.php";
?>
<!doctype html>
<html>
<head>
	<meta charset="utf8"/>
	<title>Kampüs Gelişim Günleri 2015</title>
	<link rel="stylesheet" href="inc/bootstrap/css/bootstrap.min.css">
	<script src="inc/jquery.js"></script>
	<script src="inc/bootstrap/js/bootstrap.min.js"></script>
	<style>
		.iki_oturum{
			background-color:#00aa72;
			color:white;
		}
		.bir_oturum{
			background-color:#a4295b;
			color:white;
		}
		.conflict{
			background-color:black;
			color:white;
		}
	</style>
	<!--<meta name="viewport" content="width=device-width"-->
</head>
<body>
<?php
$ikilikOturumlar=array(57,38,5,39,12,14,62,44,56,59,21,42,45,63,25,32,48,34,47);
function generateprogram($gun,$adaminID)
{
	global $conn;
	//echo "<div style=\"width:15%;margin-right:18%;display:inline-block\">";
	global $ikilikOturumlar;
	$res=$conn->query("SELECT * FROM oturumlar WHERE zaman LIKE '$gun%'",PDO::FETCH_ASSOC);
	$oturumlar=array();	
	$butunZamanlar=array();
	$butunSalonlar=array();
	$adaminOturumlar=$conn->query("SELECT katilimci_oturum.oturumid,oturumlar.zaman FROM katilimci_oturum INNER JOIN oturumlar ON katilimci_oturum.oturumid=oturumlar.id WHERE katilimci_oturum.katilimciid=".$adaminID,PDO::FETCH_ASSOC)->fetchAll();
	$l=array();
	$zamanlar=array();
	$adaminIsim=$conn->query("SELECT isim FROM katilimcilar WHERE id=".$adaminID,PDO::FETCH_NUM)->fetch()[0];
	foreach($adaminOturumlar as $ins)
	{
		array_push($l,$ins['oturumid']);
		if(key_exists($ins['zaman'],$zamanlar))
			$zamanlar[$ins['zaman']]++;
		else
			$zamanlar[$ins['zaman']]=1;
	}
	$adaminOturumlar=$l;
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
		<div style="margin-top:100px"><h1 class="text-center"><?php echo $gun; ?> Mart Günü Girdiğiniz Oturumlar ve Değerleri</h1></div>
		<div style="margin-bottom:50px" class=""><table class="table" style="width:80%;margin:0 auto;position:relative;top:50px;font-size:17px">
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
				$done=false;
				for($k=0;$k<count($oturumlar);$k++)
				{
					if($oturumlar[$k]['salon']==$butunSalonlar[$j] && $oturumlar[$k]['zaman']==$butunZamanlar[$i])
					{
						if(in_array($oturumlar[$k]['id'],$adaminOturumlar))
						{
							$hop=explode("-",$oturumlar[$k]['zaman']);
							if($zamanlar[$gun.'_'.$hop[0]."_".$hop[1]]==1)
							{
								if(in_array($oturumlar[$k]['id'],$ikilikOturumlar))
									echo "<td class=\"iki_oturum\"><span \"style=\"font-weight:bold\">".$oturumlar[$k]['oturum_isim']."</span> / ".$oturumlar[$k]['veren_isim'];
								else
									echo "<td class=\"bir_oturum\"><span \"style=\"font-weight:bold\">".$oturumlar[$k]['oturum_isim']."</span> / ".$oturumlar[$k]['veren_isim'];
							}
							else
							{
								echo "<td class=\"conflict\"><span \"style=\"font-weight:bold\">".$oturumlar[$k]['oturum_isim']."</span> / ".$oturumlar[$k]['veren_isim'];
							}
						}
						else
						{
							echo "<td><span style=\"font-weight:bold\">".$oturumlar[$k]['oturum_isim']."</span> / ".$oturumlar[$k]['veren_isim'];
						}
						$done=true;
						break;
					}
				}
				if(!$done) echo "<td>";
				echo "</td>";
			}
			echo "</tr>";
		}
	?>
		</table></div>
	<?php
	//echo "</div>";
}
?>
<?php
	if(isset($_GET['id']) && $_GET['id']==(string)(int)$_GET['id'] /*&& isset($_GET['isim'])*/)
	{
		$q=$conn->prepare("SELECT id from katilimcilar WHERE id=:id");
		$r=$q->execute($_GET);
		if($q->rowCount()==1)
		{
				?>
				<div style="margin:20px;text-align:center;margin-bottom:40px">
	<div style="text-align:center;display:inline-block;margin-right:20px"><div style="width:15px;height:15px;background-color:#a4295b;display:inline-block;margin-right:5px"></div>Bir oturum değerindeki oturumlar</div>
	<div style="text-align:center;display:inline-block;margin-right:20px"><div style="width:15px;height:15px;background-color:#00aa72;display:inline-block;margin-right:10px"></div>İki oturum değerindeki oturumlar</div>
	<div style="text-align:center;display:inline-block"><div style="width:15px;height:15px;background-color:black;display:inline-block;margin-right:10px"></div>Çakışma var.Lütfen stanta uğrayınız.</div>
</div>
				<?php
			$isim=$conn->query("SELECT isim from katilimcilar where id=".$_GET['id'],PDO::FETCH_NUM)->fetch()[0];
			echo "<h1 style=\"text-align:center;font-size:100px;\">".$isim."</h1>";
			generateprogram('2',$_GET['id']);
			generateprogram('3',$_GET['id']);
			generateprogram('4',$_GET['id']);
		}
		else
		{
			echo "<h3 style=\"text-align:center;\">"."Eşleşmeyen barkod numarası ve isim girdiniz."."</h3>";
		}
	}
	else
	{
		?>
		<h1 style="text-align:center">Kampüs Gelişim Günleri 2015 Oturum Sorgulama Sayfası</h1>
		<div style="margin:0 auto;width:300px">
			<form class="form" action="oturum_goster_publish.php" method="get">
			<div class="form-group">
				Barkod: <input class="form-control" style="margin-bottom:3px" type="text" name="id" placeholder="Kartınızın üzerinde yazan numara"/></div>
				<input class="btn btn-info" type="submit" value="Sorgula"/>
				
			</form>
		</div>
		<?php
	}
?>
</body>
</html>

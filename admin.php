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
	if(@$_SESSION['auth']!="admin")die();
	//$_SESSION['auth']="admin";
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="inc/bootstrap/css/bootstrap.min.css">
	<script src="inc/jquery.js"></script>
	<script src="inc/bootstrap/js/bootstrap.min.js"></script>
	<title>Kampüs Gelişim Günleri 2015</title>
</head>
<body>
	<div class="container">
		<?php
			include "db.php";
		?>
		<div class="row">
			<div class="col-md-4">
				<h1 class="page-header">İşlemler</h1>
				<div style="border-bottom:1px solid;padding-bottom:10px">
					<form action="admin.php?work_query" method="post">
						Kuruma göre listele:
						<?php
							$res=$conn->query("select distinct kurum from katilimcilar");
							if($res->rowCount())
							{
								echo "<select name=\"kurum\">";
								foreach($res as $ins)
								{
									echo "<option>".$ins["kurum"]."</option>";
								}
								echo "</select>";
							}
						?>
						<input type="submit" value="sorgula"/>
					</form>
				</div>
				<div style="border-bottom:1px solid;padding-bottom:10px">
					<form action="do_stuff.php" method="post">
						Oturum ekle:<br/>
						Oturum ismi:
						<input type="text" name="oturum_isim"/><br/>
						Veren kişi:
						<input type="text" name="veren_isim"/><br/>
						Veren unvan:
						<input type="text" name="veren_unvan"/><br/>
						Salon:
						<select name="salon">
							<option value=""></option>
							<option value="KK">Kemal Kurdaş</option>
							<option value="A">A Salonu</option>
							<option value="B">B Salonu</option>
							<option value="D">D Salonu</option>
							<option value="E">E Salonu</option>
							<option value="F">F Salonu</option>
							<option value="G">G Salonu</option>
							<option value="H">H Salonu</option>
						</select><br/>
						<select name="zaman">
							<option value="2_11:00_11:30">2 Mart 11:00-11:30</option>
							<option value="2_11:40_12:30">2 Mart 11:40-12:30</option>
							<option value="2_12:40_13:30">2 Mart 12:40-13:30</option>
							<option value="2_13:40_14:30">2 Mart 13:40-14:30</option>
							<option value="2_14:40_15:30">2 Mart 14:40-15:30</option>
							<option value="2_15:40_16:30">2 Mart 15:40-16:30</option>
							<option value="2_16:40_17:30">2 Mart 16:40-17:30</option>
							<option value="2_18:00_20:00">2 Mart 18:00-20:00</option>


							<option value="3_11:40_12:30">3 Mart 11:40-12:30</option>
							<option value="3_12:40_13:30">3 Mart 12:40-13:30</option>
							<option value="3_13:40_14:30">3 Mart 13:40-14:30</option>
														<option value="3_14:40_15:30">3 Mart 14:40-15:30</option>
							<option value="3_15:40_16:30">3 Mart 15:40-16:30</option>
							<option value="3_16:40_17:30">3 Mart 16:40-17:30</option>
							<option value="3_18:00_20:00">3 Mart 18:00-20:00</option>

							<option value="4_10:40_11:30">4 Mart 10:40-11:30</option>
							<option value="4_11:40_12:30">4 Mart 11:40-12:30</option>
							<option value="4_12:40_13:30">4 Mart 12:40-13:30</option>
							<option value="4_13:40_14:30">4 Mart 13:40-14:30</option>
							<option value="4_14:40_15:30">4 Mart 14:40-15:30</option>
							<option value="4_15:40_16:30">4 Mart 15:40-16:30</option>
							<option value="4_16:40_17:30">4 Mart 16:40-17:30</option>
							<option value="4_18:00_20:00">4 Mart 18:00-20:00</option>
						</select>
						<input type="hidden" name="job" value="add_session"/>
						<input type="submit" value="ekle"/>
					</form>
				</div>

				<div style="border-bottom:1px solid;padding-bottom:10px">
					Oturum düzenle:<br/>
					<form action="do_stuff.php" method="post">
						<select name="oturumid" style="display:block;width:300px">
							<?php
							$query=$conn->prepare("select id,oturum_isim,veren_isim,salon,zaman from oturumlar");
							$query->execute();
							$res=$query->fetchAll(PDO::FETCH_ASSOC);
							foreach($res as $ins)
							{
								$zmn=explode('_',$ins['zaman']);
								echo "<option value=".$ins['id'].">".$ins['oturum_isim']."/".$ins['veren_isim']."/"."Salon:".$ins['salon']."/ Zaman:".$zmn[0]." Mart ".$zmn[1]."-".$zmn[2]."</option>";
							}
							?>
						</select>
						Yeni oturum isim:
						<input type="text" name="oturum_isim"/><br/>
						Yeni veren isim:
						<input type="text" name="veren_isim"/><br/>
						Yeni veren unvan:
						<input type="text" name="veren_unvan"/><br/>
						Yeni salon:
						<select name="salon">
							<option value=""></option>
							<option value="KK">Kemal Kurdaş</option>
							<option value="A">A Salonu</option>
							<option value="B">B Salonu</option>
							<option value="D">D Salonu</option>
							<option value="E">E Salonu</option>
							<option value="F">F Salonu</option>
							<option value="G">G Salonu</option>
							<option value="H">H Salonu</option>
						</select><br/>
						Yeni zaman:
						<select name="zaman">
							<option value=""></option>
							<option value="2_11:00_11:30">2 Mart 11:00-11:30</option>
							<option value="2_11:40_12:30">2 Mart 11:40-12:30</option>
							<option value="2_12:40_13:30">2 Mart 12:40-13:30</option>
							<option value="2_13:40_14:30">2 Mart 13:40-14:30</option>
							<option value="2_14:40_15:30">2 Mart 14:40-15:30</option>
							<option value="2_15:40_16:30">2 Mart 15:40-16:30</option>
							<option value="2_16:40_17:30">2 Mart 16:40-17:30</option>
							<option value="2_18:00_20:00">2 Mart 18:00-20:00</option>

							<option value="3_11:40_12:30">3 Mart 11:40-12:30</option>
							<option value="3_12:40_13:30">3 Mart 12:40-13:30</option>
							<option value="3_13:40_14:30">3 Mart 13:40-14:30</option>
							<option value="3_14:40_15:30">3 Mart 14:40-15:30</option>
							<option value="3_15:40_16:30">3 Mart 15:40-16:30</option>
							<option value="3_16:40_17:30">3 Mart 16:40-17:30</option>
							<option value="3_18:00_20:00">3 Mart 18:00-20:00</option>

							<option value="4_10:40_11:30">4 Mart 10:40-11:30</option>
							<option value="4_11:40_12:30">4 Mart 11:40-12:30</option>
							<option value="4_12:40_13:30">4 Mart 12:40-13:30</option>
							<option value="4_13:40_14:30">4 Mart 13:40-14:30</option>
							<option value="4_14:40_15:30">4 Mart 14:40-15:30</option>
							<option value="4_15:40_16:30">4 Mart 15:40-16:30</option>
							<option value="4_16:40_17:30">4 Mart 16:40-17:30</option>
							<option value="4_18:00_20:00">4 Mart 18:00-20:00</option>
						</select>
						<input type="hidden" name="job" value="change_session"/>
						<input type="submit" value="değiş"/>
					</form>
				</div>
			
				<div style="border-bottom:1px solid;padding-bottom:10px">
					Duyuru ekle:<br/>
					<form action="do_stuff.php" method="post">
						<textarea name="duyuru" rows="3" cols="40"></textarea>
						<input type="hidden" name="job" value="add_announcement"/>
						<input type="submit" value="ekle"/>
					</form>
				</div>
				<div style="border-bottom:1px solid;padding-bottom:10px">
					Duyuru sil:<br/>
					<form action="do_stuff.php" method="post">
						<select name="duyuruid">
						<?php
							$r=$conn->query("select * from duyurular");
							foreach($r as $ins)
							{
								$s=mb_substr($ins['metin'],0,40);
								if(strlen($s)>38)$s=$s."...";
								echo "<option value=\"".$ins['id']."\">".$s."</option>";
							}
						?>
						</select>
						<input type="hidden" name="job" value="delete_announcement"/>
						<input type="submit" value="sil"/>
					</form>
				</div>
		
				<div style="border-bottom:1px solid;padding-bottom:10px">
					Duyuru düzenle:<br/>
					<form action="do_stuff.php" method="post">
						<select name="duyuruid">
						<?php
							$r=$conn->query("select * from duyurular");
							foreach($r as $ins)
							{
								$s=mb_substr($ins['metin'],0,40);
								if(strlen($s)>38)$s=$s."...";
								echo "<option value=\"".$ins['id']."\">".$s."</option>";
							}
						?>
						</select>
						<br/>Yeni Hal:<br/>
						<textarea name="duyuru" rows="3" cols="40"></textarea>
						<input type="hidden" name="job" value="edit_announcement"/>
						<input type="submit" value="düzenle"/>
					</form>
				</div>

			</div>
			<div class="col-md-8">
				<h1 class="page-header">Sonuç</h1>
				<?php
					if(isset($_GET['announcement_edited']))
					{
						echo "Duyuru düzenlendi<br/>";
					}
					if(isset($_GET['announcement_deleted']))
					{
						echo "Duyuru silindi <br/>";
					}
					if(isset($_GET['announcement_added']))
					{
						echo "Duyuru eklendi<br/>";
					}
					if(isset($_GET['announcement_empty']))
					{
						echo "Duyuru girmeyi unuttun pampa<br/>";
					}
					if(isset($_GET['add_op_successful']))
					{
						echo "Ekleme başarılı<br/>";
					}
					if(isset($_GET['empty_fields']))
					{
						echo "BAŞARISIZ.Boş alan var.GERİ DÖN.<br/>";
					}
					if(isset($_GET['session_changed']))
					{
						echo "Değişim başarılı!";
					}
					if(isset($_GET['work_query']))
					{
						$query=$conn->prepare("select isim from katilimcilar where kurum=?");
						//echo $_POST['kurum'];
						$query->execute(array($_POST['kurum']));
						$res=$query->fetchAll(PDO::FETCH_ASSOC);
						//print_r($res);
						if(count($res))
						{
							print "<span style=\"color:red;font-weight:bold\">Kurum: ";
							print "</span>".$_POST['kurum']."<br/>";
							print "<span style=\"color:red;font-weight:bold\">Toplam Kişi Sayısı: ";
							echo "</span>".count($res)."<br/>"."<br/>";
							foreach($res as $ins)
							{
								echo $ins['isim']."<br/>";
							}
						}
					}
				?>
			</div>


		</div>
	</div>
</body>
</html>

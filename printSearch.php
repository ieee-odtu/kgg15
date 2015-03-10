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
	if($_SESSION['auth']!='admin' && $_SESSION['auth']!='yenikayit')die();
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
<?php
	if(isset($_GET['id']) && !empty($_GET['id']))
	{
		$_GET['id']=(string)(int)$_GET['id'];
		if($_GET['id']!='0')
		{
			include "db.php";
			$conn->query("insert into print_queue (id) VALUES (".$_GET['id'].")");
			header("LOCATION:printSearch.php?bastirmabasarili");
		}
	}

?>
	<div class="container">
		<div class="row">
		
		<?php
		if(isset($_GET['aramayap']))
		{
			echo "<div class=\"col-md-8\" style=\"margin-top:30px\">";
			if(empty($_POST['isim']) && empty($_POST['kurum']) && empty($_POST['bolum']) && empty($_POST['sinif']) && empty($_POST['email']))
			{
				echo "haci hic bisey girmezsen olmuyo beya";die();
			}
			include "db.php";
			$q=$conn->prepare("select * from katilimcilar where isim like ? and kurum like ? and bolum like ? and sinif like ? and email like ?");
			$q->execute(array("%$_POST[isim]%","%$_POST[kurum]%","%$_POST[bolum]%","%$_POST[sinif]%","%$_POST[email]%"));
			if($q->rowCount()>0)
			{
				echo "<form action=\"printSearch.php\" method=\"get\">";
			}
			else
			{
				header("LOCATION:printSearch.php?notfound");
			}
			foreach($q as $ins)
			{
				echo "<div class=\"radio\"><input type=\"radio\" name=\"id\" value=\"".$ins['id']."\"/>".$ins['isim']."/".$ins['kurum']."/".$ins['bolum']."/".$ins['sinif']."/".$ins['email']."</div>";
			//	print_r($ins);
			}
			if($q->rowCount()>0)
			{
				echo "<button type=\"submit\" class=\"btn btn-info\">Yazdır</button>";
				echo "</form>";
			}
			echo "</div>";
		}
		else
		{
		?>
			
			<div class="col-md-4" style="margin-top:30px">
				<?php
					if(isset($_GET['notfound']))
					{
						echo "<p style=\"color:red;font-weight:bold\">Arama kriterlerine uygun katılımcı bulunamadı.</p>";
					}
					if(isset($_GET['bastirmabasarili']))
					{
						echo "<p style=\"color:green;font-weight:bold\">Yazıcıya gönderildi!</p>";
					}
				?>
				<h5>Alanları boş bırakabilirsiniz.</h5>
				<h5>Doldurduğunuz alanların birebir örtüşmesi gerekmiyor.Mesela "Peter Griffin" gibi bir adamı aramak için sadece "peter" yazabilirsiniz.</h5>
				<form action="printSearch.php?aramayap" method="post">
					<div class="form-group"><label>İsim:</label> <input type="text" class="form-control" name="isim"/></div>
					<div class="form-group"><label>Kurum:</label> <input type="text" class="form-control" name="kurum"/></div>
					<div class="form-group"><label>Bölüm:</label> <input type="text" class="form-control" name="bolum"/></div>
					<div class="form-group"><label>Sınıf:</label> <input type="text" class="form-control" name="sinif"/></div>
					<div class="form-group"><label>Email:</label> <input type="text" class="form-control" name="email"/></div>
					<button type="submit" class="btn btn-info"/>Ara</button>
				</form>
			</div>
		<?php
		}
		?>
		</div>
	</div>
</body>
</html>

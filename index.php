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
	if(@$_SESSION['auth']!="yenikayit" && @$_SESSION['auth']!='admin')die();
?>
<!doctype html>
<html>
<head>
	
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="inc/bootstrap/css/bootstrap.min.css">
	<script src="inc/jquery.js"></script>
	<script src="inc/bootstrap/js/bootstrap.min.js"></script>
	<title>Kampüs Gelişim Günleri 2015</title>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#danscieleman").hide();
			window.setTimeout(function(){$(".durum_bilgisi").hide();},3000);
			window.setTimeout(function(){$("#danscieleman").show();},30000);
			$(".troll").hide();
		/*	var count=5;
			var cur=Math.floor(Math.random()*5);
			window.setInterval(function(){
				c="#"+cur.toString();
				$(c).hide();				
				cur=cur+1;
				cur=cur%count;
				c="#"+cur.toString();
				$(c).fadeIn();
			},30000);*/
		});
	</script>
</head>
<body>
<img src="troll/pikacu.jpg" width="100" style="position:absolute;float:left"/>
	<div class="container">
		
					<div class="row" style="margin-top:30px">
						<div class="col-md-4">
							<?php
								if(isset($_GET['eklemebasarili']))
								{
							?>
									<blockquote class="durum_bilgisi">
									<img width="25"src="img/happy.jpg"/>
										Ekleme başarılı!
									</blockquote>
							<?php
								}
							?>
							
							<?php
								if(isset($_GET['bosalanvar']))
								{
							?>
									<blockquote class="durum_bilgisi">
									<img width="25"src="img/sad.png"/>
										Boş alan var! Geri dön.
									</blockquote>
							<?php
								}
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<form method="post" action="do_stuff.php">
								<h1>Katılımcı Ekle</h1>
								<p>Bölüm ve sınıf bilgilerini üniversitesi öğrencisi olmayanlar için boş bırakabilirsiniz.</p>
								<div class="form-group">
									<label>İsim soyisim</label>  <input type="text" class="form-control" name="isim"/>
								</div>
								<div class="form-group">
									<label>Kurum</label> <input type="text" class="form-control" name="kurum" value="ODTÜ"/>
								</div>
								<div class="form-group" style="width:70%;display:inline-block">									
									<label>Bölüm</label> <input type="text" class="form-control" name="bolum"/>
								</div>								
								<div class="form-group" style="width:28%;display:inline-block">								
									<label>Sınıf</label> 
									<input type="text" class="form-control" name="sinif" value="Hazırlık"/>
								</div>								
								<div class="form-group">									
									<label>Email</label> <input type="email" class="form-control" name="email"/>
								</div>								
								<input type="hidden" name="job" value="add_participant"/>
								<input type="submit" class="btn btn-success" value="ekle"/>
							</form>
						</div>
						<div class="col-md-4">
							<h1>Siz yetkili bi abiye benziyosunuz</h1>
							
							<h3>Sistem Arızası Durumunda</h3>
Baskın Burak Şenbaşlar - 0534 xxx xx xx<br/>
Kadir Çetinkaya - 0506 xxx xx xx<br/>

<h2>Diğer bütün durumlarda</h2>
Selin Akpınar - 0538 xxx xx xx - Etkinlik Koordinatörü<br/>
Merve Çiftdoğan - 0553 xxx xx xx - Etkinlik Koordinatörü<br/>
Çağrı Yalçın - 0506 xxx xx xx - Başkan<br/>
Furkan Güllü - 0506 xxx xx xx - YK<br/>
Uzay Kaş - 0534 xxx xx xx - YK<br/>
Akın Can Genç - 0531 xxx xx xx - YK<br/>
Baskın Burak Şenbaşlar - 0534 xxx xx xx - YK<br/>
						</div>
						<div class="col-md-4">
							<h1>ÖNEMLİ! OKUYUN!</h1>
							<p>İnsanların isimlerini girerken bütün isimlerin ve soyisimlerin ilk harfleri büyük gerisi küçük olacak şekilde girin.Örneğin : "Peter Griffin"."Peter GRIFFIN" veya "peter griffin" şeklinde girmeyin</p>
							<h4>Kartlarını bugün getirmeyi unutmuş olanlar için de internet kaydı alıyormuş gibi arayıp ordan basın.</h4>
							<img id="danscieleman" src="troll/giphy.gif"/>	
							<img class="troll" id="0" style="" src="troll/1.jpg"/>
							<img class="troll" id="1" style="" src="troll/2.jpg"/>
							<img class="troll" id="2" style="" src="troll/3.jpg"/>
							<img class="troll" id="3" style="" src="troll/4.jpg"/>
							<img class="troll" id="4" style="" src="troll/5.jpg"/>
						</div>
					</div>

	</div>
</body>
</html>

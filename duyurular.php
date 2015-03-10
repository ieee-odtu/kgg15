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
	<style>
		.duyuru
		{
			font-size:30px;
			margin-bottom:10px;
		}
		@media (max-width: 600px) {
   		 .duyuru {
        font-size: 15px;
   		 }
}
	</style>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12" style="text-align:center;margin-bottom:20px;">
				<h1>Kampüs Gelişim Günleri 2015 Duyurular</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php
					include "db.php";
					$currenttime=date('H:i:s');
					$t=explode(":",$currenttime);
					$currenttime=new DateTime(date('Y-m-d H:i:s'));
					$currenttime=$currenttime->getTimestamp();
					//echo $currenttime;
					$q=$conn->query("select metin,timestamp from duyurular",PDO::FETCH_ASSOC);
					$duyurular=array();
					foreach($q as $ins)
					{
						array_push($duyurular,$ins);
					}
					$duyurular=array_reverse($duyurular);
					foreach($duyurular as $ins)
					{
						$t=explode(":",explode(" ",$ins['timestamp'])[1]);
						$duyuruTime=new DateTime($ins['timestamp']);
						$duyuruTime=$duyuruTime->getTimestamp();
						echo "<div class=\"duyuru\">";
						echo "<span style=\"display:inline-block;background-color:#27C2D3;padding:5px;color:white\">";
						if(($currenttime-$duyuruTime)<1800)
							echo "<img style=\"\" src=\"img/new.gif\"/>";
						echo "<span style=\"display:inline-block;margin-right:1px;padding:5px;padding-right:7px;background-color:#27C2D3;border-right:1px solid white;color:#ffff00\">".$t[0].":".$t[1]."</span> ".$ins['metin']."</span>";
						echo "</div>";
					}
				?>				
			</div>
		</div>
	</div>
<script>
	$(document).ready(function(){
		window.setTimeout("location.reload()",15000);
	});
</script>
</body>
</html>

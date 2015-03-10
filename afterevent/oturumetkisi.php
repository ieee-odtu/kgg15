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
?>
<meta charset="utf-8"/>
<?php
	include "../db.php";
	$max=$conn->query("select max(id) from oturumlar")->fetch()[0];
	$counts=array();
	for($i=1;$i<=$max;$i++)
	{
		$count=$conn->query("select oturumlar.oturum_isim,count(*) from katilimci_oturum inner join oturumlar on oturumlar.id=oturumid where oturumid=".(string)$i,PDO::FETCH_NUM)->fetch();
		if($count[0]==NULL)continue;
		array_push($counts,array($count[0],$count[1]));
	}
	function invenDescSort($item1,$item2)
	{
		if ($item1[1] == $item2[1]) return 0;
		return ($item1[1] < $item2[1]) ? 1 : -1;
	}
	usort($counts,'invenDescSort');
	$total=0;
	foreach($counts as $i)
	{
		echo $i[1]." ".$i[0]."<br/>";
		$total+=$i[1];
	}
	echo "<br/>".$total;
?>

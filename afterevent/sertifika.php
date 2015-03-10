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
	$ikilikOturumlar=array(57,38,5,39,12,14,62,44,56,59,21,42,45,63,25,32,48,34,47);
	include "../db.php";
	$max=(int)($conn->query("select max(id) from katilimcilar")->fetch()[0]);
	
	$counts=array();
	for($i=1;$i<=$max;$i++)
	{
		$opt=$conn->query("select zaman from oturumlar inner join katilimci_oturum on katilimci_oturum.oturumid=oturumlar.id where katilimci_oturum.katilimciid=".$i,PDO::FETCH_NUM)->fetchAll();
		$success=true;
		$inArr=array();
		$puan=0;
		$isim=$conn->query("select isim,id from katilimcilar where id=".(string)$i,PDO::FETCH_NUM)->fetch();
		$id=$isim[1];
		$isim=$isim[0];
		$oturumlar=$conn->query("select oturumlar.id,oturumlar.oturum_isim from katilimci_oturum inner join oturumlar on katilimci_oturum.oturumid=oturumlar.id where katilimci_oturum.katilimciid=".(string)$i,PDO::FETCH_ASSOC)->fetchAll();
		foreach($oturumlar as $oturum){
			if(in_array($oturum['id'],$ikilikOturumlar))
				$puan+=2;
			else
				$puan++;
		}
		array_push($inArr,$isim);
		array_push($inArr,$puan);
		array_push($inArr,$oturumlar);
		array_push($inArr,$id);
		array_push($counts,$inArr);
	}
	function invenDescSort($item1,$item2)
	{
		if ($item1[1] == $item2[1]) return 0;
		return ($item1[1] < $item2[1]) ? 1 : -1;
	}
	usort($counts,'invenDescSort');
	//print_r($counts);
	$totalSetifika=0;
	$sertifikaAlanlar=array();
	foreach($counts as $i)
	{
		$flag=false;
		echo $i[0]."<br/>".$i[3]."</br>";
		if($i[1]>=14)
		{
			$opt=$conn->query("select zaman from oturumlar inner join katilimci_oturum on katilimci_oturum.oturumid=oturumlar.id where katilimci_oturum.katilimciid=".(string)$i[3],PDO::FETCH_NUM)->fetchAll();
		
			/* conflict detect */
			for($k=0;$k<count($opt);$k++)
			{
				for($j=$k+1;$j<count($opt);$j++)
				{
					if($opt[$k][0]==$opt[$j][0])
					{
						echo "Çakışma<br/><br/>";$flag=true;break;
					}
				}
				if($flag==true)break;
			}
			if($flag==true)continue;
			array_push($sertifikaAlanlar,$i[3]);
			$totalSetifika++;
		}
		
		foreach($i[2] as $oturum)
		{
			echo $oturum['oturum_isim']."<br/>";
		}
		echo $i[1];
		echo "<br/><br/>";
	}
	echo $totalSetifika;
?>

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
	$res=$conn->query("select * from print_queue",PDO::FETCH_ASSOC);
	$last="";	
	foreach($res as $ins)
	{
		if(!file_exists("barcode-images/".$ins['id'].".png"))
		{
			$barcode=imagecreatefromjpeg("http://localhost/kgg/draw.php?barcode=".$ins['id']);
			
			$res=$conn->query("select isim from katilimcilar where id=".$ins['id'],PDO::FETCH_ASSOC);
			$res=$res->fetch();
		
			$image_width=300;
			$image_height=50;
			$fontsize=20;
			$text_box=imagettfbbox($fontsize,0,"barcode/font/Arial.ttf",$res['isim']);
			$text_width=$text_box[2]-$text_box[0];
			$text_height=$text_box[5]-$text_box[1];
			if($text_width>$image_width)
			{
				$fontsize-=5;
				$text_box=imagettfbbox($fontsize,0,"barcode/font/Arial.ttf",$res['isim']);
				$text_width=$text_box[2]-$text_box[0];
				$text_height=$text_box[5]-$text_box[1];
			}
			$x=$image_width/2-$text_width/2;
			$y=$image_height/2-$text_height/2;


			$textim=imagecreatetruecolor($image_width, $image_height);
			$background = imagecolorallocate( $textim, 255, 255, 255 );
			$text_color = imagecolorallocate($textim, 0, 0, 0);
			imagefill($textim,0,0,$background);
			imagettftext($textim, $fontsize, 0,$x, $y, $text_color,"barcode/font/Arial.ttf",$res['isim']);	


		
			$to_printed=imagecreatetruecolor($image_width,$image_width/2);
			$bg=imagecolorallocate($to_printed,255,255,255);		
			imagefill($to_printed,0,0,$bg);
			imagecopymerge($to_printed,$textim,0,0,0,0,$image_width,$image_height,100);
			imagecopymerge($to_printed,$barcode,$image_width/2-imagesx($barcode)/2,50,0,0,$image_width,95,100);
			imagefilledrectangle($to_printed,0,50+imagesy($barcode),300,150,$bg);
			imagefilledrectangle($to_printed,$image_width/2+imagesx($barcode)/2,50,300,150,$bg);
			imagepng($to_printed,"barcode-images/".$ins['id'].".png");
		}
		$conn->query("DELETE FROM print_queue WHERE id=".$ins['id']);	
		$last.=(string)$ins['id'];
		$last.=",";
	}
	if($last=="")echo -1;
	else
	echo substr($last,0,-1);
?>

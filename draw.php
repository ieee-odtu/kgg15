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
	require_once('barcode/class/BCGFontFile.php');
	require_once('barcode/class/BCGColor.php');
	require_once('barcode/class/BCGDrawing.php');
	require_once('barcode/class/BCGcode39.barcode.php');
	$num=$_GET['barcode'];
	$colorFront = new BCGColor(0, 0, 0);
	$colorBack = new BCGColor(255, 255, 255);
	$font = new BCGFontFile('barcode/font/Arial.ttf', 18);
	$code = new BCGcode39();
	$code->setScale(2); 
	$code->setThickness(30); // Thickness
	$code->setForegroundColor($colorFront); // Color of bars
	$code->setBackgroundColor($colorBack); // Color of spaces
	$code->setFont($font); // Font (or 0)	
	while(strlen($num)<=7)
		$num="0".$num;
	$code->parse($num);
	//$code->draw();
	$drawing = new BCGDrawing('', $colorBack);
	$drawing->setBarcode($code);
	$drawing->draw();
	header('Content-Type: image/jpg');
	$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);
?>

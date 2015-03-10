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
	if(isset($_GET['out']))
	{
		session_start();
		unset($_SESSION['auth']);
	}
	if(isset($_POST['adm']))
	{
		if($_POST['adm']=="admin" && md5($_POST['pw'])=="e10adc3949ba59abbe56e057f20f883e")
		{
			session_start();
			$_SESSION['auth']="admin";
			die();
		}
		else if($_POST['adm']=="yenikayit" && md5($_POST['pw'])=="e10adc3949ba59abbe56e057f20f883e")
		{
			session_start();
			$_SESSION['auth']="yenikayit";
			die();
		}
		else if($_POST['adm']=="duyuru" && md5($_POST['pw'])=="e10adc3949ba59abbe56e057f20f883e")
		{
			session_start();
			$_SESSION['auth']="duyuru";
			die();
		}
		else if($_POST['adm']=="kapi" && md5($_POST['pw'])=="e10adc3949ba59abbe56e057f20f883e")
		{
			session_start();
			$_SESSION['auth']="kapi";
			die();
		}
		else if($_POST['adm']=="program" && md5($_POST['pw'])=="e10adc3949ba59abbe56e057f20f883e")
		{
			session_start();
			$_SESSION['auth']="program";
			die();
		}
	}
?>
<form action="login.php" method="post">
	<input type="password" name="adm"/>
	<input type="password" name="pw"/>
	<input type="submit" value="login"/>
</form>
<form action="login.php?out" method="post">
	<input type="submit" value=""/>
</form>

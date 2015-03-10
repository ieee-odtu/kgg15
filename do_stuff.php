<meta charset="utf8"/>
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
<?php
switch($_POST["job"])
{
	case "add_participant":
		addParticipant();
		break;
	case "add_session":
		addSession();
		break;
	case "change_session":
		changeSession();
		break;
	case "add_announcement":
		addAnnouncement();
		break;
	case "delete_announcement":
		deleteAnnouncement();
		break;
	case "edit_announcement":
		editAnnouncement();
		break;
}
?>
<?php
function editAnnouncement()
{
	session_start();
	if(@$_SESSION['auth']!="admin")die();
	unset($_POST['job']);
	$id=(string)(int)$_POST['duyuruid'];
	unset($_POST['duyuruid']);
	if(strlen($id)==0 || $id=='0')die();
	global $conn;
	$q=$conn->prepare("update duyurular set metin=:duyuru where id=$id");
	$q->execute($_POST);
	header("LOCATION:admin.php?announcement_edited");
}
function deleteAnnouncement()
{
	session_start();
	if(@$_SESSION['auth']!="admin")die();
	unset($_POST['job']);
	$id=(string)(int)$_POST['duyuruid'];
	if(strlen($id)==0 || $id=='0')die();
	global $conn;
	$conn->query("delete from duyurular where id=$id");
	header("LOCATION:admin.php?announcement_deleted");	
}
function addAnnouncement()
{
	session_start();
	if(@$_SESSION['auth']!="admin")die();
	unset($_POST['job']);
	if(empty($_POST['duyuru']))
	{
		header("LOCATION:admin.php?announcement_empty");
		die();
	}
	global $conn;
	$q=$conn->prepare("INSERT INTO duyurular SET metin=:duyuru,timestamp=NOW()");
	$q->execute($_POST);
	header("LOCATION:admin.php?announcement_added");
}
function changeSession()
{
	session_start();
	if(@$_SESSION['auth']!="admin")die();
	unset($_POST['job']);
	$oturumid=$_POST['oturumid'];
	unset($_POST['oturumid']);
	//print_r($_POST);
	global $conn;
	foreach($_POST as $key=>$value)
	{
		if(!in_array($key,array('oturum_isim','veren_isim','veren_unvan','salon','zaman')))die();
		echo $key." ".$value."<br/>";
		if(strlen($value)!=0)
		{
			echo "here";
			$arr=array($value);
			print_r($arr);
			$query=$conn->prepare("update oturumlar set ".$key."=? where id=".(string)(int)$oturumid);
			$query->execute($arr);
		}
	}
	header("LOCATION:admin.php?session_changed");
}
function addSession()
{
	session_start();
	if(@$_SESSION['auth']!="admin")die();
	if(empty($_POST['oturum_isim']) || empty($_POST['veren_isim']) || empty($_POST['veren_unvan']) || empty($_POST['salon']) || empty($_POST['zaman']))
	{
		header("LOCATION:./admin.php?empty_fields");
		die();
	}
	unset($_POST['job']);
	global $conn;
	$insert=$conn->prepare("INSERT INTO oturumlar (oturum_isim,veren_isim,veren_unvan,salon,zaman) VALUES (:oturum_isim,:veren_isim,:veren_unvan,:salon,:zaman)");
	$res=$insert->execute($_POST);
	if($res)
	{
		header("LOCATION:admin.php?add_op_successful");
		die();
	}
	else
	{
		echo "Sıkıntı oldu ekleyemedik.";
	}
	print_r($_POST);
}
function addParticipant()
{
	session_start();
	if(@$_SESSION['auth']!="yenikayit" && @$_SESSION['auth']!="admin")die();
	if(empty($_POST['isim']) || empty($_POST['kurum']) || empty($_POST['email']))
	{
		header("LOCATION:./?empty_fields");
		die();
	}

	unset($_POST["job"]);
	global $conn;
	
	
	$insert=$conn->prepare("INSERT INTO katilimcilar (isim,kurum,bolum,sinif,email,zaman) VALUES (:isim,:kurum,:bolum,:sinif,:email,NOW())");
	$res=$insert->execute($_POST);
	if($res)
	{
		$conn->query("INSERT INTO print_queue (id) VALUES (".$conn->lastInsertId().")");
		header("LOCATION:.?eklemebasarili");
		die();
	}
	else
	{
		echo "ekleyemedik.yetkili abi çağırın.";
	}
	print_r($_POST);
}
?>

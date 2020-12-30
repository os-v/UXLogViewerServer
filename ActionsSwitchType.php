<?php
//
//  @file ActionsSwitchType.php
//  @author Sergii Oryshchenko <sergii.orishchenko@gmail.com>
//  @see https://github.com/os-v/UXLogViewerServer/
//
//  Created on 28.12.20.
//  Copyright 2020 Sergii Oryshchenko. All rights reserved.
//

include_once(__DIR__."/UsersInfo.php");

session_start();

$pUser = new CUsersInfo();
if(!$pUser->Load($_SESSION["username"]))
	print("invalid username");
else
{
	$pUser->SwitchPublic();
	$pUser->Save();
	header('Location: Actions.php');
}

?>

<?php
//
//  @file ActionsThemes.php
//  @author Sergii Oryshchenko <sergii.orishchenko@gmail.com>
//  @see https://github.com/os-v/UXLogViewerServer/
//
//  Created on 22.12.20.
//  Copyright 2020 Sergii Oryshchenko. All rights reserved.
//

include_once(__DIR__."/UsersInfo.php");

session_start();

$pUser = new CUsersInfo();
if(!$pUser->Load($_SESSION["username"]))
{
	header('Location: Login.php');
	exit();
}

print("ActiveTheme:".$pUser->ActiveTheme."\r\n<br>");
print("ThemeDefs:".$pUser->ThemesDefs."\r\n");

?>

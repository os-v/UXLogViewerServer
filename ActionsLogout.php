<?php
//
//  @file ActionsLogout.php
//  @author Sergii Oryshchenko <sergii.orishchenko@gmail.com>
//  @see https://github.com/os-v/UXLogViewerServer/
//
//  Created on 22.12.20.
//  Copyright 2020 Sergii Oryshchenko. All rights reserved.
//

session_start();

$_SESSION["username"] = "";

session_destroy();

header('Location: Login.php');

?>

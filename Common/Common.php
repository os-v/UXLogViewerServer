<?php
//
//  @file Common.php
//  @author Sergii Oryshchenko <sergii.orishchenko@gmail.com>
//  @see https://github.com/os-v/UXLogViewerServer/
//
//  Created on 21.12.20.
//  Copyright 2020 Sergii Oryshchenko. All rights reserved.
//

class CCommon
{

    public static function SendMail($sAddr, $sSubject, $sBody)
    {
	$sHeaders  = "MIME-Version: 1.0"."\r\n";
	$sHeaders .= "Content-type: text/html; charset=iso-8859-1"."\r\n";
	$sHeaders .= "To: <".$sAddr.">\r\n";
	$sHeaders .= "From: UXLogViewer <UXLogViewer@os-v.pw>"."\r\n";
	mail($sAddr, $sSubject, $sBody, $sHeaders);
    }

}

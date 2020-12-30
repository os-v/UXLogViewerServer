//
//  @file Common.js
//  @author Sergii Oryshchenko <sergii.orishchenko@gmail.com>
//  @see https://github.com/os-v/UXLogViewerServer/
//
//  Created on 21.12.20.
//  Copyright 2020 Sergii Oryshchenko. All rights reserved.
//

function ValidateEmail(sEmail, fAlert)
{
	let sError = "";
        var pRegExp = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if(!pRegExp.test(sEmail))
		sError = "Invalid email address.";
	if(fAlert && sError != "")
		alert(sError);
	return sError;
}

function ValidatePassword(sPassword, fAlert)
{
	let sError = "";
	if(sPassword.length < 8)
		sError = "Password should be at least 8 characters";
	if(fAlert && sError != "")
		alert(sError);
	return sError;
}

function ValidateRLForm(sEmailID, sPasswordID, sConfirmID, fAlert, sConfirmError)
{
	if(ValidateEmail(document.getElementsByName(sEmailID)[0].value, fAlert).length)
		return false;
	if(ValidatePassword(document.getElementsByName(sPasswordID)[0].value, fAlert).length)
		return false;
	if(sConfirmError != "" && document.getElementsByName(sPasswordID)[0].value != document.getElementsByName(sConfirmID)[0].value)
	{
		if(fAlert)
			alert(sConfirmError);
		return false;
	}
	return true;
}

function ValidatePCForm(sOldPasswordID, sNewPasswordID, sConfirmID, fAlert)
{
	if(sOldPasswordID != null && ValidatePassword(document.getElementsByName(sOldPasswordID)[0].value, fAlert).length)
		return false;
	if(ValidatePassword(document.getElementsByName(sNewPasswordID)[0].value, fAlert).length)
		return false;
	if(document.getElementsByName(sNewPasswordID)[0].value != document.getElementsByName(sConfirmID)[0].value)
	{
		if(fAlert)
			alert("Confirmation should match password");
		return false;
	}
	return true;
}



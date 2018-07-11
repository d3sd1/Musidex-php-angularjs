<?php
require('../kernel/core.php');
if(USER_LOGGED_IN == true)
{
	session_destroy();
	$musidexSessions::delCookie('email');
	$musidexSessions::delCookie('time');
	echo '<script>document.getElementById("navigationHeaderUserMenu").remove();document.getElementById("headerActionsSign").innerHTML = \''.$musidexTemplate::loggedOutHeaderSignIn().'\';notifyToastr("'.$lang['notify.logout.success'].'","success");</script><div data-ng-controller="RedirectCtrl" data-ng-init="redirect(\'/start\')"></div>';
}
else
{
	echo '<div data-ng-controller="RedirectCtrl" data-ng-init="redirect(\'/start\')"></div>';
}
?>
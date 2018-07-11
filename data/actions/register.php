<?php
require('../../kernel/core.php');
if(isset($_POST)){
	$errors = null;
  	if (!isset($_POST['registerFormUsername']) or $_POST['registerFormUsername'] == null or strlen($_POST['registerFormUsername']) > 150)
	{
		if(!isset($_POST['registerFormUsername']) or $_POST['registerFormUsername'] == null)
		{
			$errors .= 'USERNAME|||'.$lang['notify.register.usernameNotSent'];
		}
		elseif(strlen($_POST['registerFormUsername']) > 150)
		{
			$errors .= 'USERNAME|||'.$lang['notify.register.usernameTooLong'];
		}
    }
	else
	{
		$username = $_POST['registerFormUsername'];
	}
	if(!isset($_POST['registerFormEmail']) or $_POST['registerFormEmail'] == null or strlen($_POST['registerFormEmail']) > 200 or !filter_var($_POST['registerFormEmail'], FILTER_VALIDATE_EMAIL) or $db->query('SELECT id FROM users WHERE email="'.$_POST['registerFormEmail'].'"')->num_rows > 0)
	{
		if($errors != null)
		{
			$errors .= ':::';
		}
		if(!isset($_POST['registerFormEmail']) or $_POST['registerFormEmail'] == null)
		{
			$errors .= 'EMAIL|||'.$lang['notify.register.emailNotSent'];
		}
		elseif(strlen($_POST['registerFormEmail']) > 400)
		{
			$errors .= 'EMAIL|||'.$lang['notify.register.emailTooLong'];
		}
		elseif(!filter_var($_POST['registerFormEmail'], FILTER_VALIDATE_EMAIL))
		{
			$errors .= 'EMAIL|||'.$lang['notify.register.emailFormatNotValid'];
		}
		elseif($db->query('SELECT id FROM users WHERE email="'.$_POST['registerFormEmail'].'"')->num_rows > 0)
		{
			$errors .= 'EMAIL|||'.$lang['notify.register.emailDuplicated'];
		}
    }
	else
	{
		$email = $_POST['registerFormEmail'];
	}
	
	if(!isset($_POST['registerFormPassword']) or $_POST['registerFormPassword'] == null or (strlen($_POST['registerFormPassword']) <= 8 or !preg_match('`[a-z]`',$_POST['registerFormPassword']) or !preg_match('`[A-Z]`',$_POST['registerFormPassword']) or !preg_match('`[0-9]`',$_POST['registerFormPassword']) or strlen($_POST['registerFormPassword']) > 200) or strlen($_POST['registerFormPassword']) > 200)
	{
		if($errors != null)
		{
			$errors .= ':::';
		}
		if(!isset($_POST['registerFormPassword']) or $_POST['registerFormPassword'] == null)
		{
			$errors .= 'PASSWORD|||'.$lang['notify.register.passwordNotSent'];
		}
		elseif(strlen($_POST['registerFormPassword']) <= 8 or !preg_match('`[a-z]`',$_POST['registerFormPassword']) or !preg_match('`[A-Z]`',$_POST['registerFormPassword']) or !preg_match('`[0-9]`',$_POST['registerFormPassword']) or strlen($_POST['registerFormPassword']) > 200)
		{
			$errors .= 'PASSWORD|||'.$lang['notify.register.passwordNotFormatted'];
		}
		elseif(strlen($_POST['registerFormPassword']) > 200)
		{
			$errors .= 'PASSWORD|||'.$lang['notify.register.passwordTooLong'];
		}
    }
	else
	{
		$password = $_POST['registerFormPassword'];
	}
	
	$securimage = new Securimage();
	if(!isset($_POST['registerFormCaptcha']) or $_POST['registerFormCaptcha'] == null)
	{
		if($errors != null)
		{
			$errors .= ':::';
		}
		$errors .= 'CAPTCHA|||'.$lang['notify.register.captchaNotSent'];
    }
	elseif($securimage->check($_POST['registerFormCaptcha']) == false)
	{
		if($errors != null)
		{
			$errors .= ':::';
		}
		$errors .= 'CAPTCHA|||'.str_replace(array('{attemptNum}','{attemptLimit}'),array(sessionManager::getSession('securimage_code_attempts'),Securimage::$maxAttemptsPerCaptcha),$lang['notify.register.attempt']);
		if(sessionManager::getSession('securimage_code_attempts') > Securimage::$maxAttemptsPerCaptcha)
		{
			$errors = 'BOT_DETECTED';
		}
	}
        if($errors != null){
			echo 'ERROR:::'.$errors;
    }else{
		$db->query('INSERT INTO users (name,email,password) VALUES ("'.$username.'","'.$email.'","'.sha1($password).'")');
		$musidexSessions::setCookie('email',$email);
		$musidexSessions::setCookie('time',time());
		$userData = $db->query('SELECT image,name,id FROM users WHERE email="'.$_POST['registerFormEmail'].'" AND password="'.sha1($_POST['registerFormPassword']).'"')->fetch_row();
		echo 'SUCCESS:::'.$musidexTemplate::loggedInUserMenu(str_replace('{*url*}',URL,$userData[0]),$userData[1],$userData[2]).':::'.$musidexTemplate::loggedInHeaderContent();
   }
}
?>
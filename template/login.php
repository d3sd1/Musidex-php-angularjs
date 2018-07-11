<?php
require('../kernel/core.php');
if(USER_LOGGED_IN == true)
{
	echo '<div data-ng-controller="RedirectCtrl" data-ng-init="redirect(\'/start\')"></div>';
	die();
}
?>
<script>var URL = "<?php echo URL ?>";var successTxt = "<?php echo $lang['notify.login.success'] ?>";var errorTxt = "<?php echo $lang['notify.action.errorTooManyAttempts']?>";</script>
<script src="<?php echo URL ?>/style/js/login.js"></script>
<div class="page-signin">

    <div class="signin-header">
        <div class="container text-center">
            <section class="logo-signin">
                <a href="#/"><i class="fa fa-3x color-primary fa-slack"></i></a>
            </section>
        </div>
    </div>

    <div class="main-body">
        <div class="container">
            <div class="form-container">
			<div id="LogoutCtrlDiv"></div>
                <section class="row signin-social text-center">
                    <a href="javascript:;" class="btn btn-twitter" tooltip-placement="top" tooltip="<?php echo $lang['login.twitter'] ?>" tooltip-append-to-body="true"><i class="fa fa-twitter"></i></a>
                    <div class="space"></div>
                    <a href="javascript:;" class="btn btn-facebook" tooltip-placement="top" tooltip="<?php echo $lang['login.facebook'] ?>" tooltip-append-to-body="true"><i class="fa fa-facebook"></i></a>
                    <div class="space"></div>
                    <a href="javascript:;" class="btn btn-google-plus" tooltip-placement="top" tooltip="<?php echo $lang['login.google'] ?>" tooltip-append-to-body="true"><i class="fa fa-google"></i></a>
                </section>

                <span class="line-thru"><?php echo $lang['login.or'] ?></span>

                <form class="form-horizontal" method="post" id="loginForm">
                    <fieldset>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-envelope"></span>
                                </span>
                                <input type="email" autocomplete="off" class="form-control" name="loginFormEmail" id="loginFormEmail" placeholder="<?php echo $lang['login.email'] ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-lock"></span>
                                </span>
                                <input type="password" autocomplete="off" class="form-control" name="loginFormPassword" id="loginFormPassword" placeholder="<?php echo $lang['login.password'] ?>">
                            </div>
                        </div>
						<div class="form-group">
                            <div class="input-group" style="display: inline">
							<img draggable="false" autocomplete="off" width="100%" style="float: left; padding-right: 5px" id="loginFormCaptchaImage" src="<?php echo URL ?>/captcha/load">
							<a tabindex="-1" href="#" onclick="document.getElementById('loginFormCaptchaImage').src = '<?php echo URL ?>/captcha/load'; this.blur(); return false"><img id="loginFormCaptchaReload" draggable="false" height="32" width="32" src="http://localhost/style/images/captcha/reload.gif" style="border: 0px; vertical-align: bottom; position: relative;float: right;margin-top: -34px;margin-right: 5px;"></a>
							</div>
						</div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                                </span>
                                <input type="text" autocomplete="off" name="loginFormCaptcha" id="loginFormCaptcha" class="form-control" placeholder="<?php echo $lang['form.captcha'] ?>">
                            </div>
                        </div>
                        <div class="form-group">
                        </div>
                        <div class="form-group">
                            <input type="submit" value="<?php echo $lang['login.button.send'] ?>" class="btn btn-primary btn-block btn-lg">
                        </div>
                    </fieldset>
                </form>

                <section>
                    <p class="text-center"><a href="signin.html#/pages/forgot"><?php echo $lang['login.recoverPass'] ?></a></p>
                    <p class="text-center text-muted text-small"><?php echo str_replace(array('{register1}','{register2}'),array('<a href="/#/register">','</a>'),$lang['login.register']) ?></p>
                </section>
                
            </div>
        </div>
    </div>

</div>
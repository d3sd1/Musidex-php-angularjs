<?php
require('../kernel/core.php');
if(USER_LOGGED_IN == true)
{
	echo '<div data-ng-controller="RedirectCtrl" data-ng-init="redirect(\'/start\')"></div>';
	die();
}
?>
<script>var URL = "<?php echo URL ?>";var successTxt = "<?php echo $lang['notify.register.success'] ?>";var errorTxt = "<?php echo $lang['notify.action.errorTooManyAttempts']?>";</script>
<script src="<?php echo URL ?>/style/js/register.js"></script>
<div class="page-signup">

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

                <section class="row signin-social text-center">
                    <a href="javascript:;" class="btn btn-twitter" tooltip-placement="top" tooltip="<?php echo $lang['register.twitter'] ?>" tooltip-append-to-body="true"><i class="fa fa-twitter"></i></a>
                    <div class="space"></div>
                    <a href="javascript:;" class="btn btn-facebook" tooltip-placement="top" tooltip="<?php echo $lang['register.facebook'] ?>" tooltip-append-to-body="true"><i class="fa fa-facebook"></i></a>
                    <div class="space"></div>
                    <a href="javascript:;" class="btn btn-google-plus" tooltip-placement="top" tooltip="<?php echo $lang['register.google'] ?>" tooltip-append-to-body="true"><i class="fa fa-google-plus"></i></a>
                </section>

                <span class="line-thru"><?php echo $lang['register.or'] ?></span>

                <section>
                    <form class="form-horizontal" method="post" id="registerForm">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-user"></span>
                                </span>
                                <input type="text" autocomplete="off" name="registerFormUsername" id="registerFormUsername" class="form-control" placeholder="<?php echo $lang['register.username'] ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-envelope"></span>
                                </span>
                                <input type="email" autocomplete="off" name="registerFormEmail" id="registerFormEmail" class="form-control" placeholder="<?php echo $lang['register.email'] ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-lock"></span>
                                </span>
                                <input type="password" autocomplete="off" name="registerFormPassword" id="registerFormPassword" class="form-control" placeholder="<?php echo $lang['register.password'] ?>">
                            </div>
                        </div>
						<div class="form-group">
                            <div class="input-group" style="display: inline">
							<img draggable="false" autocomplete="off" width="100%" style="float: left; padding-right: 5px" id="registerFormCaptchaImage" src="<?php echo URL ?>/captcha/load">
							<a tabindex="-1" href="#" onclick="document.getElementById('registerFormCaptchaImage').src = '<?php echo URL ?>/captcha/load'; this.blur(); return false"><img id="registerFormCaptchaReload" draggable="false" height="32" width="32" src="http://localhost/style/images/captcha/reload.gif" style="border: 0px; vertical-align: bottom; position: relative;float: right;margin-top: -34px;margin-right: 5px;"></a>
							</div>
						</div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                                </span>
                                <input type="text" autocomplete="off" name="registerFormCaptcha" id="registerFormCaptcha" class="form-control" placeholder="<?php echo $lang['form.captcha'] ?>">
                            </div>
                        </div>
                        <div class="form-group"  data-ng-controller="ModalDemoCtrl">
							<script type="text/ng-template" id="registerTermsAndConditions">
								<div class="modal-header" style="text-align:center">
									<h3><?php echo $lang['register.terms.title'] ?></h3>
								</div>
								<div class="modal-body" style="text-align:left">
									<?php echo $lang['register.terms.content'] ?>
								</div>
								<div class="modal-footer" style="text-align:center">
									<button class="btn btn-warning" ng-click="close()"><?php echo $lang['register.terms.close'] ?></button>
								</div>
							</script>
                            <p class="text-muted text-small"><?php echo str_replace(array('{terms1}','{terms2}'),array('<a href="" ng-click="open()">','</a>'),$lang['register.terms']) ?></p>
                            <div class="divider"></div>
                            <input type="submit" value="<?php echo $lang['register.button.send'] ?>" class="btn btn-primary btn-block btn-lg">
                        </div>
 
                    </form>
                </section>

                <section>
                    <p class="text-center text-muted"><?php echo str_replace(array('{loginLink1}','{loginLink2}'),array('<a href="#/login">','</a>'),$lang['register.login']) ?></p>
                </section>

            </div>
        </div>
    </div>
</div>
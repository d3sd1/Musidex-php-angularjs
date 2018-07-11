$(document).ready(function() {
  $('input[type="submit"]').on('click', function() {
      resetErrors();
      $.ajax({
          dataType: 'json',
          type: 'POST',
          url: URL + '/actions/login',
          data: {loginFormEmail: $('#loginFormEmail').val(),loginFormPassword: $('#loginFormPassword').val(),loginFormCaptcha: $('#loginFormCaptcha').val()},
          error: function (request, status, error) {
			  var status = request.responseText.split(":::");
				if(status[0] == 'SUCCESS')
				{
					var navigationHeaderCtrlDiv = document.getElementById('navigationHeaderCtrl');
					navigationHeaderCtrlDiv.innerHTML = status[1] + navigationHeaderCtrlDiv.innerHTML;
					document.getElementById('headerActionsSign').innerHTML = status[2];
					notifyToastr(successTxt,"success");
					location.href = URL + '/#/start';
				}
				else
				{
					var errorModal = request.responseText.split(":::");
					var captchaSolved = true;
					$.each( errorModal, function( key, preVal ) {
						if(preVal != 'ERROR' && preVal != 'BOT_DETECTED')
						{
						  var value = preVal.split("|||");
						  if(errorModal[key].value === undefined)
							{
								switch(value[0])
								{
									case 'EMAIL':
									var inputVal = "loginFormEmail";
									break;
									case 'PASSWORD':
									var inputVal = "loginFormPassword";
									break;
									case 'CAPTCHA':
									var inputVal = "loginFormCaptcha";
									captchaSolved = false;
									break;
								}
								$('input[name="' + inputVal + '"], select[name="' + inputVal + '"]').addClass('inputTxtError');
								notifyToastr(value[1],"warning");
							}
						}
						else if(preVal == 'BOT_DETECTED')
						{
							document.getElementById("loginFormEmail").disabled = true;
							document.getElementById("loginFormPassword").disabled = true;
							document.getElementById("loginFormCaptcha").disabled = true;
							notifyToastr(errorTxt,"error");
						}
					});
					if(captchaSolved === true)
					{
						document.getElementById("loginFormCaptcha").disabled = true;
						try
						{
							document.getElementById("loginFormCaptchaReload").remove();
						}catch(e){}
					}
				}
			}
      });
      return false;
  });
});
function resetErrors() {
    $('form input, form select').removeClass('inputTxtError');
    $('label.error').remove();
}
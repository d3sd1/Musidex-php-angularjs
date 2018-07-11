$(document).ready(function() {
  $('input[type="submit"]').on('click', function() {
      resetErrors();
      
      $.ajax({
          dataType: 'json',
          type: 'POST',
          url: URL + '/actions/register',
          data: {registerFormUsername: $('#registerFormUsername').val(),registerFormEmail: $('#registerFormEmail').val(),registerFormPassword: $('#registerFormPassword').val(),registerFormCaptcha: $('#registerFormCaptcha').val()},
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
						  if(errorModal[key].value === undefined)
							{
								var value = preVal.split("|||");
								switch(value[0])
								{
									case 'USERNAME':
									var inputVal = "registerFormUsername";
									break;
									case 'EMAIL':
									var inputVal = "registerFormEmail";
									break;
									case 'PASSWORD':
									var inputVal = "registerFormPassword";
									break;
									case 'CAPTCHA':
									var inputVal = "registerFormCaptcha";
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
							notifyToastr(successTxt,"error");
						}
					});
					if(captchaSolved === true)
					{
						document.getElementById("registerFormCaptcha").disabled = true;
						try
						{
							document.getElementById("registerFormCaptchaReload").remove();
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
	function checkUserName()
	{
		var sLyn = document.getElementById('USER_NAMES').innerHTML;
		if ((sLyn.indexOf(document.getElementById('username').value))>0)
			$('#inval_user').show();
		else
			$('#inval_user').hide();
	}
	function checkEmail()
	{
		var sLyn = document.getElementById('USER_EMAILS').innerHTML;
		if ((sLyn.indexOf(document.getElementById('emailAddress').value))>0)
			$('#inval_email').show();
		else
			$('#inval_email').hide();
	}

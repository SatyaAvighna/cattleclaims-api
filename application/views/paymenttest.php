<!-- saved from url=(0022)http://internet.e-mail -->
<!-- saved from url=(0022)http://internet.e-mail -->
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head id="Head1" runat="server">
    <title></title>

    <script language="javascript" type="text/javascript">
        function submitHealthForm() {
          
     document.PAYMENTFORM.submit();

        }        
         
    </script>
</head>
<body>
    <form action='https://apiuat.religarehealthinsurance.com/portalui/PortalPayment.run' name='PAYMENTFORM' method='post'>
    <div>
    <input type='hidden' name='proposalNum' value='1120004308394'/>
	<input type='hidden' name='returnURL' value='https://dev-app.apnapolicy.co.in/policiesformfillingpage'/>	
	</div>
  	<script language='javascript' type="text/javascript">      
	submitHealthForm();</script>
    </form>
</body>
</html>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/jquery/jquery-1.9.0.min.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/jquery/jquery-migrate-1.1.1.min.js"></script>

	<script type='text/javascript'>
		$(function(){
			$("form").submit();
		});
	</script>
</head>

<body>
	<p>please wait...</p>

	<form action="<?php echo $this->paymentInstance->getSubmitUrl();?>" method="<?php echo isset($this->paymentInstance->method)?$this->paymentInstance->method:"";?>">
		<?php foreach($this->sendData as $key => $item){?>
		<input type='hidden' name='<?php echo isset($key)?$key:"";?>' value='<?php echo isset($item)?$item:"";?>' />
		<?php }?>
	</form>
</body>

</html>
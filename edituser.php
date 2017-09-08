<?php

session_start();

$msglogin="";
$msgregister="";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Đăng nhập | World Water</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/price-range.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->

<body>
	<?php
	require 'block/header.php';
	require_once 'connect/db_connect.php';
	$db=new DB_Connect();
	$conn=$db->connect();

	$id=$_SESSION['id'];

	$query="select mataikhoan,matkhau,hoten,email from taikhoan where mataikhoan='$id' ";
	$result=$conn->query($query);
	if(mysqli_num_rows($result)>0){
		$row=mysqli_fetch_row($result);
		$name=$row['2'];
		$email=$row['3'];
		$pass=$row['1'];

	}else{
		die("loi gi k biet");
	}
	
	if(isset($_POST['update']))
	{
		$email=mysqli_real_escape_string($conn,$_POST['email']);
		$name=mysqli_real_escape_string($conn,$_POST['name']);
		$pass=mysqli_real_escape_string($conn,$_POST['pass']);

		//$sql="select mataikhoan,hoten,email from taikhoan where email='$email' and matkhau='$pass' and maquyen=2";

		$sql = "UPDATE taikhoan SET hoten='$name', email='$email', matkhau='$pass' WHERE mataikhoan='$id'";

		$result=$conn->query($sql);

		if ($result === TRUE) {
			$_SESSION['username']=$name;
			#send ajax to header.php


			
		    #echo "Record updated successfully";
		} else {
		    echo "Error updating record: " . $conn->error;
		}
	}
	
	?>
	<script>
	function valid()
	{
		var name=document.getElementById('register_name').value;
		var pass=document.getElementById('register_pass').value;
		var pass_again=document.getElementById('register_pass_again').value;
		if(name.length<5)
		{
			document.getElementById("alert_register").innerHTML = "Tên phải lớn hơn 5 ký tự ";
			return false;
		}else if( pass.length <6 || pass.length >20)
		{
			document.getElementById("alert_register").innerHTML = "Mật khẩu phải lớn hơn 6 và nhỏ hơn 20 ký tự";
			return false;
		}else if(pass!=pass_again)
		{
			document.getElementById("alert_register").innerHTML = "Nhập lại mật khẩu sai";
			return false;
		}
		
		return true;
	}
	</script>	
	<section id="form"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>Thông tin khách hàng</h2>
						<form action="" method="post">
						  <h4 class = "form-signin-heading" id="alert_login"><?php echo $msglogin; ?></h4>

						  	<input type="text" value="<?=$name;?>" name="name"/>
						  	<input type="text" value="<?=$email;?>" name="email"/>
						  	<input type="text" value="<?=$pass;?>" name="pass"/>
						  	
						  	
							
							
							
							<button type="submit" class="btn btn-default" name="update">Cập nhật</button>
						</form>
					</div><!--/login form-->
				</div>
				<div class="col-sm-1">
					<h2 class="or">OR</h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
						<h2>Đăng ký</h2>
						<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return valid()">
						<h4 class = "form-signin-heading" id="alert_register"><?php echo $msgregister; ?></h4>
							<input type="text" placeholder="Tên" name='register_name' id="register_name"/>
							<input type="email" placeholder="Email" name="register_email" id="register_email"/>
							<input type="password" placeholder="Mật khẩu" name="register_pass" id="register_pass"/>
							<input type="password" placeholder="Nhập lại mật khẩu" name="register_pass_again" id="register_pass_again"/>
							<button type="submit" class="btn btn-default" name="register">Đăng ký</button>
						</form>
					</div><!--/sign up form-->
				</div>
			</div>
		</div>
	</section><!--/form-->
	<?php
	require 'block/footer.php';
	?>
    <script src="js/jquery.js"></script>
	<script src="js/price-range.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
<?php
session_start();
if(!isset($_SESSION["adminEmail"]))
{
	header("Location: /thuctap/404.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin</title>

    <!-- Bootstrap Core CSS -->
    <link href="/thuctap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/thuctap/css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/thuctap/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php
		require_once 'menu.php';
		?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.html">Admin</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-table"></i> Tài khoản
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
				<div class="row">
					<div class="col-md-10 col-md-offset-3">
						<div class="col-lg-5">
						<?php
							require_once '../connect/db_connect.php';
							$maHD=$_GET['maHD'];
							$db=new DB_Connect();
							$conn=$db->connect();
							$sql="select email,tenkhachhang,sdt,diachi,hinhthucthanhtoan,trangthai from hoadon,taikhoan where mahoadon='$maHD' and hoadon.mataikhoan=taikhoan.mataikhoan";
							$result=$conn->query($sql);
							$row=mysqli_fetch_row($result);
							if(isset($_POST["submit"]))
							{
								$tenkh=$_POST['tenkhachhang'];
								$sdt=$_POST['sdt'];
								$diachi=$_POST['diachi'];
								$hinhthuc=$_POST['hinhthucthanhtoan'];
								$trangthai=$_POST['trangthai'];
								$sql="Update hoadon set tenkhachhang='$tenkh',sdt='$sdt',diachi='$diachi',hinhthucthanhtoan='$hinhthuc',trangthai='$trangthai' where mahoadon='$maHD'";
								$result=$conn->query($sql);
								if($result)
								{
									header("Location: /thuctap/admin/hoadon.php");
								}else{
									echo '<script language="javascript">';
									echo 'alert("Sửa thất bại")';
									echo '</script>';
								}
							}
							?>
							<form action="" method="post" role="form">
							<div class="form-group">
								<table>
									<tr>
										<td><label>Tài khoản</label></td>
										<td><input type="text" name="tenkhachhang" class="form-control" readonly="true" value="<?php echo $row['0']?>"></td>
									</tr>
									<tr>
										<td><label>Tên khách hàng</label></td>
										<td><input type="text" name="tenkhachhang" class="form-control" value="<?php echo $row['1']?>"></td>
									</tr>
									<tr>
										<td><label>SDT</label></td>
										<td><input type="text" name="sdt" class="form-control" value="<?php echo $row['2']?>"></td>
									</tr>
									<tr>
										<td><label>Địa chỉ</label></td>
										<td><input type="text" name="diachi" class="form-control" value="<?php echo $row['3']?>"></td>
									</tr>
									<tr>
										<td><label>Hình thức thanh toán</label></td>
										<td><select name="hinhthucthanhtoan" class="form-control">
											<?php
											if($row['4']=="Trực tiếp khi nhận hàng")
											{
												echo '<option>Trực tiếp khi nhận hàng</option>
													  <option>Thanh toán qua paypal</option>';
											}else{
												echo '<option>Thanh toán qua paypal</option>
													  <option>Trực tiếp khi nhận hàng</option>';
											}
											?>
											</select>
										</td>
									</tr>
									<tr>
										<td><label>Trạng thái</label></td>
										<td><select name="trangthai" class="form-control">
												<?php
												if($row['5']==0)
												{
													echo '<option value="0" >Chưa thanh toán</option>
														  <option value="1" >Đã thanh toán</option>';
												}else{
													echo '<option value="1" >Đã thanh toán</option>
														  <option value="0" >Chưa thanh toán</option>';
												}
												?>
											</select>
										</td>
									</tr>
									<tr>
										<td></td>
										<td><button type="submit" name="submit" class="btn btn-sm btn-success" onclick="add()">OK</button>
										<button type="reset" class="btn btn-sm btn-warning">Reset</button></td>
									</tr>
								</table>
							</div>
							</form>
						</div>
					</div>
				</div>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="/thuctap/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/thuctap/js/bootstrap.min.js"></script>
	<script src="/thuctap/js/hoadon.js"></script>

</body>

</html>

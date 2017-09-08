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
                                <i class="fa fa-table"></i> Sản phẩm
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="row">
					<div class="col-md-12 col-md-offset-1">
						<div class="col-lg-12 ">
							 <form action="#" method="post" enctype="multipart/form-data">
								<table>
									<tr>
									<?php
									require_once '../connect/db_connect.php';
									$db=new DB_Connect();
									$conn=$db->connect();
									$masp=$_GET['masp'];
									$sqlSP="select tensanpham,gia,giamgia,anh,mota,thongsokythuat,sanpham.manhom,tennhom,soluongcon from sanpham,nhomsanpham where masanpham='$masp' and sanpham.manhom=nhomsanpham.manhom";
									$resultSP=$conn->query($sqlSP);
									$rowSP=mysqli_fetch_row($resultSP);
									$sqlNSP="select * from nhomsanpham";
									$resultNSP=$conn->query($sqlNSP);
									echo '<tr>
										<td><label>Nhóm sản phẩm</label></td>
										<td><select class="form-control" id="manhom" name="manhom">
										<option value='.$rowSP['6'].'>'.$rowSP['7'].'</option>';
									while($row=mysqli_fetch_assoc($resultNSP))
									{
									echo		'<option value='.$row['manhom'].'>'.$row['tennhom'].'</option>';
									}
									echo 	'</select>
										</td>
									</tr>';
									if(isset($_POST["submit"]))
									{
										if(empty($_FILES['file']['tmp_name']))
										{
											$tensanpham=$_POST['tensanpham'];
											$gia=$_POST['gia'];
											$giamgia=$_POST['giamgia'];
											$khuyenmai=$_POST['khuyenmai'];
											$soluongcon=$_POST['soluongcon'];
											$mota=$_POST['mota'];
											$thongsokythuat=$_POST['thongsokythuat'];
											$sql="Update sanpham set tensanpham='$tensanpham',gia='$gia',giamgia='$giamgia',soluongcon='$soluongcon',mota='$mota',thongsokythuat='$thongsokythuat' where masanpham='$masp'";
											$result=$conn->query($sql);
											if($result)
											{
												header("Location: /thuctap/admin/sanpham.php");
											}else{
												echo '<script language="javascript">';
												echo 'alert("Sửa thất bại")';
												echo '</script>';
											}
										}else{
											$tensanpham=$_POST['tensanpham'];
											$gia=$_POST['gia'];
											$mota=$_POST['mota'];
											$thongsokythuat=$_POST['thongsokythuat'];
											move_uploaded_file($_FILES['file']['tmp_name'], '../images/products/'.$_FILES['file']['name']);
											$anh =$_FILES['file']['name'];
											$sql="Update sanpham set tensanpham='$tensanpham',gia='$gia',khuyenmai='$khuyenmai',anh='$anh',mota='$mota',thongsokythuat='$thongsokythuat' where masanpham='$masp'";
											$result=$conn->query($sql);
											if($result)
											{
												header("Location: /thuctap/admin/sanpham.php");
												echo $sql;
											}else{
												echo '<script language="javascript">';
												echo 'alert("Sửa thất bại")';
												echo '</script>';
											}
										}
										echo $sql;
									}
									?>
									<tr>
										<td><label>Tên sản phẩm</label></td>
										<td><input type="text" name="tensanpham" class="form-control" value="<?php echo $rowSP['0']?>"></td>
									</tr>
									<tr>
										<td><label>Giá</label></td>
										<td><input type="number" name="gia" class="form-control" value="<?php echo $rowSP['1']?>"></td>
									</tr>
									<tr>
										<td><label>Giảm giá</label></td>
										<td><input type="number" name="giamgia" class="form-control" value="<?php echo $rowSP['2']?>"></td>
									</tr>
									<tr>
										<td><label>Số lượng còn</label></td>
										<td><input type="number" name="soluongcon" class="form-control" value="<?php echo $rowSP['8']?>"></td>
									</tr>
									<tr>
										<td><label>Ảnh</label></td>
										<td><image width="50px" height="50px" src="../images/products/<?php echo $rowSP['3']?>"/><input type="file" id="file" name="file"></td>
									</tr>
									<tr>
										<td><label>Mô tả</label></td>
										<td><textarea rows="3" id="mota" name="mota" class="form-control" ><?php echo $rowSP['4']?></textarea></td>
									</tr>
									<tr>
										<td><label>Thông số kỹ thuật</label></td>
										<td><textarea rows="3" id="thongsokythuat" name="thongsokythuat" class="form-control"><?php echo $rowSP['5']?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td><button type="submit" name="submit" class="btn btn-sm btn-success">OK</button>
										<button type="reset" class="btn btn-sm btn-warning">Reset</button></td>
									</tr>
								</table>
							</form>
						</div>
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
	<script src="/thuctap/js/sanpham.js"></script>
	<script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
	 <script>
	  tinymce.init({
		selector: '#thongsokythuat',
	  });
	  tinymce.init({
		selector: '#mota'
	  });
	  </script>
</body>

</html>

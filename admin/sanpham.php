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
                <!-- /.row -->
				<div class="row">
					<div class="col-md-12 col-md-offset-1">
						<div class="col-lg-12 ">
							<div class="alert alert-success" id="alert-success-top" ></div>
							 <form id="formsanpham" method="post" enctype="multipart/form-data">
								<table>
									<tr>
									<?php
									require_once '../connect/db_connect.php';
									require_once '../quanly/paging.php';
									$db=new DB_Connect();
									$conn=$db->connect();
									$sql="select * from nhomsanpham";
									$result=$conn->query($sql);
									echo '<tr>
										<td><label>Nhóm sản phẩm</label></td>
										<td><select class="form-control" id="manhom" name="manhom">';
									while($row=mysqli_fetch_assoc($result))
									{
									echo		'<option value='.$row['manhom'].'>'.$row['tennhom'].'</option>';
									}
									echo 	'</select>
										</td>
									</tr>';
									?>
									<tr>
										<td><label>Tên sản phẩm</label></td>
										<td><input type="text" id="tensanpham" class="form-control"></td>
									</tr>
									<tr>
										<td><label>Giá </label></td>
										<td><input type="number" id="gia" class="form-control" value="0"></td>
									</tr>
									<tr>
										<td><label>Giảm giá </label></td>
										<td><input type="number" id="giamgia" class="form-control" value="0"></td>
									</tr>
									<tr>
										<td><label>Số lượng còn </label></td>
										<td><input type="number" id="soluongcon" class="form-control" value="0"></td>
									</tr>
									<tr>
										<td><label>Ảnh</label></td>
										<td><input type="file" id="file" name="file"></td>
									</tr>
									<tr>
										<td><label>Mô tả</label></td>
										<td><textarea id="mota" ></textarea></td>
									</tr>
									<tr>
										<td><label>Thông số kỹ thuật</label></td>
										<td><textarea id="thongsokythuat"></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td><button type="button" class="btn btn-sm btn-success" onclick="add()">OK</button>
										<button type="reset" class="btn btn-sm btn-warning">Reset</button></td>
									</tr>
								</table>
							</form>
						</div>
					</div>
				</div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
										<th>Ảnh</th>
                                        <th>Nhóm sản phẩm</th>
                                        <th>Mã sản phẩm</th>
                                        <th>Sản phẩm</th>
                                        <th>Giá </th>
										<th>Giảm giá </th>
										<th>Số lượng còn </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
									$result = mysqli_query($conn, 'select count(masanpham) as total from sanpham');
									$row = mysqli_fetch_assoc($result);
									$total_records = $row['total'];
									$config = array(
										'current_page'  => isset($_GET['page']) ? $_GET['page'] : 1,
										'total_record'  => $total_records,
										'limit'         => 10,
										'link_full'     => 'sanpham.php?page={page}',
										'link_first'    => 'sanpham.php',
										'range'         => 10 
									);
									$paging = new Pagination();	 
									$paging->init($config);
									$start=$paging->_config['start'];
									$limit=$paging->_config['limit'];
									$sql="select tennhom,masanpham,tensanpham,gia,giamgia,anh,soluongcon from sanpham,nhomsanpham where sanpham.manhom=nhomsanpham.manhom limit $start,$limit";
									$result=$conn->query($sql);
									while($row=mysqli_fetch_assoc($result))
									{
									echo '
                                    <tr>
										<td class="col-md-1"><image width="30px" height="30px" src="../images/products/'.$row['anh'].'"</td>
                                        <td class="col-md-1">'.$row['tennhom'].'</td>
                                        <td class="col-md-1">'.$row['masanpham'].'</td>
										<td class="col-md-2">'.$row['tensanpham'].'</td>
										<td class="col-md-1">'.$row['gia'].'</td>
										<td class="col-md-1">'.$row['giamgia'].'</td>
										<td class="col-md-1">'.$row['soluongcon'].'</td>
										<td class="col-md-1"><input type="image" src="/thuctap/images/icons/del.gif" onclick="del('.$row['masanpham'].')"/></td>
										<td class="col-md-1"><input type="image" src="/thuctap/images/icons/edit.png" onclick="edit('.$row['masanpham'].')"/></td>
										<td class="col-md-1"><input type="image" src="/thuctap/images/icons/addsale.png" onclick="addsale('.$row['masanpham'].')"/></td>
                                    </tr>';
									}
									echo $paging->html();
									?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
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
	<script src="/thuctap/js/admin/sanpham.js"></script>
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

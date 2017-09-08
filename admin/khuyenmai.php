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
                            <li>
                                <i class="fa fa-table"></i> Sản phẩm
                            </li>
							<li class="active">
                                <i class="fa fa-table"></i> Khuyến mãi
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
				<div class="row">
					<div class="col-md-10 col-md-offset-4">
						<div class="col-lg-4">
							<div class="alert alert-success" id="alert-success-top" ></div>
							<form role="form">
								<table>
									<tr>
										<td><label>Khuyến mãi</label></td>
										<td><input type="text" id="khuyenmai" class="form-control"></td>
									</tr>
									<tr>
										<td></td>
										<td><button type="button" class="btn btn-sm btn-success" onclick="add(<?php echo $_GET['id'];?>)">OK</button>
										<button type="reset" class="btn btn-sm btn-warning">Reset</button></td>
									</tr>
								</table>
							</form>
						</div>
					</div>
				</div>
                <div class="row">
                    <div class="col-lg-6 col-md-offset-3">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th class="col-md-1">Khuyến mãi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
									require_once '../connect/db_connect.php';
									require_once '../quanly/paging.php';
									$id=$_GET['id'];
									$db=new DB_Connect();
									$conn=$db->connect();
									$result = mysqli_query($conn, "select count(id) as total from khuyenmai where sanpham='$id'");
									$row = mysqli_fetch_assoc($result);
									$total_records = $row['total'];
									$config = array(
										'current_page'  => isset($_GET['page']) ? $_GET['page'] : 1,
										'total_record'  => $total_records,
										'limit'         => 10,
										'link_full'     => 'khuyenmai.php?id='.$id.'&page={page}',
										'link_first'    => 'khuyenmai.php',
										'range'         => 10 
									);
									$paging = new Pagination();	 
									$paging->init($config);
									$start=$paging->_config['start'];
									$limit=$paging->_config['limit'];
									$sql="select * from khuyenmai where sanpham='$id' limit $start,$limit";
									$result=$conn->query($sql);
									while($row=mysqli_fetch_assoc($result))
									{
									echo '
                                    <tr>
                                        <td class="col-md-1">'.$row['khuyenmai'].'</td>
										<td class="col-md-1"><input type="image" src="/thuctap/images/icons/del.gif" onclick="del('.$row['id'].')"/></td>
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
	<script src="/thuctap/js/admin/khuyenmai.js"></script>
</body>

</html>

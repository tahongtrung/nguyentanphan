<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Thông tin sản phẩm | World Water</title>
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
	?>
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<?php
					require 'block/left_sidebar.php';
					?>
				</div>
				<?php
				require_once 'connect/db_connect.php';
				require_once 'quanly/paging.php';
				$db=new DB_Connect();
				$conn=$db->connect();
				$masp=$_GET['id'];
				$result = mysqli_query($conn, "select manhom,masanpham,tensanpham,gia,giamgia,anh,mota,thongsokythuat from sanpham where masanpham='$masp'");
				$row=mysqli_fetch_row($result);
				?>
				<div class="col-sm-9 padding-right">
					<div class="product-details"><!--product-details-->
						<div class="col-sm-5">
							<div class="view-product">
								<img src="images/products/<?php echo $row[5]?>"/>
							</div>
						</div>
						<div class="col-sm-7">
							<div class="product-information"><!--/product-information-->
								<?php
									if(get_km($conn,$row['1'])>0)
									{
										echo '<img src="images/home/sale.png" class="new" alt="" />';
									}
								?>
								<h1><?php echo $row[2]?></h1>
								<p>Mã sản phẩm: <?php echo $row[1]?></p>
								<span>
									<?php if($row['4']!=0)
												{
													echo '<span style="text-decoration:line-through;">$'.number_format($row['3']).'</span>';
													echo '<span>$'.number_format($row['3']-($row['3']*$row['4']/100)).'</span>';
												}else{
													echo '<span>$ '.number_format($row['3']).'</span>';
												}?>
									<label>Số lượng:</label>
									<input type="number" name="soluong" id="soluong" value="1" />
									<button type="button" class="btn btn-fefault cart" onclick="<?php echo "add(".$row[1].",0)"?>">
										<i class="fa fa-shopping-cart"></i>
										Add to cart
									</button>
								</span>
								<p><b>Mô tả:</b></p>
								<p><?php echo $row[6]?></p>
							</div><!--/product-information-->
						</div>
					</div><!--/product-details-->
					
					<div class="category-tab shop-details-tab"><!--category-tab-->
						<div class="tab-content">
							<div class="tab-pane fade active in" id="reviews" >
								<div class="col-sm-12">
								<?php
								if(get_km($conn,$row['1'])>0)
								{
									$date=date("Y/m/d");
									$result=$conn->query("select * from khuyenmaichung where thoigianbatdau<'$date' and thoigianketthuc>'$date'");
									if(mysqli_num_rows($result)>0)
									{
										echo '<h3>Khuyến mãi chung</h3>';
										while($set=mysqli_fetch_array($result))
										{
											echo '<h3 style="color:orange"><b>+'.$set['khuyenmai'].'</b></h3></br>';
										}
									}
									echo '<h3>Khuyến mãi</h3>';
									$result=$conn->query("select * from khuyenmai where sanpham='$row[1]'");
									while($km=mysqli_fetch_array($result))
									{
										echo '<h3 style="color:orange"><b>+'.$km['khuyenmai'].'</b></h3></br>';
									}
								}
								?>
									<h3>Thông số kỹ thuật</h3>
									<p><?php echo $row[7]?></p>
								</div>
							</div>
							
						</div>
					</div><!--/category-tab-->
					<?php
					require 'block/recommended_items.php';
					?>
				</div>
			</div>
		</div>
	</section>
	<?php
	require 'block/footer.php';
	?>
    <script src="js/jquery.js"></script>
	<script src="js/price-range.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
	<script src="js/cart.js"></script>
</body>
</html>
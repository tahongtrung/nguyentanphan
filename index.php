<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Home | World Water</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/price-range.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">
</head><!--/head-->

<body>
	<?php
	require '/block/header.php';
	?>
	<?php
	require 'block/slider.php';
	?>
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
				<?php
				require 'block/left_sidebar.php';
				?>
				</div>
				<div class="col-sm-9 padding-right">
					<div class="features_items"><!--features_items-->
						<?php
						require_once 'connect/db_connect.php';
						require_once 'quanly/paging.php';
						if(isset($_GET['search']))
						{
							echo '<h2 class="title text-center">Tất cả sản phẩm của tìm kiếm "'.$_GET['search'].'"</h2>';
							$search=$_GET['search'];
							$result = mysqli_query($conn, "select count(masanpham) as total from sanpham where tensanpham like '%$search%'");
							$row = mysqli_fetch_assoc($result);
							$total_records = $row['total'];
							$config = array(
								'current_page'  => isset($_GET['page']) ? $_GET['page'] : 1,
								'total_record'  => $total_records,
								'limit'         => 9,
								'link_full'     => 'index.php?search='.$search.'?page={page}',
								'link_first'    => 'index.php?search='.$search,
								'range'         => 10 
							);
							$paging = new Pagination();	 
							$paging->init($config);
							$start=$paging->_config['start'];
							$limit=$paging->_config['limit'];
							$sql="select masanpham,tensanpham,gia,giamgia,anh from sanpham where tensanpham like '%$search%' limit $start,$limit";
						}else if(isset($_GET['from']) && isset($_GET['to']))
						{
							echo '<h2 class="title text-center">Tất cả sản phẩm giá từ "'.number_format($_GET['from']).'" tới "'.number_format($_GET['to']).'"</h2>';
							$from=$_GET['from'];
							$to=$_GET['to'];
							$result = mysqli_query($conn, "select count(masanpham) as total from sanpham where gia>=$from && gia<=$to");
							$row = mysqli_fetch_assoc($result);
							$total_records = $row['total'];
							$config = array(
								'current_page'  => isset($_GET['page']) ? $_GET['page'] : 1,
								'total_record'  => $total_records,
								'limit'         => 9,
								'link_full'     => 'index.php?from='.$from.'&to='.$to.'&page={page}',
								'link_first'    => 'index.php?from='.$from.'&to='.$to,
								'range'         => 10 
							);
							$paging = new Pagination();	 
							$paging->init($config);
							$start=$paging->_config['start'];
							$limit=$paging->_config['limit'];
							$sql="select masanpham,tensanpham,gia,giamgia,anh from sanpham where gia>=$from && gia<=$to limit $start,$limit";
						}else if(isset($_GET['search_box'])){
							echo '<h2 class="title text-center">Kết quả tìm kiếm</h2>';
							$link_first="index.php";
							if(isset($_GET["nhomsanpham"]) && count($_GET["nhomsanpham"])>0){
								$sqlNSP="";
								$first=true;
								foreach ($_GET["nhomsanpham"] as $key => $value ) {
									if($first==true)
									{
										$sqlNSP=$sqlNSP." manhom='".$value."'";
										$first=false;
										$link_first=$link_first."?nhomsanpham[]=".$value;
									}else{
										$sqlNSP=$sqlNSP." or manhom='".$value."'";
										$link_first=$link_first."&nhomsanpham[]=".$value;
									}
								}
							}else{
								$sqlNSP="";
							}
							if(isset($_GET["khung"]) && count($_GET["khung"])>0){
								if($sqlNSP!=""){$sqlK=" and ";}
								else{$sqlK="";}
								$first=true;
								foreach ($_GET["khung"] as $key => $value ) {
									if($first==true)
									{
										$sqlK=$sqlK." thongsokythuat like '%".$value."%'";
										$first=false;
										$link_first=$link_first."&khung[]=".$value;
									}else{
										$sqlK=$sqlK." or thongsokythuat like '%".$value."%'";
										$link_first=$link_first."&khung[]=".$value;
									}
								}
							}else{
								$sqlK="";
							}
							if(isset($_GET["mausac"]) && count($_GET["mausac"])>0){
								if($sqlK!="" || $sqlNSP!=""){$sqlM=" and ";}
								else{$sqlM="";}
								$first=true;
								foreach ($_GET["mausac"] as $key => $value ) {
									if($first==true)
									{
										$sqlM=$sqlM." thongsokythuat like '%".$value."%'";
										$first=false;
										$link_first=$link_first."&mausac[]=".$value;
									}else{
										$sqlM=$sqlM." or thongsokythuat like '%".$value."%'";
										$link_first=$link_first."&mausac[]=".$value;
									}
								}
							}else{
								$sqlM="";
							}
							$link_first=$link_first."&search_box=";
							if($sqlNSP=="" && $sqlK=="" && $sqlM==""){
								$result = mysqli_query($conn, 'select count(masanpham) as total from sanpham');
							}else{
								$result = mysqli_query($conn, 'select count(masanpham) as total from sanpham where '.$sqlNSP.$sqlK.$sqlM);
							}
							$row = mysqli_fetch_assoc($result);
							$total_records = $row['total'];
							$config = array(
								'current_page'  => isset($_GET['page']) ? $_GET['page'] : 1,
								'total_record'  => $total_records,
								'limit'         => 9,
								'link_full'     => $link_first.'&page={page}',
								'link_first'    => $link_first,
								'range'         => 10 
							);
							$paging = new Pagination();	 
							$paging->init($config);
							$start=$paging->_config['start'];
							$limit=$paging->_config['limit'];
							if($sqlNSP=="" && $sqlK=="" && $sqlM==""){
								$sql="select * from sanpham limit $start,$limit";
							}else{
								$sql="select * from sanpham where ".$sqlNSP.$sqlK.$sqlM." limit $start,$limit";
							}
						}else{
							echo '<h2 class="title text-center">Tất cả sản phẩm</h2>';
							$result = mysqli_query($conn, 'select count(masanpham) as total from sanpham');
							$row = mysqli_fetch_assoc($result);
							$total_records = $row['total'];
							$config = array(
								'current_page'  => isset($_GET['page']) ? $_GET['page'] : 1,
								'total_record'  => $total_records,
								'limit'         => 9,
								'link_full'     => 'index.php?page={page}',
								'link_first'    => 'index.php',
								'range'         => 10 
							);
							$paging = new Pagination();	 
							$paging->init($config);
							$start=$paging->_config['start'];
							$limit=$paging->_config['limit'];
							$sql="select masanpham,tensanpham,gia,giamgia,anh from sanpham limit $start,$limit";
						}
						$result=$conn->query($sql);
						$resultGG = $conn->query("select * from giamgiachung");
						$row = mysqli_fetch_array($resultGG);
						$giamgia = $row['giamgia'];
						$sukien=$row['sukien'];
						if(strtotime(date("Y/m/d"))> strtotime($row['thoigianbatdau']) && strtotime(date("Y/m/d"))<strtotime($row['thoigianketthuc']))
						{
							$check_gg=true;
							echo '<h2 class="title text-center">Giảm giá dịp:'.$sukien.'</h2>';
						}else{
							$check_gg=false;
						}
						while($row=mysqli_fetch_assoc($result))
						{
						echo	'<div class="col-sm-4">
									<div class="product-image-wrapper">
										<div class="single-products">
												<div class="productinfo text-center" style="height:430px;">
													<a href="product-details.php?id='.$row['masanpham'].'"><img src="images/products/'.$row['anh'].'" alt="" style="width:280px;height:200px;"/></a>';
													if($check_gg==true && $giamgia!="0")
													{
														echo '<h2 style="text-decoration:line-through;">'.number_format($row['gia']).'</h2>';
														echo '<h2 >'.number_format($row['gia']-($row['gia']*$giamgia/100)).'</h2>';
													}else{
														if($row['giamgia']!=0)
														{
															echo '<h2 style="text-decoration:line-through;">'.number_format($row['gia']).'</h2>';
															echo '<h2 >'.number_format($row['gia']-($row['gia']*$row['giamgia']/100)).'</h2>';
														}else{
															echo '<h2 style="text-decoration:line-through;"></h2>';
															echo '<h2>'.number_format($row['gia']).'</h2>';
														}
													}
													
						echo						'<p style="height:60px;line-height:20px;">'.$row['tensanpham'].'</p>
													<button type="button" class="btn btn-fefault add-to-cart" onclick="add('.$row['masanpham'].',1)">
														<i class="fa fa-shopping-cart"></i>
														Add to cart
													</button>
												</div>';
						if(get_km($conn,$row['masanpham'])>0 || $check_gg==true || $row['giamgia']!="0")
						{
							echo '<img src="images/home/sale.png" class="new" alt="" />';
						}
						echo'			</div>
									</div>
								</div>';
						}
						echo $paging->html();
						?>
					</div><!--features_items-->					
					<?php
					require 'block/recommended_items.php';
					?>
				</div>
			</div>
		</div>
	</section>
	<?php
	require '/block/footer.php';
	?>
    <script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.scrollUp.min.js"></script>
	<script src="js/price-range.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
	<script src="js/cart.js"></script>
	<script src="js/search.js"></script>
</body>
</html>
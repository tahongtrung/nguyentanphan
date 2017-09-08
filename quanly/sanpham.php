<?php
require_once '../connect/db_connect.php';
session_start();
if(isset($_SESSION['adminEmail']))
{
	$db=new DB_Connect();
	$conn=$db->connect();
	if(isset($_POST['addSP']))
	{
		$manhom=mysqli_real_escape_string($conn,$_POST['manhom']);
		$tensanpham=mysqli_real_escape_string($conn,$_POST['tensanpham']);
		$gia=mysqli_real_escape_string($conn,$_POST['gia']);
		$soluongcon=mysqli_real_escape_string($conn,$_POST['soluongcon']);
		$giamgia=mysqli_real_escape_string($conn,$_POST['giamgia']);
		$mota=mysqli_real_escape_string($conn,$_POST['mota']);
		$thongsokythuat=mysqli_real_escape_string($conn,$_POST['thongsokythuat']);
		move_uploaded_file($_FILES['file']['tmp_name'], '../images/products/'.$_FILES['file']['name']);
		$anh =$_FILES['file']['name'];
		$sql="select * from sanpham where tensanpham='$tensanpham'";
		$result=$conn->query($sql);
		if($result)
		{
			if(mysqli_num_rows($result)>0)
			{
				$response['message']='Sản phẩm đã tồn tại';
				$response['success']=3;
				echo json_encode($response);
			}else{
				$sql="Insert into sanpham(manhom,tensanpham,gia,soluongcon,anh,mota,thongsokythuat,giamgia) values('$manhom','$tensanpham','$gia','$soluongcon','$anh','$mota','$thongsokythuat','$giamgia')";
				$result=$conn->query($sql);
				if($result)
				{
					$response['message']='Thêm thành công';
					$response['success']=1;
					echo json_encode($response);
				}else{
					$response['message']='Thêm thất bại';
					$response['success']=4;
					echo json_encode($response);
				}
			}
		}else{
			$response['message']='Có lỗi xảy ra';
			$response['success']=2;
			echo json_encode($response);
		}
	}else if(isset($_POST['deleteSP'])){
		$masanpham=mysqli_real_escape_string($conn,$_POST['masp']);
		$sql="delete from sanpham where masanpham='$masanpham'";
		$result=$conn->query($sql);
		if($result)
		{
			$response['message']='Xóa thành công';
			$response['success']=1;
			echo json_encode($response);
		}else{
			$response['message']='Xóa thất bại';
			$response['success']=2;
			echo json_encode($response);
		}
	}
}else{
	header("Location: /thuctap/404.php");
}
?>
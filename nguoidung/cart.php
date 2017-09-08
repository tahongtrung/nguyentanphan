<?php
require_once '../connect/db_connect.php';
session_start();
$db=new DB_Connect();
$conn=$db->connect();
if(isset($_POST['add']))
{
	$id=$_POST['id'];
	$count=$_POST['count'];
	if(!isset($_SESSION['cart']))
	{
		$cart=array();
		$sql="select tensanpham,gia,anh,giamgia from sanpham where masanpham='$id'";
		$result=$conn->query($sql);
		$row=mysqli_fetch_row($result);
		$product['id']=$id;
		$product['name']=$row[0];
		$product['image']=$row[2];
		$product['count']=$count;
		
		$resultGG = $conn->query("select * from giamgiachung");
		$set = mysqli_fetch_array($resultGG);
		$giamgia = $set['giamgia'];
		if(strtotime(date("Y/m/d"))> strtotime($set['thoigianbatdau']) && strtotime(date("Y/m/d"))<strtotime($set['thoigianketthuc']))
		{
			$product['price']=$row[1]-$row[1]*$giamgia/100;
		}else{
			$product['price']=$row[1]-$row[1]*$row[3]/100;
		}
		
		$product['money']=$product['price']*$count;
		array_push($cart,$product);
		$response['message']='Thêm thành công';
		$response['success']=1;
		echo json_encode($response);
		$_SESSION['cart']=$cart;
	}else{
		$ok=1;
		$cart=$_SESSION['cart'];
		foreach($cart as $key=>&$value)
		{
			if($id==$value['id'])
			{
				$value['count']=$value['count']+$count;
				$value['money']=$value['price']*$value['count'];
				$ok=2;
			}
		}
		if($ok==1)
		{
			$sql="select tensanpham,gia,anh,giamgia from sanpham where masanpham='$id'";
			$result=$conn->query($sql);
			$row=mysqli_fetch_row($result);
			$product['id']=$id;
			$product['name']=$row[0];
			$product['image']=$row[2];
			$product['count']=$count;
			$resultGG = $conn->query("select * from giamgiachung");
			$set = mysqli_fetch_array($resultGG);
			$giamgia = $set['giamgia'];
			if(strtotime(date("Y/m/d"))> strtotime($set['thoigianbatdau']) && strtotime(date("Y/m/d"))<strtotime($set['thoigianketthuc']))
			{
				$product['price']=$row[1]-$row[1]*$giamgia/100;
			}else{
				$product['price']=$row[1]-$row[1]*$row[3]/100;
			}
			$product['money']=$product['price']*$count;
			array_push($cart,$product);
		}
		$_SESSION['cart']=$cart;
		$response['message']='Thêm thành công';
		$response['success']=1;
		echo json_encode($response);
	}
}else if(isset($_POST['del']))
{
	$id=$_POST['id'];
	if(isset($_SESSION['cart']))
	{
		$cart=$_SESSION['cart'];
		foreach($cart as $key=>$value)
		{
			if($id==$value['id'])
			{
				unset($cart[$key]);
			}
		}
		$_SESSION['cart']=$cart;
		$response['message']='Xóa thành công';
		$response['success']=1;
		echo json_encode($response);
	}
}else if(isset($_POST['update']))
{
	$soluong=$_POST['soluong'];
	if(isset($_SESSION['cart']))
	{
		$cart=$_SESSION['cart'];
		foreach($cart as $key=>&$value)
		{
			$value['count']=$soluong[$key];
			$value['money']=$value['price']*$value['count'];
		}
		$_SESSION['cart']=$cart;
		$response['message']='Xóa thành công';
		$response['success']=1;
		echo json_encode($response);
	}
}else if(isset($_POST['delete_all']))
{
	unset($_SESSION['cart']);
	$response['message']='Xóa giỏ hàng thành công';
	$response['success']=1;
	echo json_encode($response);
}
else{
	die('nothing submit!');
}
?>
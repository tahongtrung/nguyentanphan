function add()
{
	hoten=$('#hoten').val();
	email=$('#email').val();
	matkhau=$('#matkhau').val();
	quyen=$('#quyen').val();
	if(hoten!="" && email!="" && matkhau!="")
	{
		$.ajax({
			url: "../quanly/taikhoan.php",
			type: "post",
			dateType: "json",
			data: {
				addTK:"add",
				hoten:hoten,
				email:email,
				matkhau:matkhau,
				quyen:quyen,
			},
			success: function(result){
				var obj=JSON.parse(result);
				document.getElementById("alert-success-top").innerHTML = obj.message;
				window.setTimeout(function(){location.reload()},500)
			}
		});
	}else{
			alert('Hãy nhập đầy đủ thông tin');
	}
}
function del(matk)
{
	if(confirm('Bạn có muốn xóa không?'))
	{
	$.ajax({
			url : "../quanly/taikhoan.php",
			type : "post",
			dateType:"json",
			data : {
				deleteTK:"delete",
				 mataikhoan:matk,
			},
			success : function (result){		
				var obj = JSON.parse(result);
				document.getElementById("alert-success-top").innerHTML = obj.message;
				window.setTimeout(function(){location.reload()},500)
			}
		});
	}else{
		return;
	}
}
function edit(matk)
{
	var link="../admin/edittaikhoan.php?matk="+matk;
	window.location.href=link;
}
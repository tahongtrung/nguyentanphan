function add(id)
{
	khuyenmai=$(khuyenmai).val();
	if(khuyenmai!="")
	{
		$.ajax({
			url: "../quanly/khuyenmai.php",
			type: "post",
			dateType: "json",
			data: {
				addKM:"add",
				id:id,
				khuyenmai:khuyenmai,
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
function del(id)
{
	if(confirm('Bạn có muốn xóa không?'))
	{
	$.ajax({
			url : "../quanly/khuyenmai.php",
			type : "post",
			dateType:"json",
			data : {
				deleteKM:"delete",
				id:id,
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
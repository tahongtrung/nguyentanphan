function add()
{
	manhom=$('#manhom').val();
	tensanpham=$('#tensanpham').val();
	gia=$('#gia').val();
	giamgia=$('#giamgia').val();
	soluongcon=$('#soluongcon').val();
	mota=window.parent.tinymce.get('mota').getContent();
	thongsokythuat=window.parent.tinymce.get('thongsokythuat').getContent();
	if(tensanpham!="" && gia!="" && thongsokythuat!="")
	{
		var m_data = new FormData(); 
		m_data.append('addSP',"add");
		m_data.append('manhom',manhom);
		m_data.append('tensanpham',tensanpham);
		m_data.append('gia',gia);
		m_data.append('giamgia',giamgia);
		m_data.append('soluongcon',soluongcon);
		m_data.append('mota',mota);
		m_data.append('thongsokythuat',thongsokythuat);
		m_data.append( 'file', $('input[name=file]')[0].files[0]);
		
		$.ajax({
			url: "../quanly/sanpham.php",
			type: "post",
			dateType: "json",
			data: m_data,
			processData: false,
			contentType: false,
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
function del(masp)
{
	if(confirm('Bạn có muốn xóa không?'))
	{
	$.ajax({
			url : "../quanly/sanpham.php",
			type : "post",
			dateType:"json",
			data : {
				deleteSP:"delete",
				masp:masp,
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
function edit(masp)
{
	var link="../admin/editsanpham.php?masp="+masp;
	window.location.href=link;
}
function addsale(masp)
{
	var link="../admin/khuyenmai.php?id="+masp;
	window.location.href=link;
}
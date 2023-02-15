// JavaScript Document
function lo(th,url)
{
	$.ajax(url,{cache:false,success: function(x){$(th).html(x)}})
}
function good(id,type,user)
{
	$.post("back.php?do=good&type="+type,{"id":id,"user":user},function()
	{
		if(type=="1")
		{
			$("#vie"+id).text($("#vie"+id).text()*1+1)
			$("#good"+id).text("收回讚").attr("onclick","good('"+id+"','2','"+user+"')")
		}
		else
		{
			$("#vie"+id).text($("#vie"+id).text()*1-1)
			$("#good"+id).text("讚").attr("onclick","good('"+id+"','1','"+user+"')")
		}
	})
}
$(document).ready(()=>{
	$('.goods').on('click',function(){
		let news=$(this).data('news');
		let user=$(this).data('user');
		let num=parseInt($(this).siblings('.num').text())
	})

	$.post("./api/good.php",{news,user}),()=>
	{

		if($(this).text()=="讚")
		{
			$(this).text("收回讚")
			$(this).siblings('.num').text(num+1)
		}
		else
		{
			$(this).text("讚")
			$(this).siblings('.num').text(num-1)
		}

		location.reload();
	}
})
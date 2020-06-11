function ajax(a){
	
	if(!a.b) a.b='';
	if(!a.c) a.c=function(){};
	if(!a.d) a.d=function(){};
	/* return  $.ajax({ */
	return  $.ajax({
		url:a.a+'.php',
		data:a.b,
		type:'POST',
		error: a.c,
		success: a.d
	});
}
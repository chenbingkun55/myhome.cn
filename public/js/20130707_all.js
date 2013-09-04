$(document).ready(function(){
	$("#tool_bar_m1").load("/Ajax/tool_bar/menu/tool_bar_m1/index/0/lid/0/pid/0/uid/1/");
	$("#tool_bar_m2").load("/Ajax/tool_bar/menu/tool_bar_m2/index/0/lid/0/pid/0/uid/1/");
	$("#tool_bar_m3").load("/Ajax/tool_bar/menu/tool_bar_m3/index/0/lid/0/pid/0/uid/1/");
	$("#left_bar").load("/Ajax/left_bar/index/0/pid/0/rid/0/lfid/0/uid/1/");
	$("#conten_box").load("/Ajax/conten_box/pid/0/rid/0/lfid/0/uid/1/");
	$("#title_bar").load("/Ajax/title_bar/rid/0/tid/0/lfid/0/uid/1/");
});

function tool_bar(str,index,lid,pid){
	//alert('tool_bar   str='+str+' index='+index+' lid='+lid+' pid='+pid);
	if (str=='m1'){
		$("#tool_bar_m1").load("/Ajax/tool_bar/menu/tool_bar_m1/index/"+index+"/lid/"+lid+"/pid/"+pid+"/uid/1/");
		$("#tool_bar_m2").load("/Ajax/tool_bar/menu/tool_bar_m2/index/0/lid/"+lid+"/pid/"+pid+"/uid/1/");
		$("#tool_bar_m3").load("/Ajax/tool_bar/menu/tool_bar_m3/index/0/lid/"+lid+"/pid/"+pid+"/uid/1/");
		left_bar(0,0,0,0);
	} else if (str=='m2'){
		$("#tool_bar_m1").load("/Ajax/tool_bar/menu/tool_bar_m1/index/0/lid/"+lid+"/pid/"+pid+"/uid/1/");
		$("#tool_bar_m2").load("/Ajax/tool_bar/menu/tool_bar_m2/index/"+index+"/lid/"+lid+"/pid/"+pid+"/uid/1/");
		$("#tool_bar_m3").load("/Ajax/tool_bar/menu/tool_bar_m3/index/0/lid/"+lid+"/pid/"+pid+"/uid/1/");
		left_bar(0,pid,0,0);
	} else {
		$("#tool_bar_"+str).load("/Ajax/tool_bar/menu/tool_bar_"+str+"/index/"+index+"/lid/"+lid+"/pid/"+pid+"/uid/1/");
	}	
}

function left_bar(index,pid,rid,lfid){
	//alert('left_bar    index='+index+' pid='+pid+' rid='+rid);
	tool_bar('m3',index,rid,pid);
	$("#left_bar").load("/Ajax/left_bar/index/0/pid/"+pid+"/rid/"+rid+"/lfid/"+lfid+"/uid/1/");
	title_bar(rid,0);
	conten_box(pid,rid,lfid);
}

function title_bar(rid,tid){
	//alert('title_bar    rid='+rid+' tid='+tid);
	$("#title_bar").load("/Ajax/title_bar/rid/"+rid+"/tid/"+tid+"/uid/1/");
}

function conten_box(pid,rid,lfid){
	//alert('conten_box    pid='+pid+' rid='+rid);
	$("#conten_box").load("/Ajax/conten_box/pid/"+pid+"/rid/"+rid+"/lfid/"+lfid+"/uid/1/");
}

function resource_select(pid,rid,lfid){
	$("#R"+rid+"LF"+lfid).slideDown("slow");
	$("#R"+rid+"LF"+lfid).load("/Ajax/resource_select/pid/"+pid+"/rid/"+rid+"/lfid/"+lfid+"/uid/1/");
}

function resource_conten(pid,rid,lfid,oid){
	//alert('欢迎进入 resource_conten'+' Pid='+pid+' Rid='+rid+' LFid='+lfid+' S_id='+oid);
	$("#conten_box").load("/Ajax/resource_conten/pid/"+pid+"/rid/"+rid+"/lfid/"+lfid+"/oid/"+oid+"/uid/1/");
}

var xmlHttp = false;

try{
	xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
} catch(e) {
	try{
		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	} catch (e2) {	}
}

if ( !xmlHttp && typeof XMLHttpRequest != "undefined") {
	try{
		xmlHttp = new XMLHttpRequest();
	} catch(e3) {
		xmlHttp = false;
	}
}

function StatHandler(){
	if(xmlHttp.readyState==4 && xmlHttp.status==200){
		document.getElementById("conten_box").innerHTML=xmlHttp.responseText;
	}
}

function StatTitle(){
	if(xmlHttp.readyState==4 && xmlHttp.status==200){
		document.getElementById("title_bar").innerHTML=xmlHttp.responseText;
	}
}

function chenge_contenbox(obj){

	xmlHttp.open("POST","/t.html",true);
	xmlHttp.setRequestHeader("Content-Type","application/x-www-from-urlencoded;");
	xmlHttp.onreadystatechange=StatHandler;

	xmlHttp.send();
}

function chenge_hs(){
	xmlHttp.open("POST","/hs.html",true);
	xmlHttp.setRequestHeader("Content-Type","application/x-www-from-urlencoded;");
	xmlHttp.onreadystatechange=StatHandler;

	xmlHttp.send();
}

function chenge_slot(){
	xmlHttp.open("POST","/slot.html",true);
	xmlHttp.onreadystatechange=StatHandler;

	xmlHttp.send();
}

function chenge_bingo(){
	xmlHttp.open("POST","/bingo.html",true);
	xmlHttp.setRequestHeader("Content-Type","application/x-www-from-urlencoded;");
	xmlHttp.onreadystatechange=StatHandler;

	xmlHttp.send();
}

function chenge_title(){
	xmlHttp.open("POST","/title.html",true);
	xmlHttp.onreadystatechange=StatTitle;

	xmlHttp.send();
}


function switch_color(obj){
	obj.style.backgroundColor = obj.style.backgroundColor == "" ? "#6666FF"  : "";
}


function change_menu1(obj){
		document.getElementById("menu1").style.height="24px";
		$(this).hide();
		if (obj.innerHTML.replace(/<.+?>/gim,'')=="所有")
		{
			menu_lo(arr_lo,0);
			menu_pro(arr_pro,0);
		} else {
			menu_lo(arr_lo,1);
			menu_pro(arr_pro,1);
		}
}

function change_menu2(obj){
		document.getElementById("menu2").style.height="24px";
		alert(obj.Name);
		if (obj.innerHTML.replace(/<.+?>/gim,'')=="所有")
		{
			menu_re(arr_re,0);
		} else {
			menu_re(arr_re,1);
		}
}

function change_menu3(obj){
		document.getElementById("menu3").style.height="24px";
}

function menu_lo(arr,index){
	for( i=0;i<arr.length;i++){
		if ( arr[i]['L_id'] == index )
		{
			document.getElementById("menu1").innerHTML="<DIV  id=\""+arr[i]['L_id']+"\" onmouseover=switch_color(this) onmouseout=switch_color(this)  style=\"height:24px;cursor:default;font-family: Tahoma; font-size: 12px; font-weight: bold;\">"+arr[i]['L_name']+"</DIV>";
		}
	}	

	document.getElementById("menu1").innerHTML+="<DIV id=\"lo-all\"  onmouseover=switch_color(this) onmouseout=switch_color(this)  style=\"height:24px;cursor:default;font-family: Tahoma; font-size: 12px; font-weight: bold;\">所有</DIV>";


	for( i=0;i<arr.length;i++){
		if ( arr[i]['L_id'] != index ){
			document.getElementById("menu1").innerHTML+="<DIV  id=\""+arr[i]['L_id']+"\"  onmouseover=switch_color(this) onmouseout=switch_color(this)  style=\"height:24px;cursor:default;font-family: Tahoma; font-size: 12px; font-weight: bold;\">"+arr[i]['L_name']+"</DIV>";
		}
	}
}

function menu_pro(arr,index){
	if ( index == "0" ){
		document.getElementById("menu2").innerHTML="<DIV name=\"all\"  onClick=change_menu1(this) onmouseover=switch_color(this) onmouseout=switch_color(this)  style=\"height:24px;cursor:default;font-family: Tahoma; font-size: 12px; font-weight: bold;\"><span id=\"pro-0\">所有</span></DIV>";
	} else {
		document.getElementById("menu2").innerHTML="<DIV name=\"all\"  onClick=change_menu1(this) onmouseover=switch_color(this) onmouseout=switch_color(this)  style=\"height:24px;cursor:default;font-family: Tahoma; font-size: 12px; font-weight: bold;\"><span id=\"pro-0\">所有2</span></DIV>";	
	}

	for( i=0;i<arr.length;i++){
		document.getElementById("menu2").innerHTML+="<DIV name=\""+arr[i]['P_id']+"\"  onClick=change_menu2(this) onmouseover=switch_color(this) onmouseout=switch_color(this)  style=\"height:24px;cursor:default;font-family: Tahoma; font-size: 12px; font-weight: bold;\"><span id=\"pro-"+i+"\">"+arr[i]['P_name']+"</span></DIV>";
	}
}

function menu_re(arr,index){
	if ( index == "0" ){
		document.getElementById("menu3").innerHTML="<DIV name=\"all\"  onClick=change_menu1(this) onmouseover=switch_color(this) onmouseout=switch_color(this)  style=\"height:24px;cursor:default;font-family: Tahoma; font-size: 12px; font-weight: bold;\"><span id=\"re-0\">所有</span></DIV>";
	} else {
		document.getElementById("menu3").innerHTML="<DIV name=\"all\"  onClick=change_menu1(this) onmouseover=switch_color(this) onmouseout=switch_color(this)  style=\"height:24px;cursor:default;font-family: Tahoma; font-size: 12px; font-weight: bold;\"><span id=\"re-0\">所有2</span></DIV>";	
	}

	for( i=0;i<arr.length;i++){
		document.getElementById("menu3").innerHTML+="<DIV name=\""+arr[i]['R_id']+"\"  onClick=change_menu3(this) onmouseover=switch_color(this) onmouseout=switch_color(this)  style=\"height:24px;cursor:default;font-family: Tahoma; font-size: 12px; font-weight: bold;\"><span id=\"re-"+i+"\">"+arr[i]['R_name']+"</span></DIV>";
	}
}


function limitText(limitField, limitCount, limitNum) {
	if (limitField.value.length > limitNum) {
	limitField.value = limitField.value.substring(0, limitNum);
	} else {
			limitCount.value = limitNum - limitField.value.length;
	}
}


function showComment(str)
{
var xmlhttp;
if (window.XMLHttpRequest)
  {
  // code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {
  // code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
{
if(xmlhttp.readyState==4)
  {
  var HTMLcontent = xmlhttp.responseText;
  document.getElementById("teacher_comment").innerHTML = HTMLcontent;
  return;
  }
}
url = "getcomment.php";
url=url+"?q="+str;
url=url+"&sid="+Math.random();
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}


function createWindow(str)
{
var xmlhttp2;
if (window.XMLHttpRequest)
  {
  // code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp2=new XMLHttpRequest();
  }
else
  {
  // code for IE6, IE5
  xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp2.onreadystatechange=function()
{
if(xmlhttp2.readyState==4)
  {
  var HTMLcontent = xmlhttp2.responseText;
  document.getElementById("comment").innerHTML = HTMLcontent;
  return;
  }
}
url2 = "setcommentsession.php";
url2=url2+"?q="+str;
url2=url2+"&sid="+Math.random();
xmlhttp2.open("GET",url2,true);
xmlhttp2.send(null);
document.getElementById("styled_popup").style.display="block";
}

///////////////////////////////
//add new contact pop up window
///////////////////////////////

var ie = document.all;
var nn6 = document.getElementById &&! document.all;

var x, y;
var dobj;

function styledPopupClose() {
  document.getElementById("styled_popup").style.display = "none";
}
			
//end code for add new contact pop up window										
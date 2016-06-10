<?
$hostname = 'localhost';  /////// MySQL server, usually `localhost`. It can also be IP address, or valid domain name
$mysql_user='calen';  ////////////// username for MySQL server
$mysql_pass='neil';  ////////////// password for MySQL server
$mysql_database='calendb'; //////////// MySQL database name

$admin_username = 'always'; ////////  ADMIN PASSWORD
$admin_password = 'neilaware';  ////////  ADMIN USERNAME

$tableCALENDAR = 'webcalendar_data_ver3';
$tableSETTINGS = 'webcalendar_settings_ver3';
$tableCALENDARS = 'webcalendar_calendars_ver3';
////////////////////
////////////////////
////////////////////
////////////////////
////////////////////
////////////////////
error_reporting(0);
import_request_variables("gP", "");

$connection = mysql_connect($hostname, $mysql_user, $mysql_pass) or die ('request "Unable to connect to MySQL server."');
$db = mysql_select_db($mysql_database, $connection) or die ('request "Unable to select database."');
//////////////////////
//////////////////////
/////   ADMIN  ///////
//////////////////////
//////////////////////
session_start();
if (!isset($ac)) $ac='data';

if ($ac=='logout') {
   $_SESSION["FlashCalendar"] = '0';
} elseif ($ac=='login') {
	if ($user == $admin_username and $pass == $admin_password) {
		$_SESSION["FlashCalendar"] = "logged";
		$ac='calendars';
	} else {
		$message = '<strong style="color:#FF0000">Incorrect login details.</strong>';
		$_SESSION["FlashCalendar"] = "";
		unset($_SESSION["FlashCalendar"]);
	};
};

$monthnames_arr = Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Flash Web Calendar - Admin</title>
<style>
TD {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #000000;
	text-decoration: none;
	font-weight: normal;

}
.bodytext {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #000000;
	text-decoration: none;
	font-weight: normal;

}
.titles {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #FFFFFF;
	text-decoration: none;
	font-weight: bold;
}
</style>
<script language="javascript">
function getAnchorPosition(anchorname){var useWindow=false;var coordinates=new Object();var x=0,y=0;var use_gebi=false, use_css=false, use_layers=false;if(document.getElementById){use_gebi=true;}else if(document.all){use_css=true;}else if(document.layers){use_layers=true;}if(use_gebi && document.all){x=AnchorPosition_getPageOffsetLeft(document.all[anchorname]);y=AnchorPosition_getPageOffsetTop(document.all[anchorname]);}else if(use_gebi){var o=document.getElementById(anchorname);x=AnchorPosition_getPageOffsetLeft(o);y=AnchorPosition_getPageOffsetTop(o);}else if(use_css){x=AnchorPosition_getPageOffsetLeft(document.all[anchorname]);y=AnchorPosition_getPageOffsetTop(document.all[anchorname]);}else if(use_layers){var found=0;for(var i=0;i<document.anchors.length;i++){if(document.anchors[i].name==anchorname){found=1;break;}}if(found==0){coordinates.x=0;coordinates.y=0;return coordinates;}x=document.anchors[i].x;y=document.anchors[i].y;}else{coordinates.x=0;coordinates.y=0;return coordinates;}coordinates.x=x;coordinates.y=y;return coordinates;}
function getAnchorWindowPosition(anchorname){var coordinates=getAnchorPosition(anchorname);var x=0;var y=0;if(document.getElementById){if(isNaN(window.screenX)){x=coordinates.x-document.body.scrollLeft+window.screenLeft;y=coordinates.y-document.body.scrollTop+window.screenTop;}else{x=coordinates.x+window.screenX+(window.outerWidth-window.innerWidth)-window.pageXOffset;y=coordinates.y+window.screenY+(window.outerHeight-24-window.innerHeight)-window.pageYOffset;}}else if(document.all){x=coordinates.x-document.body.scrollLeft+window.screenLeft;y=coordinates.y-document.body.scrollTop+window.screenTop;}else if(document.layers){x=coordinates.x+window.screenX+(window.outerWidth-window.innerWidth)-window.pageXOffset;y=coordinates.y+window.screenY+(window.outerHeight-24-window.innerHeight)-window.pageYOffset;}coordinates.x=x;coordinates.y=y;return coordinates;}
function AnchorPosition_getPageOffsetLeft(el){var ol=el.offsetLeft;while((el=el.offsetParent) != null){ol += el.offsetLeft;}return ol;}
function AnchorPosition_getWindowOffsetLeft(el){return AnchorPosition_getPageOffsetLeft(el)-document.body.scrollLeft;}
function AnchorPosition_getPageOffsetTop(el){var ot=el.offsetTop;while((el=el.offsetParent) != null){ot += el.offsetTop;}return ot;}
function AnchorPosition_getWindowOffsetTop(el){return AnchorPosition_getPageOffsetTop(el)-document.body.scrollTop;}
function PopupWindow_getXYPosition(anchorname){var coordinates;if(this.type == "WINDOW"){coordinates = getAnchorWindowPosition(anchorname);}else{coordinates = getAnchorPosition(anchorname);}this.x = coordinates.x;this.y = coordinates.y;}
function PopupWindow_setSize(width,height){this.width = width;this.height = height;}
function PopupWindow_populate(contents){this.contents = contents;this.populated = false;}
function PopupWindow_setUrl(url){this.url = url;}
function PopupWindow_setWindowProperties(props){this.windowProperties = props;}
function PopupWindow_refresh(){if(this.divName != null){if(this.use_gebi){document.getElementById(this.divName).innerHTML = this.contents;}else if(this.use_css){document.all[this.divName].innerHTML = this.contents;}else if(this.use_layers){var d = document.layers[this.divName];d.document.open();d.document.writeln(this.contents);d.document.close();}}else{if(this.popupWindow != null && !this.popupWindow.closed){if(this.url!=""){this.popupWindow.location.href=this.url;}else{this.popupWindow.document.open();this.popupWindow.document.writeln(this.contents);this.popupWindow.document.close();}this.popupWindow.focus();}}}
function PopupWindow_showPopup(anchorname){this.getXYPosition(anchorname);this.x += this.offsetX;this.y += this.offsetY;if(!this.populated &&(this.contents != "")){this.populated = true;this.refresh();}if(this.divName != null){if(this.use_gebi){document.getElementById(this.divName).style.left = this.x + "px";document.getElementById(this.divName).style.top = this.y;document.getElementById(this.divName).style.visibility = "visible";}else if(this.use_css){document.all[this.divName].style.left = this.x;document.all[this.divName].style.top = this.y;document.all[this.divName].style.visibility = "visible";}else if(this.use_layers){document.layers[this.divName].left = this.x;document.layers[this.divName].top = this.y;document.layers[this.divName].visibility = "visible";}}else{if(this.popupWindow == null || this.popupWindow.closed){if(this.x<0){this.x=0;}if(this.y<0){this.y=0;}if(screen && screen.availHeight){if((this.y + this.height) > screen.availHeight){this.y = screen.availHeight - this.height;}}if(screen && screen.availWidth){if((this.x + this.width) > screen.availWidth){this.x = screen.availWidth - this.width;}}var avoidAboutBlank = window.opera ||( document.layers && !navigator.mimeTypes['*']) || navigator.vendor == 'KDE' ||( document.childNodes && !document.all && !navigator.taintEnabled);this.popupWindow = window.open(avoidAboutBlank?"":"about:blank","window_"+anchorname,this.windowProperties+",width="+this.width+",height="+this.height+",screenX="+this.x+",left="+this.x+",screenY="+this.y+",top="+this.y+"");}this.refresh();}}
function PopupWindow_hidePopup(){if(this.divName != null){if(this.use_gebi){document.getElementById(this.divName).style.visibility = "hidden";}else if(this.use_css){document.all[this.divName].style.visibility = "hidden";}else if(this.use_layers){document.layers[this.divName].visibility = "hidden";}}else{if(this.popupWindow && !this.popupWindow.closed){this.popupWindow.close();this.popupWindow = null;}}}
function PopupWindow_isClicked(e){if(this.divName != null){if(this.use_layers){var clickX = e.pageX;var clickY = e.pageY;var t = document.layers[this.divName];if((clickX > t.left) &&(clickX < t.left+t.clip.width) &&(clickY > t.top) &&(clickY < t.top+t.clip.height)){return true;}else{return false;}}else if(document.all){var t = window.event.srcElement;while(t.parentElement != null){if(t.id==this.divName){return true;}t = t.parentElement;}return false;}else if(this.use_gebi && e){var t = e.originalTarget;while(t.parentNode != null){if(t.id==this.divName){return true;}t = t.parentNode;}return false;}return false;}return false;}
function PopupWindow_hideIfNotClicked(e){if(this.autoHideEnabled && !this.isClicked(e)){this.hidePopup();}}
function PopupWindow_autoHide(){this.autoHideEnabled = true;}
function PopupWindow_hidePopupWindows(e){for(var i=0;i<popupWindowObjects.length;i++){if(popupWindowObjects[i] != null){var p = popupWindowObjects[i];p.hideIfNotClicked(e);}}}
function PopupWindow_attachListener(){if(document.layers){document.captureEvents(Event.MOUSEUP);}window.popupWindowOldEventListener = document.onmouseup;if(window.popupWindowOldEventListener != null){document.onmouseup = new Function("window.popupWindowOldEventListener();PopupWindow_hidePopupWindows();");}else{document.onmouseup = PopupWindow_hidePopupWindows;}}
function PopupWindow(){if(!window.popupWindowIndex){window.popupWindowIndex = 0;}if(!window.popupWindowObjects){window.popupWindowObjects = new Array();}if(!window.listenerAttached){window.listenerAttached = true;PopupWindow_attachListener();}this.index = popupWindowIndex++;popupWindowObjects[this.index] = this;this.divName = null;this.popupWindow = null;this.width=0;this.height=0;this.populated = false;this.visible = false;this.autoHideEnabled = false;this.contents = "";this.url="";this.windowProperties="toolbar=no,location=no,status=no,menubar=no,scrollbars=auto,resizable,alwaysRaised,dependent,titlebar=no";if(arguments.length>0){this.type="DIV";this.divName = arguments[0];}else{this.type="WINDOW";}this.use_gebi = false;this.use_css = false;this.use_layers = false;if(document.getElementById){this.use_gebi = true;}else if(document.all){this.use_css = true;}else if(document.layers){this.use_layers = true;}else{this.type = "WINDOW";}this.offsetX = 0;this.offsetY = 0;this.getXYPosition = PopupWindow_getXYPosition;this.populate = PopupWindow_populate;this.setUrl = PopupWindow_setUrl;this.setWindowProperties = PopupWindow_setWindowProperties;this.refresh = PopupWindow_refresh;this.showPopup = PopupWindow_showPopup;this.hidePopup = PopupWindow_hidePopup;this.setSize = PopupWindow_setSize;this.isClicked = PopupWindow_isClicked;this.autoHide = PopupWindow_autoHide;this.hideIfNotClicked = PopupWindow_hideIfNotClicked;}
ColorPicker_targetInput = null;
function ColorPicker_writeDiv(){document.writeln("<DIV ID=\"colorPickerDiv\" STYLE=\"position:absolute;visibility:hidden;\"> </DIV>");}
function ColorPicker_show(anchorname){this.showPopup(anchorname);}
function ColorPicker_pickColor(color,obj){obj.hidePopup();pickColor(color);}
function pickColor(color){if(ColorPicker_targetInput==null){alert("Target Input is null, which means you either didn't use the 'select' function or you have no defined your own 'pickColor' function to handle the picked color!");return;}ColorPicker_targetInput.value = color;}
function ColorPicker_select(inputobj,linkname){if(inputobj.type!="text" && inputobj.type!="hidden" && inputobj.type!="textarea"){alert("colorpicker.select: Input object passed is not a valid form input object");window.ColorPicker_targetInput=null;return;}window.ColorPicker_targetInput = inputobj;this.show(linkname);}
function ColorPicker_highlightColor(c){var thedoc =(arguments.length>1)?arguments[1]:window.document;var d = thedoc.getElementById("colorPickerSelectedColor");d.style.backgroundColor = c;d = thedoc.getElementById("colorPickerSelectedColorValue");d.innerHTML = c;}
function ColorPicker(){var windowMode = false;if(arguments.length==0){var divname = "colorPickerDiv";}else if(arguments[0] == "window"){var divname = '';windowMode = true;}else{var divname = arguments[0];}if(divname != ""){var cp = new PopupWindow(divname);}else{var cp = new PopupWindow();cp.setSize(225,250);}cp.currentValue = "#FFFFFF";cp.writeDiv = ColorPicker_writeDiv;cp.highlightColor = ColorPicker_highlightColor;cp.show = ColorPicker_show;cp.select = ColorPicker_select;var colors = new Array("#000000","#000033","#000066","#000099","#0000CC","#0000FF","#330000","#330033","#330066","#330099","#3300CC",
"#3300FF","#660000","#660033","#660066","#660099","#6600CC","#6600FF","#990000","#990033","#990066","#990099",
"#9900CC","#9900FF","#CC0000","#CC0033","#CC0066","#CC0099","#CC00CC","#CC00FF","#FF0000","#FF0033","#FF0066",
"#FF0099","#FF00CC","#FF00FF","#003300","#003333","#003366","#003399","#0033CC","#0033FF","#333300","#333333",
"#333366","#333399","#3333CC","#3333FF","#663300","#663333","#663366","#663399","#6633CC","#6633FF","#993300",
"#993333","#993366","#993399","#9933CC","#9933FF","#CC3300","#CC3333","#CC3366","#CC3399","#CC33CC","#CC33FF",
"#FF3300","#FF3333","#FF3366","#FF3399","#FF33CC","#FF33FF","#006600","#006633","#006666","#006699","#0066CC",
"#0066FF","#336600","#336633","#336666","#336699","#3366CC","#3366FF","#666600","#666633","#666666","#666699",
"#6666CC","#6666FF","#996600","#996633","#996666","#996699","#9966CC","#9966FF","#CC6600","#CC6633","#CC6666",
"#CC6699","#CC66CC","#CC66FF","#FF6600","#FF6633","#FF6666","#FF6699","#FF66CC","#FF66FF","#009900","#009933",
"#009966","#009999","#0099CC","#0099FF","#339900","#339933","#339966","#339999","#3399CC","#3399FF","#669900",
"#669933","#669966","#669999","#6699CC","#6699FF","#999900","#999933","#999966","#999999","#9999CC","#9999FF",
"#CC9900","#CC9933","#CC9966","#CC9999","#CC99CC","#CC99FF","#FF9900","#FF9933","#FF9966","#FF9999","#FF99CC",
"#FF99FF","#00CC00","#00CC33","#00CC66","#00CC99","#00CCCC","#00CCFF","#33CC00","#33CC33","#33CC66","#33CC99",
"#33CCCC","#33CCFF","#66CC00","#66CC33","#66CC66","#66CC99","#66CCCC","#66CCFF","#99CC00","#99CC33","#99CC66",
"#99CC99","#99CCCC","#99CCFF","#CCCC00","#CCCC33","#CCCC66","#CCCC99","#CCCCCC","#CCCCFF","#FFCC00","#FFCC33",
"#FFCC66","#FFCC99","#FFCCCC","#FFCCFF","#00FF00","#00FF33","#00FF66","#00FF99","#00FFCC","#00FFFF","#33FF00",
"#33FF33","#33FF66","#33FF99","#33FFCC","#33FFFF","#66FF00","#66FF33","#66FF66","#66FF99","#66FFCC","#66FFFF",
"#99FF00","#99FF33","#99FF66","#99FF99","#99FFCC","#99FFFF","#CCFF00","#CCFF33","#CCFF66","#CCFF99","#CCFFCC",
"#CCFFFF","#FFFF00","#FFFF33","#FFFF66","#FFFF99","#FFFFCC","#FFFFFF");var total = colors.length;var width = 18;var cp_contents = "";var windowRef =(windowMode)?"window.opener.":"";if(windowMode){cp_contents += "<HTML><HEAD><TITLE>Select Color</TITLE></HEAD>";cp_contents += "<BODY MARGINWIDTH=0 MARGINHEIGHT=0 LEFTMARGIN=0 TOPMARGIN=0><CENTER>";}cp_contents += "<TABLE BORDER=1 CELLSPACING=1 CELLPADDING=0>";var use_highlight =(document.getElementById || document.all)?true:false;for(var i=0;i<total;i++){if((i % width) == 0){cp_contents += "<TR>";}if(use_highlight){var mo = 'onMouseOver="'+windowRef+'ColorPicker_highlightColor(\''+colors[i]+'\',window.document)"';}else{mo = "";}cp_contents += '<TD BGCOLOR="'+colors[i]+'"><FONT SIZE="-3"><A HREF="#" onClick="'+windowRef+'ColorPicker_pickColor(\''+colors[i]+'\','+windowRef+'window.popupWindowObjects['+cp.index+']);return false;" '+mo+' STYLE="text-decoration:none;">&nbsp;&nbsp;&nbsp;</A></FONT></TD>';if( ((i+1)>=total) ||(((i+1) % width) == 0)){cp_contents += "</TR>";}}if(document.getElementById){var width1 = Math.floor(width/2);var width2 = width = width1;cp_contents += "<TR><TD COLSPAN='"+width1+"' BGCOLOR='#ffffff' ID='colorPickerSelectedColor'>&nbsp;</TD><TD COLSPAN='"+width2+"' ALIGN='CENTER' ID='colorPickerSelectedColorValue'>#FFFFFF</TD></TR>";}cp_contents += "</TABLE>";if(windowMode){cp_contents += "</CENTER></BODY></HTML>";}cp.populate(cp_contents+"\n");cp.offsetY = 25;cp.autoHide();return cp;}
var cp = new ColorPicker('window'); 
</script>
</head>

<body bgcolor="#7F9274">
<?
if ($_SESSION["FlashCalendar"]=="logged") {

if ($ac=='save_settings') {
	$sql = "UPDATE $tableSETTINGS SET data_value='".str_replace("#","",$monthColor)."' WHERE data_key='monthColor' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "UPDATE $tableSETTINGS SET data_value='".str_replace("#","",$monthText)."' WHERE data_key='monthText' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "UPDATE $tableSETTINGS SET data_value='".str_replace("#","",$dayBackground)."' WHERE data_key='dayBackground' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "UPDATE $tableSETTINGS SET data_value='".str_replace("#","",$dayColor)."' WHERE data_key='dayColor' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "UPDATE $tableSETTINGS SET data_value='".str_replace("#","",$dayNumbers)."' WHERE data_key='dayNumbers' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "UPDATE $tableSETTINGS SET data_value='".str_replace("#","",$dayComment)."' WHERE data_key='dayComment' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "UPDATE $tableSETTINGS SET data_value='".str_replace("#","",$dayNoComment)."' WHERE data_key='dayNoComment' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "UPDATE $tableSETTINGS SET data_value='".str_replace("#","",$arrowCircle)."' WHERE data_key='arrowCircle' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "UPDATE $tableSETTINGS SET data_value='".str_replace("#","",$arrowColor)."' WHERE data_key='arrowColor' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);

	$sql = "UPDATE $tableSETTINGS SET data_value='$monthName1' WHERE data_key='monthName1' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "UPDATE $tableSETTINGS SET data_value='$monthName2' WHERE data_key='monthName2' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "UPDATE $tableSETTINGS SET data_value='$monthName3' WHERE data_key='monthName3' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "UPDATE $tableSETTINGS SET data_value='$monthName4' WHERE data_key='monthName4' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "UPDATE $tableSETTINGS SET data_value='$monthName5' WHERE data_key='monthName5' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "UPDATE $tableSETTINGS SET data_value='$monthName6' WHERE data_key='monthName6' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "UPDATE $tableSETTINGS SET data_value='$monthName7' WHERE data_key='monthName7' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "UPDATE $tableSETTINGS SET data_value='$monthName8' WHERE data_key='monthName8' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "UPDATE $tableSETTINGS SET data_value='$monthName9' WHERE data_key='monthName9' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "UPDATE $tableSETTINGS SET data_value='$monthName10' WHERE data_key='monthName10' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "UPDATE $tableSETTINGS SET data_value='$monthName11' WHERE data_key='monthName11' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "UPDATE $tableSETTINGS SET data_value='$monthName12' WHERE data_key='monthName12' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);

	$sql = "UPDATE $tableSETTINGS SET data_value='$dayNames1' WHERE data_key='dayNames1' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "UPDATE $tableSETTINGS SET data_value='$dayNames2' WHERE data_key='dayNames2' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "UPDATE $tableSETTINGS SET data_value='$dayNames3' WHERE data_key='dayNames3' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "UPDATE $tableSETTINGS SET data_value='$dayNames4' WHERE data_key='dayNames4' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "UPDATE $tableSETTINGS SET data_value='$dayNames5' WHERE data_key='dayNames5' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "UPDATE $tableSETTINGS SET data_value='$dayNames6' WHERE data_key='dayNames6' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "UPDATE $tableSETTINGS SET data_value='$dayNames7' WHERE data_key='dayNames7' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);

	$sql = "UPDATE $tableSETTINGS SET data_value='$closePopUPMessage' WHERE data_key='closePopUPMessage' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "UPDATE $tableSETTINGS SET data_value='$startMonday' WHERE data_key='startMonday' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);

	if (ereg("^[0-9]+$", $width)) { 
		$sql = "UPDATE $tableSETTINGS SET data_value='$width' WHERE data_key='width' AND calendar_id='$cid'";
		$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	} else {
		$message = '<strong>Width should be integer</strong><br>';
	};
	$ac='settings'; $message .= '<strong>Calendar settings saved.</strong><br>';
} elseif ($ac=='save_data') {
	$sql = "SELECT * FROM $tableCALENDAR WHERE year='$year' AND month='$month' AND day='$day' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	if (mysql_num_rows($sql_result)>0) {
		$sql = "UPDATE $tableCALENDAR SET data='".mysql_escape_string($note)."', color='".str_replace("#","",$color)."' WHERE year='$year' AND month='$month' AND day='$day' AND calendar_id='$cid'";
		$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	} else {
		$sql = "INSERT INTO $tableCALENDAR VALUES ('$year', '$month', '$day', '".str_replace("#","",$color)."', '".mysql_escape_string($note)."', '$cid')";
		$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	};
	$ac='data'; $message = '<strong>Calendar data saved.</strong><br>';
} elseif ($ac=='del') {
	$sql = "DELETE FROM $tableCALENDAR WHERE calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "DELETE FROM $tableSETTINGS WHERE calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "DELETE FROM $tableCALENDARS WHERE id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$ac='calendars'; $message = '<strong>Calendar deleted.</strong><br>';

} elseif ($ac=='add') {
	$sql = "INSERT INTO $tableCALENDARS VALUES (null, '".mysql_escape_string($name)."')";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$cid = mysql_insert_id();
	$sql = "INSERT INTO $tableSETTINGS VALUES (null, 'monthColor', '3E4A22', '$cid')";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "INSERT INTO $tableSETTINGS VALUES (null, 'monthText', 'FFFFFF', '$cid')";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "INSERT INTO $tableSETTINGS VALUES (null, 'dayBackground', '7F9274', '$cid')";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "INSERT INTO $tableSETTINGS VALUES (null, 'dayColor', 'FFFFFF', '$cid')";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "INSERT INTO $tableSETTINGS VALUES (null, 'dayNumbers', '000000', '$cid')";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "INSERT INTO $tableSETTINGS VALUES (null, 'dayComment', 'DE8C00', '$cid')";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "INSERT INTO $tableSETTINGS VALUES (null, 'dayNoComment', 'CCCC99', '$cid')";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "INSERT INTO $tableSETTINGS VALUES (null, 'width', '300', '$cid')";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('arrowCircle','DDEE11','$cid');";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('arrowColor','AA3344','$cid');";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);

			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('monthName1','January','$cid');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('monthName2','February','$cid');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('monthName3','March','$cid');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('monthName4','April','$cid');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('monthName5','May','$cid');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('monthName6','June','$cid');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('monthName7','July','$cid');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('monthName8','August','$cid');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('monthName9','September','$cid');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('monthName10','October','$cid');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('monthName11','November','$cid');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('monthName12','December','$cid');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);

			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('closePopUPMessage','Close','$cid');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('startMonday','true','$cid');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);

			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('dayNames1','S','$cid');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('dayNames2','M','$cid');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('dayNames3','T','$cid');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('dayNames4','W','$cid');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('dayNames5','T','$cid');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('dayNames6','F','$cid');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('dayNames7','S','$cid');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);


	$ac='calendars'; $message = '<strong>Calendar added.</strong><br>';
};

?>
<table width="780" height="31" border="0" cellpadding="0" cellspacing="0" bgcolor="26619E" style="border-bottom:2px solid #373737">
  <tr align="center">
    <td width="100" bgcolor="#A6B39D"><a href="calendar-admin.php?ac=calendars" style="color:#FFFFFF"><strong>Calendars</strong></a></td>
    <td width="100" bgcolor="#A6B39D"><a href="calendar-admin.php?ac=new" style="color:#FFFFFF"><strong>New</strong></a></td>
    <td align="right" bgcolor="#A6B39D"><a href="calendar-admin.php?ac=logout" style="color:#FFFFFF"><strong>LOGOUT</strong></a>&nbsp;&nbsp;</td>
  </tr>
</table>

<?
if ($ac=='html' OR $ac=='data' OR $ac=='settings') {
	$sql = "SELECT * FROM $tableCALENDARS WHERE id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result);
?>
<table width="780" height="31" border="0" cellpadding="0" cellspacing="0" bgcolor="26619E" style="border-bottom:2px solid #373737">
  <tr align="center">
    <td width="100" bgcolor="#C4CCBD"><a href="calendar-admin.php?ac=data&cid=<? echo $cid; ?>" style="color:#000000"><strong>Data</strong></a></td>
    <td width="100" bgcolor="#C4CCBD"><a href="calendar-admin.php?ac=settings&cid=<? echo $cid; ?>" style="color:#000000"><strong>Settings</strong></a></td>
    <td width="100" bgcolor="#C4CCBD"><a href="calendar-admin.php?ac=html&cid=<? echo $cid; ?>" style="color:#000000"><strong>HTML code </strong></a></td>
    <td align="left" bgcolor="#C4CCBD" style="padding-left:5px">Calendar: <? echo stripslashes(utf8_decode($CALENDAR["name"])); ?></td>
  </tr>
</table>
<?
};
?>

<table width="780" height="31" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border-bottom:2px solid #373737">
<tr><td align="left" valign="top" style="padding:20px">
<? echo $message; ?>

<?
if ($ac=='calendars') {
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="494" valign="top" bgcolor="#DFE4E8"><strong>Calendar title </strong></td>
    <td bgcolor="#DFE4E8" colspan="4">&nbsp;</td>
  </tr>
  <?
	$sql = "SELECT * FROM $tableCALENDARS ORDER BY name ASC";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	while ($CALENDAR = mysql_fetch_assoc($sql_result)) {
?>
  <tr>
    <td style="border-bottom:1px solid #DFE4E8"><? echo stripslashes(utf8_decode($CALENDAR["name"])); ?></td>
    <td width="57" align="left" style="border-bottom:1px solid #DFE4E8"><a href='calendar-admin.php?ac=data&cid=<? echo $CALENDAR["id"]; ?>'><strong>Data</strong></a></td>
    <td width="57" align="left" style="border-bottom:1px solid #DFE4E8"><a href='calendar-admin.php?ac=settings&cid=<? echo $CALENDAR["id"]; ?>'><strong>Settings</strong></a></td>
    <td width="95" align="left" style="border-bottom:1px solid #DFE4E8"><a href='calendar-admin.php?ac=html&cid=<? echo $CALENDAR["id"]; ?>'><strong>HTML code </strong></a></td>
    <td width="68" align="left" style="border-bottom:1px solid #DFE4E8"><a href='#' onclick='pass=confirm("Are you sure you want to delete it?",""); if (pass) window.location="calendar-admin.php?ac=del&cid=<? echo $CALENDAR["id"]; ?>";'><strong style='color:red'>DELETE</strong></a></td>
  </tr>
  <?
	};
?>
</table>
<?
} elseif ($ac=='new') {
?>
<form action="calendar-admin.php" method="post">
<input type="hidden" name="ac" value="add" />
Calendar title: <input type="text" name="name" value="" size="50" maxlength="250" /><br />
<input name="submit" type="submit" value="Create calendar" />
</form>
<?
} elseif ($ac=='html') {
	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='width' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result);
?>
Copy and paste the code below on your web page. Please, make sure that you have the calendar.swf and calendar-data.php files in the same folder where the web page is.
<textarea name="textarea" cols="135" rows="12" class="bodytext"><?
$height = ceil($CALENDAR["data_value"] * 5 / 6);
?>
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="<? echo $CALENDAR["data_value"]; ?>" height="<? echo $height; ?>" align="middle">
<param name="allowScriptAccess" value="sameDomain" />
<param name="movie" value="calendar.swf?link=calendar-data.php&cid=<? echo $cid; ?>&owner=phpjabbers.com" /><param name="quality" value="high" />
<param name="bgcolor" value="#FFFFFF" />
<embed src="calendar.swf?link=calendar-data.php&cid=<? echo $cid; ?>&owner=phpjabbers.com" quality="high" bgcolor="#FFFFFF" width="<? echo $CALENDAR["data_value"]; ?>" height="<? echo $height; ?>" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object></textarea>
<?	
} elseif ($ac=='data') {
if (!isset($year) OR !isset($month) OR !isset($day)) {
	$year = date("Y");
	$month = date("n")-1;
	$day = date("j");
};
$date = "<strong style='color:red'>".date("dS \of F Y", mktime(0, 0, 0, $month+1, $day, $year))."</strong>";
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="400" valign="top" class="bodytext">
	<form action="calendar-admin.php" method="post" style="margin:0px; padding:0px" name="frm">
	<input type="hidden" name="ac" value="save_data" />
    <input type="hidden" name="cid" value="<? echo $cid; ?>" />
	<table width="100%" border="0" cellspacing="4" cellpadding="5">
      <tr>
        <td bgcolor="#DFE4E8" class="bodytext" style="border:1px solid #5D5D5D"><strong>Step 1</strong> - select date and press update<br />
		Date: 
          <select name="month" class="bodytext" id="month">
<?
		  for ($i=0; $i<12; $i++) {
		  	if ($month==$i) { $selected=' selected="selected"'; } else { $selected=''; };
		  	echo '<option value="'.$i.'"'.$selected.'>'.$monthnames_arr[$i].'</option>';
		  };
?>
          </select>
          <select name="day" class="bodytext" id="day">
		  <?
		  for ($i=1; $i<32; $i++) {
		  	if ($day==$i) { $selected=' selected="selected"'; } else { $selected=''; };
		  	echo '<option value="'.$i.'"'.$selected.'>'.$i.'</option>';
		  };
		  ?>
			</select>
          <select name="year" class="bodytext" id="year">
		  <?
		  for ($i=2005; $i<2011; $i++) {
		  	if ($year==$i) { $selected=' selected="selected"'; } else { $selected=''; };
		  	echo '<option value="'.$i.'"'.$selected.'>'.$i.'</option>';
		  };
		  ?>
          </select>
          <input type="submit" name="Submit" value="Update" onclick="document.frm.ac.value='data'"/></td>
      </tr>
<?
$sql = "SELECT * FROM $tableCALENDAR WHERE year='$year' AND month='$month' AND day='$day' AND calendar_id='$cid'";
$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
$data = mysql_fetch_assoc($sql_result);
$note = stripslashes($data["data"]);
$open = "&openyear=$year&openmonth=$month";
?>
      <tr>
        <td valign="top" bgcolor="#DFE4E8" class="bodytext" style="border:1px solid #5D5D5D"><strong>Step 2</strong> - add note for <? echo $date; ?><br />
		 
		  Set custom color for this date: 
		    <input name="color" type="text" value="<? echo $data["color"]; ?>" size="7" maxlength="7" />            
		  <a href="#" onclick="cp.select(frm.color,'pick2');return false;" name="pick2" id="pick2">select colour</a>
		 <br />Note: <br />
          <textarea name="note" cols="65" rows="10" class="bodytext" id="note"><? echo $note; ?></textarea></td>
      </tr>
      
      <tr>
        <td bgcolor="#DFE4E8" class="bodytext" style="border:1px solid #5D5D5D">
          <input type="submit" name="Submit" value="Save" />        </td>
      </tr>
    </table>
	</form>	</td>
    <td align="center">
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="270" height="225" align="middle">
<param name="allowScriptAccess" value="sameDomain" />
<param name="movie" value="calendar.swf?link=calendar-data.php&cid=<? echo $cid; ?><? echo $open; ?>&owner=phpjabbers.com" /><param name="quality" value="high" />
<param name="bgcolor" value="#FFFFFF" />
<embed src="calendar.swf?link=calendar-data.php&cid=<? echo $cid; ?><? echo $open; ?>&owner=phpjabbers.com" quality="high" bgcolor="#FFFFFF" width="270" height="225" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>	</td>
  </tr>
</table>

<?
} elseif ($ac=='settings') {
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="400" valign="top" class="bodytext">
	<form action="calendar-admin.php" method="post" name="frm" id="frm" style="margin:0px; padding:0px">
      <input type="hidden" name="ac" value="save_settings" />
      <input type="hidden" name="cid" value="<? echo $cid; ?>" />
      <table width="100%" border="0" cellspacing="4" cellpadding="5">
        <tr>
          <td bgcolor="#DFE4E8" class="bodytext" style="border:1px solid #5D5D5D"><strong>Step 1</strong> - choose colors<br />
<?
	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='monthColor' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result);
?>
            Month background
            <input name="monthColor" type="text" class="bodytext" id="monthColor" size="7" maxlength="7" value="<? echo $CALENDAR["data_value"]; ?>" />
            <a href="#" onclick="cp.select(frm.monthColor,'pick2');return false;" name="pick2" id="pick2">select colour</a><br />
<?
	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='monthText' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result);
?>
			Month title
			<input name="monthText" type="text" class="bodytext" id="monthText" size="7" maxlength="7" value="<? echo $CALENDAR["data_value"]; ?>" />
			<a href="#" onclick="cp.select(frm.monthText,'pick2');return false;" name="pick2" id="pick2">select colour</a> <br />
<?
	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='dayBackground' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result);
?>
			Days background
			<input name="dayBackground" type="text" class="bodytext" id="dayBackground" size="7" maxlength="7" value="<? echo $CALENDAR["data_value"]; ?>" />
			<a href="#" onclick="cp.select(frm.dayBackground,'pick2');return false;" name="pick2" id="pick2">select colour</a> <br />
<?
	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='dayColor' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result);
?>
			Days titles
			<input name="dayColor" type="text" class="bodytext" id="dayColor" size="7" maxlength="7" value="<? echo $CALENDAR["data_value"]; ?>" />
			<a href="#" onclick="cp.select(frm.dayColor,'pick2');return false;" name="pick2" id="pick2">select colour</a> <br />
<?
	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='dayNumbers' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result);
?>
			Day number
			<input name="dayNumbers" type="text" class="bodytext" id="dayNumbers" size="7" maxlength="7" value="<? echo $CALENDAR["data_value"]; ?>" />
			<a href="#" onclick="cp.select(frm.dayNumbers,'pick2');return false;" name="pick2" id="pick2">select colour</a> <br />
<?
	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='dayComment' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result);
?>
			Days with events 
			<input name="dayComment" type="text" class="bodytext" id="dayComment" size="7" maxlength="7" value="<? echo $CALENDAR["data_value"]; ?>" />
			<a href="#" onclick="cp.select(frm.dayComment,'pick2');return false;" name="pick2" id="pick2">select colour</a> <br />
<?
	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='dayNoComment' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result);
?>
			Days without events
			<input name="dayNoComment" type="text" class="bodytext" id="dayNoComment" size="7" maxlength="7" value="<? echo $CALENDAR["data_value"]; ?>" />
			<a href="#" onclick="cp.select(frm.dayNoComment,'pick2');return false;" name="pick2" id="pick2">select colour</a> <br />
<?
	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='arrowCircle' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result);
?> Navigation arrow circle 
<input name="arrowCircle" type="text" class="bodytext" id="arrowCircle" size="7" maxlength="7" value="<? echo $CALENDAR["data_value"]; ?>" />
			<a href="#" onclick="cp.select(frm.arrowCircle,'pick2');return false;" name="pick2" id="pick2">select colour</a> <br />
<?
	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='arrowColor' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result);
?> Navigation arrow 
<input name="arrowColor" type="text" class="bodytext" id="arrowColor" size="7" maxlength="7" value="<? echo $CALENDAR["data_value"]; ?>" />
			<a href="#" onclick="cp.select(frm.arrowColor,'pick2');return false;" name="pick2" id="pick2">select colour</a>            </td>
        </tr>
        <tr>
          <td bgcolor="#DFE4E8" class="bodytext" style="border:1px solid #5D5D5D"><strong>Step 2</strong> - calendar titles <br />
		  Notes `close` message:  <?
	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='closePopUPMessage' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result);
?>  
<input name="closePopUPMessage" type="text" class="bodytext" id="closePopUPMessage" size="20" maxlength="20" value="<? echo $CALENDAR["data_value"]; ?>" />


<br />
		  <table width="100%" border="0" cellspacing="0" cellpadding="1">
            <tr>
              <td colspan="4"><em>Translate in your language</em> </td>
              </tr>
            <tr>
              <td width="13%">January:</td>
              <td width="40%"><?
	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='monthName1' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result);
?>
                <input name="monthName1" type="text" class="bodytext" id="monthName1" size="20" maxlength="20" value="<? echo $CALENDAR["data_value"]; ?>" /></td>
              <td><strong>S</strong>unday</td>
              <td><?
	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='dayNames1' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result);
?>
                <input name="dayNames1" type="text" class="bodytext" id="dayNames1" size="1" maxlength="1" value="<? echo $CALENDAR["data_value"]; ?>" /></td>
            </tr>
            <tr>
              <td>February:</td>
              <td><?
	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='monthName2' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result);
?>
                <input name="monthName2" type="text" class="bodytext" id="monthName2" size="20" maxlength="20" value="<? echo $CALENDAR["data_value"]; ?>" /></td>
              <td width="15%"><strong>M</strong>onday</td>
              <td width="32%"><?
	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='dayNames2' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result);
?>
                <input name="dayNames2" type="text" class="bodytext" id="dayNames2" size="1" maxlength="1" value="<? echo $CALENDAR["data_value"]; ?>" /></td>
            </tr>
            <tr>
              <td>March:</td>
              <td><?
	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='monthName3' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result);
?>
                <input name="monthName3" type="text" class="bodytext" id="monthName3" size="20" maxlength="20" value="<? echo $CALENDAR["data_value"]; ?>" /></td>
              <td><strong>T</strong>uesday</td>
              <td><?
	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='dayNames3' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result);
?>
                <input name="dayNames3" type="text" class="bodytext" id="dayNames3" size="1" maxlength="1" value="<? echo $CALENDAR["data_value"]; ?>" /></td>
            </tr>
            <tr>
              <td>April:</td>
              <td><?
	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='monthName4' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result);
?>
                <input name="monthName4" type="text" class="bodytext" id="monthName4" size="20" maxlength="20" value="<? echo $CALENDAR["data_value"]; ?>" /></td>
              <td><strong>W</strong>endesday</td>
              <td><?
	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='dayNames4' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result);
?>
                <input name="dayNames4" type="text" class="bodytext" id="dayNames4" size="1" maxlength="1" value="<? echo $CALENDAR["data_value"]; ?>" /></td>
            </tr>
            <tr>
              <td>May:</td>
              <td><?
	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='monthName5' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result);
?>
                <input name="monthName5" type="text" class="bodytext" id="monthName5" size="20" maxlength="20" value="<? echo $CALENDAR["data_value"]; ?>" /></td>
              <td><strong>T</strong>hursday</td>
              <td><?
	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='dayNames5' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result);
?>
                <input name="dayNames5" type="text" class="bodytext" id="dayNames5" size="1" maxlength="1" value="<? echo $CALENDAR["data_value"]; ?>" /></td>
            </tr>
            <tr>
              <td>June:</td>
              <td><?
	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='monthName6' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result);
?>
                <input name="monthName6" type="text" class="bodytext" id="monthName6" size="20" maxlength="20" value="<? echo $CALENDAR["data_value"]; ?>" /></td>
              <td><strong>F</strong>riday</td>
              <td><?
	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='dayNames6' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result);
?>
                <input name="dayNames6" type="text" class="bodytext" id="dayNames6" size="1" maxlength="1" value="<? echo $CALENDAR["data_value"]; ?>" /></td>
            </tr>
            <tr>
              <td>July:</td>
              <td><?
	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='monthName7' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result);
?>
                <input name="monthName7" type="text" class="bodytext" id="monthName7" size="20" maxlength="20" value="<? echo $CALENDAR["data_value"]; ?>" /></td>
              <td><strong>S</strong>aturday</td>
              <td><?
	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='dayNames7' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result);
?>
                <input name="dayNames7" type="text" class="bodytext" id="dayNames7" size="1" maxlength="1" value="<? echo $CALENDAR["data_value"]; ?>" /></td>
            </tr>
            <tr>
              <td>August:</td>
              <td><?
	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='monthName8' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result);
?>
                <input name="monthName8" type="text" class="bodytext" id="monthName8" size="20" maxlength="20" value="<? echo $CALENDAR["data_value"]; ?>" /></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>September:</td>
              <td><?
	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='monthName9' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result);
?>
                <input name="monthName9" type="text" class="bodytext" id="monthName9" size="20" maxlength="20" value="<? echo $CALENDAR["data_value"]; ?>" /></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>October:</td>
              <td><?
	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='monthName10' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result);
?>
                <input name="monthName10" type="text" class="bodytext" id="monthName10" size="20" maxlength="20" value="<? echo $CALENDAR["data_value"]; ?>" /></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>November:</td>
              <td><?
	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='monthName11' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result);
?>
                <input name="monthName11" type="text" class="bodytext" id="monthName11" size="20" maxlength="20" value="<? echo $CALENDAR["data_value"]; ?>" /></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>December:</td>
              <td><?
	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='monthName12' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result);
?>
                <input name="monthName12" type="text" class="bodytext" id="monthName12" size="20" maxlength="20" value="<? echo $CALENDAR["data_value"]; ?>" /></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td bgcolor="#DFE4E8" class="bodytext" style="border:1px solid #5D5D5D"><strong>Step 3 </strong><br>
<?
	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='startMonday' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result);
?>
		 Week starts from 
		   <input name="startMonday" type="radio" value="false" <? if ($CALENDAR["data_value"]=='false') echo 'checked="checked" '; ?>/>
		   Sunday or <input name="startMonday" type="radio" value="true" <? if ($CALENDAR["data_value"]=='true') echo 'checked="checked" '; ?>/>Monday  
            
		  <br>
<?
	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='width' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result);
?>
		  Calendar width 
            <input name="width" type="text" class="bodytext" id="width" size="3" maxlength="3" value="<? echo $CALENDAR["data_value"]; ?>" />
            pixels </td>
        </tr>
        <tr>
          <td bgcolor="#DFE4E8" class="bodytext" style="border:1px solid #5D5D5D"><input type="submit" name="Submit3" value="Save" />          </td>
        </tr>
      </table>
    </form></td>
    <td align="center" valign="top">
<?
$height = ceil($CALENDAR["data_value"] * 5 / 6);
?>
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="<? echo $CALENDAR["data_value"]; ?>" height="<? echo $height; ?>" align="middle">
      <param name="allowScriptAccess" value="sameDomain" />
      <param name="movie" value="calendar.swf?link=calendar-data.php&cid=<? echo $cid; ?>&owner=phpjabbers.com" />
      <param name="quality" value="high" />
      <param name="bgcolor" value="#FFFFFF" />
      <embed src="calendar.swf?link=calendar-data.php&cid=<? echo $cid; ?>&owner=phpjabbers.com" quality="high" bgcolor="#FFFFFF" width="<? echo $CALENDAR["data_value"]; ?>" height="<? echo $height; ?>" align="middle" allowscriptaccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" /></embed>
    </object></td>
  </tr>
</table>
<?
} elseif ($ac=='search') {
?>
Search
<?
};
?>


</td>
</tr></table>

<?
} else { /////////// LOGIN BOX
?>
<center>
          <form action="calendar-admin.php" method="post">
            <input type="hidden" name="ac" value="login">
            <table width="300" border="0" cellpadding="4" cellspacing="0" bordercolor="#000000" bgcolor="#EDEFF1">
              <tr align="center">
                <td colspan="2"><? echo $message; ?></td>
              </tr>
              <tr align="center" bgcolor="#FD9003">
                <td colspan="2" bgcolor="#A6B39D" class="white">Admin login </td>
              </tr>
              <tr>
                <td width="91">Username:</td>
                <td width="193"><input name="user" type="text" id="user" size="15"></td>
              </tr>
              <tr>
                <td>Password:</td>
                <td><input name="pass" type="password" id="pass" size="15"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="Submit" value="Login"></td>
              </tr>
            </table>
          </form>
</center>
<?
};
?>
</body>
</html>
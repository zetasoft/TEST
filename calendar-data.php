<?
$hostname = 'localhost';  /////// MySQL server, usually `localhost`. It can also be IP address, or valid domain name
$mysql_user='calen';  ////////////// username for MySQL server
$mysql_pass='neil';  ////////////// password for MySQL server
$mysql_database='calendb'; //////////// MySQL database name

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
$monthnames_arr = Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

//////////////////////
//////////////////////
///  GENERATE XML ////
//////////////////////
//////////////////////
	header("Content-type: text/xml; charset=UTF-8"); 
?>
<calendar>
	<settings>
<?	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='monthColor' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result); ?>
		<monthColor>0x<? echo $CALENDAR["data_value"]; ?></monthColor>
<?	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='monthText' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result); ?>
		<monthText>0x<? echo $CALENDAR["data_value"]; ?></monthText>
<?	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='dayBackground' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result); ?>
		<dayBackground>0x<? echo $CALENDAR["data_value"]; ?></dayBackground>
<?	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='dayColor' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result); ?>
		<dayColor>0x<? echo $CALENDAR["data_value"]; ?></dayColor>
<?	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='dayNumbers' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result); ?>
		<dayNumbers>0x<? echo $CALENDAR["data_value"]; ?></dayNumbers>
<?	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='dayComment' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result); ?>
		<dayComment>0x<? echo $CALENDAR["data_value"]; ?></dayComment>
<?	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='dayNoComment' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result); ?>
		<dayNoComment>0x<? echo $CALENDAR["data_value"]; ?></dayNoComment>
<?	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='arrowCircle' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result); ?>
		<arrowCircle>0x<? echo $CALENDAR["data_value"]; ?></arrowCircle>
<?	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='arrowColor' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result); ?>
		<arrowColor>0x<? echo $CALENDAR["data_value"]; ?></arrowColor>

		<monthNames>
<?	
	for ($i=1; $i<13; $i++) {
	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='monthName".$i."' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result); ?>
			<name><? echo $CALENDAR["data_value"]; ?></name>
<? }; ?>			
		</monthNames>

<?	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='startMonday' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result); ?>
		<dayNames startMonday="<? echo $CALENDAR["data_value"]; ?>">
<?	
	for ($i=1; $i<13; $i++) {
	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='dayNames".$i."' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result); ?>
			<name><? echo $CALENDAR["data_value"]; ?></name>
<? }; ?>			
		</dayNames>
<?	$sql = "SELECT * FROM $tableSETTINGS WHERE data_key='closePopUPMessage' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	$CALENDAR = mysql_fetch_assoc($sql_result); ?>
		<closePopUPMessage><? echo $CALENDAR["data_value"]; ?></closePopUPMessage>


	</settings>
<?
	$month--;
	$sql = "SELECT * FROM $tableCALENDAR WHERE year='$year' AND month='$month' AND calendar_id='$cid'";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	while ($row = mysql_fetch_assoc($sql_result)) {
		if ($row["data"]<>'') {
			if ($row["color"]<>'') { $color=' color="0x'.$row["color"].'"'; } else { $color=''; };
			echo "\t\t\t".'<day day="'.$row["day"].'"'.$color.'>'.nl2br(stripslashes($row["data"])).'</day>'."\n";
		};
	};
	echo "\t\t\t".'<day day="99"></day>'."\n";
?>

</calendar>
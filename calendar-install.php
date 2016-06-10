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
?>
<html>
<head>
<title>Web Calendar - Installation</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
</head>
<body bgcolor="#7F9274">
<center>
<table width="780" height="31" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border-bottom:2px solid #373737">
<tr>
  <td align="left" valign="top" style="padding:20px">
<?
if (!isset($step)) {
?>
<form action="calendar-install.php" method="post">
<input type="hidden" name="step" value="2" />
<table width="550" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td colspan="2"><strong>These are the login details that Web Calendar will use to install and run: </strong></td>
        </tr>
      <tr>
        <td width="119">Hostname:</td>
        <td width="423"><? echo $hostname; ?></td>
      </tr>
      <tr>
        <td>MySQL database name: </td>
        <td><? echo $mysql_database; ?></td>
      </tr>
      <tr>
        <td>MySQL username: </td>
        <td><? echo $mysql_user; ?></td>
      </tr>
      <tr>
        <td>MySQL password: </td>
        <td><? echo $mysql_pass; ?></td>
      </tr>
      <tr>
        <td colspan="2">If this is correct click on 
          <input type="submit" name="Submit" value="Install" /> 
          button or edit the calendar-install.php file and set the correct login details. The script will try to connect to your MySQL server and create 2 database tables used by the web calendar. </td>
        </tr>
    </table>
</form>	
<?
} elseif ($step=='2') {

	$connection = mysql_connect($hostname, $mysql_user, $mysql_pass);
	if (!$connection) {
		echo "Unable to connect to MySQL server. Please, check your login details! <br><strong>error message: " . mysql_error()."</strong>";
	} else {
		$db = mysql_select_db($mysql_database, $connection);;
		if (!$db) {
			echo "Unable to select database. Please check database name.";
		} else {

			$sql = "DROP TABLE IF EXISTS `$tableCALENDARS`;";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			
			$sql = "CREATE TABLE `$tableCALENDARS` (   
                         `id` int(11) NOT NULL auto_increment,  
                         `name` varchar(250) default NULL,      
                         PRIMARY KEY  (`id`)                    
                       ) TYPE=MyISAM";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);

			$sql = "INSERT INTO $tableCALENDARS VALUES (null, 'Demo calendar')";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);


			$sql = "DROP TABLE IF EXISTS `$tableSETTINGS`;";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);

			$sql = "CREATE TABLE `$tableSETTINGS` (      
                        `id` int(11) NOT NULL auto_increment,    
                        `data_key` varchar(250) default NULL,    
                        `data_value` varchar(250) default NULL,  
						`calendar_id` int(11) default NULL,
                        PRIMARY KEY  (`id`)                      
                      ) TYPE=MyISAM";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			

			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('monthColor','3E4A22','1');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('monthText','FFFFFF','1');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('dayBackground','7F9274','1');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('dayColor','FFFFFF','1');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('dayNumbers','000000','1');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('dayComment','DE8C00','1');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('dayNoComment','CCCC99','1');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('arrowCircle','DDEE11','1');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('arrowColor','AA3344','1');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);

			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('width','200','1');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);

			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('monthName1','January','1');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('monthName2','February','1');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('monthName3','March','1');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('monthName4','April','1');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('monthName5','May','1');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('monthName6','June','1');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('monthName7','July','1');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('monthName8','August','1');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('monthName9','September','1');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('monthName10','October','1');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('monthName11','November','1');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('monthName12','December','1');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);

			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('closePopUPMessage','Close','1');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('startMonday','true','1');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);

			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('dayNames1','S','1');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('dayNames2','M','1');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('dayNames3','T','1');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('dayNames4','W','1');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('dayNames5','T','1');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('dayNames6','F','1');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			$sql = "insert into `$tableSETTINGS` (`data_key`,`data_value`, `calendar_id`) values ('dayNames7','S','1');";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);

			$sql = "DROP TABLE IF EXISTS `$tableCALENDAR`;";
			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			
			$sql = "CREATE TABLE `$tableCALENDAR` (  
                    `year` int(11) default NULL,     
                    `month` int(11) default NULL,    
                    `day` int(11) default NULL,      
                    `color` varchar(250) default NULL,      
                    `data` text,                      
					`calendar_id` int(11) default NULL
                  ) TYPE=MyISAM";

			$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
			echo "Web calendar successfully installed. <a href='calendar-admin.php'>Login</a>.";
			mysql_close($connection);
		};
	};
?>




<?
};
?>	
	
	</td>
</tr>
</table>
</center>
</body>
</html>
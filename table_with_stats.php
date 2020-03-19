<html>
<body>
<head>
<style>
table.redTable {
  border: 2px solid #4AA4A0;
  background-color: #EEE7DB;
  width: 100%;
  text-align: center;
  border-collapse: collapse;
}
table.redTable td, table.redTable th {
  border: 1px solid #AAAAAA;
  padding: 3px 2px;
}
table.redTable tbody td {
  font-size: 13px;
}
table.redTable tr:nth-child(even) {
  background: #F5C8BF;
}
table.redTable thead {
  background: #000000;
}
table.redTable thead th {
  font-size: 19px;
  font-weight: bold;
  color: #003FFF;
  text-align: center;
  border-left: 2px solid #6B90A4;
}
table.redTable thead th:first-child {
  border-left: none;
}

table.redTable tfoot {
  font-size: 13px;
  font-weight: bold;
  color: #FFFFFF;
  background: #4A4343;
}
table.redTable tfoot td {
  font-size: 13px;
}
table.redTable tfoot .links {
  text-align: right;
}
table.redTable tfoot .links a{
  display: inline-block;
  background: #FFFFFF;
  color: #A40808;
  padding: 2px 8px;
  border-radius: 5px;
}
</style>
</head>
<?php 
$username = "lazy"; 
$password = "bum"; 
$database = "autospeak"; 
$mysqli = new mysqli("localhost", $username, $password, $database); 
$query = "SELECT client_nick,connections,time_spent,idle_time_spent,client_version,client_lastconnected FROM clients";
 
 
echo '<table class ="redTable" border="0" cellspacing="2" cellpadding="2"> 
      <tr> 
          <td> <font face="Arial">Nick</font> </td> 
          <td> <font face="Arial">Connections</font> </td> 
          <td> <font face="Arial">Time Spent</font> </td> 
          <td> <font face="Arial">Idle Time Spent</font> </td> 
          <td> <font face="Arial">Client Version</font> </td> 
          <td> <font face="Arial">Client Lastconnected</font> </td> 
      </tr>';
 
if ($result = $mysqli->query($query)) {
    while ($row = $result->fetch_assoc()) {
        $field1name = $row["client_nick"];
        $field2name = $row["connections"];
        $field3name = $row["time_spent"]/3600000;
        $field4name = $row["idle_time_spent"]/3600000;
        $field5name = $row["client_version"]; 
        $field6name = $row["client_lastconnected"]; 
 
        echo '<tr> 
                  <td>'.$field1name.'</td> 
                  <td>'.$field2name.'</td> 
                  <td>'.$field3name.'</td> 
                  <td>'.$field4name.'</td> 
                  <td>'.$field5name.'</td> 
                  <td>'.$field6name.'</td> 
              </tr>';
    }
    $result->free();
} 
?>
</body>
</html>

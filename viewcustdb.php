<?php
// Create connection
$con=mysqli_connect("db536766613.db.1and1.com","dbo536766613","IMCsql!s05","db536766613");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
} 

echo "<strong>CUSTOMERS (Table):</strong><p>";

$search1 = mysqli_query($con,"SELECT * FROM `Customer`");
$o = 0;

$arraylist = array();

?>

<head>
<style>
th,td {
    text-align: center;
}
</style>
</head>
<body>

<table class="display" cellspacing="0" width="100%">
    <thead  style="background-color: #848482; color: #ffffff;" >
		<tr>
          <th>First Name</th>
		  <th>Last Name</th>
		  <th>Customer ID</th> 
		  <th>Days Since Last Visit</th>
		  <th>Genre Preference</th>
		  <th>Number of Purchases</th>
		  <th>Total Purchase Value</th>
		  <th>Days Since Last Purchase</th>
		  <th>Items in Cart</th>
		  <th>Latest Item Added</th>
		</tr> 
    </thead>	

 <?php
while($row = mysqli_fetch_array($search1)) {
 echo '<tr>';
  echo '<td>' . $row['First'] . '</td>';
  $arraylist[$o][First] = $row['First'];
  echo '<td>' . $row['Last'] . '</td>';
  $arraylist[$o][Last] = $row['Last'];
  echo '<td>' . $row['Cust_id'] . '</td>';
  $arraylist[$o][Cust_id] = $row['Cust_id'];
  echo '<td>' . $row['VisitDays'] . '</td>';
  $arraylist[$o][VisitDays] = $row['VisitDays'];
  echo '<td>' . $row['Pref'] . '</td>';
  $arraylist[$o][Pref] = $row['Pref'];
  echo '<td>' . $row['PurchNum'] . '</td>';
  $arraylist[$o][PurchNum] = $row['PurchNum'];
  echo '<td>' . $row['PurchTot'] . '</td>';
  $arraylist[$o][PurchTot] = $row['PurchTot'];
  echo '<td>' . $row['PurchDays'] . '</td>';
  $arraylist[$o][PurchDays] = $row['PurchDays'];
  echo '<td>' . $row['CartItems'] . '</td>';
  $arraylist[$o][CartItems] = $row['CartItems'];
   echo '<td>' . $row['LastCart'] . '</td>';
  $arraylist[$o][LastCart] = $row['LastCart'];
 echo '</tr>';
 $o++;
 } 
 ?>
 
</table>

<p><strong>CUSTOMERS (Array):</strong><p>
<?php  

mysqli_close($con);

  echo "<pre>";
  print_r($arraylist);

?>

</body>


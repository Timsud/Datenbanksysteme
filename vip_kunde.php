<!DOCTYPE html>

<?php
  $user = 'a01277687';
  $pass = 'dbs17';
  $database = 'lab';
 
  // establish database connection
  $conn = oci_connect($user, $pass, $database);
  if (!$conn) exit;
?>
<html lang="de">
 <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Online Shop</title>


</head>
     <body>
    
                               <a class="navbar-brand" href="index.html">Hauptseite</a>
                            
                            <ul>
                                
                                
                                    
                               <li><a href="kunde.php">Kunde</a></li>     
                                <li><a href="lager.php">Lager</a></li> 
                                <li><a href="produkt.php">Produkt</a></li>
                                <li><a href="aktion.php">Aktion</a></li>
                                <li><a href="vip_kunde.php">VIP_Kunde</a></li>
                                <li><a href="einfache_kunde.php">Einfache_Kunde</a></li>
                                <li><a href="bestellung.php">Bestellung</a></li>
                                <li><a href="macht.php">Macht</a></li>
                                <li><a href="istgeschickt.php">Istgeschickt</a></li>
                                <li><a href="istgeliefert.php">Istgeliefert</a></li>
                                
                                    
                                </ul>
                               
                                 
        
    
          
    
                    <center><h1>VIP_Kunde </h1></center>
  <form id='insertform' action='vip_kunde.php' method='get'>
    Neue VIP-Kunde einfuegen:
 <table>
	<thead>
	 <tr>
        <th>VIP_ID</th>
        <th>Kunde_nr</th>
        <th>Summe_aller_Einkaeufe</th>
	 </tr>
  </thead>
	  <tbody>
	     <tr>
	        <td>  
	           <input id='VIP_ID' name='VIP_ID' type='number' size='20' value='<?php if (isset($_GET['VIP_ID'])) echo $_GET['VIP_ID']; ?>' />
            </td>
                <td> 
                   <input id='Kunde_nr' name='Kunde_nr' type='number' size='10' value='<?php if (isset($_GET['Kunde_nr'])) echo $_GET['Kunde_nr']; ?>' />
                </td>
		<td>
		   <input id='Summe_aller_Einkaeufe' name='Summe_aller_Einkaeufe' type='number' size='10' value='<?php if (isset($_GET['Summe_aller_Einkaeufe'])) echo $_GET['Summe_aller_Einkaeufe']; ?>' />
		</td>
           </tbody>
        </table>
        
        <input id='submit' type='submit' name='BUTTON' value='Insert!' />
        <input id='submit' type='submit' name='BUTTON' value='Delete!' />
      
  
  </form>


<?php
  //Handle insert
  if (isset($_GET['VIP_ID'])&&$_GET['BUTTON']=='Insert!') 
  {
    //Prepare insert statementd
    $sql = "INSERT INTO VIP_Kunde  VALUES('" . $_GET['VIP_ID'] . "','"  . $_GET['Kunde_nr'] . "','" . $_GET['Summe_aller_Einkaeufe'] . "')";
    //Parse and execute statement
    $insert = oci_parse($conn, $sql);
    oci_execute($insert);
    $conn_err=oci_error($conn);
    $insert_err=oci_error($insert);
    if(!$conn_err & !$insert_err){
	print("Successfully inserted");
 	print("<br>");
    }
    //Print potential errors and warnings
    else{
       print($conn_err);
       print_r($insert_err);
       print("<br>");
        print("<h3>Falsche Eingabe!</h3>");
    }
    oci_free_statement($insert);
  } 
                    
  if (isset($_GET['VIP_ID'])&&$_GET['BUTTON']=='Delete!') 
  {
      if($_GET['VIP_ID']!=NULL && $_GET['Kunde_nr']!=NULL && $_GET['Summe_aller_Einkaeufe']!=NULL){
    //Prepare insert statementd
    $sql = "DELETE FROM VIP_Kunde WHERE VIP_ID='". $_GET['VIP_ID'] ."' AND Kunde_nr='". $_GET['Kunde_nr'] ."' AND Summe_aller_Einkaeufe='". $_GET['Summe_aller_Einkaeufe'] ."' ";
    //Parse and execute statement
    $insert = oci_parse($conn, $sql);
    oci_execute($insert);
    $conn_err=oci_error($conn);
    $insert_err=oci_error($insert);
    if(!$conn_err & !$insert_err){
	print("Successfully deleted");
 	print("<br>");
    }
    //Print potential errors and warnings
    else{
       print($conn_err);
       print_r($insert_err);
       print("<br>");
    }
    oci_free_statement($insert);
        }else{   
      print("<br>");  
      print("<h3>Falsche Eingabe!</h3>");
      }  
  }
?>

<div>
  <form id='searchname' action='vip_kunde.php' method='get'>
    Suche Nachname einer Kunde nach VIP_ID:
      <input id='VIP_ID2' name='VIP_ID2' type='number' size='20' value='<?php if (isset($_GET['VIP_ID2'])) echo $_GET['VIP_ID2']; ?>' />
      <input id='submit' type='submit' value='Suchen' />
  </form>
</div>

<?php
  //Handle Stored Procedure
  if (isset($_GET['VIP_ID2']))
  {
	  //Call Stored Procedure	
      $vip_id = $_GET['VIP_ID2'];
	  $nachname='';
	  $sproc = oci_parse($conn, 'begin nach_vip(:p1, :p2); end;');
	  oci_bind_by_name($sproc, ':p1', $vip_id);
	  oci_bind_by_name($sproc, ':p2', $nachname, 20);
      oci_execute($sproc);
      
	  $conn_err=oci_error($conn);
	  $proc_err=oci_error($sproc);
	  if(!$conn_err && !$proc_err){
	     echo("<br><b>" . $vip_id . " hat Nachname " . $nachname . "</b><br>" );  // prints OUT parameter of stored procedure
      }
	  else{
	     //Print potential errors and warnings
	     print($conn_err);
	     print_r($proc_err);
    
	  }  
      	  oci_free_statement($sproc);
  }
  
  // clean up connections
  
?>                  

                    <br><br>
<form id='show' action='vip_kunde.php' method='get'>
<input type="hidden" name="show" value="show" />
<input type="submit" value="Alle VIP Kunde anzeigen"/>
</form>
                    
<?php 
if(isset($_GET['show'])||isset($_GET['search'])){
?>
<div>
    <form id='searchform' action='vip_kunde.php' method='get'>
      <a href='vip_kunde.php'>Alle VIP Kunde</a> ---
      Suche nach VIP_ID: 
      <input id='search' name='search' type='text' size='20' value='<?php if (isset($_GET['search'])) echo $_GET['search']; ?>' />
      <input id='submit' type='submit' value='Los!' />
    </form>
  </div>
<?php
  // check if search view of list view
  if (isset($_GET['search'])) {
    $sql = "SELECT * FROM VIP_Kunde WHERE VIP_ID like '%" . $_GET['search'] . "%'";
  } else {
    $sql = "SELECT * FROM VIP_Kunde";
  }
  // execute sql statement
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
?>
                    
                    <table>
 <thead>
   <tr>
   <th>VIP_ID</th>
   <th>Kunde_nr</th>
   <th>Summe_aller_Einkaeufe</th>
   </tr>
</thead>
    <tbody>
<?php
 while ($row = oci_fetch_assoc($stmt)) {
 echo "<tr>"; 
 echo "<td>" . $row['VIP_ID'] . "</td>";
 echo "<td>" . $row['KUNDE_NR'] . "</td>";
 echo "<td>" . $row['SUMME_ALLER_EINKAEUFE'] . "</td>"; 
 echo "</tr>";
 }
?>
     </tbody>
   </table>
<div>Insgesamt <?php echo oci_num_rows($stmt); ?> Kunden gefunden.</div>
                    <br><br><br>
<?php  oci_free_statement($stmt);
                    
                    oci_close($conn);
                    
?>


<?php 
                         
                        }
    ?>

    </body>
 </html>
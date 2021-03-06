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
                               
                                 
        
    
          
    
                    <center><h1>Aktion</h1></center>
  <form id='insertform' action='aktion.php' method='get'>
    Neue Aktion einfuegen:
 <table>
	  <thead>
	    <tr>
        <th>AktionsID</th>
        <th>Akt_V</th>
        <th>Akt_E</th>
        <th>ProduktID</th>
        <th>IDNummLager</th>
	    </tr>
	  </thead>
	  <tbody>
	     <tr>
	        <td>
	           <input id='AktionsID' name='AktionsID' type='number' size='20' value='<?php if (isset($_GET['AktionsID'])) echo $_GET['AktionsID']; ?>' />
                </td>
                <td>
                   <input id='Akt_V' name='Akt_V' type='text' size='10' value='<?php if (isset($_GET['Akt_V'])) echo $_GET['Akt_V']; ?>' />
                </td>
		<td>
		   <input id='Akt_E' name='Akt_E' type='text' size='10' value='<?php if (isset($_GET['Akt_E'])) echo $_GET['Akt_E']; ?>' />
        </td>
        <td>
		   <input id='ProduktID' name='ProduktID' type='number' size='20' value='<?php if (isset($_GET['ProduktID'])) echo $_GET['ProduktID']; ?>' />
		</td>
         <td>
		   <input id='IDNummLager' name='IDNummLager' type='number' size='20' value='<?php if (isset($_GET['IDNummLager'])) echo $_GET['IDNummLager']; ?>' />
		</td>
           </tbody>
        </table>
        
        <input id='submit' type='submit' name='BUTTON' value='Insert!' />
        <input id='submit' type='submit' name='BUTTON' value='Delete!' />
      
  
  </form>


<?php
  //Handle insert
  if (isset($_GET['AktionsID'])&&$_GET['BUTTON']=='Insert!') 
  {
    //Prepare insert statementd
    $sql = "INSERT INTO aktion VALUES('" . $_GET['AktionsID'] . "','"  . $_GET['Akt_V'] . "','" . $_GET['Akt_E'] . "','". $_GET['ProduktID'] . "','". $_GET['IDNummLager'] . "')";
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
                    
  if (isset($_GET['AktionsID'])&&$_GET['BUTTON']=='Delete!') 
  {
      if($_GET['AktionsID']!=NULL && $_GET['Akt_V']!=NULL && $_GET['Akt_E']!=NULL && $_GET['ProduktID']!=NULL && $_GET['IDNummLager']!=NULL){
    //Prepare insert statementd
    $sql = "DELETE FROM Aktion WHERE AktionsID='". $_GET['AktionsID'] ."' AND Akt_V='". $_GET['Akt_V'] ."' AND Akt_E='". $_GET['Akt_E'] ."' AND ProduktID='". $_GET['ProduktID'] ."' AND IDNummLager='". $_GET['IDNummLager'] ."'";
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

                    

                    <br><br>
<form id='show' action='aktion.php' method='get'>
<input type="hidden" name="show" value="show" />
<input type="submit" value="Alle Aktionen anzeigen"/>
</form>
                    
<?php 
if(isset($_GET['show'])||isset($_GET['search'])){
?>
<div>
    <form id='searchform' action='aktion.php' method='get'>
      <a href='aktion.php'>Alle Aktionen</a> ---
      Suche nach AktionsID: 
      <input id='search' name='search' type='text' size='20' value='<?php if (isset($_GET['search'])) echo $_GET['search']; ?>' />
      <input id='submit' type='submit' value='Los!' />
    </form>
  </div>
<?php
  // check if search view of list view
  if (isset($_GET['search'])) {
    $sql = "SELECT * FROM Aktion WHERE AktionsID like '%" . $_GET['search'] . "%'";
  } else {
    $sql = "SELECT * FROM Aktion";
  }
  // execute sql statement
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
?>
                    
                    <table>
    <thead>
      <tr>
        <th>AktionsID</th>
        <th>Akt_V</th>
        <th>Akt_E</th>
        <th>ProduktID</th>
        <th>IDNummLager</th>
      </tr>
    </thead>
    <tbody>
<?php
 while ($row = oci_fetch_assoc($stmt)) {
 echo "<tr>"; 
 echo "<td>" . $row['AKTIONSID'] . "</td>";
 echo "<td>" . $row['AKT_V'] . "</td>";
 echo "<td>" . $row['AKT_E'] . "</td>";
 echo "<td>" . $row['PRODUKTID'] . "</td>";
 echo "<td>" . $row['IDNUMMLAGER'] . "</td>"; 
 echo "</tr>";
 }
?>
    </tbody>
  </table>
<div>Insgesamt <?php echo oci_num_rows($stmt); ?> Aktionen gefunden.</div>
                    <br><br><br>
<?php  oci_free_statement($stmt);
                    
                    oci_close($conn);
                    
?>

<?php 
                         
                        }
    ?>

   </body>
</html>
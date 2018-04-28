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
                               
                          
          
          
    
                    <center><h1>Lager</h1></center>
 
  <form id='insertform' action='lager.php' method='get'>
    Neue Person einfuegen:
<table>
	  <thead>
	    <tr>
        <th>IDNummLager</th>
        <th>Land</th>
        <th>Stadt</th>
        <th>Strasse</th>
        <th>Geb_Nummer</th>
	    </tr>
	  </thead>
	  <tbody>
	     <tr>
	        <td>
	           <input id='IDNummLager' name='IDNummLager' type='number' size='10' value='<?php if (isset($_GET['IDNummLager'])) echo $_GET['IDNummLager']; ?>' />
                </td>
                <td>
                   <input id='Land' name='Land' type='text' size='20' value='<?php if (isset($_GET['Land'])) echo $_GET['Land']; ?>' />
                </td>
		<td>
		   <input id='Stadt' name='Stadt' type='text' size='20' value='<?php if (isset($_GET['Stadt'])) echo $_GET['Stadt']; ?>' />
        </td>
        
        <td>
            <input id='Strasse' name='Strasse' type='text' size='20' value='<?php if (isset($_GET['Strasse'])) echo $_GET['Strasse']; ?>' />
        </td>
		<td>
		   <input id='Geb_Nummer' name='Geb_Nummer' type='number' size='20' value='<?php if (isset($_GET['Geb_Nummer'])) echo $_GET['Geb_Nummer']; ?>' />
		</td>


           </tbody>
        </table>
        
         <input id='submit' type='submit' name='BUTTON' value='Insert!' />
         <input id='submit' type='submit' name='BUTTON' value='Delete!' />
      
  </form>



<?php
  //Handle insert
  if (isset($_GET['IDNummLager'])&&$_GET['BUTTON']=='Insert!') 
  {
    //Prepare insert statementd
    $sql = "INSERT INTO lager VALUES('". $_GET['IDNummLager'] . "','"  . $_GET['Land'] . "','" . $_GET['Stadt'] . "','"  . $_GET['Strasse'] . "','" . $_GET['Geb_Nummer'] . "')";
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
    if (isset($_GET['IDNummLager'])&&$_GET['BUTTON']=='Delete!')                 
    {
        if($_GET['IDNummLager']!=NULL && $_GET['Land']!=NULL && $_GET['Stadt']!=NULL  && $_GET['Strasse']!=NULL && $_GET['Geb_Nummer']!=NULL){
    //Prepare insert statementd
    $sql = "DELETE FROM lager WHERE IDNummLager='". $_GET['IDNummLager'] ."' AND Land='". $_GET['Land'] ."' AND Stadt='". $_GET['Stadt'] ."'  AND Strasse='". $_GET['Strasse'] ."' AND Geb_Nummer='". $_GET['Geb_Nummer'] ."' ";
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
  
                    <br>                    
  <form id='suchen' action='lager.php' method='get'>
<input type="hidden" name="bestellung" value="bestellung" />
<input type="submit" value="Alle Bestellungen anzeigen"/>
</form>
<?php
if(isset($_GET['bestellung'])){
    $sql = "SELECT * FROM istgeschickt";
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
    ?>
<table>
    <thead>
      <tr>
        <th>Bestellungsnummer</th>
        <th>IDNummLager</th>
      </tr>
    </thead>
    <tbody>
<?php
 while ($row = oci_fetch_assoc($stmt)) {
 echo "<tr>"; 
 echo "<td>" . $row['BESTELLUNGSNUMMER'] . "</td>";
 echo "<td>" . $row['IDNUMMLAGER'] . "</td>";
 echo "</tr>";
 }
?>
    </tbody>
  </table>
<div>Insgesamt <?php echo oci_num_rows($stmt); ?> Bestellungen gefunden!</div>                    
<?php
     oci_free_statement($stmt);   
}
    ?>



                                        <br><br>
<form id='show' action='lager.php' method='get'>
<input type="hidden" name="show" value="show" />
<input type="submit" value="Alle Lager anzeigen"/>
</form>
                    
<?php 
if(isset($_GET['show'])||isset($_GET['search'])){
?>
    <div>
    <form id='searchform' action='lager.php' method='get'>
      <a href='lager.php'>Alle Lager</a> ---
      Suche nach IDNummLager: 
      <input id='search' name='search' type='text' size='20' value='<?php if (isset($_GET['search'])) echo $_GET['search']; ?>' />
      <input id='submit' type='submit' value='Los!' />
    </form>
  </div>
<?php
  // check if search view of list view
  if (isset($_GET['search'])) {
    $sql = "SELECT * FROM lager WHERE IDNummLager like '%" . $_GET['search'] . "%'";
  } else {
    $sql = "SELECT * FROM lager";
  }
  // execute sql statement
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
?>
<table>
    <thead>
      <tr>
      <th>IDNummLager</th>
      <th>Land</th>
      <th>Stadt</th>
      <th>Strasse</th>
      <th>Geb_Nummer</th>
      </tr>
    </thead>
    <tbody>
<?php
 while ($row = oci_fetch_assoc($stmt)) {
 echo "<tr>"; 
 echo "<td>" . $row['IDNUMMLAGER'] . "</td>";
 echo "<td>" . $row['LAND'] . "</td>";
 echo "<td>" . $row['STADT'] . "</td>";
 echo "<td>" . $row['STRASSE'] . "</td>";
 echo "<td>" . $row['GEB_NUMMER'] . "</td>";
 echo "</tr>";
 }
?>
    </tbody>
  </table>
<div>Insgesamt <?php echo oci_num_rows($stmt); ?> Lager gefunden!</div>
                    <br><br><br>
<?php  oci_free_statement($stmt); 
                     oci_close($conn);
                                                }
                    ?>  
  
    
                                        <br><br>

          

  
  </body>
</html>
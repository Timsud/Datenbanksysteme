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
                               
                                 
        
    
          
    
                    <center><h1>Produkt </h1></center>
  <form id='insertform' action='produkt.php' method='get'>
    Neue Produkt einfuegen:
 <table>
	<thead>
	 <tr>
        <th>ProduktID</th>
        <th>Anz_produkte</th>
        <th>Preis</th>
        <th>Kategorie</th>
        <th>IDNummLager</th>
        <th>Bestellungsnummer</th>
	 </tr>
  </thead>
	  <tbody>
	     <tr>
	        <td>  
	           <input id='ProduktID' name='ProduktID' type='number' size='20' value='<?php if (isset($_GET['ProduktID'])) echo $_GET['ProduktID']; ?>' />
            </td>
                <td>
                   <input id='Anz_produkte' name='Anz_produkte' type='number' size='10' value='<?php if (isset($_GET['Anz_produkte'])) echo $_GET['Anz_produkte']; ?>' />
                </td>
		<td>
		   <input id='Preis' name='Preis' type='number' size='10' value='<?php if (isset($_GET['Preis'])) echo $_GET['Preis']; ?>' />
		</td>
		<td>
		   <input id='Kategorie' name='Kategorie' type='text' size='20' value='<?php if (isset($_GET['Kategorie'])) echo $_GET['Kategorie']; ?>' />
        </td>
        <td>
		   <input id='IDNummLager' name='IDNummLager' type='number' size='20' value='<?php if (isset($_GET['IDNummLager'])) echo $_GET['IDNummLager']; ?>' />
        </td>
        <td>
		   <input id='Bestellungsnummer' name='Bestellungsnummer' type='number' size='20' value='<?php if (isset($_GET['Bestellungsnummer'])) echo $_GET['Bestellungsnummer']; ?>' />
		</td>
           </tbody>
        </table>
        
        <input id='submit' type='submit' name='BUTTON' value='Insert!' />
        <input id='submit' type='submit' name='BUTTON' value='Delete!' />
      
  
  </form>


<?php
  //Handle insert
  if (isset($_GET['ProduktID'])&&$_GET['BUTTON']=='Insert!') 
  {
    //Prepare insert statementd
    $sql = "INSERT INTO produkt  VALUES('" . $_GET['ProduktID'] . "','"  . $_GET['Anz_produkte'] . "','" . $_GET['Preis'] . "','". $_GET['Kategorie'] . "', '". $_GET['IDNummLager'] . "', '". $_GET['Bestellungsnummer'] . "')";
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
                    
  if (isset($_GET['ProduktID'])&&$_GET['BUTTON']=='Delete!') 
  {
      if($_GET['ProduktID']!=NULL && $_GET['Anz_produkte']!=NULL && $_GET['Preis']!=NULL && $_GET['Kategorie']!=NULL && $_GET['IDNummLager']!=NULL && $_GET['Bestellungsnummer']!=NULL){
    //Prepare insert statementd
    $sql = "DELETE FROM produkt WHERE ProduktID='". $_GET['ProduktID'] ."' AND Anz_produkte='". $_GET['Anz_produkte'] ."' AND Preis='". $_GET['Preis'] ."' AND Kategorie='". $_GET['Kategorie'] ."' AND IDNummLager='". $_GET['IDNummLager'] ."' AND Bestellungsnummer='". $_GET['Bestellungsnummer'] ."' ";
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
<br>                    
  <form id='suchen' action='produkt.php' method='get'>
<input type="hidden" name="Kunde_nr" value="Kunde_nr" />
<input type="submit" value="Kundennummer anzeigen"/>
</form>
<?php
if(isset($_GET['Kunde_nr'])){
    $sql = "SELECT * FROM istgeliefert";
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
    ?>
<table>
    <thead>
      <tr>
        <th>ProduktID</th>
        <th>Kunde_nr</th>
     </tr>
    </thead>
    <tbody>
<?php
 while ($row = oci_fetch_assoc($stmt)) {
 echo "<tr>"; 
 echo "<td>" . $row['PRODUKTID'] . "</td>";
 echo "<td>" . $row['KUNDE_NR'] . "</td>";
 echo "</tr>";
 }
?>
    </tbody>
</table>
<div>Insgesamt <?php echo oci_num_rows($stmt); ?> ID's sind angezeigt!</div>                    
<?php
     oci_free_statement($stmt);   
}
    ?>
<br><br>
                    

                    <br><br>
<form id='show' action='produkt.php' method='get'>
<input type="hidden" name="show" value="show" />
<input type="submit" value="Alle Produkte anzeigen"/>
</form>
                    
<?php 
if(isset($_GET['show'])||isset($_GET['search'])){
?>
<div>
    <form id='searchform' action='produkt.php' method='get'>
      <a href='produkt.php'>Alle Produkte</a> ---
      Suche nach ProduktID: 
      <input id='search' name='search' type='text' size='20' value='<?php if (isset($_GET['search'])) echo $_GET['search']; ?>' />
      <input id='submit' type='submit' value='Los!' />
    </form>
  </div>
<?php
  // check if search view of list view
  if (isset($_GET['search'])) {
    $sql = "SELECT * FROM produkt WHERE produktid like '%" . $_GET['search'] . "%'";
  } else {
    $sql = "SELECT * FROM produkt";
  }
  // execute sql statement
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
?>
                    
                    <table>
 <thead>
   <tr>
    <th>ProduktID</th>
    <th>Anz_produkte</th>
    <th>Preis</th>
    <th>Kategorie</th>
    <th>IDNummLager</th>
    <th>Bestellungsnummer</th>
   </tr>
</thead>
    <tbody>
<?php
 while ($row = oci_fetch_assoc($stmt)) {
 echo "<tr>"; 
 echo "<td>" . $row['PRODUKTID'] . "</td>";
 echo "<td>" . $row['ANZ_PRODUKTE'] . "</td>";
 echo "<td>" . $row['PREIS'] . "</td>";
 echo "<td>" . $row['KATEGORIE'] . "</td>";
 echo "<td>" . $row['IDNUMMLAGER'] . "</td>"; 
 echo "<td>" . $row['BESTELLUNGSNUMMER'] . "</td>"; 
 echo "</tr>";
 }
?>
     </tbody>
   </table>
<div>Insgesamt <?php echo oci_num_rows($stmt); ?> Produkte gefunden.</div>
                    <br><br><br>
<?php  oci_free_statement($stmt);
                    
                    oci_close($conn);
                    
?>

<?php 
                         
                        }
    ?>

    </body>
</html>
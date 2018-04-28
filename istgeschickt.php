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
                               
                                 
        
    
          
    
                    <center><h1>Istgeschickt </h1></center>
  <form id='insertform' action='istgeschickt.php' method='get'>
    Neue Istgeschickt beziehungen:
 <table>
	<thead>
	 <tr>
        <th>Bestellungsnummer</th>
        <th>IDNummLager</th>
	 </tr>
  </thead>
	  <tbody>
	     <tr>
	        <td>  
	           <input id='Bestellungsnummer' name='Bestellungsnummer' type='number' size='20' value='<?php if (isset($_GET['Bestellungsnummer'])) echo $_GET['Bestellungsnummer']; ?>' />
            </td>
                <td> 
                   <input id='IDNummLager' name='IDNummLager' type='number' size='10' value='<?php if (isset($_GET['IDNummLager'])) echo $_GET['IDNummLager']; ?>' />
                </td>
           </tbody>
        </table>
        
        <input id='submit' type='submit' name='BUTTON' value='Insert!' />
        <input id='submit' type='submit' name='BUTTON' value='Delete!' />
      
  
  </form>


<?php
  //Handle insert
  if (isset($_GET['Bestellungsnummer'])&&$_GET['BUTTON']=='Insert!') 
  {
    //Prepare insert statementd
    $sql = "INSERT INTO Istgeschickt  VALUES('" . $_GET['Bestellungsnummer'] . "','"  . $_GET['IDNummLager'] . "')";
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
                    
  if (isset($_GET['Bestellungsnummer'])&&$_GET['BUTTON']=='Delete!') 
  {
      if($_GET['Bestellungsnummer']!=NULL && $_GET['IDNummLager']!=NULL){
    //Prepare insert statementd
    $sql = "DELETE FROM Istgeschickt WHERE Bestellungsnummer='". $_GET['Bestellungsnummer'] ."' AND IDNummLager='". $_GET['IDNummLager'] ."'";
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
<form id='show' action='istgeschickt.php' method='get'>
<input type="hidden" name="show" value="show" />
<input type="submit" value="Alle Istgeschickt beziehungen anzeigen"/>
</form>
                    
<?php 
if(isset($_GET['show'])||isset($_GET['search'])){
?>
<div>
    <form id='searchform' action='istgeschickt.php' method='get'>
      <a href='istgeschickt.php'>Alle Istgeschickt Beziehungen</a> ---
      Suche nach Bestellungsnummer: 
      <input id='search' name='search' type='text' size='20' value='<?php if (isset($_GET['search'])) echo $_GET['search']; ?>' />
      <input id='submit' type='submit' value='Los!' />
    </form>
  </div>
<?php
  // check if search view of list view
  if (isset($_GET['search'])) {
    $sql = "SELECT * FROM Istgeschickt WHERE Bestellungsnummer like '%" . $_GET['search'] . "%'";
  } else {
    $sql = "SELECT * FROM Istgeschickt";
  }
  // execute sql statement
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
<div>Insgesamt <?php echo oci_num_rows($stmt); ?> Istgeschickt beziehungen gefunden.</div>
                    <br><br><br>
<?php  oci_free_statement($stmt);
                    
                    oci_close($conn);
                    
?>


<?php 
                         
                        }
    ?>

    </body>
 </html>
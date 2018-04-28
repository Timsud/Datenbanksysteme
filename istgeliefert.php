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
                               
                                 
        
    
          
    
                    <center><h1>Istgeliefert </h1></center>
  <form id='insertform' action='istgeliefert.php' method='get'>
    Neue Istgeliefert Beziehung:
 <table>
	<thead>
	 <tr>
        <th>ProduktID</th>
        <th>Kunde_nr</th>
        <th>LiefererID</th>
        <th>Art_von_Lieferung</th>
        <th>anz_gelief_prod</th>
        <th>IDNummLager</th>
	 </tr>
  </thead>
	  <tbody>
	     <tr>
	        <td>  
	           <input id='ProduktID' name='ProduktID' type='number' size='20' value='<?php if (isset($_GET['ProduktID'])) echo $_GET['ProduktID']; ?>' />
            </td>
                <td> 
                   <input id='Kunde_nr' name='Kunde_nr' type='number' size='10' value='<?php if (isset($_GET['Kunde_nr'])) echo $_GET['Kunde_nr']; ?>' />
                </td>
                <td>  
	           <input id='LiefererID' name='LiefererID' type='number' size='20' value='<?php if (isset($_GET['LiefererID'])) echo $_GET['LiefererID']; ?>' />
            </td>
                <td> 
                   <input id='Art_von_Lieferung' name='Art_von_Lieferung' type='text' size='10' value='<?php if (isset($_GET['Art_von_Lieferung'])) echo $_GET['Art_von_Lieferung']; ?>' />
                </td>
                <td> 
                   <input id='anz_gelief_prod' name='anz_gelief_prod' type='number' size='10' value='<?php if (isset($_GET['anz_gelief_prod'])) echo $_GET['anz_gelief_prod']; ?>' />
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
  if (isset($_GET['ProduktID'])&&$_GET['BUTTON']=='Insert!') 
  {
    //Prepare insert statementd
    $sql = "INSERT INTO istgeliefert VALUES('". $_GET['ProduktID'] . "','"  . $_GET['Kunde_nr'] . "', '" . $_GET['LiefererID'] . "','"  . $_GET['Art_von_Lieferung'] . "','"  . $_GET['anz_gelief_prod'] . "','"  . $_GET['IDNummLager'] . "')";
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
      if($_GET['ProduktID']!=NULL&& $_GET['Kunde_nr']!=NULL&& $_GET['LiefererID']!=NULL&& $_GET['Art_von_Lieferung']!=NULL&& $_GET['anz_gelief_prod']!=NULL&& $_GET['IDNummLager']!=NULL){
    //Prepare insert statementd
    $sql = "DELETE FROM istgeliefert WHERE ProduktID='". $_GET['ProduktID'] ."' AND Kunde_nr='". $_GET['Kunde_nr'] ."' AND LiefererID='". $_GET['LiefererID'] ."' AND Art_von_Lieferung='". $_GET['Art_von_Lieferung'] ."'AND anz_gelief_prod='". $_GET['anz_gelief_prod'] ."' AND IDNummLager='". $_GET['IDNummLager'] ."'";
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
<form id='show' action='istgeliefert.php' method='get'>
<input type="hidden" name="show" value="show" />
<input type="submit" value="Alle istgeliefert beziehungen anzeigen"/>
</form>
                    
<?php 
if(isset($_GET['show'])||isset($_GET['search'])){
?>
<div>
    <form id='searchform' action='istgeliefert.php' method='get'>
      <a href='istgeliefert.php'>Alle istgeliefert beziehungen</a> ---
      Suche nach ProduktID: 
      <input id='search' name='search' type='text' size='20' value='<?php if (isset($_GET['search'])) echo $_GET['search']; ?>' />
      <input id='submit' type='submit' value='Los!'/>
    </form>
  </div>
<?php
  // check if search view of list view
  if (isset($_GET['search'])) {
    $sql = "SELECT * FROM istgeliefert WHERE ProduktID like '%" . $_GET['search'] . "%'";
  } else {
    $sql = "SELECT * FROM istgeliefert";
  }
  // execute sql statement
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
?>
                    
                    <table>
 <thead>
   <tr>
   <th>ProduktID</th>
   <th>Kunde_nr</th>
   <th>LiefererID</th>
   <th>Art_von_Lieferung</th>
   <th>anz_gelief_prod</th>
   <th>IDNummLager</th>

</thead>
    <tbody>
<?php
 while ($row = oci_fetch_assoc($stmt)) {
 echo "<tr>"; 
 echo "<td>" . $row['PRODUKTID'] . "</td>";
 echo "<td>" . $row['KUNDE_NR'] . "</td>"; 
 echo "<td>" . $row['LIEFERERID'] . "</td>";
 echo "<td>" . $row['ART_VON_LIEFERUNG'] . "</td>"; 
 echo "<td>" . $row['ANZ_GELIEF_PROD'] . "</td>";  
 echo "<td>" . $row['IDNUMMLAGER'] . "</td>";   
 echo "</tr>";
 }
?>
     </tbody>
   </table>
<div>Insgesamt <?php echo oci_num_rows($stmt); ?>  Istgeliefert beziehungen gefunden.</div>
                    <br><br><br>
<?php  oci_free_statement($stmt);
                    
                    oci_close($conn);
                    
?>


<?php 
                         
                        }
    ?>

    </body>
 </html>
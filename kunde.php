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
                               
                                 
        
    
          
          
    
                    <center><h1>Kunde</h1></center>

<div>
  <form id='insertform' action='kunde.php' method='get'>
    Neue Person einfuegen:
 <table>
	  <thead>
	    <tr>
        <th>Vorname</th>
        <th>Nachname</th>
        <th>Geschlecht</th>
	    </tr>
	  </thead>
	  <tbody>
	     <tr>
                <td>
                   <input id='VORNAME' name='VORNAME' type='text' size='10' value='<?php if (isset($_GET['VORNAME'])) echo $_GET['VORNAME']; ?>' />
                </td>
		<td>
		   <input id='NACHNAME' name='NACHNAME' type='text' size='10' value='<?php if (isset($_GET['NACHNAME'])) echo $_GET['NACHNAME']; ?>' />
		</td>
		<td>
		   <input id='GESCHLECHT' name='GESCHLECHT' type='text' size='20' value='<?php if (isset($_GET['GESCHLECHT'])) echo $_GET['GESCHLECHT']; ?>' />
		</td>
           </tbody>
        </table>
           
         <input id='submit' type='submit' name='BUTTON' value='Insert!' />
         <input id='submit' type='submit' name='BUTTON' value='Delete!' />
      
      </div>
  </form>
</div>


<?php
  //Handle insert
  if (isset($_GET['VORNAME'])&&$_GET['BUTTON']=='Insert!') 
  {
    //Prepare insert statementd
    $sql = "INSERT INTO kunde(vorname, nachname, geschlecht) VALUES('". $_GET['VORNAME'] ."','".$_GET['NACHNAME']."','".$_GET['GESCHLECHT'] . "')";
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
                    
  if (isset($_GET['VORNAME'])&&$_GET['BUTTON']=='Delete!') 
  {
      if($_GET['VORNAME']!=NULL && $_GET['NACHNAME']!=NULL && $_GET['GESCHLECHT']!=NULL){
    //Prepare insert statementd
    $sql = "DELETE FROM kunde WHERE VORNAME='". $_GET['VORNAME'] ."' AND NACHNAME='". $_GET['NACHNAME'] ."' AND GESCHLECHT='". $_GET['GESCHLECHT'] ."'";
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
  <form id='suchen' action='kunde.php' method='get'>
<input type="hidden" name="bestellung" value="bestellung" />
<input type="submit" value="Alle Bestellungen anzeigen"/>
</form>
<?php
if(isset($_GET['bestellung'])){
    $sql = "SELECT * FROM macht";
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
    ?>
<table class="table table-bordered">
    <thead>
      <tr>
        <th>Kunde_nr</th>
        <th>Bestellungsnummer</th>
      </tr>
    </thead>
    <tbody>
<?php
 while ($row = oci_fetch_assoc($stmt)) {
 echo "<tr>"; 
 echo "<td>" . $row['KUNDE_NR'] . "</td>";
 echo "<td>" . $row['BESTELLUNGSNUMMER'] . "</td>";
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
                    

                    <br><br>
<form id='show' action='kunde.php' method='get'>
<input type="hidden" name="show" value="show" />
<input type="submit" value="Alle Kunden anzeigen"/>
</form>
                    
<?php 
if(isset($_GET['show'])||isset($_GET['search'])){
?>
<div>
    <form id='searchform' action='kunde.php' method='get'>
      <a href='kunde.php'>Alle Kunden</a> ---
      Suche nach VORNAME: 
      <input id='search' name='search' type='text' size='20' value='<?php if (isset($_GET['search'])) echo $_GET['search']; ?>' />
      <input id='submit' type='submit' value='Los!' />
    </form>
  </div>
<?php
  // check if search view of list view
  if (isset($_GET['search'])) {
    $sql = "SELECT * FROM kunde WHERE VORNAME like '%" . $_GET['search'] . "%'";
  } else {
    $sql = "SELECT * FROM kunde";
  }
  // execute sql statement
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
?>
                    
                    <table>
    <thead>
      <tr>
        <th>Kundennummer</th>
        <th>Vorname</th>
        <th>Nachname</th>
        <th>Geschlecht</th>
      </tr>
    </thead>
    <tbody>
<?php
 while ($row = oci_fetch_assoc($stmt)) {
 echo "<tr>"; 
 echo "<td>" . $row['KUNDE_NR'] . "</td>";
 echo "<td>" . $row['VORNAME'] . "</td>";
 echo "<td>" . $row['NACHNAME'] . "</td>";
 echo "<td>" . $row['GESCHLECHT'] . "</td>";
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
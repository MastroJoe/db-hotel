<!-- Descrizione:
Pagina con la lista delle stanze, un click porta al dettaglio della stanza -->

<?php
// database
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "db_hotel";

// creo il collegamento
$conn = new mysqli($servername, $username, $password, $dbname);

// check della connessione
if ($conn && $conn->connect_error) {
  echo "Connessione fallita per:" . $conn->connect_error;
}
  // condizione inserimento utente
  if ($_GET['id']) {
    // SQL injections e placeholder
    $stmt = $conn->prepare("SELECT * FROM stanze WHERE id = ?");
    $stmt->bind_param("i", $_GET['id']);
    // settaggio ed esecuzione
    $stmt->execute();
    $result = $stmt->get_result();
    // ciclo dei risultati
    while($row = $result->fetch_assoc()) {
      ?>
      <?php  ?>
      <!-- Stampo le informazioni della camera selezionata -->
      <div><?= 'ID:' .$row['id'] ?></div>
      <div><?= 'Stanza N:' .$row['room_number'] ?></div>
      <div><?= 'Numero di letti:' .$row['beds'] ?></div>
      <div><?= 'Piano:' .$row['floor'] ?></div>
      <div><a href="/db-hotel/"><?= 'Torna alle stanze' ?></a></div>
      <?php
    }
  } else {
    // creo la query
    $sql = "SELECT room_number, id, floor FROM stanze";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
      $row = $result->fetch_assoc();
      // ciclo i risultati
      while ($row) {
      ?>
      <!-- Stampo i risultati -->
        <div><a href="/db-hotel/?id=<?= $row['id'] ?>"><?= "Stanza N." .$row['room_number']; ?></a></div>
      <?php
        $row = $result->fetch_assoc();
      }
    } else if ($result) {
      echo "0 risultati";
    } else {
      echo "Errore nella query";
    }
    $conn->close();
  }
 ?>

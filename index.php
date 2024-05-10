<!-- Per esportare la tabella degli utenti in formato CSV in due file distinti,
 uno con campi delimitati e uno con campi non delimitati, puoi utilizzare 
 il seguente script PHP: -->




<?php
// Connessione al database
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "nome_database";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica della connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Query per selezionare tutti gli utenti dalla tabella
$sql = "SELECT * FROM utenti";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Apertura del file CSV con campi delimitati
    $csv_delimited = fopen("utenti_delimited.csv", "w");

    // Apertura del file CSV con campi non delimitati
    $csv_nondelimited = fopen("utenti_nondelimited.csv", "w");

    // Scrivi l'intestazione nei file CSV
    fputcsv($csv_delimited, array('ID', 'Nome', 'Cognome', 'Email'));
    fwrite($csv_nondelimited, "ID\tNome\tCognome\tEmail\n");

    // Scrivi i dati degli utenti nei file CSV
    while ($row = $result->fetch_assoc()) {
        // Scrivi nei file CSV con campi delimitati
        fputcsv($csv_delimited, $row);

        // Scrivi nei file CSV con campi non delimitati
        fwrite($csv_nondelimited, implode("\t", $row) . "\n");
    }

    // Chiudi i file CSV
    fclose($csv_delimited);
    fclose($csv_nondelimited);

    echo "Esportazione CSV completata con successo.";
} else {
    echo "Nessun risultato trovato nella tabella degli utenti.";
}

// Chiudi la connessione al database
$conn->close();
?>
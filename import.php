Per importare i dati dal CSV al database,
puoi utilizzare il seguente script PHP:
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

// Percorso del file CSV da importare
$csv_file = "percorso_del_file/utenti_delimited.csv";

// Query per eliminare eventuali dati preesistenti nella tabella
$sql_delete = "DELETE FROM utenti";
$conn->query($sql_delete);

// Importa dati dal file CSV alla tabella del database
$sql_import = <<<SQL
    LOAD DATA INFILE '$csv_file'
    INTO TABLE utenti
    FIELDS TERMINATED BY ','
    ENCLOSED BY '"'
    LINES TERMINATED BY '\n'
    IGNORE 1 ROWS;
SQL;

if ($conn->query($sql_import) === TRUE) {
    echo "Importazione CSV completata con successo.";
} else {
    echo "Errore durante l'importazione CSV: " . $conn->error;
}

// Chiudi la connessione al database
$conn->close();
?>
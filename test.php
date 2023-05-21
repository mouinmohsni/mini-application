
<?php

$hostname     = "localhost:3306";
$username     = "root";
$password     = "root";
$databasename = "db_test";
// Create connection
$conn = mysqli_connect($hostname, $username, $password,$databasename);
// Check connection
if (!$conn) {
    die("Unable to Connect database: " . mysqli_connect_error());
}


?>






<?php
include_once('./connect.php');
$db=$conn;
global $db;




$urls = array(
    'ulr_1' =>'http://localhost:8000/api/products' ,
    'ulr_2' => 'http://localhost:8000/api/user' ,
    
);

// Récupérer les noms des tables de la base de données
$tables = array();
$result = $db->query("SHOW TABLES");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_row()) {
        $tables[] = $row[0];
    }
}

// Parcourir les tables et effectuer les requêtes API
$apiResponses = array();
foreach ($tables as $table) {
    $tableData = array();

    // Requête SQL pour récupérer les données de la table
    $query = "SELECT * FROM " . $table;
    $exec = mysqli_query($db, $query);

    if ($exec && mysqli_num_rows($exec) > 0) {
        while ($data = mysqli_fetch_assoc($exec)) {
            $tableData[] = $data;
        }
    }

    // Convertir le tableau $tableData en JSON
    $json_data = json_encode($tableData);
$i = 0;
    // Parcourir les URLs des API
    foreach ($urls as $url) {
        // Configuration de la requête curl
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        // Exécution de la requête curl
        $response = curl_exec($curl);
echo  $response ;
        // Vérification des erreurs
        if ($response === false) {
            echo 'Erreur curl : ' . curl_error($curl);
        } else {
            echo $i;
            $apiResponses[$table][$url] = $response;
        }

        // Fermeture de la requête curl
        curl_close($curl);
        $i++;
    }
}

// // Afficher les réponses des API
// foreach ($apiResponses as $table => $responses) {
//     echo 'Réponses de l\'API pour la table ' . $table . ' : <br>';
//     foreach ($responses as $url => $response) {
//         echo 'API : ' . $url . ' - Réponse : ' . $response . '<br>';
//     }
//     echo '<br>';
// }
?>

<?php
include_once('./connect.php');
// Assurez-vous que votre fichier connect.php établit la connexion à la base de données et définit $conn

$urls = array(
    'ulr_1' =>'http://localhost/php-rest-api-master/api/create.php' ,
);

// Récupérer les noms des tables de la base de données
$tables = array();
$result = $conn->query("SHOW TABLES");
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
    $exec = mysqli_query($conn, $query);

    if ($exec && mysqli_num_rows($exec) > 0) {
        while ($data = mysqli_fetch_assoc($exec)) {
            $tableData[] = $data;
        }
    }

    // Parcourir les URLs des API
    foreach ($urls as $url) {
        // Parcourir les tableaux de données
        foreach ($tableData as $data) {
            // Convertir l'objet en JSON
            $json_data = json_encode($data);
            
            echo '========================================='.$json_data;
            // Configuration de la requête curl
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

            // Exécution de la requête curl
            $response = curl_exec($curl);

            // Vérification des erreurs
            if ($response === false) {
                echo 'Erreur curl : ' . curl_error($curl);
            } else {
                $apiResponses[$table][$url] = $response;
            }

            // Fermeture de la requête curl
            curl_close($curl);
        }
    }
}

// Afficher les réponses des API
foreach ($apiResponses as $table => $responses) {
    echo 'Réponses de l\'API pour la table ' . $table . ' : <br>';
    foreach ($responses as $url => $response) {
        echo 'API : ' . $url . ' - Réponse : ' . $response . '<br>';
    }
    echo '<br>';
}
?>

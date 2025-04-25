<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    exit(0);
}

require_once 'config/database.php';

try {
    $database = new Database();
    $db = $database->getConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['etudiant_id'])) {
        $query = "SELECT * FROM student WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $_GET['etudiant_id'], PDO::PARAM_INT);
        $stmt->execute();
        $etudiant = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($etudiant ?: ["message" => "Étudiant non trouvé"]);
        exit;
    }
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $query = "SELECT * FROM student";
        $stmt = $db->prepare($query);
        $stmt->execute();

        $etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);

        http_response_code(200);
        echo json_encode([
            "students" => $etudiants
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);

        if (
            !empty($data['nom']) &&
            !empty($data['postNom']) &&
            !empty($data['preNom']) &&
            !empty($data['date_naissance']) &&
            !empty($data['option']) &&
            isset($data['pourcentage_obtenu']) &&
            !empty($data['genre']) &&
            !empty($data['lieu_naissance']) &&
            !empty($data['nationalite'])
        ) {
            $query = "INSERT INTO student 
                (nom, postNom, preNom, date_naissance, `option`, pourcentage_obtenu, genre, lieu_naissance, nationalite) 
                VALUES 
                (:nom, :postNom, :preNom, :date_naissance, :option, :pourcentage_obtenu, :genre, :lieu_naissance, :nationalite)";

            $stmt = $db->prepare($query);
            $stmt->bindParam(':nom', $data['nom']);
            $stmt->bindParam(':postNom', $data['postNom']);
            $stmt->bindParam(':preNom', $data['preNom']);
            $stmt->bindParam(':date_naissance', $data['date_naissance']);
            $stmt->bindParam(':option', $data['option']);
            $stmt->bindParam(':pourcentage_obtenu', $data['pourcentage_obtenu']);
            $stmt->bindParam(':genre', $data['genre']);
            $stmt->bindParam(':lieu_naissance', $data['lieu_naissance']);
            $stmt->bindParam(':nationalite', $data['nationalite']);

            if ($stmt->execute()) {
                http_response_code(201);
                echo json_encode(["success" => true, "message" => "Étudiant ajouté avec succès"]);
            } else {
                http_response_code(500);
                echo json_encode(["success" => false, "message" => "Échec de l'insertion"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["success" => false, "message" => "Champs manquants ou invalides"]);
        }
    }

    else {
        http_response_code(405);
        echo json_encode(["success" => false, "message" => "Méthode non autorisée"]);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Erreur lors du traitement",
        "error" => $e->getMessage()
    ]);
}

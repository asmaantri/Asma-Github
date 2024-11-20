<?php
include(__DIR__ . '/../config.php');
include(__DIR__ . '/../Model/Musee.php');

class MuseeController
{
    // Liste tous les musées
    public function listMusees()
    {
        $sql = "SELECT * FROM musees";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    // Supprimer un musée
    function deleteMusee($id)
    {
        $sql = "DELETE FROM musees WHERE id = :id";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    // Ajouter un musée
    function addMusee($musee)
    {   
        $sql = "INSERT INTO musees (nom, adresse) VALUES (:nom, :adresse)";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'nom' => $musee->getNom(),
                'adresse' => $musee->getAdresse(),
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    // Mettre à jour un musée
    function updateMusee($musee, $id)
    {
        try {
            $db = config::getConnexion();

            $query = $db->prepare(
                'UPDATE musees SET 
                    nom = :nom,
                    adresse = :adresse
                WHERE id = :id'
            );

            $query->execute([
                'id' => $id,
                'nom' => $musee->getNom(),
                'adresse' => $musee->getAdresse(),
            ]);

            echo $query->rowCount() . " records UPDATED successfully <br>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage(); 
        }
    }

    // Afficher un musée spécifique
    function showMusee($id)
    {
        $sql = "SELECT * FROM musees WHERE id = $id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute();

            $musee = $query->fetch();
            return $musee;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
}

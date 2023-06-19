<?php
include_once "Database.php";  

class PlantDAO
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function createPlant($plant): void
    {
        try {
            $id_user = $plant->getIdUser();
            $common_name = $plant->getCommonName();
            $scientific_name = $plant->getScientificName();
            $family = $plant->getFamily();
            $genus = $plant->getGenus();
            $species = $plant->getSpecies();
            $place = $plant->getPlace();
            $date_of_collection = $plant->getDateOfCollection();
            $color = $plant->getColor();
            $collection_name = $plant->getCollectionName();
            $hashtags = $plant->getHashtags();
            $filename = $plant->getFileName();

            $stmt = $this->conn->prepare("INSERT INTO plants (id_user, common_name, scientific_name, family, genus, species, place, date_of_collection, color, collection_name, hashtags,filename) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)");
            $stmt->bind_param("isssssssssss", $id_user, $common_name, $scientific_name, $family, $genus, $species, $place, $date_of_collection, $color, $collection_name, $hashtags,$filename);
            $stmt->execute();
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function getPlantById($plantId)
{
    $sql = "SELECT * FROM plants WHERE id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $plantId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}
}

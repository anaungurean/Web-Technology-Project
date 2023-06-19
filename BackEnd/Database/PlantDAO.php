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

    public function getPlantById($plantId){
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

    public function getPlantByFilename($filename)
    {
        // var_dump($filename);
        $sql = "SELECT * FROM plants WHERE filename = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $filename);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

  public function getPlantsByUserId($user_id)
{        
    $sql = "SELECT id, id_user, common_name, scientific_name, family, genus, species, place, date_of_collection, color, collection_name, hashtags, filename FROM plants WHERE id_user = ?";
    $stmt =  $this->conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $plants = [];

    while ($row = $result->fetch_assoc()) {
        $plant = new Plant();
        $plant->setId($row['id']);
        $plant->setIdUser($row['id_user']);
        $plant->setCommonName($row['common_name']);
        $plant->setScientificName($row['scientific_name']);
        $plant->setFamily($row['family']);
        $plant->setGenus($row['genus']);
        $plant->setSpecies($row['species']);
        $plant->setPlace($row['place']);
        $plant->setDateOfCollection($row['date_of_collection']);
        $plant->setColor($row['color']);
        $plant->setCollectionName($row['collection_name']);
        $plant->setHashtags($row['hashtags']);
        $plant->setFileName($row['filename']);
        $plants[] = $plant;
    }

    return $plants;
}
}


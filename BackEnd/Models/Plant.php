<?php

class Plant implements JsonSerializable
{
    private $id;
    private $id_user;
    private $common_name;
    private $scientific_name;
    private $family;
    private $genus;
    private $species;
    private $place;
    private $date_of_collection;
    private $color;
    private $collection_name;
    private $hashtags;

    public function __construct()
    {
    }

    // Setter and Getter for $id
    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    // Setter and Getter for $id_user
    public function getIdUser()
    {
        return $this->id_user;
    }

    public function setIdUser($id_user): void
    {
        $this->id_user = $id_user;
    }

    // Setter and Getter for $common_name
    public function getCommonName()
    {
        return $this->common_name;
    }

    public function setCommonName($common_name): void
    {
        $this->common_name = $common_name;
    }

    // Setter and Getter for $scientific_name
    public function getScientificName()
    {
        return $this->scientific_name;
    }

    public function setScientificName($scientific_name): void
    {
        $this->scientific_name = $scientific_name;
    }

    // Setter and Getter for $family
    public function getFamily()
    {
        return $this->family;
    }

    public function setFamily($family): void
    {
        $this->family = $family;
    }

    // Setter and Getter for $genus
    public function getGenus()
    {
        return $this->genus;
    }

    public function setGenus($genus): void
    {
        $this->genus = $genus;
    }

    // Setter and Getter for $species
    public function getSpecies()
    {
        return $this->species;
    }

    public function setSpecies($species): void
    {
        $this->species = $species;
    }

    // Setter and Getter for $place
    public function getPlace()
    {
        return $this->place;
    }

    public function setPlace($place): void
    {
        $this->place = $place;
    }

    // Setter and Getter for $date_of_collection
    public function getDateOfCollection()
    {
        return $this->date_of_collection;
    }

    public function setDateOfCollection($date_of_collection): void
    {
        $this->date_of_collection = $date_of_collection;
    }

    // Setter and Getter for $color
    public function getColor()
    {
        return $this->color;
    }

    public function setColor($color): void
    {
        $this->color = $color;
    }

    // Setter and Getter for $collection_name
    public function getCollectionName()
    {
        return $this->collection_name;
    }

    public function setCollectionName($collection_name): void
    {
        $this->collection_name = $collection_name;
    }

    // Setter and Getter for $hashtags
    public function getHashtags()
    {
        return $this->hashtags;
    }

    public function setHashtags($hashtags): void
    {
        $this->hashtags = $hashtags;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'id_user' => $this->id_user,
            'common_name' => $this->common_name,
            'scientific_name' => $this->scientific_name,
            'family' => $this->family,
            'genus' => $this->genus,
            'species' => $this->species,
            'place' => $this->place,
            'date_of_collection' => $this->date_of_collection,
            'color' => $this->color,
            'collection_name' => $this->collection_name,
            'hashtags' => $this->hashtags,
        ];
    }

    public function __toString(): string
    {
        return "Plant: " . $this->id . " " . $this->common_name;
    }
}

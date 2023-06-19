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
    private $filename;


    public function __construct()
    {
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

     public function getIdUser()
    {
        return $this->id_user;
    }

    public function setIdUser($id_user): void
    {
        $this->id_user = $id_user;
    }

     public function getCommonName()
    {
        return $this->common_name;
    }

    public function setCommonName($common_name): void
    {
        $this->common_name = $common_name;
    }

     public function getScientificName()
    {
        return $this->scientific_name;
    }

    public function setScientificName($scientific_name): void
    {
        $this->scientific_name = $scientific_name;
    }

     public function getFamily()
    {
        return $this->family;
    }

    public function setFamily($family): void
    {
        $this->family = $family;
    }

     public function getGenus()
    {
        return $this->genus;
    }

    public function setGenus($genus): void
    {
        $this->genus = $genus;
    }

     public function getSpecies()
    {
        return $this->species;
    }

    public function setSpecies($species): void
    {
        $this->species = $species;
    }

     public function getPlace()
    {
        return $this->place;
    }

    public function setPlace($place): void
    {
        $this->place = $place;
    }

     public function getDateOfCollection()
    {
        return $this->date_of_collection;
    }

    public function setDateOfCollection($date_of_collection): void
    {
        $this->date_of_collection = $date_of_collection;
    }

     public function getColor()
    {
        return $this->color;
    }

    public function setColor($color): void
    {
        $this->color = $color;
    }

     public function getCollectionName()
    {
        return $this->collection_name;
    }

    public function setCollectionName($collection_name): void
    {
        $this->collection_name = $collection_name;
    }

     public function getHashtags()
    {
        return $this->hashtags;
    }

    public function setHashtags($hashtags): void
    {
        $this->hashtags = $hashtags;
    }

       public function getFileName()
    {
        return $this->filename;
    }

    public function setFileName($filename): void
    {
        $this->filename = $filename;
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
            'filename' => $this->filename,
        ];
    }

    public function __toString(): string
    {
        return "Plant: " . $this->id . " " . $this->common_name;
    }
}

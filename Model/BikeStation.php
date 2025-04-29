<?php
class BikeStation
{
    private ?int $id_station;
    private ?string $name;
    private ?string $location;
    private ?int $total_bikes;
    private ?int $available_bikes;
    private ?float $status;
    private ?float $latitude;
    private ?float $longitude;

    public function __construct($id_station, $name, $location, $total_bikes, $available_bikes, $status, $latitude = null, $longitude = null)
    {
        $this->id_station = $id_station;
        $this->name = $name;
        $this->location = $location;
        $this->total_bikes = $total_bikes;
        $this->available_bikes = $available_bikes;
        $this->status = $status;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getId() { return $this->id_station; }
    public function getName() { return $this->name; }
    public function getLocation() { return $this->location; }
    public function getTotalBikes() { return $this->total_bikes; }
    public function getAvailableBikes() { return $this->available_bikes; }
    public function getStatus() { return $this->status; }
    public function getLatitude() { return $this->latitude; }
    public function getLongitude() { return $this->longitude; }
}
?>

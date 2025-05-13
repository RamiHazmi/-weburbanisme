<?php
class Bike
{
    private ?int $id_bike;
    private ?int $station_id; // Renommé station_start pour correspondre à la table
    private ?string $status; // Remplacé feedback par status
    private ?float $total_kilometers;

    public function __construct(
        ?int $id_bike,
        ?int $station_id,
        ?string $status,
        ?float $total_kilometers
    ) {
        $this->id_bike = $id_bike;
        $this->station_id = $station_id;
        $this->status = $status;
        $this->total_kilometers = $total_kilometers;
    }

    // Getters
    public function getIdBike(): ?int { return $this->id_bike; }
    public function getStationId(): ?int { return $this->station_id; }
    public function getStatus(): ?string { return $this->status; }
    public function getTotalKilometers(): ?float { return $this->total_kilometers; }

    // Setters
    public function setStationId(int $station_id): void { $this->station_id = $station_id; }
    public function setStatus(string $status): void { $this->status = $status; }
    public function setTotalKilometers(float $total_kilometers): void { $this->total_kilometers = $total_kilometers; }
}
?>

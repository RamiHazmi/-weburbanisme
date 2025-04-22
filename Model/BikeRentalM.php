<?php
class BikeRental
{
    private ?int $id_rental;
    private ?int $id_bike;
    private ?int $id_user;
    private ?int $end_station;
    private ?string $start_time;
    private ?string $end_time;
    private ?string $feedback;
    private ?string $start_station;


    public function __construct(
        ?int $id_rental,
        ?int $id_bike,
        ?int $id_user,
        ?int $end_station,
        ?string $start_time,
        ?string $end_time,
        ?string $feedback,
        ?string $start_station
    ) {
        $this->id_rental = $id_rental;
        $this->id_bike = $id_bike;
        $this->id_user = $id_user;
        $this->end_station = $end_station;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->feedback = $feedback;
        $this->start_station = $start_station;
    }

    // Getters
    public function getIdRental(): ?int { return $this->id_rental; }
    public function getIdBike(): ?int { return $this->id_bike; }
    public function getIdUser(): ?int { return $this->id_user; }
    public function getEndStation(): ?int { return $this->end_station; }
    public function getStartTime(): ?string { return $this->start_time; }
    public function getEndTime(): ?string { return $this->end_time; }
    public function getFeedback(): ?string { return $this->feedback; }
    public function getStartStation(): ?string { return $this->start_station; }

    // Setters
    public function setIdBike(int $id_bike): void { $this->id_bike = $id_bike; }
    public function setIdUser(int $id_user): void { $this->id_user = $id_user; }
    public function setEndStation(int $end_station): void { $this->end_station = $end_station; }
    public function setStartTime(string $start_time): void { $this->start_time = $start_time; }
    public function setEndTime(string $end_time): void { $this->end_time = $end_time; }
    public function setFeedback(string $feedback): void { $this->feedback = $feedback; }
    public function setStartStation(string $start_station): void { $this->feedback = $start_station; }

}
?>

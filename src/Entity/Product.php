<?php

namespace App\Entity;

class Product
{
    public $category;

    public $name;

    public $model;

    public $price;

    public $quantity;

    public $manufacturer;

    public $description;

    public function __construct(
        string $category,
        string $name,
        string $model,
        float $price,
        int $quantity,
        string $manufacturer,
        string $description
    ) {
        $this->category = $category;
        $this->name = $name;
        $this->model = $model;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->manufacturer = $manufacturer;
        $this->description = $description;
    }
}
<?php
class Product implements JsonSerializable
{
  public int $id;
  public string $name;
  public string $price;
  public string $installment;
  public string $imageUrl;
  public bool $favorite;
  
  public function __construct($id, $name, $price, $installment, $imageUrl, $favorite) {
    $this->id = $id;
    $this->name = $name;
    $this->price = $price;
    $this->installment = $installment;
    $this->imageUrl = $imageUrl;
    $this->favorite = $favorite;
  }

  public function jsonSerialize() {
    return [
        'id' => $this->id,
        'name' => $this->name,
        'price' => $this->price,
        'installment' => $this->installment,
        'imageUrl' => $this->imageUrl,
        'favorite' => $this->favorite
    ];
  }
}

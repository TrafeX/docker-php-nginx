<?php
require_once 'Product.php';
require '../database/Connection.php';

class ProductModel
{
  public static function getAll(): array {
    return Connection::getDB();
  }

  public static function getById(int $id): object {
    $products = Connection::getDB();
    $productFilter = array_filter($products, fn($product): bool => (string) $product->id === (string) $id);
    $product = array_pop($productFilter);
    return $product;
  }

  public static function getByName(string $name): array {
    $products = Connection::getDB();

    $productsFilter = array_values(array_filter(
      $products,
      fn($product): bool => str_contains(strtolower($product->name), strtolower($name))
    ));

    return $productsFilter;
  }

  public static function insert(Product $product): Product {
    $products = Connection::getDB();

    array_push($products, $product);

    file_put_contents('../products.json', json_encode($products));

    return $product;
  }

  public static function update(int $id, Product $updateProduct): Product {
    $products = Connection::getDB();

    $updateProductCast = (object) $updateProduct;
    $products = array_map(fn($product) => $product->id == $id ? $updateProductCast : $product, $products);

    file_put_contents('../products.json', json_encode($products));

    return $updateProduct;
  }
}

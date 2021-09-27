<?php
require_once '../models/Product.php';

use Psr\Http\Message\UploadedFileInterface;

class ProductService
{

  public static function getAll(): string {
    return json_encode(ProductModel::getAll());
  }

  public static function getById(int $id): string {
    return json_encode(ProductModel::getById($id));
  }

  public static function getByName(string $name): string {
    return json_encode(ProductModel::getByName($name));
  }

  public static function insert($product, $directory, $uploadedFile): string {
    $product['id'] = count(json_decode(file_get_contents('../products.json'))) + 1;

    if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
      $filenameBase = 'product_' . $product['id'] . '_';
      $product['filename'] = ProductService::moveUploadedFile($directory, $uploadedFile, $filenameBase);
    }
  
    $newProduct = new Product(
      $product['id'],
      $product['name'],
      $product['price'],
      $product['installment'],
      $product['filename'],
      $product['favorite']
    );
    return json_encode(ProductModel::insert($newProduct));
  }

  public static function update(int $id, $product, $directory, $uploadedFile): string {

    if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
      $filenameBase = 'product_' . $id . '_';
      $product['filename'] = ProductService::moveUploadedFile($directory, $uploadedFile, $filenameBase);
    }
  
    $updateProduct = new Product(
      $id,
      $product['name'],
      $product['price'],
      $product['installment'],
      $product['filename'],
      $product['favorite']
    );
    return json_encode(ProductModel::update($id, $updateProduct));
  }

  /**
   * Moves the uploaded file to the upload directory and assigns it a unique name
   * to avoid overwriting an existing uploaded file.
   *
   * @param string $directory The directory to which the file is moved
   * @param UploadedFileInterface $uploadedFile The file uploaded file to move
   *
   * @return string The filename of moved file
   */
  private static function moveUploadedFile(string $directory, UploadedFileInterface $uploadedFile, $filenameBase)
  {
      $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);

      // see http://php.net/manual/en/function.random-bytes.php
      $basename = bin2hex(random_bytes(8));
      $filename = sprintf('%s.%0.8s', $basename, $extension);

      $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filenameBase . $filename);

      return 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . '/images/' . $filenameBase . $filename;
  }
}

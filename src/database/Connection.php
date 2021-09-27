<?php
class Connection
{
  public static function getDB(): array {
    return json_decode(file_get_contents('../products.json'));
  }
}
<?php

namespace App\Service;

/**
 * Interface JsonSerializable
 * @package JsonSerializable
 */
interface JsonSerializableInterface
{
  /**
   * Specify data which should be serialized to JSON
   *
   * @return mixed Data to be serialized as JSON
   * @since 5.4.0
   */
  public function jsonSerialize(): mixed;
}
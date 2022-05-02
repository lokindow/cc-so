<?php

namespace Src\Components\Coffee\Application\UseCases\Water;

use Src\Components\Coffee\Domain\Interfaces\WaterContainer;
use Src\Components\Coffee\Domain\Interfaces\ICoffeeRepository;
use Src\Components\Coffee\Infrastructure\Exceptions\ContainerFullException;

/**
 * Water
 *
 */
class WaterContainerUseCase implements WaterContainer
{

  protected $objCoffeeRepository;

  public function __construct(ICoffeeRepository $iCoffeeRepository)
  {
    $this->objCoffeeRepository = $iCoffeeRepository;
  }

  /**
   * Adds water to the coffee machine's water tank
   *
   * @param float $litres number of litres of water
   *
   * @return void
   * @throws ContainerFullException
   *
   */
  public function addWater(float $litres): void
  {
    $this->objCoffeeRepository->addWater($litres);
  }

  /**
   * Use $litres from the container
   *
   * @param float $litres float number of litres of water
   *
   * @return float number of litres used
   */
  public function useWater(float $litres): float
  {
    return $this->objCoffeeRepository->useWater($litres);
  }

  /**
   * Returns the volume of water left in the container
   *
   * @return float number of litres remaining
   */
  public function getWater(): float
  {
    return $this->objCoffeeRepository->getWater();
  }
}

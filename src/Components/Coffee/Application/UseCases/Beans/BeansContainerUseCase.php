<?php

namespace Src\Components\Coffee\Application\UseCases\Beans;

use Src\Components\Coffee\Domain\Interfaces\BeansContainer;
use Src\Components\Coffee\Domain\Interfaces\ICoffeeRepository;
use Src\Components\Coffee\Infrastructure\Exceptions\ContainerFullException;

/**
 * Beans
 *
 */
class BeansContainerUseCase implements BeansContainer
{

  protected $objCoffeeRepository;


  public function __construct(ICoffeeRepository $iCoffeeRepository)
  {
    $this->objCoffeeRepository = $iCoffeeRepository;
  }

  /**
   * Adds beans to the container
   *
   * @param int $numSpoons number of spoons of beans
   *
   * @return void
   * @throws ContainerFullException
   *
   */
  public function addBeans(int $numSpoons): void
  {
    $this->objCoffeeRepository->addBeans($numSpoons);
  }

  /**
   * Use $numSpoons from the container
   *
   * @param int $numSpoons number of spoons of beans
   *
   * @return int number of bean spoons used
   */
  public function useBeans(int $numSpoons): int
  {
    return $this->objCoffeeRepository->useBeans($numSpoons);
  }

  /**
   * Returns the number of spoons of beans left in the container
   *
   * @return int
   */
  public function getBeans(): int
  {
    return  $this->objCoffeeRepository->getBeans();
  }
}

<?php

namespace Src\Components\Coffee\Application\UseCases\EspressoMachine;

use Src\Components\Coffee\Domain\Coffee;
use Src\Components\Coffee\Domain\Interfaces\EspressoMachineInterface;
use Src\Components\Coffee\Domain\Interfaces\BeansContainer;
use Src\Components\Coffee\Domain\Interfaces\WaterContainer;

use Src\Components\Coffee\Infrastructure\Exceptions\NoBeansException;
use Src\Components\Coffee\Infrastructure\Exceptions\NoWaterException;

/**
 * Espresso Machine
 *
 */
class EspressoMachineUseCase implements EspressoMachineInterface
{

  protected $objCoffeeRepository;
  protected $objBeans;
  protected $objWater;
  protected $objCoffee;

  public function __construct(BeansContainer $beansContainer, WaterContainer $waterContainer)
  {
    $this->objBeans = $beansContainer;
    $this->objWater = $waterContainer;
    $this->objCoffee = new Coffee();
  }

  /**
   * Runs the process for making Espresso
   *
   * @return float amount of litres of coffee made
   *
   * @throws NoBeansException
   * @throws NoWaterException
   */
  public function makeEspresso(): float
  {
    $this->objCoffee->setWater($this->objWater->getWater());
    $this->objCoffee->setBeans($this->objBeans->getBeans());

    // Validate
    if ($this->objCoffee->getWater() < $this->objCoffee->getWaterEspresso()) {
      throw new NoWaterException("There is not enough water in the machine", 500);
    } elseif ($this->objCoffee->getBeans() < $this->objCoffee->getBeansEspresso()) {
      throw new NoBeansException("There are not enough beans in the machine", 500);
    }

    $this->objWater->useWater($this->objCoffee->getWaterEspresso());
    $this->objBeans->useBeans($this->objCoffee->getBeansEspresso());

    return $this->objCoffee->getWaterEspresso();
  }

  /**
   * Runs the process for making Double Espresso
   *
   * @return float of litres of coffee made
   *
   * @throws NoBeansException
   * @throws NoWaterException
   */
  public function makeDoubleEspresso(): float
  {
    // Setter
    $this->objCoffee->setWater($this->objWater->getWater());
    $this->objCoffee->setBeans($this->objBeans->getBeans());

    // Validate
    if ($this->objCoffee->getWater() < $this->objCoffee->getWaterDoubleEspresso()) {
      throw new NoWaterException("There is not enough water in the machine", 500);
    } elseif ($this->objCoffee->getBeans() < $this->objCoffee->getBeansDoubleExpresso()) {
      throw new NoBeansException("There are not enough beans in the machine", 500);
    }

    $this->objWater->useWater($this->objCoffee->getWaterDoubleEspresso());
    $this->objBeans->useBeans($this->objCoffee->getBeansDoubleExpresso());

    return $this->objCoffee->getWaterDoubleEspresso();
  }

  /**
   * This method controls what is displayed on the screen of the machine
   * Returns ONE of the following human readable statuses in the following preference order:
   *
   * - Add beans and water
   * - Add beans
   * - Add water
   * - {int} Espressos left
   *
   * @return string
   */
  public function getStatus(): string
  {
    $this->objCoffee->setWater($this->objWater->getWater());
    $this->objCoffee->setBeans($this->objBeans->getBeans());

    $strMore = "Ned more : " . implode(" and ", $this->objCoffee->more());
    $strQt = "have more : " . $this->objCoffee->qt() . " espress";

    return $strMore . " and you " . $strQt;
  }
}

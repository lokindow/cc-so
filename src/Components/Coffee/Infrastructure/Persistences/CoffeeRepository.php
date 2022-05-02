<?php

namespace Src\Components\Coffee\Infrastructure\Persistences;

use Src\Libs\Utils;

use Src\Components\Coffee\Domain\Coffee;
use Src\Components\Coffee\Domain\Interfaces\ICoffeeRepository;

class CoffeeRepository implements ICoffeeRepository
{

    protected $objCoffee;
    protected $objUtils;

    public function __construct(CoffeeModel $model, Utils $utils)
    {
        $this->objCoffee = new Coffee();
        $this->objUtils = $utils;
        $this->model = $model;
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
        $this->model = $this->model::firstOrNew(["id" => $this->objCoffee->getId()]);

        $this->model->water = $this->model->water + $litres;

        $this->model->save();
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
        $this->model = $this->model::firstOrNew(["id" => $this->objCoffee->getId()]);

        $this->model->water =  $this->model->water - $litres;

        $this->model->save();

        return $litres;
    }

    /**
     * Returns the volume of water left in the container
     *
     * @return float number of litres remaining
     */
    public function getWater(): float
    {
        $this->model = $this->model::firstOrNew(["id" => $this->objCoffee->getId()]);

        return $this->model->getAttributes()["water"];
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
        $this->model = $this->model::firstOrNew(["id" => $this->objCoffee->getId()]);

        $this->model->beans = $this->model->beans + $numSpoons;

        $this->model->save();
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
        $this->model = $this->model::firstOrNew(["id" => $this->objCoffee->getId()]);

        $this->model->beans =  $this->model->beans - $numSpoons;

        $this->model->save();

        return $numSpoons;
    }

    /**
     * Returns the number of spoons of beans left in the container
     *
     * @return int
     */
    public function getBeans(): int
    {
        $this->model = $this->model::firstOrNew(["id" => $this->objCoffee->getId()]);

        return $this->model->getAttributes()["beans"];
    }
}

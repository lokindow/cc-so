<?php

namespace Src\Components\Coffee\Domain\Interfaces;

use Src\Components\Coffee\Infrastructure\Exceptions\ContainerFullException;

interface ICoffeeRepository
{
    /**
     * Adds water to the coffee machine's water tank
     *
     * @param float $litres number of litres of water
     *
     * @return void
     * @throws ContainerFullException
     *
     */
    public function addWater(float $litres): void;

    /**
     * Use $litres from the container
     *
     * @param float $litres float number of litres of water
     *
     * @return float number of litres used
     */
    public function useWater(float $litres): float;

    /**
     * Returns the volume of water left in the container
     *
     * @return float number of litres remaining
     */
    public function getWater(): float;

    /**
     * Adds beans to the container
     *
     * @param int $numSpoons number of spoons of beans
     *
     * @return void
     * @throws ContainerFullException
     *
     */
    public function addBeans(int $numSpoons): void;

    /**
     * Use $numSpoons from the container
     *
     * @param int $numSpoons number of spoons of beans
     *
     * @return int number of bean spoons used
     */
    public function useBeans(int $numSpoons): int;

    /**
     * Returns the number of spoons of beans left in the container
     *
     * @return int
     */
    public function getBeans(): int;
}

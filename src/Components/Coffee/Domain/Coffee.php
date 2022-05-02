<?php

namespace Src\Components\Coffee\Domain;

class Coffee
{
    // Rules
    const ESPRESSO_BEANS = 1;
    const ESPRESSO_WATER = 0.05;
    const DOUBLE_ESPRESSO_BEANS = 2;
    const DOUBLE_ESPRESSO_WATER = 0.10;
    const CONTAINER_BEANS = 50;
    const CONTAINER_WATER = 2;

    private $id = 1;
    private $beans;
    private $water;

    /**
     * Get the value of beans
     */
    public function getBeans()
    {
        return $this->beans;
    }

    /**
     * Get the value of beans
     */
    public function getBeansEspresso()
    {
        return self::ESPRESSO_BEANS;
    }

    /**
     * Get the value of double beans
     */
    public function getBeansDoubleExpresso()
    {
        return self::DOUBLE_ESPRESSO_BEANS;
    }

    /**
     * Get the value of water
     */
    public function getWater()
    {
        return $this->water;
    }

    /**
     * Get the value of water
     */
    public function getWaterEspresso()
    {
        return self::ESPRESSO_WATER;
    }

    /**
     * Get the value of water
     */
    public function getWaterDoubleEspresso()
    {
        return self::DOUBLE_ESPRESSO_WATER;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of beans
     *
     * @return  self
     */
    public function setBeans($beans)
    {
        $this->beans = $beans;

        return $this;
    }

    /**
     * Set the value of water
     *
     * @return  self
     */
    public function setWater($water)
    {
        $this->water = $water;

        return $this;
    }

    /**
     * What more does he need
     *
     * @return array
     */
    public function more(): array
    {
        $arrResult = [];

        if ($this->beans < self::CONTAINER_BEANS) {
            $arrResult = ["beans"];
        }
        if ($this->water < self::CONTAINER_WATER) {
            $arrResult = ["water"];
        }

        return $arrResult;
    }

    /**
     * How many espressos more
     *
     * @return array
     */
    public function qt(): int
    {
        return min($this->beans / self::ESPRESSO_BEANS, $this->water / self::ESPRESSO_WATER);
    }
}

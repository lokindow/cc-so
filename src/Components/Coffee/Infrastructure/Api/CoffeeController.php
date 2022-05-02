<?php

namespace Src\Components\Coffee\Infrastructure\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

use Src\Components\Coffee\Infrastructure\Api\CoffeePresenter;
use Src\Components\Coffee\Domain\Interfaces\EspressoMachineInterface;

class CoffeeController extends Controller
{
    protected $objEspressoMachine;
    protected $objPresenter;

    public function __construct(EspressoMachineInterface $espressoMachineInterface, CoffeePresenter $coffeePresenter)
    {
        $this->objPresenter = $coffeePresenter;
        $this->objEspressoMachine = $espressoMachineInterface;
    }

    /**
     * Espresso
     *
     * @param  Request  $objRequest
     * @return Json
     */
    public function setEspresso(Request $objRequest): JsonResponse
    {
        $objResult = $this->objEspressoMachine->makeEspresso();
        $objOutput = $this->objPresenter->formatCoffeeInt($objResult);

        return response()->json($objOutput, 201);
    }

    /**
     * Double Espresso
     *
     * @param  Request  $objRequest
     * @return Json
     */
    public function setDoubleEspresso(Request $objRequest): JsonResponse
    {
        $objResult = $this->objEspressoMachine->makeDoubleEspresso();
        $objOutput = $this->objPresenter->formatCoffeeInt($objResult);

        return response()->json($objOutput, 201);
    }

    /**
     * Status
     *
     * @param  Request  $objRequest
     * @return Json
     */
    public function getStatus(Request $objRequest): JsonResponse
    {
        $objResult = $this->objEspressoMachine->getStatus();
        $objOutput = $this->objPresenter->formatCoffeeStr($objResult);

        return response()->json($objOutput, 200);
    }
}

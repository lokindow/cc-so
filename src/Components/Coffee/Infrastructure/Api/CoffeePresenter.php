<?php

namespace Src\Components\Coffee\Infrastructure\Api;

use Src\Libs\CommonPresenter;

class CoffeePresenter extends CommonPresenter
{
    public function formatCoffeeInt($intOutput)
    {
        $objOutput = (object)["Number_of_litres_of_coffee_made" => $intOutput];

        $objOutput = parent::present($objOutput);

        return $objOutput;
    }
    public function formatCoffeeStr($strOutput)
    {
        $objOutput = (object)["Result" => $strOutput];

        $objOutput = parent::present($objOutput);

        return $objOutput;
    }
}

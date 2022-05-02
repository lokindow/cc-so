<?php

namespace Src\Libs;

use Src\Libs\Utils;

class CommonPresenter
{

  protected $objUtils;

  public function __construct()
  {
    $this->objUtils = new Utils();
  }

  public function present($objOutput)
  {
    if (!empty($objOutput->error)) {
      return $this->objUtils->getFormattedErrorMessage(
        $objOutput->error->message,
        $objOutput->error->status,
        $objOutput->error->errors
      );
    }

    $objOutput->meta = [];
    $objOutput->meta['created_at'] = time();
    $objOutput->meta['created_date'] = date('Y-m-d H:i:s');


    return (array) $objOutput;
  }

  public function presentPagination($objOutput)
  {
    $objOutputFormatted = $this->present($objOutput);
    $arrData = [];

    if (!empty($objOutputFormatted['data']) && !empty($objOutputFormatted['data']['data'])) {
      $arrData = $objOutputFormatted['data']['data'];
      unset($objOutputFormatted['data']['data']);

      $objOutputFormatted['meta'] = $objOutputFormatted['data'];
      $objOutputFormatted['data'] = $arrData;
    }

    return (array) $objOutputFormatted;
  }
}

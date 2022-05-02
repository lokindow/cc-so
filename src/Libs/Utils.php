<?php

namespace Src\Libs;

use Src\Libs\Log;

class Utils
{
    /**
     * Get camelized text, if $bitPascalCase is true (default) it will return a PascalCase style
     *
     * @param string $strText
     * @param string $strSeparator
     * @param bool $bitPascalCase
     * @return string
     */
    public function getCamelizedText(string $strText, string $strSeparator = '_', bool $bitPascalCase = true): string
    {
        $strReturn = str_replace($strSeparator, '', ucwords($strText, $strSeparator));
        return (string) ($bitPascalCase ? $strReturn : lcfirst($strReturn));
    }

    /**
     * Convert entity to array
     *
     * @param [mixed] $varData
     * @return array
     */
    public function entityToArray($varData): array
    {
        $reflectionClass = new \ReflectionClass(get_class($varData));
        $array = [];
        foreach ($reflectionClass->getProperties() as $property) {
            $property->setAccessible(true);
            if ($property->getValue($varData))
                $array[$property->getName()] = $property->getValue($varData);

            $property->setAccessible(false);
        }
        return $array;
    }

    /**
     * Get message error translated and formated as array
     *
     * @param string $strMessage
     * @param int $intStatusCode
     * @param array $arrErrors
     * @return array
     */
    public function getFormattedErrorMessage(string $strMessage, int $intStatusCode, array $arrErrors = []): array
    {
        $arrTranslated = [];
        foreach ($arrErrors as $error) {
            if (!empty($error['extra'])) {
                $arrTranslated[$error['extra']['key']][] = __($error['validation'], $error['extra']);
            }
        }

        return [
            "error" => [
                "message" => env('APP_ENV') != 'testing' ? __($strMessage) : $strMessage,
                "status" => $intStatusCode,
                "errors" => $arrTranslated
            ]
        ];
    }

    /**
     * Get a formatted api error message
     *
     * @param int
     * @return JsonResponse
     */
    public function getApiError(int $intStatusCode = 500)
    {
        $strMsg = null;
        switch ($intStatusCode) {
            case 401:
                $strMsg = 'custom.token_not_provided';
                break;
            case 403:
                $strMsg = 'custom.access_denied';
                break;
            case 404:
                $strMsg = 'custom.not_found';
                break;
            case 422:
                $strMsg = 'custom.bad_request';
                break;
            case 429:
                $strMsg = 'custom.limit_exceeded';
                break;
            case 500:
                $strMsg = 'custom.generic_error';
                break;
            case 0:
            case 503:
                $intStatusCode = 503;
                $strMsg = 'custom.service_unavailable';
                break;
            case 504:
                $intStatusCode = 504;
                $strMsg = 'custom.gateway_timeout';
                break;
            default:
                $intStatusCode = 500;
                $strMsg = 'custom.generic_error';
                break;
        }

        $arrOutputError = $this->getFormattedErrorMessage((string) $strMsg, $intStatusCode);
        $objLog = new Log();
        $objLog->writeLine(
            'error',
            'Generic Exception Handler: ',
            $arrOutputError
        );

        return response()->json($arrOutputError, $intStatusCode);
    }

    /**
     * Get status code and message from cURL error
     *
     * @param int
     * @return JsonResponse
     */
    public function getCurlError($intCurlErrno = null)
    {
        $strMessage = null;
        $intStatusCode = 0;
        switch ($intCurlErrno) {
            case 43: //CURLE_BAD_FUNCTION_ARGUMENT
            case 61: //CURLE_BAD_CONTENT_ENCODING
                $intStatusCode = 400;
                $strMessage = 'custom.bad_request';
                break;
            case 8: //CURLE_FTP_WEIRD_SERVER_REPLY
            case 9: //CURLE_REMOTE_ACCESS_DENIED
            case 67: //CURLE_LOGIN_DENIED
            case 79: //CURLE_SSH
                $intStatusCode = 403;
                $strMessage = 'custom.access_denied';
                break;
            case 5: //CURLE_FTP_WEIRD_SERVER_REPLY
            case 6: //CURLE_COULDNT_RESOLVE_HOST
            case 7: //CURLE_COULDNT_CONNECT
            case 34: //CURLE_HTTP_POST_ERROR
                $intStatusCode = 503;
                $strMessage = 'custom.service_unavailable';
                break;
            case 28: //CURLE_OPERATION_TIMEDOUT
                $intStatusCode = 504;
                $strMessage = 'custom.gateway_timeout';
                break;
            default:
                $intStatusCode = 500;
                $strMessage = 'custom.generic_error';
                break;
        }

        return [
            "error" => [
                "message" => env('APP_ENV') != 'testing' ? __($strMessage) : $strMessage,
                "status" => $intStatusCode
            ]
        ];
    }

    /**
     * Function to encapsulate data in Sub Arrays/Objects
     * It will use the prefix passed as args to wrap the items
     *
     * @param array $arrOriginal
     * @param string $strPrefix
     * @return array/Object
     */
    public function encapsulateData(array $arrOriginal, string $strPrefix)
    {
        $objReturn = [];
        $objReturn[$strPrefix] = [];
        foreach ($arrOriginal as $key => $value) {
            if (strpos($key, $strPrefix) !== false) {
                $strNewKey = substr($key, strlen($strPrefix) + 1);
                $objReturn[$strPrefix][$strNewKey] = $value;
            } else {
                $objReturn[$key] = $value;
            }
        }
        settype($objReturn, gettype($arrOriginal));
        return $objReturn;
    }

    /**
     * Function to get formatted key of cache
     *
     * @param string $strPrefix
     * @param integer $intId
     * @param integer $intPeriod
     * @return string
     */
    public function getFormattedKey(string $strPrefix, int $intId, int $intPeriod): string
    {
        return $strPrefix . "_" . $intId . "_" . date("Hi", round(time() / ($intPeriod * 60)) * ($intPeriod * 60));
    }

    /**
     * Function to substract extension/TLD of domain
     *
     * @param string $strDomain
     * @return void
     */
    public function getDomainExtension(string $strDomain)
    {
        $strDomain = str_replace("www.", "", $strDomain);
        return substr(
            $strDomain,
            strpos($strDomain, ".")
        );
    }

    /**
     * Get the difference between to dates in hours
     *
     * @param string $strDateStart
     * @param string $strDateEnd
     * @return int
     */
    public function getDateDiff(string $strDateStart, string $strDateEnd = "now")
    {
        $dteStart = new \DateTime($strDateStart);
        $objDiff = $dteStart->diff(new \DateTime($strDateEnd));
        return $objDiff->days * 24 + $objDiff->h;
    }

    /**
     * Filter null in array[]
     *
     * @param array $arrayArgs
     * @return array
     */


    private function filterArray($elementArray)
    {
        return ($elementArray !== null);
    }


    public function filterNullArray(array $arrArgs)
    {
        $arr = array_filter($arrArgs, [$this, "filterArray"]);

        return $arr ?? [];
    }

    /** Validate CPF
     *
     * @param string $strCpf
     * @return bool
     */
    public function validateCpf(string $strCpf): bool
    {
        //Gets only the numbers
        $strCpf = preg_replace('/[^0-9]/is', '', $strCpf);

        //Checks that all digits were entered correctly
        if (strlen($strCpf) != 11) {
            return false;
        }
        //Checks whether a sequence of repeated digits has been entered. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $strCpf)) {
            return false;
        }
        //Calculates and checks if CPF is valid
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $strCpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($strCpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }

    /**
     * Return a filtered array, based on "$arrSource" using "$arrKeys" as mapper.
     *
     * @param array $arrSource
     * @param array $arrKeys
     * @return array
     */
    function array_intersect_key_recursive(array $arrSource, array $arrKeys): array
    {
        if (!is_numeric(array_key_first($arrSource))) {
            $arrSource = array_intersect_key($arrSource, $arrKeys);
        }

        foreach ($arrSource as $key => $value) {
            if (is_array($value)) {
                $arrSource[$key] = $this->array_intersect_key_recursive($value, $arrKeys);
            }
        }
        return $arrSource;
    }

    public function getArrayGroupedby(array $arr, $key): array
    {
        if (!is_string($key) && !is_int($key) && !is_float($key) && !is_callable($key)) {
            trigger_error('getArrayGroupedby(): The key should be a string, an integer, a float, or a function', E_USER_ERROR);
        }

        $isFunction = !is_string($key) && is_callable($key);

        // Load the new array, splitting by the target key
        $grouped = [];
        foreach ($arr as $value) {
            $groupKey = null;

            if ($isFunction) {
                $groupKey = $key($value);
            } else if (is_object($value)) {
                $groupKey = $value->{$key};
            } else {
                $groupKey = $value[$key];
            }

            $grouped[$groupKey][] = $value;
        }

        // Recursively build a nested grouping if more parameters are supplied
        // Each grouped array value is grouped according to the next sequential key
        if (func_num_args() > 2) {
            $args = func_get_args();

            foreach ($grouped as $groupKey => $value) {
                $params = array_merge([$value], array_slice($args, 2, func_num_args()));
                $grouped[$groupKey] = call_user_func_array('getArrayGroupedby', $params);
            }
        }

        return $grouped;
    }
}

<?php
/**
 * Code written is strictly used within this program.
 * Any other use of this code is in violation of copy rights.
 *
 * @package   Core
 * @author    Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright 2016 Developer
 * @license   - No License
 * @version   GIT: $Id$
 * @link      -
 */
namespace Bridge\Core\Services;

/**
 * Curl class description.
 *
 * @package    Core
 * @subpackage Services
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
class Curl
{

    /**
     * Allowed empty parameter option property.
     *
     * @var boolean $AllowedEmptyParameter
     */
    private $AllowedEmptyParameter;

    /**
     * Char set property.
     *
     * @var string $Charset
     */
    private $CharSet;

    /**
     * Content type property.
     *
     * @var string $ContentType
     */
    private $ContentType;

    /**
     * Data that will be passed to url via curl http.
     *
     * @var array $Data
     */
    private $Data;

    /**
     * Error message property.
     *
     * @var string $ErrorMsg
     */
    private $ErrorMsg;

    /**
     * Error number property.
     *
     * @var integer $ErrorNo
     */
    private $ErrorNo;

    /**
     * Header return option.
     *
     * @var boolean $HeaderReturn
     */
    private $HeaderReturn;

    /**
     * Method that will be used to call http request via curl.
     *
     * @var string $Method
     */
    private $Method;

    /**
     * Response for curl execution.
     *
     * @var string $Response
     */
    private $Response;

    /**
     * Response format property.
     *
     * @var string $ResponseFormat
     */
    private $ResponseFormat;

    /**
     * Response info that get from after curl execution.
     *
     * @var array $ResponseInfo
     */
    private $ResponseInfo;

    /**
     * Return transfer curl result as string option property.
     *
     * @var boolean $ReturnTransfer
     */
    private $ReturnTransfer;

    /**
     * Url that will be called by curl.
     *
     * @var string $Url
     */
    private $Url;

    /**
     * Accepted content type set data array property.
     *
     * @var $AcceptedContentType
     */
    private static $AcceptedContentType = [
        'json' => 'application/json',
        'form' => 'application/x-www-form-urlencoded',
        'xml'  => 'text/xml',
        'html' => 'text/html'
    ];

    /**
     * Accepted method by curl format data array property.
     *
     * @var array $AcceptedMethod
     */
    private static $AcceptedMethod = ['POST', 'GET', 'PUT', 'DELETE', 'HEAD'];

    /**
     * Accepted response format data array property.
     *
     * @var array $AcceptedResponseFormat
     */
    private static $AcceptedResponseFormat = ['array', 'json', 'serial', 'string', 'xml'];

    /**
     * CurlHandler constructor.
     *
     * @param string $url         Url parameter.
     * @param array  $data        Data parameter.
     * @param string $method      Method parameter.
     * @param string $contentType Content type parameter.
     */
    public function __construct($url = '', array $data = [], $method = 'post', $contentType = 'form')
    {
        $this->setUrl($url);
        $this->setData($data);
        $this->setMethod($method);
        $this->setContentType($contentType);
        $this->setResponseFormat('string');
        $this->setHeaderReturn(false);
        $this->setReturnTransfer(true);
    }

    /**
     * Execute call to http via curl.
     *
     * @throws \Bridge\Core\Exceptions\Types\Debug If the data passed is not valid.
     * @return void
     */
    public function doExecute()
    {
        if ($this->doValidateData() === true) {
            $curlHandle = curl_init();
            if ($this->getMethod() === 'POST') {
                curl_setopt($curlHandle, CURLOPT_URL, $this->getUrl());
                curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $this->getBuildData());
            } elseif ($this->getMethod() === 'GET') {
                # Override the CURLOPT_URL.
                curl_setopt($curlHandle, CURLOPT_URL, $this->getUrl() . '?' . $this->getBuildData());
            }
            $contentType = 'Content-Type: ' . $this->getContentType();
            if (empty($this->getCharSet()) === false) {
                $contentType = '; charset=' . $this->getCharSet();
            }
            curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, $this->getMethod());
            curl_setopt($curlHandle, CURLOPT_HEADER, $this->isHeaderReturn());
            curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, (boolean)$this->isReturnTransfer());
            curl_setopt($curlHandle, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($curlHandle, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
            curl_setopt(
                $curlHandle,
                CURLOPT_HTTPHEADER,
                [
                    $contentType,
                    'Content-Length: ' . strlen($this->getBuildData())
                ]
            );
            $this->Response = curl_exec($curlHandle);
            $this->ResponseInfo = curl_getinfo($curlHandle);
            if ((boolean)curl_errno($curlHandle) === true) {
                $this->ErrorNo = curl_errno($curlHandle);
                $this->ErrorMsg = curl_error($curlHandle);
            }
            curl_close($curlHandle);
        } else {
            throw new \Bridge\Core\Exceptions\Types\Debug('The data parameter that has been passed is not valid');
        }
    }

    /**
     * Do validate content type header format.
     *
     * @param string $contentType The content type parameter that will be validated.
     *
     * @return boolean
     */
    public static function doValidateContentType($contentType)
    {
        return array_key_exists(strtolower($contentType), static::$AcceptedContentType);
    }

    /**
     * Do validate method that want to be used by curl.
     *
     * @param string $method The method string that will be validated.
     *
     * @return boolean
     */
    public static function doValidateMethod($method)
    {
        return in_array(strtoupper($method), static::$AcceptedMethod, true);
    }

    /**
     * Do validate response format.
     *
     * @param string $responseFormat The response format parameter that will be validated.
     *
     * @return boolean
     */
    public static function doValidateResponseFormat($responseFormat)
    {
        return in_array($responseFormat, static::$AcceptedResponseFormat, true);
    }

    /**
     * Get build data that want be passed to curl.
     *
     * @return string
     */
    public function getBuildData()
    {
        $result = '';
        if (empty($this->getData()) === false) {
            switch ((string)array_search($this->getContentType(), static::$AcceptedContentType, false)) {
                case 'json':
                    if (is_array($this->getData()) === true) {
                        $result = json_encode($this->getData());
                    }
                    break;
                case 'form':
                    if (is_array($this->getData()) === true) {
                        $result = http_build_query($this->getData());
                    }
                    break;
                default:
                    $result = $this->getData();
                    break;
            }
        }
        return $result;
    }

    /**
     * Get charset property.
     *
     * @return string
     */
    public function getCharSet()
    {
        return $this->CharSet;
    }

    /**
     * Get content type property.
     *
     * @return string
     */
    public function getContentType()
    {
        return $this->ContentType;
    }

    /**
     * Get data parameter property.
     *
     * @return array
     */
    public function getData()
    {
        return $this->Data;
    }

    /**
     * Get error message property.
     *
     * @return string
     */
    public function getErrorMsg()
    {
        return $this->ErrorMsg;
    }

    /**
     * Get error number property.
     *
     * @return integer
     */
    public function getErrorNo()
    {
        return $this->ErrorNo;
    }

    /**
     * Get method property.
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->Method;
    }

    /**
     * Get response property.
     *
     * @return string
     */
    public function getResponse()
    {
        return $this->Response;
    }

    /**
     * Get Response format property.
     *
     * @return string
     */
    public function getResponseFormat()
    {
        return $this->ResponseFormat;
    }

    /**
     * Get curl response info property.
     *
     * @return array
     */
    public function getResponseInfo()
    {
        return $this->ResponseInfo;
    }

    /**
     * Get url property.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->Url;
    }

    /**
     * Get allowed empty parameter property.
     *
     * @return boolean
     */
    public function isAllowedEmptyParameter()
    {
        return $this->AllowedEmptyParameter;
    }

    /**
     * Get if curl execution raised any error.
     *
     * @return boolean
     */
    public function isError()
    {
        return (empty($this->ErrorNo) === false);
    }

    /**
     * Get header return option property.
     *
     * @return boolean
     */
    public function isHeaderReturn()
    {
        return $this->HeaderReturn;
    }

    /**
     * Get the return transfer option property
     *
     * @return boolean
     */
    public function isReturnTransfer()
    {
        return $this->ReturnTransfer;
    }

    /**
     * Set Allowed empty parameter.
     *
     * @param boolean $allowedEmptyParameter The allowed empty parameter option parameter.
     *
     * @return void
     */
    public function setAllowedEmptyParameter($allowedEmptyParameter)
    {
        $this->AllowedEmptyParameter = $allowedEmptyParameter;
    }

    /**
     * Set charset property.
     *
     * @param string $charSet The charset parameter.
     *
     * @return void
     */
    public function setCharSet($charSet)
    {
        $this->CharSet = strtolower($charSet);
    }

    /**
     * Set content type property.
     *
     * @param string $contentType The Content type parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Debug If invalid content type parameter given.
     * @return void
     */
    public function setContentType($contentType)
    {
        if (static::doValidateContentType($contentType) === true) {
            $this->ContentType = static::$AcceptedContentType[$contentType];
        } else {
            throw new \Bridge\Core\Exceptions\Types\Debug('Invalid content type parameter for curl');
        }
    }

    /**
     * Set data parameter property.
     *
     * @param array $data The data parameter.
     *
     * @return void
     */
    public function setData(array $data)
    {
        $this->Data = $data;
    }

    /**
     * Set header return option property.
     *
     * @param boolean $headerReturn The header return option parameter.
     *
     * @return void
     */
    public function setHeaderReturn($headerReturn)
    {
        $this->HeaderReturn = $headerReturn;
    }

    /**
     * Set Curl Method property.
     *
     * @param string $method The curl method parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Debug If invalid method parameter given.
     * @return void
     */
    public function setMethod($method)
    {
        if (static::doValidateMethod($method) === true) {
            $this->Method = strtoupper($method);
        } else {
            throw new \Bridge\Core\Exceptions\Types\Debug('Invalid method parameter for curl');
        }
    }

    /**
     * Set response format property.
     *
     * @param string $responseFormat The curl response format parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Debug If invalid response format given.
     * @return void
     */
    public function setResponseFormat($responseFormat)
    {
        if (static::doValidateResponseFormat($responseFormat) === true) {
            $this->ResponseFormat = $responseFormat;
        } else {
            throw new \Bridge\Core\Exceptions\Types\Debug('Invalid response format given');
        }
    }

    /**
     * Set the return transfer property.
     *
     * @param boolean $returnTransfer The return transfer option parameter.
     *
     * @return void
     */
    public function setReturnTransfer($returnTransfer)
    {
        $this->ReturnTransfer = $returnTransfer;
    }

    /**
     * Set Url property.
     *
     * @param string $url Url string parameter.
     *
     * @return void
     */
    public function setUrl($url)
    {
        $this->Url = $url;
    }

    /**
     * Do validate curl data that want to be passed.
     *
     * @return boolean
     */
    private function doValidateData()
    {
        return (empty($this->getData()) === false or $this->isAllowedEmptyParameter() === true) and empty($this->getUrl(
        )) === false;
    }
}

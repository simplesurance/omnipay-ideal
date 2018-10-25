<?php

namespace Bamarni\Omnipay\Ideal\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class FetchIssuersResponse extends AbstractResponse
{
    protected $isSuccessful;

    public function __construct(RequestInterface $request, ResponseInterface $response)
    {
        parent::__construct($request, $this->decodeXml($response));

        $this->isSuccessful = ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) || $response->getStatusCode() == 304;
    }

    public function isSuccessful()
    {
        return $this->isSuccessful;
    }

    public function getIssuers()
    {
        $issuers = array();

        foreach ($this->data->banks->bank as $bank) {
            $id = (string) $bank->code;
            $issuers[$id] = (string) $bank->name;
        }

        return $issuers;
    }

    private function decodeXml(ResponseInterface $response)
    {
        $xml = null;
        $errorMessage = null;
        $internalErrors = libxml_use_internal_errors(true);
        $disableEntities = libxml_disable_entity_loader(true);
        libxml_clear_errors();

        try {
            $xml = new \SimpleXMLElement((string) $response->getBody() ?: '<root />', LIBXML_NONET);
            if ($error = libxml_get_last_error()) {
                $errorMessage = $error->message;
            }
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
        }

        libxml_clear_errors();
        libxml_use_internal_errors($internalErrors);
        libxml_disable_entity_loader($disableEntities);

        if ($errorMessage) {
            throw new \RuntimeException('Unable to parse response body into XML: ' . $errorMessage);
        }

        return $xml;
    }
}

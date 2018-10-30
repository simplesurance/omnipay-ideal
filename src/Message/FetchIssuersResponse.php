<?php

namespace Bamarni\Omnipay\Ideal\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\FetchIssuersResponseInterface;
use Omnipay\Common\Message\RequestInterface;

class FetchIssuersResponse extends AbstractResponse implements FetchIssuersResponseInterface
{
    public function __construct(RequestInterface $request, string $data = null, int $statusCode)
    {
        $data = null;
        if (($statusCode >= 200 && $statusCode < 300) || $statusCode == 304) {
            $data = $this->decode($data);
        }

        parent::__construct($request, $data);
    }

    public function isSuccessful()
    {
        return is_object($this->data) && isset($this->data->banks->bank);
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

    private function decode(string $data)
    {
        $xml = null;
        $errorMessage = null;
        $internalErrors = libxml_use_internal_errors(true);
        $disableEntities = libxml_disable_entity_loader(true);
        libxml_clear_errors();

        try {
            $xml = new \SimpleXMLElement($data ?: '<root />', LIBXML_NONET);
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

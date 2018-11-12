<?php

namespace Bamarni\Omnipay\Ideal\Message;

class FetchIssuersRequest extends AbstractRequest
{
    public function sendData($data)
    {
        $response = $this->httpClient->request($this->getHttpMethod(), $this->getEndpoint(), $this->getHeaders());

        return $this->response = new FetchIssuersResponse($this, $response->getBody()->getContents(), $response->getStatusCode());
    }

    private function getHeaders()
    {
        return [
            'Content-Type'  => 'application/xml; charset=UTF-8',
            'Accept'        => 'application/xml; charset=UTF-8',
            'Authorization' => 'Basic ' . base64_encode($this->getUserId() . ':' . $this->getApiKey())
        ];
    }

    private function getEndpoint()
    {
        return 'https://www.sofort.com/payment/ideal/banks';
    }

    private function getHttpMethod()
    {
        return 'POST';
    }
}

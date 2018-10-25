<?php

namespace Bamarni\Omnipay\Ideal\Message;

class FetchIssuersRequest extends AbstractRequest
{
    public function sendData($data)
    {
        $response = $this->httpClient->request(
            'POST',
            'https://www.sofort.com/payment/ideal/banks',
            [
                'Content-Type'  => 'application/xml; charset=UTF-8',
                'Accept'        => 'application/xml; charset=UTF-8',
                'Authorization' => 'Basic ' . base64_encode($this->getUserId() . ':' . $this->getApiKey())
            ]
        );

        return $this->response = new FetchIssuersResponse($this, $response);
    }
}

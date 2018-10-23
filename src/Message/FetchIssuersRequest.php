<?php

namespace Bamarni\Omnipay\Ideal\Message;

use GuzzleHttp\Psr7\Request;

class FetchIssuersRequest extends AbstractRequest
{
    public function sendData($data)
    {
        $request = new Request(
            'POST',
            'https://www.sofort.com/payment/ideal/banks',
            [
                'Content-Type' => 'application/xml; charset=UTF-8',
                'Accept'       => 'application/xml; charset=UTF-8',
            ]
        );

        $response = $this->httpClient->request($request, ['auth' => [$this->getUserId(), $this->getApiKey(), 'Basic']]);

        return $this->response = new FetchIssuersResponse($this, $response);
    }
}

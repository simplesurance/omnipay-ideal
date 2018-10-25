<?php

namespace Bamarni\Omnipay\Ideal;

use Bamarni\Omnipay\Ideal\Message\CompleteAuthorizeRequest;
use Bamarni\Omnipay\Ideal\Message\FetchIssuersRequest;
use Bamarni\Omnipay\Ideal\Message\PurchaseRequest;
use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway
{
    use Parameters;

    public function getName()
    {
        return 'iDeal';
    }

    public function getDefaultParameters()
    {
        return array(
            'testMode' => false,
        );
    }

    public function fetchIssuers(array $parameters = array())
    {
        return $this->createRequest(FetchIssuersRequest::class, $parameters);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    public function authorize(array $parameters = array())
    {
        return $this->purchase($parameters);
    }

    public function completeAuthorize(array $parameters = array())
    {
        return $this->createRequest(CompleteAuthorizeRequest::class, $parameters);
    }
}

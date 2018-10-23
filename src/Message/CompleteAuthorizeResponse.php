<?php

namespace Bamarni\Omnipay\Ideal\Message;

use Omnipay\Common\Message\AbstractResponse;

class CompleteAuthorizeResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return true;
    }

    public function getTransactionReference()
    {
        return $this->data;
    }
}

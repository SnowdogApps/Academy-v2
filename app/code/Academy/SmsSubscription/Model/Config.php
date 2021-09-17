<?php

namespace Snowdog\Academy\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    private ScopeConfigInterface $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function isEnabled(): bool
    {
        return (bool) $this->scopeConfig->getValue(
            'smssubscription/general/enable',
            ScopeInterface::SCOPE_STORE
        );
    }
}

<?php

namespace Academy\ProductFeed\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    private ScopeConfigInterface $scopeConfig;

    public const FIELD_NAME_ENABLE = 'product_feed/general/enable';

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function isEnabled(): bool
    {
        return (bool)$this->scopeConfig->getValue(
            self::FIELD_NAME_ENABLE,
            ScopeInterface::SCOPE_STORE
        );
    }
}

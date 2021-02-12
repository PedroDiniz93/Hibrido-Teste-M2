<?php

namespace Hibrido\ColorPalette\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Hibrido\ColorPalette\Helper\Log;
use Hibrido\ColorPalette\Helper\Config;

class Style extends Template
{
    protected $configHelper;

    public function __construct(Context $context, Config $configHelper)
    {
        $this->configHelper = $configHelper;
        parent::construct($context);
    }

    public function getColorConfig()
    {
        Log::createLog($this->configHelper->getConfigValue('color'));
        return $this->configHelper->getConfigValue('color', 1);
    }
}
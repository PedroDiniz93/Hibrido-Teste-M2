<?php

namespace Hibrido\ColorPalette\Block;

use Magento\Framework\View\Element\Template\Context;

use Hibrido\ColorPalette\Helper\Config as HelperConfig;
use Hibrido\ColorPalette\Helper\Log as LogHelper;
use Magento\Store\Model\StoreManagerInterface;

class Style extends \Magento\Framework\View\Element\Template
{
    /**
     * @var HelperConfig
     */
    protected $helperConfig;

        /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @param Context $context
     * @param HelperConfig $helperConfig
     * @param array $data
     */
    public function __construct(
        Context $context,
        HelperConfig $helperConfig,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->storeManager = $storeManager;
        $this->helperConfig = $helperConfig;
        parent::__construct($context, $data);
    }

    /**
     * @return string|void
     */
    public function getColorSaved()
    {
        try {
            if ($this->helperConfig->getConfigValue('active', $this->storeManager->getStore()->getWebsiteId())) {
                return $this->helperConfig->getConfigValue(
                    'color',
                    $this->storeManager->getStore()->getWebsiteId()
                );
            }
        } catch (\Exception $e) {
            LogHelper::createLog($e->getMessage());
        }
    }

    /**
     * @return string
     */
    public function getCSS()
    {
        if ($this->getColorSaved()) {
            return  '<style> .button{ background-color: #' . $this->getColorSaved() . '!important; } </style>';
        }
    }
}

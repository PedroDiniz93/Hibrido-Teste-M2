<?php

namespace Hibrido\ColorPalette\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Cache\TypeListInterface;

class Config extends AbstractHelper
{
    /**
     * Constantes responsáveis por guardar o caminho das configurações de system.xml
     */
    const BASE_CONFIG = 'colorpalette/general/';

    /**
     * @var Magento\Framework\App\Config\ScopeConfigInterface
     * @var Magento\Framework\App\Config\MutableScopeConfigInterface
     */
    protected $scopeConfig;
    protected $configWriter;
    protected $cacheTypeList;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param MutableScopeConfigInterface $scopeConfig
     */
    public function __construct(
        WriterInterface $configWriter,
        ScopeConfigInterface $scopeConfig,
        TypeListInterface $cacheTypeList
    ) {
        $this->configWriter = $configWriter;
        $this->scopeConfig = $scopeConfig;
        $this->cacheTypeList = $cacheTypeList;
    }

    /**
     * Retorna o valor salvo no painel administrativo.
     * Deve ser passado o caminho do campo de configuração que deseja obter o valor
     *
     * @param String $field
     * @return void
     */
    public function getConfigValue($field, $storeId = null)
    {
        try {
            return $this->scopeConfig->getValue(
                self::BASE_CONFIG . $field,
                ScopeInterface::SCOPE_STORE,
                $storeId
            );
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Seta o valor no painel administrativo.
     * Deve ser passado o caminho do campo de configuração setar o valor
     *
     * @param String $field
     * @return void
     */
    public function setConfigValue($field, $value, $storeId = null)
    {
        try {
            $this->configWriter->save(
                self::BASE_CONFIG . $field,
                $value,
                ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
                $storeId
            );
            $this->cacheTypeList->cleanType(\Magento\Framework\App\Cache\Type\Config::TYPE_IDENTIFIER);
            $this->cacheTypeList->cleanType(\Magento\PageCache\Model\Cache\Type::TYPE_IDENTIFIER);
            return $this;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
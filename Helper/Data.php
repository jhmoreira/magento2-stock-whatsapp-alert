<?php
namespace Moreira\LowStock\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper{

    const XML_PATH_WHATSAPP = "lowstock/general/whatsapp";
    const XML_PATH_THRESHOLD = "lowstock/general/thereshold";
    const XML_PATH_LIMIT = "lowstock/general/limit";


    public function getThreshold($storeId = null){
        return $this->scopeConfig->getValue(
            self::XML_PATH_THRESHOLD,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function getLimit($storeId = null){
        return $this->scopeConfig->getValue(
            self::XML_PATH_LIMIT,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function getWhatsAppNumber($storeId = null){
        return $this->scopeConfig->getValue(
            self::XML_PATH_WHATSAPP,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
?>
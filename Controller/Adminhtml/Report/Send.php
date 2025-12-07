<?php

namespace Moreira\LowStock\Controller\Adminhtml\Report;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Moreira\LowStock\Model\VerifyStock;
use Magento\Framework\Controller\Result\RawFactory;

class Send extends Action{
   private  VerifyStock $verifyStock;
   private RawFactory $resultRawFactory;
   private $helper;

   public function __construct(
    Context $context,
    VerifyStock $verifyStock,
    RawFactory $resultRawFactory,
    \Moreira\LowStock\Helper\Data $helper){
    parent::__construct($context);
    $this->verifyStock = $verifyStock;
    $this->resultRawFactory = $resultRawFactory;
    $this->helper = $helper;
   }

    public function _isAllowed(){
        return $this->_authorization->isAllowed('Moreira_LowStock::send_report');
    }

    public function execute(){
        $threshold = $this->helper->getThreshold();
        $limit = $this->helper->getLimit();
        $whats = $this->helper->getWhatsAppNumber();

        $items = $this->verifyStock->getLowStock($threshold, $limit);
        $total = $this->verifyStock->getTotalLowStock($threshold);

        if(empty($items)){
            $this->messageManager->addNoticeMessage(__('Nenhum produto com estoque abaixo de %1', $threshold));
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('adminhtml/dashboard/index');
            return $resultRedirect;
        }
        $message = "{$total} produtos com estoque baixo. \n";
        foreach($items as $item){
            $qty = intval($item['qty']);
            $message .= "{$item['name']} (SKU: {$item['sku']}) - Quantidade: {$qty} \n";
        }
        $link = "https://wa.me/{$whats}?text=" . urlencode($message);
        $resultRaw = $this->resultRawFactory->create();
        $page = $this->_redirect->getRefererUrl();
        $js ="<script>
        window.open('{$link}', '_blank');
        window.location.href = '{$page}';
        </script>";
        return $resultRaw->setContents($js);

    }
}
<?php

namespace Moreira\LowStock\Model;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class VerifyStock{
    protected $productCollectionFactory;
    protected $storeManager;

    public function __construct(
        CollectionFactory $productCollectionFactory,
        StoreManagerInterface $storeManager
        ){
        $this->productCollectionFactory = $productCollectionFactory;
        $this->storeManager = $storeManager;
        }

    public function getLowStock($threshold =10, $limit = 10){
        $storeId = $this->storeManager->getStore()->getId();

        $collection = $this->productCollectionFactory->create();
        $collection->addStoreFilter($storeId);
        $collection->addAttributeToSelect(['name','sku']);

        $resource = $collection->getResource();
        $stockTable = $resource->getTable('cataloginventory_stock_item');

        $collection->getSelect()->joinLeft(
            ['stock' =>$stockTable],
            'e.entity_id = stock.product_id',
            [
            'qty'=>'stock.qty',
            'is_in_stock'=>'stock.is_in_stock'
            ]

        );
        $collection->getSelect()->where('stock.qty < ? AND stock.is_in_stock = 1 OR stock.is_in_stock = 0',$threshold);
        $collection->getSelect()->limit($limit);
        $lowStock=[];

        foreach($collection as $product){
                $lowStock[]=[
                    'id' =>$product->getId(),
                    'sku' =>$product->getSku(),
                    'name' =>$product->getName(),
                    'qty' =>$product->getData('qty'),
                ];
        }

        return $lowStock;
    }

    public function getTotalLowStock($threshold =10){
        $storeId = $this->storeManager->getStore()->getId();

        $collection = $this->productCollectionFactory->create();
        $collection->addStoreFilter($storeId);
        $collection->addAttributeToSelect(['name','sku']);

        $resource = $collection->getResource();
        $stockTable = $resource->getTable('cataloginventory_stock_item');

        $collection->getSelect()->joinLeft(
            ['stock' =>$stockTable],
            'e.entity_id = stock.product_id',
            [
            'qty'=>'stock.qty'
            ]

        );
        $collection->getSelect()->where('stock.qty < ? AND stock.is_in_stock = 1 OR stock.is_in_stock = 0',$threshold);
        $lowStock=[];

        foreach($collection as $product){
                $lowStock[]=[
                    'id' =>$product->getId(),
                    'sku' =>$product->getSku(),
                    'name' =>$product->getName(),
                    'qty' =>$product->getData('qty'),
                ];
        }

        return $collection->getSize();
    }
}
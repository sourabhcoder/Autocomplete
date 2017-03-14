<?php
/**
 *
 * Cart Printer Controller
 * Copyright © 2016 Voicyou Softwares. All rights reserved.
 */
namespace Sourabh\Autocomplete\Controller\Autocomplete;

class Index extends \Magento\Framework\App\Action\Action
{

    /**
     *
     * @var type 
     */
    protected $context;
    /**
     *
     * @var type 
     */
    protected $searchterm;
    
    protected $product;
    
    protected $storeManagerInterface;
    public function __construct(
       \Magento\Framework\App\Action\Context $context,
       \Sourabh\Autocomplete\Model\ResourceModel\Searchterm $searchterm,
       \Magento\Catalog\Model\ProductFactory $product,
       \Magento\Store\Model\StoreManagerInterface $storeManagerInterface
        ) 
    {
        parent::__construct($context);
        $this->searchterm = $searchterm;
        $this->product    = $product;
        $this->storeManagerInterface = $storeManagerInterface;
    }
    public function execute()
    {
          if ($this->_request->getParam('searchterm') == '')
          {
              return NULL;
          }
          $allProducts= $this->searchterm->getProductData($this->_request->getParams());
          $prodReturnData = array();
          $i = 0;
          $htmlData = '';
          $currentStore = $this->storeManagerInterface->getStore();
          $mediaUrl = $currentStore->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
          $webUrl   = $currentStore->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB);
          foreach($allProducts as $eachProd)
          {
              $productData = $this->product->create()->load($eachProd['entity_id']);
              if ($productData->getImage())
              {
                  $fullImageUrl = $mediaUrl.'catalog/product'.$productData->getImage();
              }
              else
              {
                  $fullImageUrl = $webUrl."pub/static/frontend/Magento/luma/en_US/Sourabh_Autocomplete/images/placeholder.jpg";
              }
              
              $htmlData = $htmlData."<a href = '". $productData->getProductUrl()."'>"
                      . "<div>"
                      . "<div>".$productData->getName()."</div>"
                      . "<div><img class='admin__control-thumbnail' src = '".$fullImageUrl."' /></div>"
                      . "</div>"
                      . "</a>"; 
          }
          echo $htmlData;
    }
    
}

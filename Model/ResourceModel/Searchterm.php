<?php

namespace Sourabh\Autocomplete\Model\ResourceModel;

class Searchterm extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     *
     * @var type 
     */
    protected $storeManagerInterface;
    /**
     * 
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManagerInterface
     * @param type $connectionName
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManagerInterface,
        $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
        $this->storeManagerInterface = $storeManagerInterface;
    }

    protected function _construct() {
        
    }

    public function getProductData($params)
    {
        $storeId = 0;
        if ($this->storeManagerInterface->getStore()->getId())
        {
            if ($this->storeManagerInterface->getStore()->getId() == 1)
            {
                $storeId = 0;
            }
            else
            {
                $storeId = $this->storeManagerInterface->getStore()->getId();                
            }

        }
        $stmt = $this->getConnection()->query("SELECT cpev.entity_id as entity_id FROM " . $this->getTable('catalog_product_entity_varchar') . " as cpev INNER JOIN  " . $this->getTable('catalog_product_entity_int') . " as cpei ON cpev.entity_id = cpei.entity_id  WHERE cpev.value LIKE '%".$params['searchterm']."%'  ANd cpev.attribute_id = (SELECT attribute_id FROM  " . $this->getTable('eav_attribute') . " as ea WHERE ea.attribute_code = 'name' AND ea.entity_type_id = 4) AND cpei.attribute_id = (SELECT eavn.attribute_id FROM ".$this->getTable('eav_attribute')." as eavn WHERE eavn.attribute_code = 'visibility' AND eavn.entity_type_id = 4 )   AND cpei.value = 4  AND cpev.store_id = '".$storeId."' AND cpei.store_id = '".$storeId."' ");
        
        $result = $stmt->fetchAll();
        return $result;
    }
}

<?php

namespace Sourabh\Autocomplete\Model\ResourceModel;

class Searchterm extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * 
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param type $connectionName
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
    }

    protected function _construct() {
        
    }

    public function getProductData($params)
    {
        $stmt = $this->getConnection()->query("SELECT cpev.entity_id as entity_id FROM " . $this->getTable('catalog_product_entity_varchar') . " as cpev INNER JOIN  " . $this->getTable('catalog_product_entity_int') . " as cpei ON cpev.entity_id = cpei.entity_id  WHERE cpev.value LIKE '%".$params['searchterm']."%'  ANd cpev.attribute_id = (SELECT attribute_id FROM  " . $this->getTable('eav_attribute') . " as ea WHERE ea.attribute_code = 'name' AND ea.entity_type_id = 4 AND cpei.attribute_id = (SELECT eavn.attribute_id FROM ".$this->getTable('eav_attribute')." as eavn WHERE attribute_code = 'visibility' AND entity_type_id = 4 ) )  AND cpei.value = 4 ");
        $result = $stmt->fetchAll();
        return $result;
    }
}

<?php
/**
 * @category    SchumacherFM_Pgp
 * @package     Helper
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://opensource.org/licenses/osl-3.0.php
 */
class SchumacherFM_Pgp_Model_Resource_Pubkeys extends Mage_Core_Model_Resource_Db_Abstract
{

    protected $_isPkAutoIncrement = FALSE;

    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('pgp/pgp_public_keys', 'key_id');

    }

    /**
     * Process page data before saving
     *
     * @param Mage_Core_Model_Abstract $object
     *
     * @return Mage_Cms_Model_Resource_Page
     */
//    protected function _beforeSave(Mage_Core_Model_Abstract $object)
//    {
//        return parent::_beforeSave($object);
//    }

}

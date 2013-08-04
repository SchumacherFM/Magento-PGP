<?php
/**
 * @category    SchumacherFM_Pgp
 * @package     Model
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://www.gnu.org/licenses/gpl.html  GPL
 */
class SchumacherFM_Pgp_Model_Pubkeys extends Mage_Core_Model_Abstract
{

    protected $_eventPrefix = 'pgp_pubkeys';
    protected $_eventObject = 'public_key';

    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('pgp/pubkeys');
    }

}

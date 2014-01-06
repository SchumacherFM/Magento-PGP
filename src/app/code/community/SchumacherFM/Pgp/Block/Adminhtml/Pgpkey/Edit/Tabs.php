<?php
/**
 * @category    SchumacherFM_Pgp
 * @package     Block
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://opensource.org/licenses/osl-3.0.php
 */
class SchumacherFM_Pgp_Block_Adminhtml_Pgpkey_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize edit page tabs
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('pgpkey_info_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('pgp')->__('PGP Key Information'));
    }
}

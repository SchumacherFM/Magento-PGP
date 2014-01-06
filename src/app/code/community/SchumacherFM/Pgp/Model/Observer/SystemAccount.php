<?php
/**
 * @category    SchumacherFM_Pgp
 * @package     Helper
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://opensource.org/licenses/osl-3.0.php
 */
class SchumacherFM_Pgp_Model_Observer_SystemAccount
{

    public function injectPgpForm(Varien_Event_Observer $observer)
    {
        /** @var Mage_Adminhtml_Block_System_Account_Edit $block */
        $block = $observer->getEvent()->getBlock();

        if (!$this->_isAllowed($block)) {
            return NULL;
        }

        /** @var Varien_Data_Form $form */
        $form = $block->getForm();

        Mage::getModel('pgp/options_publicKeyForm')->injectFieldSet($form);
    }

    /**
     * @param Mage_Adminhtml_Block_Template $block
     *
     * @return bool
     */
    protected function _isAllowed(Mage_Adminhtml_Block_Template $block)
    {
        return $block instanceof Mage_Adminhtml_Block_System_Account_Edit_Form;
    }
}
<?php
/**
 * @category    SchumacherFM_Pgp
 * @package     Block
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://www.gnu.org/licenses/gpl.html  GPL
 */
class SchumacherFM_Pgp_Block_Adminhtml_Pgpkey_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    /**
     * Prepare form before rendering HTML
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array('id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post'));

        $pubkeys = Mage::registry('current_pubkeys');

        if ($pubkeys->getId()) {
            $form->addField('key_id', 'hidden', array(
                'name' => 'key_id',
            ));
            $form->setValues($pubkeys->getData());
        }

        $form->setUseContainer(TRUE);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}

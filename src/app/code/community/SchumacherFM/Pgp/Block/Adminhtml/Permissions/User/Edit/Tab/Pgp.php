<?php
/**
 * @category    SchumacherFM_Pgp
 * @package     Helper
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://www.gnu.org/licenses/gpl.html  GPL
 */
class SchumacherFM_Pgp_Block_Adminhtml_Permissions_User_Edit_Tab_Pgp extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    protected function _prepareForm()
    {

        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('pgp_');

        $fieldSet = $form->addFieldset('pgp_fieldset', array('legend' => Mage::helper('adminhtml')->__('PGP Public Key')));

        $fieldSet->addField('key_id', 'text', array(
            'name'     => 'key_id',
            'label'    => Mage::helper('pgp')->__('Public Sub Key ID'),
            'id'       => 'key_id',
            'title'    => Mage::helper('pgp')->__('Public Sub Key ID'),
            'disabled' => TRUE,

        ));

        $fieldSet->addField('public_key', 'textarea', array(
            'name'               => 'public_key',
            'label'              => Mage::helper('pgp')->__('Public Key'),
            'id'                 => 'public_key',
            'title'              => Mage::helper('pgp')->__('Public Key'),
            'required'           => FALSE,
            'after_element_html' => Mage::helper('pgp')->__('Must belong to the users email address. No comments inside the key.')
        ));
        $form->setValues($this->_getPublicKey()->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * @return Mage_Core_Model_Abstract
     */
    protected function _getPublicKey()
    {
        $model = Mage::registry('permissions_user');
        return Mage::getModel('pgp/pubkeys')->load($model->getEmail(), 'email');
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return $this->__('PGP Public Key');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->__('PGP Public Key');
    }

    /**
     * Returns status flag about this tab can be shown or not
     *
     * @return true
     */
    public function canShowTab()
    {
        return TRUE;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return true
     */
    public function isHidden()
    {
        return FALSE;
    }

}

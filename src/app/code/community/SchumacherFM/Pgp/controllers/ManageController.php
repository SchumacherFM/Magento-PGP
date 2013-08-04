<?php

class SchumacherFM_Pgp_ManageController extends Mage_Core_Controller_Front_Action
{
    /**
     * Action predispatch
     *
     * Check customer authentication for some actions
     */
    public function preDispatch()
    {
        parent::preDispatch();
        if (!Mage::getSingleton('customer/session')->authenticate($this)) {
            $this->setFlag('', 'no-dispatch', TRUE);
        }
    }

    public function indexAction()
    {
        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('catalog/session');

        if ($block = $this->getLayout()->getBlock('customer_newsletter')) {
            $block->setRefererUrl($this->_getRefererUrl());
        }
        $this->getLayout()->getBlock('head')->setTitle($this->__('PGP Key Management'));
        $this->renderLayout();
    }

    public function saveAction()
    {
        if (!$this->_validateFormKey()) {
            return $this->_redirect('customer/account/');
        }
        try {

//            Mage::getSingleton('customer/session')->getCustomer()
//                ->setStoreId(Mage::app()->getStore()->getId())
//                ->setIsSubscribed((boolean)$this->getRequest()->getParam('is_subscribed', FALSE))
//                ->save();

            if ((boolean)$this->getRequest()->getParam('is_subscribed', FALSE)) {
                Mage::getSingleton('customer/session')->addSuccess($this->__('The PGP Key has been saved.'));
            } else {
                Mage::getSingleton('customer/session')->addSuccess($this->__('The PGP Key has been removed.'));
            }
        } catch (Exception $e) {
            Mage::getSingleton('customer/session')->addError($this->__('An error occurred while saving your PGP Key.'));
        }
        $this->_redirect('customer/account/');
    }
}

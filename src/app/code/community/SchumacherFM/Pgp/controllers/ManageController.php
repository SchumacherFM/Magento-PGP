<?php
/**
 * @category    SchumacherFM_Pgp
 * @package     Controller
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://www.gnu.org/licenses/gpl.html  GPL
 */
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

        /** @var SchumacherFM_Pgp_Block_Customer_PublicKey $block */
        $block = $this->getLayout()->getBlock('customer_pgp');
        if ($block) {
            $block->setRefererUrl($this->_getRefererUrl());
        }

        $this->getLayout()->getBlock('head')->setTitle($this->__('PGP Key Management') . ' - ' . $this->getLayout()->getBlock('head')->getTitle());
        $this->renderLayout();
    }

    public function saveAction()
    {
        if (!$this->_validateFormKey()) {
            return $this->_redirect('customer/account/');
        }
        try {

            $result = $this->_getPkDetails();

            if ($result['return'] === TRUE) {
                Mage::getSingleton('customer/session')->addSuccess($result['message']);
            } else {
                Mage::getSingleton('customer/session')->addError($result['message']);
            }
        } catch (Exception $e) {
            Mage::getSingleton('customer/session')->addError($this->__('An error occurred while saving your PGP Key.'));
        }
        $this->_redirect('*/*/index/');
    }

    /**
     * @return array
     */
    protected function _getPkDetails()
    {
        /** @var Mage_Customer_Model_Customer $customer */
        $customer = Mage::getSingleton('customer/session')->getCustomer();

        $publicKey = $this->getRequest()->getParam('publicKey', '');

        if (empty($publicKey)) {
            return array('return' => FALSE, 'message' => $this->__('The PGP Key has NOT been saved.'));
        }

        /** @var SchumacherFM_Pgp_Model_Pgp $pgp */
        $pgp = Mage::getModel('pgp/pgp', array(
            'publicKeyAscii' => $publicKey,
            'engine'         => null,
        ));

        $pgpDetails = $pgp->getPublicKeyDetails();

        if (strtolower($pgpDetails['usr']) !== strtolower($customer->getEmail())) {
            return array(
                'return'  => FALSE,
                'message' => $this->__('The email address of your account (%s) does not match with email address (%s) in the public key.',
                    $customer->getEmail(), $pgpDetails['usr'])
            );
        }

        $model = Mage::getModel('pgp/pubkeys')->load($customer->getEmail(), 'email');
        $model
            ->setKeyId($pgpDetails['id'])
            ->setEmail($pgpDetails['usr'])
            ->setPublicKey($publicKey)
            ->setCreatedAt(date('Y-m-d H:i:s'))
            ->save();

        return array(
            'return'  => TRUE,
            'message' => $this->__('Your PGP Public Key has been saved.')
        );

    }

}

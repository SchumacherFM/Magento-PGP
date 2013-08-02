<?php
/**
 * @category    SchumacherFM_Pgp
 * @package     Helper
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://www.gnu.org/licenses/gpl.html  GPL
 */
class SchumacherFM_Pgp_Model_Observer_AdminUser
{
    public function savePublicKey(Varien_Event_Observer $observer)
    {

        $event = $observer->getEvent();
        /** @var Mage_Admin_Model_User $dataObject */
        $dataObject = $event->getDataObject();

        $publicKey = $dataObject->getPublicKey();
        $email     = $dataObject->getEmail();

        /** @var SchumacherFM_Pgp_Model_Php_Gpg_PublicKey $gpgPublicKey */
        $gpgPublicKey = Mage::getModel('pgp/php_gpg_publicKey', $publicKey);

        if (empty($gpgPublicKey->key_id)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('pgp')->__('Invalid PGP public key.')
            );
            return FALSE;
        }

        if (stristr($gpgPublicKey->user, $email) === FALSE) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('pgp')->__('Email address of the key does not match the email address of the public key.')
            );
            return FALSE;
        }

        /** @var SchumacherFM_Pgp_Model_Pubkeys $userKey */
        $userKey = Mage::getModel('pgp/pubkeys');
        $userKey->setData(array(
            'key_id'     => $gpgPublicKey->key_id,
            'email'      => $email,
            'public_key' => $publicKey,
        ));
        $userKey->save();
        Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('pgp')->__('The public key has been saved.'));

    }
}
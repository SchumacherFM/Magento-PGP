<?php

class SchumacherFM_Pgp_Model_Php_Factory extends SchumacherFM_Pgp_Model_AbstractFactory
{
    public function encrypt()
    {

        /** @var $gpg SchumacherFM_Pgp_Model_Php_Gpg */
        $gpg = Mage::getModel('pgp/php_gpg');

        // create an instance of a GPG public key object based on ASCII key
        $pubKey = Mage::getModel('pgp/php_gpg_publicKey', $this->getPublicKeyAscii());

        // using the key, encrypt your plain text using the public key
        $this->_setEncrypted($gpg->encrypt($pubKey, $this->getPlainTextString()));
        return $this;
    }
}

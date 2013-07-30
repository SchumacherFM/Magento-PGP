<?php
/**
 * @category    SchumacherFM_Pgp
 * @package     Helper
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://www.gnu.org/licenses/gpl.html  GPL
 */
class SchumacherFM_Pgp_Model_Php_Factory extends SchumacherFM_Pgp_Model_AbstractFactory
{
    /**
     * @return SchumacherFM_Pgp_Model_Php_Gpg
     */
    protected function _getInstance()
    {
        if ($this->_gpg === null) {
            $this->_gpg = Mage::getModel('pgp/php_gpg');
        }
        return $this->_gpg;
    }

    /**
     * @param string $publicKey
     * @param string $plainTextString
     *
     * @return string
     */
    public function encrypt($publicKey, $plainTextString)
    {

        // create an instance of a GPG public key object based on ASCII key
        /** @var SchumacherFM_Pgp_Model_Php_Gpg_PublicKey $pubKey */
        $pubKey = Mage::getModel('pgp/php_gpg_publicKey', $publicKey);

        // using the key, encrypt your plain text using the public key
        return $this->_getInstance()->encrypt($pubKey, $plainTextString);
    }
}

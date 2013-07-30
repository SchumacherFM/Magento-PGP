<?php
/**
 * @category    SchumacherFM_Pgp
 * @package     Helper
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://www.gnu.org/licenses/gpl.html  GPL
 */
class SchumacherFM_Pgp_Model_Cli_Factory extends SchumacherFM_Pgp_Model_AbstractFactory
{

    /**
     * @return SchumacherFM_Pgp_Model_Cli_Gpg
     */
    protected function _getInstance()
    {
        if ($this->_gpg === null) {
            $this->_gpg = Mage::getModel('pgp/cli_gpg', Mage::helper('pgp/cli')->getGpgEngineOptions());
        }
        return $this->_gpg;
    }

    /**
     * @param string $publicKey
     * @param string $plainTextString
     *
     * @return string
     * @throws SchumacherFM_Pgp_Model_Cli_Gpg_Exception
     */
    public function encrypt($publicKey, $plainTextString)
    {
        $importResult = $this->_getInstance()->importKey($publicKey);

        if (!isset($importResult['fingerprint']) || strlen($importResult['fingerprint']) < 32) {
            throw new SchumacherFM_Pgp_Model_Cli_Gpg_Exception('fingerprint not found or invalid');
        }
        $fingerPrint = $importResult['fingerprint'];

        $this->_getInstance()->addEncryptKey($fingerPrint);
        return $this->_getInstance()->encrypt('Hello World');

    }
}

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

        $fingerPrint = $this->_importKey($publicKey);
        $this->_getInstance()->addEncryptKey($fingerPrint);
        return $this->_getInstance()->encrypt($plainTextString);
    }

    /**
     * @param string $publicKeyAsc
     *
     * @return string the fingerprint
     * @throws SchumacherFM_Pgp_Model_Cli_Gpg_Exception
     */
    protected function _importKey($publicKeyAsc)
    {
        $importResult = $this->_getInstance()->importKey($publicKeyAsc);
        if (!isset($importResult['fingerprint']) || strlen($importResult['fingerprint']) < 32) {
            throw new SchumacherFM_Pgp_Model_Cli_Gpg_Exception('fingerprint not found or invalid');
        }
        return $importResult['fingerprint'];
    }

    /**
     * @param string $publicKey
     *
     * @return array
     * @throws SchumacherFM_Pgp_Model_Cli_Gpg_Exception
     */
    public function getPublicKeyDetails($publicKey)
    {

        $fingerPrint = $this->_importKey($publicKey);

        $importResult = $this->_getInstance()->getKeys($fingerPrint);

        if (!isset($importResult[0])) {
            throw new SchumacherFM_Pgp_Model_Cli_Gpg_Exception('key ' . $fingerPrint . ' not found or invalid');
        }
        /** @var SchumacherFM_Pgp_Model_Cli_Gpg_Key $keys */
        $keys = $importResult[0];

        /** @var SchumacherFM_Pgp_Model_Cli_Gpg_SubKey $pk */
        $pk = $keys->getPrimaryKey();

        $userIds = $keys->getUserIds();
        /** @var SchumacherFM_Pgp_Model_Cli_Gpg_UserId $userId */
        $userId = isset($userIds[0]) ? $userIds[0] : new Varien_Object();

        return array(
            'id'  => strtoupper($pk->getId()),
            'fp'  => strtoupper($pk->getFingerprint()),
            'usr' => strtolower($userId->getEmail()),
        );

    }
}

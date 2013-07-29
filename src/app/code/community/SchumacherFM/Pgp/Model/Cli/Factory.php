<?php

class SchumacherFM_Pgp_Model_Cli_Factory extends SchumacherFM_Pgp_Model_AbstractFactory
{
    const DEBUG_LOG_FILE_NAME = 'gpg.log';

    /**
     * @param $publicKey
     * @param $plainTextString
     *
     * @return string
     */
    public function encrypt($publicKey, $plainTextString)
    {

        /** @var $gpg SchumacherFM_Pgp_Model_Cli_Gpg */
        $gpg = Mage::getModel('pgp/cli_gpg', Mage::helper('pgp/cli')->getGpgEngineOptions());

        $res = $gpg->importKey($publicKey);

        Zend_Debug::dump($res);

        $fingerprint = $res['fingerprint'];

        Zend_Debug::dump($res['fingerprint']);

        $key = $gpg->getKeys($res['fingerprint']);

        Zend_Debug::dump($key);

        $gpg->addEncryptKey($fingerprint);

        $encryptedData = $gpg->encrypt('Hello World');
        return $encryptedData;
    }
}

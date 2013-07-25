<?php

class SchumacherFM_Pgp_Model_Cli_Factory extends SchumacherFM_Pgp_Model_AbstractFactory
{
    /**
     * @param $publicKey
     * @param $plainTextString
     *
     * @return string
     */
    public function encrypt($publicKey, $plainTextString)
    {

        /** @var $gpg SchumacherFM_Pgp_Model_Php_Gpg */
        $gpg = Mage::getModel('pgp/cli_gpg',
            array(
                'homedir' => '/my/writeable/directory',
                'debug'   => FALSE,
                // 'binary' => '/home/joe/bin/gpg'
            )
        );

        // create an instance of a GPG public key object based on ASCII key
        $pubKey = Mage::getModel('pgp/cli_gpg_publicKey', $publicKey);

        // using the key, encrypt your plain text using the public key
        return $gpg->encrypt($pubKey, $plainTextString);
    }
}

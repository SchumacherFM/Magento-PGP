<?php
/**
 * @category    SchumacherFM_Pgp
 * @package     Helper
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://www.gnu.org/licenses/gpl.html  GPL
 */
class SchumacherFM_Pgp_Helper_Data extends Mage_Core_Helper_Abstract
{

    /**
     * @param $publicKey
     *
     * @return mixed
     */
    public function encrypt($publicKeyAscii)
    {
        /*
        $gpg = new GPG();

        // create an instance of a GPG public key object based on ASCII key
        $pub_key = new GPG_Public_Key($public_key_ascii);

        // using the key, encrypt your plain text using the public key
        $encrypted = $gpg->encrypt($pub_key,$plain_text_string);
        */
    }

    /**
     * @todo configurable via backend so that user can choose
     * @return string
     */
    public function getMethod()
    {
        return 'Php';
    }
}
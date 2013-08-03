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
     * disable sending via attachment, after decryption user will see plain HTML, not rendered one.
     *
     * @return bool
     */
    public function isForcePlainText()
    {
        return TRUE;
    }

    /**
     * if isForcePlainText and strip tags true, then all HTML will be removed
     *
     * @return bool
     */
    public function isStripHtml()
    {
        return TRUE;
    }

    /**
     * @todo
     * @return bool
     */
    public function isMoveSubjectToBody()
    {
        return TRUE;
    }

    /**
     * @todo
     * @return array|bool
     */
    public function getRandomSender()
    {

        if ((int)Mage::getStoreConfig('schumacherfm/pgp/email_random_sender') === 0) {
            return FALSE;
        }

        $return = array(
            'sender_email'      => 'john.doe234234@gmail.com',
            'sender_name'       => 'John Doe',
            'return_path_email' => 'john.doe234234@gmail.com',
        );
        return $return;
    }

    /**
     * @todo
     * @return bool
     */
    public function getAllowOnlyOneRecipient()
    {
        return false;
    }

    /**
     * @return string
     */
    public function getEngine()
    {
        return Mage::getStoreConfig('schumacherfm/pgp/engine');

    }

    /**
     * @param string $asc
     *
     * @return bool
     */
    public function isPublicKey($asc)
    {
        return strpos($asc, '-----BEGIN PGP PUBLIC KEY BLOCK-----') !== FALSE;
    }
}
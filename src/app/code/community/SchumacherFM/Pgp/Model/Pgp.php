<?php
/**
 * @category    SchumacherFM_Pgp
 * @package     Helper
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://www.gnu.org/licenses/gpl.html  GPL
 */
class SchumacherFM_Pgp_Model_Pgp
{

    /**
     * @var string
     */
    private $_engine = 'php';

    /**
     * @var SchumacherFM_Pgp_Model_AbstractFactory
     */
    private $_encryptor = null;

    /**
     * @var string
     */
    private $_publicKeyAscii = '';

    /**
     * @var string
     */
    private $_plainTextString = '';

    /**
     * @var string
     */
    private $_encrypted = '';

    /**
     * @var string used for getting the key
     */
    private $_emailAddress = '';

    /**
     * @param array $args can contain publicKeyAscii and engine
     */
    public function __construct(array $args = null)
    {
        $publicKeyAscii = isset($args['publicKeyAscii']) ? $args['publicKeyAscii'] : null;
        if (!empty($publicKeyAscii)) {
            $this->setPublicKeyAscii($publicKeyAscii);
        }
        $engine = isset($args['engine']) ? $args['engine'] : null;
        if (empty($engine)) {
            $this->setEngine(Mage::helper('pgp')->getEngine());
        }
    }

    /**
     * @param string $encrypted
     *
     * @return $this
     */
    protected function _setEncrypted($encrypted)
    {
        $this->_encrypted = $encrypted;
        return $this;
    }

    /**
     * @return string
     */
    public function getEncrypted()
    {
        return $this->_encrypted;
    }

    /**
     * @param string $plainTextString
     *
     * @return $this
     */
    public function setPlainTextString($plainTextString)
    {
        $this->_plainTextString = $plainTextString;
        return $this;
    }

    /**
     * @return string
     */
    public function getPlainTextString()
    {
        return $this->_plainTextString;
    }

    /**
     * @param string $publicKeyAscii
     *
     * @return $this
     */
    public function setPublicKeyAscii($publicKeyAscii)
    {
        if (!Mage::helper('pgp')->isPublicKey($publicKeyAscii)) {
            throw new Exception('Public Key is invalid!');
        }
        $this->_publicKeyAscii = $publicKeyAscii;
        return $this;
    }

    /**
     * @return string
     */
    public function getPublicKeyAscii()
    {
        if (empty($this->_publicKeyAscii)) {
            $this->_publicKeyAscii = $this->_getPublicKeyByEmail();
        }

        return $this->_publicKeyAscii;
    }

    /**
     * @return string
     */
    protected function _getPublicKeyByEmail()
    {
        /** @var SchumacherFM_Pgp_Model_Pubkeys $pubkey */
        $pubkey = Mage::getModel('pgp/pubkeys')->load($this->getEmailAddress(), 'email');
        return $pubkey->getPublicKey();
    }

    public function setEmailAddress($email)
    {

        if (!Zend_Validate::is($email, 'EmailAddress')) {
            throw new Exception('Bad email address for pgp encryption');
        }

        $this->_emailAddress = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->_emailAddress;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setEngine($type)
    {
        $type          = strtolower($type);
        $_methods      = array(
            'php' => 1,
            'cli' => 1,
        );
        $type          = isset($_methods[$type]) ? $type : 'php';
        $this->_engine = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getEngine()
    {
        return $this->_engine;
    }

    /**
     * @return SchumacherFM_Pgp_Model_AbstractFactory
     */
    protected function _getEncryptor()
    {
        if ($this->_encryptor === null) {
            $this->_encryptor = Mage::getModel('pgp/' . $this->getEngine() . '_factory');
        }
        return $this->_encryptor;
    }

    /**
     * @return $this
     */
    public function encrypt()
    {
        $this->_setEncrypted(
            $this->_getEncryptor()->encrypt($this->getPublicKeyAscii(), $this->getPlainTextString())
        );
        return $this;
    }

    /**
     * @return array
     */
    public function getPublicKeyDetails()
    {
        $return = $this->_getEncryptor()->getPublicKeyDetails($this->getPublicKeyAscii());
        return $return;
    }

}
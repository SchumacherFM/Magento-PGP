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
        $this->_publicKeyAscii = $publicKeyAscii;
        return $this;
    }

    /**
     * @return string
     */
    public function getPublicKeyAscii()
    {
        return $this->_publicKeyAscii;
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
     * @param $asc
     *
     * @return array
     */
    public function getPublicKeyDetails($asc)
    {

        $return = array();

        return $return;
    }

}
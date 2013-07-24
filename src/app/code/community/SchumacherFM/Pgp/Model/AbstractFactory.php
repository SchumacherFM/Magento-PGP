<?php

abstract class SchumacherFM_Pgp_Model_AbstractFactory
{
    private $_publicKeyAscii = '';
    private $_plainTextString = '';
    private $_encrypted = '';

    /**
     * @param string $encrypted
     */
    protected function _setEncrypted($encrypted)
    {
        $this->_encrypted = $encrypted;
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
     */
    public function setPlainTextString($plainTextString)
    {
        $this->_plainTextString = $plainTextString;
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
     */
    public function setPublicKeyAscii($publicKeyAscii)
    {
        $this->_publicKeyAscii = $publicKeyAscii;
    }

    /**
     * @return string
     */
    public function getPublicKeyAscii()
    {
        return $this->_publicKeyAscii;
    }

    abstract function encrypt();

}

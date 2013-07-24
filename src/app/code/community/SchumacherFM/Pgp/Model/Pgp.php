<?php

class SchumacherFM_Pgp_Model_Pgp
{

    private $_methods = array('php' => 1, 'cli' => 1);
    private $_method = 'php';
    private $_encryptor = null;
    private $_publicKeyAscii = '';
    private $_plainTextString = '';
    private $_encrypted = '';

    /**
     * @param string $encrypted
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
     * @param string $method
     */
    public function setMethod($method)
    {
        if (isset($this->_methods[$method])) {
            $this->_method = $method;
        } else {
            throw new Exception('PGP Encryption method not supported');
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->_method;
    }

    public function getEncryptor()
    {
        if ($this->_encryptor === null) {
            $this->_encryptor = Mage::getModel('pgp/' . $this->getMethod() . '_factory');
        }
        return $this->_encryptor;
    }

    public function encrypt()
    {
        $this->_setEncrypted(
            $this->getEncryptor()->encrypt($this->getPublicKeyAscii(), $this->getPlainTextString())
        );
        return $this;
    }

}
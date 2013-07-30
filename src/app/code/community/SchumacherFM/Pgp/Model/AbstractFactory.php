<?php

abstract class SchumacherFM_Pgp_Model_AbstractFactory
{
    /**
     * @var object
     */
    protected $_gpg = null;

    /**
     * @return mixed
     */
    abstract protected function _getInstance();

    /**
     * @param $publicKey
     * @param $plainTextString
     *
     * @return string
     */
    abstract function encrypt($publicKey, $plainTextString);

}

<?php
/**
 * @category    SchumacherFM_Pgp
 * @package     Helper
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://opensource.org/licenses/osl-3.0.php
 */
abstract class SchumacherFM_Pgp_Model_AbstractFactory
{
    /**
     * @var object
     */
    protected $_gpg = NULL;

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

    /**
     * @param string $publicKeyAsc
     *
     * @return array
     */
    abstract function getPublicKeyDetails($publicKeyAsc);
}

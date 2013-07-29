<?php
/**
 * @category    SchumacherFM_Pgp
 * @package     Helper
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 */
class SchumacherFM_Pgp_Helper_Cli extends Mage_Core_Helper_Abstract
{

    /**
     * @todo configurable via backend
     *
     * @return string
     */
    public function getHomeDir()
    {
        return '/tmp';
    }

    /**
     * @todo configurable via backend
     *
     * @return string
     */
    public function isDebug()
    {
        return FALSE;
    }

    public function getGpgEngineOptions()
    {
        return
            array(
                'homedir' => $this->getHomeDir(),
                'debug'   => $this->isDebug(),
                // 'binary' => '/home/joe/bin/gpg'
                // agent
                // publicKeyring
                // privateKeyring
                // trustDb

            );
    }
}
<?php
/**
 * @category    SchumacherFM_Pgp
 * @package     Helper
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://www.gnu.org/licenses/gpl.html  GPL
 */
class SchumacherFM_Pgp_Helper_Cli extends Mage_Core_Helper_Abstract
{

    /**
     * @todo configurable via backend
     */

    /**
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

    /**
     * @see SchumacherFM_Pgp_Model_Cli_Gpg_Engine::_debug
     * @return string
     */
    public function getLogFileName()
    {
        return 'gpg.log';
    }
}
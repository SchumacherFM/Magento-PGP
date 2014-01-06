<?php
/**
 * @category    SchumacherFM_Pgp
 * @package     Helper
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://opensource.org/licenses/osl-3.0.php
 */
class SchumacherFM_Pgp_Helper_Cli extends Mage_Core_Helper_Abstract
{

    /**
     * @return string
     */
    public function getHomeDir()
    {
        return Mage::getStoreConfig('schumacherfm/pgp/cli_homedir');
    }

    /**
     * @return string
     */
    public function getBinary()
    {
        $config = trim(Mage::getStoreConfig('schumacherfm/pgp/cli_binary'));
        return !empty($config) ? $config : FALSE;
    }

    /**
     * @todo configurable via backend
     *
     * @return string
     */
    public function isDebug()
    {
        return (int)Mage::getStoreConfig('schumacherfm/pgp/cli_debug') === 1;
    }

    /**
     * @return array
     */
    public function getGpgEngineOptions()
    {
        $return = array(
            'homedir' => $this->getHomeDir(),
            'debug'   => $this->isDebug(),
            // agent
            // publicKeyring
            // privateKeyring
            // trustDb

        );
        $binary = $this->getBinary();
        if ($binary) {
            $return['binary'] = $binary;
        }
        return $return;
    }

    /**
     * @see SchumacherFM_Pgp_Model_Cli_Gpg_Engine::_debug
     * @return string
     */
    public function getLogFileName()
    {
        return Mage::getStoreConfig('schumacherfm/pgp/cli_logfile');
    }
}
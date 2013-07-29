<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Contains a class representing GPG keys
 *
 * PHP version 5
 *
 * LICENSE:
 *
 * This library is free software; you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as
 * published by the Free Software Foundation; either version 2.1 of the
 * License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @category  Encryption
 * @package   Crypt_GPG
 * @author    Michael Gauthier <mike@silverorange.com>
 * @copyright 2008-2010 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 * @version   CVS: $Id$
 * @link      http://pear.php.net/package/Crypt_GPG
 */

// {{{ class SchumacherFM_Pgp_Model_Cli_Gpg_Key

/**
 * A data class for GPG key information
 *
 * This class is used to store the results of the {@link SchumacherFM_Pgp_Model_Cli_Gpg::getKeys()}
 * method.
 *
 * @category  Encryption
 * @package   Crypt_GPG
 * @author    Michael Gauthier <mike@silverorange.com>
 * @copyright 2008-2010 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 * @link      http://pear.php.net/package/Crypt_GPG
 * @see       SchumacherFM_Pgp_Model_Cli_Gpg::getKeys()
 */
class SchumacherFM_Pgp_Model_Cli_Gpg_Key
{
    // {{{ class properties

    /**
     * The user ids associated with this key
     *
     * This is an array of {@link SchumacherFM_Pgp_Model_Cli_Gpg_UserId} objects.
     *
     * @var array
     *
     * @see SchumacherFM_Pgp_Model_Cli_Gpg_Key::addUserId()
     * @see SchumacherFM_Pgp_Model_Cli_Gpg_Key::getUserIds()
     */
    private $_userIds = array();

    /**
     * The subkeys of this key
     *
     * This is an array of {@link SchumacherFM_Pgp_Model_Cli_Gpg_SubKey} objects.
     *
     * @var array
     *
     * @see SchumacherFM_Pgp_Model_Cli_Gpg_Key::addSubKey()
     * @see SchumacherFM_Pgp_Model_Cli_Gpg_Key::getSubKeys()
     */
    private $_subKeys = array();

    // }}}
    // {{{ getSubKeys()

    /**
     * Gets the sub-keys of this key
     *
     * @return array the sub-keys of this key.
     *
     * @see SchumacherFM_Pgp_Model_Cli_Gpg_Key::addSubKey()
     */
    public function getSubKeys()
    {
        return $this->_subKeys;
    }

    // }}}
    // {{{ getUserIds()

    /**
     * Gets the user ids of this key
     *
     * @return array the user ids of this key.
     *
     * @see SchumacherFM_Pgp_Model_Cli_Gpg_Key::addUserId()
     */
    public function getUserIds()
    {
        return $this->_userIds;
    }

    // }}}
    // {{{ getPrimaryKey()

    /**
     * Gets the primary sub-key of this key
     *
     * The primary key is the first added sub-key.
     *
     * @return SchumacherFM_Pgp_Model_Cli_Gpg_SubKey the primary sub-key of this key.
     */
    public function getPrimaryKey()
    {
        $primary_key = null;
        if (count($this->_subKeys) > 0) {
            $primary_key = $this->_subKeys[0];
        }
        return $primary_key;
    }

    // }}}
    // {{{ canSign()

    /**
     * Gets whether or not this key can sign data
     *
     * This key can sign data if any sub-key of this key can sign data.
     *
     * @return boolean true if this key can sign data and false if this key
     *                 cannot sign data.
     */
    public function canSign()
    {
        $canSign = false;
        foreach ($this->_subKeys as $subKey) {
            if ($subKey->canSign()) {
                $canSign = true;
                break;
            }
        }
        return $canSign;
    }

    // }}}
    // {{{ canEncrypt()

    /**
     * Gets whether or not this key can encrypt data
     *
     * This key can encrypt data if any sub-key of this key can encrypt data.
     *
     * @return boolean true if this key can encrypt data and false if this
     *                 key cannot encrypt data.
     */
    public function canEncrypt()
    {
        $canEncrypt = false;
        foreach ($this->_subKeys as $subKey) {
            if ($subKey->canEncrypt()) {
                $canEncrypt = true;
                break;
            }
        }
        return $canEncrypt;
    }

    // }}}
    // {{{ addSubKey()

    /**
     * Adds a sub-key to this key
     *
     * The first added sub-key will be the primary key of this key.
     *
     * @param SchumacherFM_Pgp_Model_Cli_Gpg_SubKey $subKey the sub-key to add.
     *
     * @return SchumacherFM_Pgp_Model_Cli_Gpg_Key the current object, for fluent interface.
     */
    public function addSubKey(SchumacherFM_Pgp_Model_Cli_Gpg_SubKey $subKey)
    {
        $this->_subKeys[] = $subKey;
        return $this;
    }

    // }}}
    // {{{ addUserId()

    /**
     * Adds a user id to this key
     *
     * @param SchumacherFM_Pgp_Model_Cli_Gpg_UserId $userId the user id to add.
     *
     * @return SchumacherFM_Pgp_Model_Cli_Gpg_Key the current object, for fluent interface.
     */
    public function addUserId(SchumacherFM_Pgp_Model_Cli_Gpg_UserId $userId)
    {
        $this->_userIds[] = $userId;
        return $this;
    }

    // }}}
}

// }}}

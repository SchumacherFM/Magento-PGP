<?php
/**
 * Various exception handling classes for Crypt_GPG
 *
 * Crypt_GPG provides an object oriented interface to GNU Privacy
 * Guard (GPG). It requires the GPG executable to be on the system.
 *
 * This file contains various exception classes used by the Crypt_GPG package.
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
 * @author    Nathan Fredrickson <nathan@silverorange.com>
 * @author    Michael Gauthier <mike@silverorange.com>
 * @copyright 2005-2011 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 * @version   CVS: $Id$
 * @link      http://pear.php.net/package/Crypt_GPG
 */

// {{{ class SchumacherFM_Pgp_Model_Cli_Gpg_DeletePrivateKeyException

/**
 * An exception thrown when an attempt is made to delete public key that has an
 * associated private key on the keyring
 *
 * @category  Encryption
 * @package   Crypt_GPG
 * @author    Michael Gauthier <mike@silverorange.com>
 * @copyright 2008 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 * @link      http://pear.php.net/package/Crypt_GPG
 */
class SchumacherFM_Pgp_Model_Cli_Gpg_DeletePrivateKeyException extends SchumacherFM_Pgp_Model_Cli_Gpg_Exception
{
    // {{{ private class properties

    /**
     * The key identifier the deletion attempt was made upon
     *
     * @var string
     */
    private $_keyId = '';

    // }}}
    // {{{ __construct()

    /**
     * Creates a new SchumacherFM_Pgp_Model_Cli_Gpg_DeletePrivateKeyException
     *
     * @param string  $message an error message.
     * @param integer $code    a user defined error code.
     * @param string  $keyId   the key identifier of the public key that was
     *                         attempted to delete.
     *
     * @see SchumacherFM_Pgp_Model_Cli_Gpg::deletePublicKey()
     */
    public function __construct($message, $code = 0, $keyId = '')
    {
        $this->_keyId = $keyId;
        parent::__construct($message, $code);
    }

    // }}}
    // {{{ getKeyId()

    /**
     * Gets the key identifier of the key that was not found
     *
     * @return string the key identifier of the key that was not found.
     */
    public function getKeyId()
    {
        return $this->_keyId;
    }

    // }}}
}

// }}}

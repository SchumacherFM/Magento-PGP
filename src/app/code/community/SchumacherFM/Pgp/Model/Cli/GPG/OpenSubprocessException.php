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

/**
 * An exception thrown when the GPG subprocess cannot be opened
 *
 * This exception is thrown when the {@link SchumacherFM_Pgp_Model_Cli_Gpg_Engine} tries to open a
 * new subprocess and fails.
 *
 * @category  Encryption
 * @package   Crypt_GPG
 * @author    Michael Gauthier <mike@silverorange.com>
 * @copyright 2005 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 * @link      http://pear.php.net/package/Crypt_GPG
 */
class SchumacherFM_Pgp_Model_Cli_Gpg_OpenSubprocessException extends SchumacherFM_Pgp_Model_Cli_Gpg_Exception
{
    // {{{ private class properties

    /**
     * The command used to try to open the subprocess
     *
     * @var string
     */
    private $_command = '';

    // }}}
    // {{{ __construct()

    /**
     * Creates a new SchumacherFM_Pgp_Model_Cli_Gpg_OpenSubprocessException
     *
     * @param string  $message an error message.
     * @param integer $code    a user defined error code.
     * @param string  $command the command that was called to open the
     *                         new subprocess.
     *
     * @see SchumacherFM_Pgp_Model_Cli_Gpg::_openSubprocess()
     */
    public function __construct($message, $code = 0, $command = '')
    {
        $this->_command = $command;
        parent::__construct($message, $code);
    }

    // }}}
    // {{{ getCommand()

    /**
     * Returns the contents of the internal _command property
     *
     * @return string the command used to open the subprocess.
     *
     * @see SchumacherFM_Pgp_Model_Cli_Gpg_OpenSubprocessException::$_command
     */
    public function getCommand()
    {
        return $this->_command;
    }

    // }}}
}

// }}}
// {{{ class SchumacherFM_Pgp_Model_Cli_Gpg_InvalidOperationException

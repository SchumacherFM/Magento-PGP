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
 * An exception thrown when a file is used in ways it cannot be used
 *
 * For example, if an output file is specified and the file is not writeable, or
 * if an input file is specified and the file is not readable, this exception
 * is thrown.
 *
 * @category  Encryption
 * @package   Crypt_GPG
 * @author    Michael Gauthier <mike@silverorange.com>
 * @copyright 2007-2008 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 * @link      http://pear.php.net/package/Crypt_GPG
 */
class SchumacherFM_Pgp_Model_Cli_Gpg_FileException extends SchumacherFM_Pgp_Model_Cli_Gpg_Exception
{
    // {{{ private class properties

    /**
     * The name of the file that caused this exception
     *
     * @var string
     */
    private $_filename = '';

    // }}}
    // {{{ __construct()

    /**
     * Creates a new SchumacherFM_Pgp_Model_Cli_Gpg_FileException
     *
     * @param string  $message  an error message.
     * @param integer $code     a user defined error code.
     * @param string  $filename the name of the file that caused this exception.
     */
    public function __construct($message, $code = 0, $filename = '')
    {
        $this->_filename = $filename;
        parent::__construct($message, $code);
    }

    // }}}
    // {{{ getFilename()

    /**
     * Returns the filename of the file that caused this exception
     *
     * @return string the filename of the file that caused this exception.
     *
     * @see SchumacherFM_Pgp_Model_Cli_Gpg_FileException::$_filename
     */
    public function getFilename()
    {
        return $this->_filename;
    }

    // }}}
}
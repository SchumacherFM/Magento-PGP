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

// {{{ class SchumacherFM_Pgp_Model_Cli_Gpg_InvalidKeyParamsException

/**
 * An exception thrown when an attempt is made to generate a key and the
 * key parameters set on the key generator are invalid
 *
 * @category  Encryption
 * @package   Crypt_GPG
 * @author    Michael Gauthier <mike@silverorange.com>
 * @copyright 2011 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 * @link      http://pear.php.net/package/Crypt_GPG
 */
class SchumacherFM_Pgp_Model_Cli_Gpg_InvalidKeyParamsException extends SchumacherFM_Pgp_Model_Cli_Gpg_Exception
{
    // {{{ private class properties

    /**
     * The key algorithm
     *
     * @var integer
     */
    private $_algorithm = 0;

    /**
     * The key size
     *
     * @var integer
     */
    private $_size = 0;

    /**
     * The key usage
     *
     * @var integer
     */
    private $_usage = 0;

    // }}}
    // {{{ __construct()

    /**
     * Creates a new SchumacherFM_Pgp_Model_Cli_Gpg_InvalidKeyParamsException
     *
     * @param string  $message   an error message.
     * @param integer $code      a user defined error code.
     * @param string  $algorithm the key algorithm.
     * @param string  $size      the key size.
     * @param string  $usage     the key usage.
     */
    public function __construct(
        $message,
        $code = 0,
        $algorithm = 0,
        $size = 0,
        $usage = 0
    )
    {
        parent::__construct($message, $code);

        $this->_algorithm = $algorithm;
        $this->_size      = $size;
        $this->_usage     = $usage;
    }

    // }}}
    // {{{ getAlgorithm()

    /**
     * Gets the key algorithm
     *
     * @return integer the key algorithm.
     */
    public function getAlgorithm()
    {
        return $this->_algorithm;
    }

    // }}}
    // {{{ getSize()

    /**
     * Gets the key size
     *
     * @return integer the key size.
     */
    public function getSize()
    {
        return $this->_size;
    }

    // }}}
    // {{{ getUsage()

    /**
     * Gets the key usage
     *
     * @return integer the key usage.
     */
    public function getUsage()
    {
        return $this->_usage;
    }

    // }}}
}

// }}}
<?php
/** @package    php-gpg */

/**
 * Pure PHP implementation of PHP/GPG encryption.
 * Supports RSA, DSA public key length of 2,4,8,16,512,1024,2048 or 4096
 * Currently supports only encrypt
 *
 * @package   php-gpg::Encryption
 * @link      http://www.verysimple.com/
 * @copyright 1997-2012 VerySimple, Inc.
 * @license   http://www.gnu.org/licenses/gpl.html  GPL
 * @todo      implement decryption
 * @version   1.0
 *
 * @example
 *        $gpg = new GPG();
 *        $pub_key = new GPG_Public_Key($public_key_ascii);
 *        $encrypted = $gpg->encrypt($pub_key,$plain_text_string);
 */
class SchumacherFM_Pgp_Model_Php_Gpg
{

    private $width = 16;
    private $el = array(3, 5, 9, 17, 513, 1025, 2049, 4097);
    private $version = '1.4.7';
    private $_globals;

    public function __construct()
    {
        $this->_globals = Mage::getModel('pgp/php_gpg_globals');
    }

    private function gpg_encrypt($key, $text)
    {

        $i      = 0;
        $i      = 0;
        $len    = strlen($text);
        $len    = strlen($text);
        $iblock = array_fill(0, $this->width, 0);
        $rblock = array_fill(0, $this->width, 0);
        $ct     = array_fill(0, $this->width + 2, 0);

        $cipher = '';

        if ($len % $this->width) {
            for ($i = ($len % $this->width); $i < $this->width; $i++) $text .= "\0";
        }

        $ekey = new SchumacherFM_Pgp_Model_Php_Gpg_ExpandedKey($key);

        for ($i = 0; $i < $this->width; $i++) {
            $iblock[$i] = 0;
            $rblock[$i] = SchumacherFM_Pgp_Model_Php_Gpg_Utility::c_random();
        }

        $iblock = SchumacherFM_Pgp_Model_Php_Gpg_Aes::encrypt($iblock, $ekey);
        for ($i = 0; $i < $this->width; $i++) {
            $ct[$i] = ($iblock[$i] ^= $rblock[$i]);
        }

        $iblock               = SchumacherFM_Pgp_Model_Php_Gpg_Aes::encrypt($iblock, $ekey);
        $ct[$this->width]     = ($iblock[0] ^ $rblock[$this->width - 2]);
        $ct[$this->width + 1] = ($iblock[1] ^ $rblock[$this->width - 1]);

        for ($i = 0; $i < $this->width + 2; $i++) $cipher .= chr($ct[$i]);

        $iblock = array_slice($ct, 2, $this->width + 2);

        for ($n = 0; $n < strlen($text); $n += $this->width) {
            $iblock = SchumacherFM_Pgp_Model_Php_Gpg_Aes::encrypt($iblock, $ekey);
            for ($i = 0; $i < $this->width; $i++) {
                $iblock[$i] ^= ord($text[$n + $i]);
                $cipher .= chr($iblock[$i]);
            }
        }

        return substr($cipher, 0, $len + $this->width + 2);
    }

    private function gpg_header($tag, $len)
    {
        if ($len > 0xff) $tag += 1;
        $h = chr($tag);
        if ($len > 0xff) $h .= chr($len / 0x100);
        $h .= chr($len % 0x100);

        return $h;
    }

    private function gpg_session($key_id, $key_type, $session_key, $public_key)
    {

        $mod = array();
        $exp = array();
        $enc = '';

        $s   = base64_decode($public_key);
        $l   = floor((ord($s[0]) * 256 + ord($s[1]) + 7) / 8);
        $mod = $this->_globals->mpi2b(substr($s, 0, $l + 2));
        if ($key_type) {
            $grp = array();
            $y   = array();
            $B   = array();
            $C   = array();

            $l2     = floor((ord($s[$l + 2]) * 256 + ord($s[$l + 3]) + 7) / 8) + 2;
            $grp    = $this->_globals->mpi2b(substr($s, $l + 2, $l2));
            $y      = $this->_globals->mpi2b(substr($s, $l + 2 + $l2));
            $exp[0] = $this->el[SchumacherFM_Pgp_Model_Php_Gpg_Utility::c_random() & 7];
            $B      = $this->_globals->bmodexp($grp, $exp, $mod);
            $C      = $this->_globals->bmodexp($y, $exp, $mod);
        } else {
            $exp = $this->_globals->mpi2b(substr($s, $l + 2));
        }

        $c   = 0;
        $lsk = strlen($session_key);
        for ($i = 0; $i < $lsk; $i++) $c += ord($session_key[$i]);
        $c &= 0xffff;

        $lm = ($l - 2) * 8 + 2;
        $m  = chr($lm / 256) . chr($lm % 256) .
            chr(2) . SchumacherFM_Pgp_Model_Php_Gpg_Utility::s_random($l - $lsk - 6, 1) . "\0" .
            chr(7) . $session_key .
            chr($c / 256) . chr($c & 0xff);

        if ($key_type) {
            $enc = $this->_globals->b2mpi($B) . $this->_globals->b2mpi($this->_globals->bmod($this->_globals->bmul($this->_globals->mpi2b($m), $C), $mod));
            return $this->gpg_header(0x84, strlen($enc) + 10) .
            chr(3) . $key_id . chr(16) . $enc;
        } else {
            $enc = $this->_globals->b2mpi($this->_globals->bmodexp($this->_globals->mpi2b($m), $exp, $mod));
            return $this->gpg_header(0x84, strlen($enc) + 10) .
            chr(3) . $key_id . chr(1) . $enc;
        }
    }

    private function gpg_literal($text)
    {
        if (strpos($text, "\r\n") === FALSE)
            $text = str_replace("\n", "\r\n", $text);

        return
            $this->gpg_header(0xac, strlen($text) + 10) . "t" .
            chr(4) . "file\0\0\0\0" . $text;
    }

    private function gpg_data($key, $text)
    {
        $enc = $this->gpg_encrypt($key, $this->gpg_literal($text));
        return $this->gpg_header(0xa4, strlen($enc)) . $enc;
    }

    /**
     * GPG Encypts a message to the provided public key
     *
     * @param GPG_Public_Key $pk
     * @param string         $plaintext
     *
     * @return string encrypted text
     */
    public function encrypt($pk, $plaintext)
    {
        // normalize the public key
        $key_id     = $pk->GetKeyId();
        $key_type   = $pk->GetKeyType();
        $public_key = $pk->GetPublicKey();

        $session_key = SchumacherFM_Pgp_Model_Php_Gpg_Utility::s_random($this->width, 0);
        $key_id      = SchumacherFM_Pgp_Model_Php_Gpg_Utility::hex2bin($key_id);
        $cp          = $this->gpg_session($key_id, $key_type, $session_key, $public_key) .
            $this->gpg_data($session_key, $plaintext);

        $code = base64_encode($cp);
        $code = wordwrap($code, 60, "\n", 1);

        return
            "-----BEGIN PGP MESSAGE-----\nVersion: VerySimple PHP-GPG v" . $this->version . "\n\n" .
            $code . "\n=" . base64_encode(SchumacherFM_Pgp_Model_Php_Gpg_Utility::crc24($cp)) .
            "\n-----END PGP MESSAGE-----\n";
    }
}

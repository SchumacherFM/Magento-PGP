<?php
/** @package    php-gpg::GPG */

/**
 * @package    php-gpg::GPG
 */
class SchumacherFM_Pgp_Model_Php_Gpg_ExpandedKey
{
    var $rounds = 0;
    var $rk;

    public function __construct($key)
    {
        $RCON = SchumacherFM_Pgp_Model_Php_Gpg_Cipher::$RCON;
        $S    = SchumacherFM_Pgp_Model_Php_Gpg_Cipher::$S;

        $maxkc = SchumacherFM_Pgp_Model_Php_Gpg_Cipher::$maxkc;
        $maxrk = SchumacherFM_Pgp_Model_Php_Gpg_Cipher::$maxrk;

        $kc          = 0;
        $i           = 0;
        $j           = 0;
        $r           = 0;
        $t           = 0;
        $rounds      = 0;
        $keySched    = array_fill(0, $maxrk + 1, 0);
        $keylen      = strlen($key);
        $k           = array_fill(0, $maxkc, 0);
        $tk          = array_fill(0, $maxkc, 0);
        $rconpointer = 0;

        if ($keylen == 16) {
            $rounds = 10;
            $kc     = 4;
        } else if ($keylen == 24) {
            $rounds = 12;
            $kc     = 6;
        } else if ($keylen == 32) {
            $rounds = 14;
            $kc     = 8;
        } else {
            return;
        }

        for ($i = 0; $i < $maxrk + 1; $i++) $keySched[$i] = array_fill(0, 4, 0);
        for ($i = 0, $j = 0; $j < $keylen; $j++, $i += 4) {
            if ($i < $keylen) {
                $k[$j] = ord($key[$i]) | (ord($key[$i + 1]) << 0x8) |
                    (ord($key[$i + 2]) << 0x10) | (ord($key[$i + 3]) << 0x18);
            } else {
                $k[$j] = 0;
            }
        }
        for ($j = $kc - 1; $j >= 0; $j--) $tk[$j] = $k[$j];

        $r = 0;
        $t = 0;
        for ($j = 0; ($j < $kc) && ($r < $rounds + 1);) {
            for (; ($j < $kc) && ($t < 4); $j++, $t++) {
                $keySched[$r][$t] = $tk[$j];
            }
            if ($t == 4) {
                $r++;
                $t = 0;
            }
        }

        while ($r < $rounds + 1) {
            $temp = $tk[$kc - 1];

            $tk[0] ^= $S[SchumacherFM_Pgp_Model_Php_Gpg_Utility::B1($temp)] | ($S[SchumacherFM_Pgp_Model_Php_Gpg_Utility::B2($temp)] << 0x8) |
                ($S[SchumacherFM_Pgp_Model_Php_Gpg_Utility::B3($temp)] << 0x10) | ($S[SchumacherFM_Pgp_Model_Php_Gpg_Utility::B0($temp)] << 0x18);
            $tk[0] ^= $RCON[$rconpointer++];

            if ($kc != 8) {
                for ($j = 1; $j < $kc; $j++) $tk[$j] ^= $tk[$j - 1];
            } else {
                for ($j = 1; $j < $kc / 2; $j++) $tk[$j] ^= $tk[$j - 1];

                $temp = $tk[$kc / 2 - 1];
                $tk[$kc / 2] ^= $S[SchumacherFM_Pgp_Model_Php_Gpg_Utility::B0($temp)] | ($S[SchumacherFM_Pgp_Model_Php_Gpg_Utility::B1($temp)] << 0x8) |
                    ($S[SchumacherFM_Pgp_Model_Php_Gpg_Utility::B2($temp)] << 0x10) | ($S[SchumacherFM_Pgp_Model_Php_Gpg_Utility::B3($temp)] << 0x18);

                for ($j = $kc / 2 + 1; $j < $kc; $j++) $tk[$j] ^= $tk[$j - 1];
            }

            for ($j = 0; ($j < $kc) && ($r < $rounds + 1);) {
                for (; ($j < $kc) && ($t < 4); $j++, $t++) {
                    $keySched[$r][$t] = $tk[$j];
                }
                if ($t == 4) {
                    $r++;
                    $t = 0;
                }
            }
        }

        $this->rounds = $rounds;
        $this->rk     = $keySched;
        return $this;
    }
}

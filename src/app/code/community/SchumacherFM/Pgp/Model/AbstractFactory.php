<?php

abstract class SchumacherFM_Pgp_Model_AbstractFactory
{


    abstract function encrypt($publicKey, $plainTextString);

}

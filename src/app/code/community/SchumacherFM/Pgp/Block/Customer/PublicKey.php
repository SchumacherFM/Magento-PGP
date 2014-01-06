<?php
/**
 * @category    SchumacherFM_Pgp
 * @package     Block
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 * @copyright   Copyright (c)
 * @license     http://opensource.org/licenses/osl-3.0.php
 */
class SchumacherFM_Pgp_Block_Customer_PublicKey extends Mage_Customer_Block_Account_Dashboard // Mage_Core_Block_Template
{

    /**
     * @return Mage_Core_Controller_Varien_Action|string
     */
    public function getAction()
    {
        return $this->getUrl('*/*/save');
    }

    /**
     * @return array
     */
    public function getCustomerPgpKey()
    {
        /** @var Mage_Customer_Model_Customer $customer */
        $customer = $this->getCustomer();

        /** @var SchumacherFM_Pgp_Model_Pgp $pgpKey */
        $pgpKey = Mage::getModel('pgp/pgp')->setEmailAddress($customer->getEmail());
        return $pgpKey->getPublicKeyDetails();
    }

}

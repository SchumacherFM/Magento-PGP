<?php
/**
 * @category    SchumacherFM_Pgp
 * @package     Helper
 * @author      Cyrill at Schumacher dot fm / @SchumacherFM
 */
class SchumacherFM_Pgp_Model_Core_Email_Template extends Mage_Core_Model_Email_Template
{
    /**
     * @var SchumacherFM_Pgp_Model_Pgp
     */
    protected $_encryptor = null;

    /**
     * @return SchumacherFM_Pgp_Model_Pgp
     */
    protected function _getEncryptor()
    {
        if ($this->_encryptor === null) {
            $this->_encryptor = Mage::getModel('pgp/pgp');
            $this->_encryptor->setEngine(Mage::helper('pgp')->getEngine());
        }
        return $this->_encryptor;
    }

    /**
     * Process email template code
     *
     * @param   array $variables
     *
     * @return  string
     */
    public function getProcessedTemplate(array $variables = array())
    {
        $text = parent::getProcessedTemplate($variables);

        // @todo bug sending GPG HTML mails not possible
        // $this->setTemplateType(self::TYPE_TEXT);
//Zend_Debug::dump($text);

        $emailAddressForEncryption = $this->getEmailAddressForEncryption();
        $this->_getEncryptor()
            ->setPlainTextString($text)
            ->setEmailAddress($emailAddressForEncryption);

        $encrypted = $this->_getEncryptor()->encrypt()->getEncrypted();

//        $this->getMail()->createAttachment(
//            'Version: 1',
//            'application/pgp-encrypted',
//            Zend_Mime::DISPOSITION_INLINE,
//            Zend_Mime::ENCODING_7BIT
//        );

        /*
        $this->getMail()->createAttachment(
            $encrypted,
            Zend_Mime::TYPE_OCTETSTREAM,
            Zend_Mime::DISPOSITION_INLINE,
            Zend_Mime::ENCODING_7BIT,
            'encrypted.asc'
        );
        return 'This is an OpenPGP/MIME encrypted message (RFC 2440 and 3156)';
        */

        return $encrypted;
    }

    /**
     * Send mail to recipient
     *
     * @param   array|string      $email        E-mail(s)
     * @param   array|string|null $name         receiver name(s)
     * @param   array             $variables    template variables
     *
     * @return  boolean
     **/
    public function send($email, $name = null, array $variables = array())
    {
        if (!$this->isValidForSend()) {
            Mage::logException(new Exception('This letter cannot be sent.')); // translation is intentionally omitted
            return FALSE;
        }

        $emails = array_values((array)$email);
        $names  = is_array($name) ? $name : (array)$name;
        $names  = array_values($names);
        foreach ($emails as $key => $email) {
            if (!isset($names[$key])) {
                $names[$key] = substr($email, 0, strpos($email, '@'));
            }
        }

        $variables['email'] = reset($emails);
        $variables['name']  = reset($names);

        ini_set('SMTP', Mage::getStoreConfig('system/smtp/host'));
        ini_set('smtp_port', Mage::getStoreConfig('system/smtp/port'));

        $mail = $this->getMail();

        $setReturnPath = Mage::getStoreConfig(self::XML_PATH_SENDING_SET_RETURN_PATH);
        switch ($setReturnPath) {
            case 1:
                $returnPathEmail = $this->getSenderEmail();
                break;
            case 2:
                $returnPathEmail = Mage::getStoreConfig(self::XML_PATH_SENDING_RETURN_PATH_EMAIL);
                break;
            default:
                $returnPathEmail = null;
                break;
        }

        if ($returnPathEmail !== null) {
            $mailTransport = new Zend_Mail_Transport_Sendmail("-f" . $returnPathEmail);
            Zend_Mail::setDefaultTransport($mailTransport);
        }

        foreach ($emails as $key => $email) {
            $mail->addTo($email, '=?utf-8?B?' . base64_encode($names[$key]) . '?=');
        }

        $this->setUseAbsoluteLinks(TRUE);
        $this->setEmailAddressForEncryption($variables['email']);
        $text = $this->getProcessedTemplate($variables);
//    Zend_Debug::dump($text);
//    exit;
        if ($this->isPlain()) {
            $mail->setBodyText($text);
        } else {
            $mail->setBodyHTML($text);
        }

        $mail->setSubject('=?utf-8?B?' . base64_encode($this->getProcessedTemplateSubject($variables)) . '?=');
        $mail->setFrom($this->getSenderEmail(), $this->getSenderName());

        try {
            $mail->send();
            $this->_mail = null;
        } catch (Exception $e) {
            $this->_mail = null;
            Mage::logException($e);
            return FALSE;
        }

        return TRUE;
    }

}

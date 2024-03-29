<?php
class sxQueue extends xPDOSimpleObject {

    /** {ihneritDoc} */
    public function save($cacheFlag = null) {
        if ($this->get('email_to') == '') {
            return false;
        }

        $hash = sha1(serialize(array(
            'subscriber_id' => $this->subscriber_id,
            'newsletter_id' => $this->newsletter_id,
            'email_to' => $this->email_to,
            'email_subject' => $this->email_subject,
            'email_body' => $this->email_body,
            'email_from' => $this->email_from,
            'email_from_name' => $this->email_from_name,
            'email_reply' => $this->email_reply,
        )));

        if (!$this->xpdo->getCount('sxQueue', array('hash' => $hash))) {
            $this->set('hash', $hash);
            return parent::save($cacheFlag);
        } else {
            return true;
        }
    }

    /**
     * Sends an email to subscriber
     * 
     * @return bool
     */
    public function send() {
        /** @var modPHPMailer $mail */
        $mail = $this->xpdo->getService('mail', 'mail.modPHPMailer');
        $mail->set(modMail::MAIL_BODY, $this->email_body);
        $mail->set(modMail::MAIL_FROM, $this->email_from);
        $mail->set(modMail::MAIL_FROM_NAME, $this->email_from_name);
        $mail->set(modMail::MAIL_SUBJECT, $this->email_subject);
        $mail->address('to', $this->email_to);
        $mail->address('reply-to', $this->reply_to);
        $mail->setHTML(true);
        if (!$mail->send()) {
            $this->xpdo->log(xPDO::LOG_LEVEL_ERROR, 'An error occured while trying to send email: ' . $mail->mailer->ErrorInfo);
            $mail->reset();
            return $mail->mailer->ErrorInfo;
        }
        else {
            $mail->reset();
            $this->remove();
            return true;
        }
    }
}

<?php

declare(strict_types=1);

namespace app\forms;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 * @property string $name
 * @property string $email
 * @property string $subject
 * @property string $body
 * @property string $verifyCode
 */
final class ContactForm extends Model
{
    public string $name = '';
    public string $email = '';
    public string $subject = '';
    public string $body = '';
    public string $verifyCode = '';


    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'email', 'subject', 'body'], 'required'],
            ['email', 'email'],
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool true when model validated and email is sent
     */
    public function contact(string $email): bool
    {
        if (!$this->validate()) {
            return false;
        }
        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
            ->setReplyTo([$this->email => $this->name])
            ->setSubject($this->subject)
            ->setTextBody($this->body)
            ->send();
    }
}

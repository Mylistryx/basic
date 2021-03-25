<?php

namespace tests\unit\models;

use app\forms\ContactForm;
use Yii;
use yii\mail\MessageInterface;

class ContactFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    public $tester;

    public function testEmailIsSentOnContact()
    {
        $model = new ContactForm();

        $model->attributes = [
            'name'       => 'Tester',
            'email'      => 'tester@example.com',
            'subject'    => 'very important letter subject',
            'body'       => 'body of current message',
            'verifyCode' => 'testme',
        ];

        expect_that($model->contact('admin@example.com'));

        // using Yii2 module actions to check email was sent
        $this->tester->seeEmailIsSent();

        /** @var MessageInterface $emailMessage */
        $emailMessage = $this->tester->grabLastSentEmail();
        expect('valid email is sent', $emailMessage)->isInstanceOf(MessageInterface::class);
        expect($emailMessage->getTo())->hasKey(Yii::$app->params['adminEmail']);
        expect($emailMessage->getFrom())->hasKey(Yii::$app->params['senderEmail']);
        expect($emailMessage->getReplyTo())->hasKey('tester@example.com');
        expect($emailMessage->getSubject())->equals('very important letter subject');
        expect($emailMessage->toString())->stringContainsString('body of current message');
    }
}

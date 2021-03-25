<?php

namespace tests\unit\models;

use app\models\Identity;
use Codeception\Test\Unit;

class UserTest extends Unit
{
    public function testFindUserById()
    {
        expect_that($user = Identity::findIdentity(100));
        expect($user->email)->equals('admin');

        expect_not(Identity::findIdentity(999));
    }

    public function testFindUserByAccessToken()
    {
        expect_that($user = Identity::findIdentityByAccessToken('100-token'));
        expect($user->email)->equals('admin');

        expect_not(Identity::findIdentityByAccessToken('non-existing'));
    }

    public function testFindUserByUsername()
    {
        expect_that(Identity::findByEmail('admin'));
        expect_not(Identity::findByEmail('not-admin'));
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser()
    {
        $user = Identity::findByEmail('admin');
        expect_that($user->validateAuthKey('test100key'));
        expect_not($user->validateAuthKey('test102key'));

        expect_that($user->validatePassword('admin'));
        expect_not($user->validatePassword('123456'));        
    }

}

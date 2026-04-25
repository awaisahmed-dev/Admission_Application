<?php
use \AcceptanceTester;

class IdcardCest
{
    public static $usernameField = '#login-form #loginform-username';
    public static $passwordField = '#login-form input[name="LoginForm[password]"]';
    public static $loginButton = '#login-form button[type=submit]';
    public function _before(AcceptanceTester $I, \Page\Login $loginPage)
    {
//        $loginPage->login('alhira_admin', 'Kashifkazmi3029882KK');
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function Test(AcceptanceTester $I)
    {
        $I->amOnPage('/school-management/student/idcard-print?id=42');
        $I->fillField(self::$usernameField, 'alhira_admin');
        $I->fillField(self::$passwordField, 'Kashifkazmi3029882KK');
        $I->click(self::$loginButton);
        $I->wait(5);
        $I->see("ponka", 'h1');
    }
}

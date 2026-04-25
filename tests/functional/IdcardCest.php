<?php
use \FunctionalTester;

class IdcardCest
{
    public function _before(AcceptanceTester $I, \Page\Login $loginPage)
    {
        $loginPage->login('alhira_admin', 'Kashifkazmi3029882KK');
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function Test(AcceptanceTester $I)
    {
        $I->amOnPage('http://schooladmin.techkorner.ca/school-management/student/idcard-print?id=42');
        $I->wait(5);
        $I->see("ponka", 'h1');
    }
}

<?php
use \AcceptanceTester;

class IdcardCest
{
    public function _before(AcceptanceTester $I)
    {
        $loginPage->login('aalhira_admin', 'Kashifkazmi3029882KK');
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function _tryToTest(AcceptanceTester $I)
    {
        $I->amOnPage('http://schooladmin.techkorner.ca/school-management/student/idcard-print?id=42');
        $I->see($example['title'], 'h1');
    }
}

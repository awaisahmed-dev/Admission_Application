<?php
use \AcceptanceTester;

class LoginCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    
    public function showTimeline(AcceptanceTester $I, \Page\Login $loginPage)
    {
        $loginPage->login('bill evans', 'debby');
        $I->wait(3);
        $I->see('Incorrect username or password.');

        $loginPage->login('superadmin', 'superadmin');
        
        $I->amOnPage('/timeline-event/index');
        $I->see('Application timeline', 'h1');
    }
    
    public function _tryToTest(AcceptanceTester $I)
    {
    }
}

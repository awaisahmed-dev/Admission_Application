<?php
use \FunctionalTester;

class SitemapCest
{
    public function _before(FunctionalTester $I, \Page\Login $loginPage)
    {
        $loginPage->login('demo@schooladmin', 'schooladmin123');
        
    }

    public function _after(FunctionalTester $I)
    {
    }
/**
    * @dataprovider pageProvider
    */

    public function siteModules(AcceptanceTester $I, \Codeception\Example $example)
    {
        //$example = $this->example;
        $I->amOnPage($example['url']);
        $I->see($example['title'], 'h1');
        $I->seeInTitle($example['title']);
    }
    
    /**
     * @return array
     */
    protected function pageProvider()
    {
        return [
            ['url'=>"/", 'title'=>"Campus Management Timeline"],
            ['url'=>"/school-management/school", 'title'=>"Schools"],
            ['url'=>"/school-management/student", 'title'=>"Students"],
            ['url'=>"/school-management/student-attendance", 'title'=>"Student Attendances"],
            ['url'=>"/school-management/student-class", 'title'=>"Student Classes"],
            ['url'=>"/school-management/subject", 'title'=>"Subjects"],
//            ['url'=>"/sections", 'title'=>"Sections"],
//            ['url'=>"/admission", 'title'=>"Admissions"],
            ['url'=>"/fee-management/student-fee", 'title'=>"Fees"],
            ['url'=>"/school-management/examination", 'title'=>"Examinations"],
            ['url'=>"/school-management/examination-schedule", 'title'=>"Examination Schedules"],
            ['url'=>"/school-management/examination-result", 'title'=>"Examination Results"],
            ['url'=>"/property-management/property", 'title'=>"Properties"],
            ['url'=>"/notification/notification", 'title'=>"Notifications"],
            ['url'=>"/notification/notification-log", 'title'=>"Notification Logs"],
            ['url'=>"/inventory-management/inventory", 'title'=>"Inventories"]
        ];
    }
}

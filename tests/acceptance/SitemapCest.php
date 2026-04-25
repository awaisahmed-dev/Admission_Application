<?php
use \AcceptanceTester;

class SitemapCest
{
    
    protected  $example;
    
    public function _before(AcceptanceTester $I, \Page\Login $loginPage)
    {
        $loginPage->login('superadmin', 'superadmin');
    }

    public function _after(AcceptanceTester $I)
    {
    }
    
//    protected function _inject(\Codeception\Example $example)
//    {
//        $this->example = $example;
////        $this->navBar = $navBar;
//    }

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
            ['url'=>"/", 'title'=>"Application timeline"],
            ['url'=>"/school-management/school", 'title'=>"Schools"],
            ['url'=>"/school-management/student", 'title'=>"Students"],
            ['url'=>"/school-management/student-attendance", 'title'=>"Student Attendances"],
            ['url'=>"/school-management/class", 'title'=>"Classes"],
            ['url'=>"/school-management/subject", 'title'=>"Subjects"],
//            ['url'=>"/sections", 'title'=>"Sections"],
//            ['url'=>"/admission", 'title'=>"Admissions"],
            ['url'=>"/fee", 'title'=>"Fees"],
            ['url'=>"/school-management/examination", 'title'=>"Examinations"],
            ['url'=>"/school-management/examination-schedule", 'title'=>"Examination schedules"],
            ['url'=>"/school-management/examination-result", 'title'=>"examination Results"],
            ['url'=>"/property-management/property", 'title'=>"Properties"],
            ['url'=>"/notification-management/notification", 'title'=>"Notifications"],
            ['url'=>"/notification-management/notification-log", 'title'=>"Notification log"],
            ['url'=>"/inventory-management/inventory", 'title'=>"Inventory"],
//            ['url'=>"/staff", 'title'=>"Staffs"],
//            ['url'=>"/class-promotion", 'title'=>"Class Promotions"],
//            ['url'=>"/print-template", 'title'=>"Print Templates"],
//            ['url'=>"/notifications", 'title'=>"Notifications"],
//            ['url'=>"/reports", 'title'=>"Reports"],
//            ['url'=>"/dashboards", 'title'=>"Dashboard"],
//            ['url'=>"/expense", 'title'=>"expenses"],
//            ['url'=>"/bug", 'title'=>"Bugs"],
//            ['url'=>"/feedback", 'title'=>"feedbacks"],
        ];
    }
}

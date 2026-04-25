<?php
use \AcceptanceTester;

class SitemapCest
{
    
    protected  $example;
    
    public function _before(AcceptanceTester $I, \Page\Login $loginPage)
    {
//        $loginPage->login('superadmin', 'superadmin');
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
        $example = $this->example;
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
//            ['url'=>"/school", 'title'=>"Schools"],
//            ['url'=>"/property", 'title'=>"Properties"],
//            ['url'=>"/staff", 'title'=>"Staffs"],
//            ['url'=>"/batch", 'title'=>"Batches"],
//            ['url'=>"/student", 'title'=>"Students"],
//            ['url'=>"/stationery", 'title'=>"Statioaries"],
//            ['url'=>"/class", 'title'=>"Classes"],
//            ['url'=>"/sections", 'title'=>"Sections"],
//            ['url'=>"/admission", 'title'=>"Admissions"],
//            ['url'=>"/fee", 'title'=>"Fees"],
//            ['url'=>"/attendance", 'title'=>"Attendances"],
//            ['url'=>"/examination", 'title'=>"Examinations"],
//            ['url'=>"/exam-schedule", 'title'=>"Exam schedules"],
//            ['url'=>"/result", 'title'=>"results"],
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

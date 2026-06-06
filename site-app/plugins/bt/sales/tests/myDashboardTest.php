<?php
use Bt\Sales\Models\SrnItem;
use Backend\Models\User;
class myDashboardTest extends PluginTestCase
{
//    public function testAddItem(){
//        $srnitem = SrnItem::find(2334);
//        $this->assertEquals(2334, $srnitem->id);
//        //Test Relationships
//        $this->assertTrue($srnitem->srn()->exists());
//    }
//    public function testPageLoad(){
//        $response = $this->get('/backend/bt/sales/mydashboard');
//        $response->assertStatus(302);
//    }
//
//    public function testSRNModelRules(){
//        $srn = SrnItem::find(4334);
//        $srnRules = $srn->rules;
//
//        $this->assertContains('required', $srnRules);
//
//    }
//    public function testMyDashboard(){
//
//        $user = User::find(1);
//
//        $this->actingAs($user);
//
//        $response = $this->post('/backend/bt/sales/mydashboard', ['startdate' => '2023-01-01', 'enddate' => '2023-01-01']);
//
//        $html = $response->getContent();
//
//        preg_match_all('@<td>(.+)</td>@', $html, $matches);
//
//        $objarray = array();
//        foreach ($matches as $targets)
//        {
//            foreach ($targets as $values)
//            {
//                $firsttrim =  trim($values, '<td>');
//                $secondTrim = trim($firsttrim, '</td>');
//                $objarray[] = $secondTrim;
//            }
//        }
//        $response->assertStatus(200);
//    }

    public function testDashboard(){
        $user = User::find(1);
        $this->actingAs($user);
        $response = $this->get('/tv');
        $response->assertStatus(200);
    }
//    public function testSrnTestPage(){
//        $user = User::find(1);
//        $this->actingAs($user);
//        $response = $this->get('/backend/bt/sales/srn/update/899999');
//        $response->assertStatus(200);
//    }
}

<?php

use Backend\Models\User;
class MainDashboardTest extends PluginTestCase
{

    public function testTVLoad(){
        $user = User::find(1);
        $this->actingAs($user);
        $response = $this->get('/tv');
        $response->assertStatus(200);
    }

    public function testDashboardLoad()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $response = $this->get('/backend');
        $response->assertStatus(200);
    }
}

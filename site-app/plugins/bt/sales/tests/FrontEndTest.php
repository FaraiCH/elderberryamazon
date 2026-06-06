<?php
use RainLab\User\Models\User;
class FrontEndTest extends PluginTestCase
{

    public function testFrontEnd()
    {
        $user = User::find(2);
        $this->actingAs($user);
        $response = $this->get('/');
        $response->assertStatus(200);
    }

}

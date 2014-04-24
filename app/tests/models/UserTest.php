<?php

use Mockery as m;
use Woodling\Woodling;

class UserTest extends TestCase {

    public function testIsConfirmedByEmail()
    {
        $user = Woodling::retrieve('UserAdmin');
        $this->assertEquals( $user->isConfirmed(array('email'=>'admin@example.org')), 1 );
    }

    public function testIsConfirmedByEmailFail()
    {
        $user = Woodling::retrieve('UserAdmin');
        $this->assertNotEquals( $user->isConfirmed(array('email'=>'non-user@example.org')), true );
    }



}

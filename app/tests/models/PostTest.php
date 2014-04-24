<?php

use Woodling\Woodling;

class PostTest extends TestCase {



    public function testUrl()
    {
        $post = Woodling::retrieve('Post');
        $this->assertGreaterThan( 0, strpos($post->url(), 'in-iisque-similique-reprimique-eum') );
    }
}
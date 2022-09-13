<?php

namespace crawlerests;

use luya\testsuite\traits\MessageFileCompareTrait;

/**
 * Message File Compare Trait.
 *
 */
class MessageFileTest extends CrawlerTestCase
{
    use MessageFileCompareTrait;
    
    public function testFiles()
    {
        $this->compareMessages(__DIR__ . '/../src/admin/messages', 'en');
    }
}

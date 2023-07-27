<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace MVWP\WPDataTableView\Tests\Unit;

use MVWP\WPDataTableView\Helpers;

class HelpersTest extends AbstractUnitTestCase
{

    public function testIsResponseCode2xx()
    {
        $this->assertTrue(Helpers::isResponseCode2xx(200));
        $this->assertTrue(Helpers::isResponseCode2xx(204));
        $this->assertTrue(Helpers::isResponseCode2xx(299));

        $this->assertFalse(Helpers::isResponseCode2xx(100));
        $this->assertFalse(Helpers::isResponseCode2xx(300));
        $this->assertFalse(Helpers::isResponseCode2xx(404));
    }

}
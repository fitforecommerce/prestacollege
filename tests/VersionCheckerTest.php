<?php

require_once(dirname(__FILE__).'/../classes/VersionChecker.php');

use PHPUnit\Framework\TestCase;
# use PrestaShop\Module\PrestaCollege\VersionChecker;

final class VersionCheckerTest extends TestCase
{
    private $version_checker;

    public function setUp()
    {
        parent::setUp();
        $this->version_checker = new VersionChecker();
    }
    public function testVersionCheckerCreated()
    {
      $this->assertInstanceOf(VersionChecker::class, $this->version_checker);
    }
    public function testReleaseDataLoaded()
    {
        $d = $this->version_checker->get_release_data();
        $this->assertTrue(strlen($d) > 20);
    }
}
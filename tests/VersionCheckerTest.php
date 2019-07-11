<?php
declare(strict_types=1);

require_once(dirname(__FILE__).'/../classes/VersionChecker.php');

use PHPUnit\Framework\TestCase;

# use PrestaShop\Module\PrestaCollege\VersionChecker;

class VersionCheckerTest extends TestCase
{
    private $version_checker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->version_checker = new VersionChecker();
    }
    public function testVersionCheckerCreated(): void
    {
      $this->assertInstanceOf(VersionChecker::class, $this->version_checker);
    }
    public function testReleaseDataLoaded(): void
    {
        $d = $this->version_checker->get_release_data();
        $this->assertTrue(strlen($d) > 20);
    }
}
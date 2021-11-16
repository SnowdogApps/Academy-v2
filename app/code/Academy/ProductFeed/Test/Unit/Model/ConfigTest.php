<?php
declare(strict_types=1);

namespace Academy\ProductFeed\Test\Unit\Model;

use Academy\ProductFeed\Model\Config;
use Magento\Framework\App\Config\ScopeConfigInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{

    /**
     * @var ScopeConfigInterface|MockObject
     */
    private ScopeConfigInterface $configScopeMock;

    /**
     * @var Config
     */
    private Config $testObject;

    protected function setUp(): void
    {
        $this->configScopeMock = $this->createMock(ScopeConfigInterface::class);
        $this->testObject = new Config($this->configScopeMock);
    }

    /**
     * @testWith [true, true]
     * [false, false]
     * [true, 1]
     * [false, 0]
     */
    public function TestShouldReturnTrueWhenProductFeedIsEnabled($expected, $configResult): void
    {
        $this->configScopeMock->method('getValue')->willReturn($configResult);
        $this->assertSame($expected, $this->testObject->isEnabled());
    }

}

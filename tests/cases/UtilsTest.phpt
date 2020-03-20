<?php declare(strict_types=1);

namespace Tests\Surda\Adldap\Extra\Utils;

use Surda\Adldap\Extra\Utils\Utils;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class UtilsTest extends TestCase
{
    public function testSid()
    {
        $bin = "\x01\x05\x00\x00\x00\x00\x00\x05\x15\x00\x00\x00\xcd4\x13\x1byH\xa7n\x15,\xb4o(\x04\x00\x00";
        $string = "S-1-5-21-454243533-1856456825-1874078741-1064";

        Assert::same($string, Utils::SIDtoString($bin));
    }

    public function testGuid()
    {
        $bin = "6xd\x89\xdd`\x8eN\x84\xed\nQ\x14en\x95";
        $string = "89647836-60DD-4E8E-84ED-0A5114656E95";

        Assert::same($string, Utils::GUIDtoString($bin));
    }
}

(new UtilsTest())->run();
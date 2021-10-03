<?php
/**
 * GetWord | tests file
 */

namespace jarne\getword;

use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \jarne\getword\GetWord
 */
class GetWordTest extends TestCase
{
    /**
     * Test if the website returns valid data
     *
     * @covers ::process
     */
    public function testProcess(): void
    {
        $getWord = new GetWord();

        $output = $getWord->process(
            array(
                "REQUEST_URI" => "localhost",
            )
        );

        $this->assertStringContainsString("GetWord", $output);
    }

    /**
     * Test if the API works
     *
     * @covers ::process
     * @runInSeparateProcess
     */
    public function testApi(): void
    {
        $getWord = new GetWord();

        $output = $getWord->process(
            array(
                "REQUEST_URI" => "localhost/api/7/70/30/40/true",
            )
        );

        $data = json_decode($output);

        $this->assertTrue(isset($data->status));
        $this->assertTrue(isset($data->generatedPassword));

        $status = $data->status;
        $generatedPassword = $data->generatedPassword;

        $this->assertEquals("success", $status);
        $this->assertEquals(7, strlen($generatedPassword));
    }

    /**
     * Test the API with invalid parameters
     *
     * @covers ::process
     * @runInSeparateProcess
     */
    public function checkApiFailed(): void
    {
        $getWord = new GetWord();

        $output = $getWord->process(
            array(
                "REQUEST_URI" => "localhost/api/0/0/0/0/false",
            )
        );

        $data = json_decode($output);

        $this->assertTrue(isset($data->status));
        $this->assertNotTrue(isset($data->generatedPassword));

        $status = $data->status;

        $this->assertEquals("failed", $status);
    }

    /**
     * Check a password with only letters in it
     *
     * @covers ::process
     * @runInSeparateProcess
     */
    public function testLettersApi(): void
    {
        $getWord = new GetWord();

        $output = $getWord->process(
            array(
                "REQUEST_URI" => "localhost/api/15/100/0/0/false",
            )
        );

        $data = json_decode($output);

        $this->assertTrue(isset($data->status));
        $this->assertTrue(isset($data->generatedPassword));

        $status = $data->status;
        $generatedPassword = $data->generatedPassword;

        $this->assertEquals("success", $status);
        $this->assertEquals(15, strlen($generatedPassword));
        $this->assertTrue(ctype_alpha($generatedPassword));
    }

    /**
     * Check a password with only numbers in it
     *
     * @covers ::process
     * @runInSeparateProcess
     */
    public function testNumericApi(): void
    {
        $getWord = new GetWord();

        $output = $getWord->process(
            array(
                "REQUEST_URI" => "localhost/api/23/0/100/0/false",
            )
        );

        $data = json_decode($output);

        $this->assertTrue(isset($data->status));
        $this->assertTrue(isset($data->generatedPassword));

        $status = $data->status;
        $generatedPassword = $data->generatedPassword;

        $this->assertEquals("success", $status);
        $this->assertEquals(23, strlen($generatedPassword));
        $this->assertTrue(is_numeric($generatedPassword));
    }

    /**
     * Test a valid percentage
     *
     * @covers ::isValidPercentage
     */
    public function testValidPercentage(): void
    {
        $getWord = new GetWord();

        $this->assertTrue($getWord->isValidPercentage("0"));
        $this->assertTrue($getWord->isValidPercentage("50"));
        $this->assertTrue($getWord->isValidPercentage("67"));
        $this->assertTrue($getWord->isValidPercentage("100"));
    }

    /**
     * Test invalid percentage
     *
     * @covers ::isValidPercentage
     */
    public function testInvalidPercentage(): void
    {
        $getWord = new GetWord();

        $this->assertFalse($getWord->isValidPercentage("abc"));
        $this->assertFalse($getWord->isValidPercentage("-9"));
        $this->assertFalse($getWord->isValidPercentage("250"));
        $this->assertFalse($getWord->isValidPercentage(""));
    }

    /**
     * Test a valid length
     *
     * @covers ::isValidLength
     */
    public function testValidLength(): void
    {
        $getWord = new GetWord();

        $this->assertTrue($getWord->isValidLength("1"));
        $this->assertTrue($getWord->isValidLength("24"));
        $this->assertTrue($getWord->isValidLength("100"));
    }

    /**
     * Test invalid length
     *
     * @covers ::isValidLength
     */
    public function testInvalidLength(): void
    {
        $getWord = new GetWord();

        $this->assertFalse($getWord->isValidLength("abc"));
        $this->assertFalse($getWord->isValidLength("-9"));
        $this->assertFalse($getWord->isValidLength("0"));
        $this->assertFalse($getWord->isValidLength("130"));
    }
}

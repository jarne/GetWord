<?php
/**
 * GetWord | tests file
 */

namespace jarne\getword;

use PHPUnit\Framework\TestCase;

class GetWordTest extends TestCase
{
    /**
     * Test if the website returns valid data
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
     * @runInSeperateProcess
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
}

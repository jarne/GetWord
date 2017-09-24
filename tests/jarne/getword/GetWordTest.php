<?php
/**
 * Created by PhpStorm.
 * User: jarne
 * Date: 14.05.17
 * Time: 16:41
 */

namespace jarne\getword;

use PHPUnit\Framework\TestCase;

class GetWordTest extends TestCase {
    /**
     * Test if the website works
     */
    public function testProcess() {
        $getWord = new GetWord();

        $output = $getWord->process(array(
            "REQUEST_URI" => ""
        ));

        $this->assertContains("GetWord", $output);
    }

    /**
     * Test if the API works
     *
     * @runInSeparateProcess
     */
    public function testApi() {
        $getWord = new GetWord();

        $output = $getWord->process(array(
            "REQUEST_URI" => "localhost/api/12/70/30/40/true"
        ));

        $data = json_decode($output);

        $status = $data->status;
        $generatedPassword = $data->generatedPassword;

        $this->assertEquals("success", $status);
        $this->assertEquals(12, strlen($generatedPassword));
    }

    /**
     * Test with only numeric password if the API works
     *
     * @runInSeparateProcess
     */
    public function testNumericApi() {
        $getWord = new GetWord();

        $output = $getWord->process(array(
            "REQUEST_URI" => "localhost/api/12/0/100/0/false"
        ));

        $data = json_decode($output);

        $status = $data->status;
        $generatedPassword = $data->generatedPassword;

        $this->assertEquals("success", $status);
        $this->assertEquals(12, strlen($generatedPassword));
        $this->assertTrue(is_numeric($generatedPassword));
    }
}
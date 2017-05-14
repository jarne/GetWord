<?php
/**
 * Created by PhpStorm.
 * User: jarne
 * Date: 14.05.17
 * Time: 16:41
 */

namespace jarne\getword;

use jarne\password\Password;

class GetWord {
    /* @var Password */
    private $password;

    public function __construct() {
        $this->password = new Password();
    }

    /**
     * Process a request
     *
     * @param array $server
     * @return string
     */
    public function process(array $server) {
        $requestUri = $server["REQUEST_URI"];
        $urlParts = explode("/", $requestUri);

        if(count($urlParts) > 6 AND $urlParts[1] == "api") {
            $length = $urlParts[2];
            $useLetters = $this->stringToChance($urlParts[3]);
            $useNumbers = $this->stringToChance($urlParts[4]);
            $useSpecialCharacters = $this->stringToChance($urlParts[5]);
            $easyToRemember = $urlParts[6];

            if(is_numeric($length)) {
                if($easyToRemember == "true") {
                    $generatedPassword = $this->getPassword()->generate($length, $useLetters, $useNumbers, $useSpecialCharacters);
                } else {
                    $generatedPassword = $this->getPassword()->generateEasyToRemember($length, $useLetters, $useNumbers, $useSpecialCharacters);
                }

                $this->goingToReturnJson();

                return json_encode(array(
                    "status" => "success",
                    "generatedPassword" => $generatedPassword
                ));
            }

            return json_encode(array(
                "status" => "failed"
            ));
        }

        return file_get_contents("templates/index.html");
    }

    /**
     * Get the chance from a boolean string
     *
     * @param string $string
     * @return int
     */
    public function stringToChance(string $string) {
        if($string == "true") {
            return 1;
        }

        return 0;
    }

    /**
     * Set content type to JSON
     */
    public function goingToReturnJson() {
        header("Content-Type: application/json");
    }

    /**
     * @return Password
     */
    public function getPassword(): Password {
        return $this->password;
    }
}
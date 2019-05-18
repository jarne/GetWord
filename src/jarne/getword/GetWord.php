<?php
/**
 * GetWord | main class
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
    public function process(array $server): string {
        $requestUri = $server["REQUEST_URI"];
        $urlParts = explode("/", $requestUri);

        if(count($urlParts) > 6 AND $urlParts[1] === "api") {
            $length = $urlParts[2];
            $useLetters = $urlParts[3];
            $useNumbers = $urlParts[4];
            $useSpecialCharacters = $urlParts[5];
            $easyToRemember = $urlParts[6];

            if($this->isValidLength($length)) {
                if($this->isValidPercentage($useLetters) AND $this->isValidPercentage(
                        $useNumbers
                    ) AND $this->isValidPercentage($useSpecialCharacters)) {
                    if($easyToRemember === "true") {
                        $generatedPassword = $this->getPassword()->generateEasyToRemember(
                            $length,
                            $useLetters,
                            $useNumbers,
                            $useSpecialCharacters
                        );
                    } else {
                        $generatedPassword = $this->getPassword()->generate(
                            $length,
                            $useLetters,
                            $useNumbers,
                            $useSpecialCharacters
                        );
                    }

                    $this->goingToReturnJson();

                    return json_encode(
                        array(
                            "status" => "success",
                            "generatedPassword" => $generatedPassword,
                        )
                    );
                }
            }

            return json_encode(
                array(
                    "status" => "failed",
                )
            );
        }

        return file_get_contents("templates/index.html");
    }

    /**
     * Check if a percentage is valid
     *
     * @param string $value
     * @return bool
     */
    public function isValidPercentage(string $value): bool {
        if(is_numeric($value)) {
            return ($value >= 0) AND ($value <= 100);
        }

        return false;
    }

    /**
     * Check if a length is valid
     *
     * @param string $length
     * @return bool
     */
    public function isValidLength(string $length): bool {
        if(is_numeric($length)) {
            return ($length > 0) AND ($length <= 100);
        }

        return false;
    }

    /**
     * Set content type to JSON
     */
    public function goingToReturnJson(): void {
        header("Content-Type: application/json");
    }

    /**
     * @return Password
     */
    public function getPassword(): Password {
        return $this->password;
    }
}

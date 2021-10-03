<?php
/**
 * GetWord | main class
 */

namespace jarne\getword;

use jarne\password\Password;

class GetWord
{
    /* @var Password */
    private Password $password;

    /**
     * Initialize password library
     */
    public function __construct()
    {
        $this->password = new Password();
    }

    /**
     * Process a request
     *
     * @param array $server
     * @return string
     */
    public function process(array $server): string
    {
        $requestUri = $server["REQUEST_URI"];
        $urlParts = explode("/", $requestUri);

        if (count($urlParts) > 6 and $urlParts[1] === "api") {
            $length = $urlParts[2];
            $useLetters = $urlParts[3];
            $useNumbers = $urlParts[4];
            $useSpecialCharacters = $urlParts[5];
            $easyToRemember = $urlParts[6];

            if ($this->isValidLength($length)) {
                if ($this->isValidPercentage($useLetters) and $this->isValidPercentage(
                        $useNumbers
                    ) and $this->isValidPercentage($useSpecialCharacters)) {
                    if ($easyToRemember === "true") {
                        $generatedPassword = $this->password->generateEasyToRemember(
                            $length,
                            $useLetters,
                            $useNumbers,
                            $useSpecialCharacters
                        );
                    } else {
                        $generatedPassword = $this->password->generate(
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

        return file_get_contents(__DIR__ . "/../../../templates/index.html");
    }

    /**
     * Check if a percentage is valid
     *
     * @param string $value
     * @return bool
     */
    public function isValidPercentage(string $value): bool
    {
        if (is_numeric($value)) {
            return ($value >= 0) and ($value <= 100);
        }

        return false;
    }

    /**
     * Check if a length is valid
     *
     * @param string $length
     * @return bool
     */
    public function isValidLength(string $length): bool
    {
        if (is_numeric($length)) {
            return ($length > 0) and ($length <= 100);
        }

        return false;
    }

    /**
     * Set content type to JSON
     *
     * @codeCoverageIgnore
     */
    public function goingToReturnJson(): void
    {
        header("Content-Type: application/json");
    }
}

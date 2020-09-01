<?php

namespace AG\PasswordGenerator\Password;

defined('ABSPATH') or die();

class GetPassword
{
    use \AG\PasswordGenerator\Log\Logger;

    private const MAX_LENGTH_PASSWORD = 99;

    //  $args = array(
    //     'pwd_length' => 8,
    //     'lowercase' => 1,
    //     'uppercase' => 1,
    //     'numbers'   => 0,
    //     'symbols'   => 0
    // )
    public function generatePassword(array $args): string {
        $this->logger(AG_PASSWORD_GENERATOR_DEBUG, AG_PASSWORD_GENERATOR_LOGGING);

        // extract array into vars
        extract($args);

        if (
            $lowercase === 0 &&
            $uppercase === 0 &&
            $numbers === 0 &&
            $symbols === 0
            ) {
                return '';
            }

        // simple error handling
        // if (!is_numeric($pwd_length) && is_integer($pwd_length)) {
        //     throw new \Exception('Password length argument should be an integer!');
        // }

        // $pwd_length = filter_var($pwd_length, FILTER_VALIDATE_INT);
        $pwd_length = filter_var($pwd_length, FILTER_SANITIZE_NUMBER_INT);

        // small letters
        $lowercaseChars = 'abcdefghijklmnopqrstuvwxyz';

        // CAPITAL LETTERS            
        $uppercaseChars  = strtoupper($lowercaseChars);

        // numerics                
        $numberChars   = '1234567890';

        // special characters                          
        $symbolChars = '`~!@#$%^&*()-_=+]}[{;:,<.>/?\'"\|';

        $charset = '';

        // Contains specific character groups
        if ($lowercase) {
            $charset .= (string) $lowercaseChars;
        }
        if ($uppercase) {
            $charset .= $uppercaseChars;
        }
        if ($numbers) {
            $charset .= $numberChars;
        }
        if ($symbols) {
            $charset .= $symbolChars;
        }
        // echo $charset . '<br />';

        // store password
        $password = '';

        // Loop until the preferred length reached
        for ($i = 0; $i < $pwd_length; $i++) {
            // get randomized length with cryptographically secure integers                                
            $_rand = random_int(0, strlen($charset) - 1);
            
            // returns part of the string                
            $password .= substr($charset, $_rand, 1);
        }


        return $password;
    }
}

<?php

namespace AG\PasswordGenerator\Input;

defined('ABSPATH') or die();

class FormInput
{
    use \AG\PasswordGenerator\Log\Logger;

    private const MAX_LENGTH_PASSWORD = 99;

    public function validateInput(): array
    {
        try {
        // validate request
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST ?? 0) {

            // Is lowercase, uppercase, etc. checked
            $lowercase  = ($_POST['lowercase'] ?? 0) ? 1 : 0;
            $uppercase  = ($_POST['uppercase'] ?? 0) ? 1 : 0;
            $numbers    = ($_POST['numbers'] ?? 0) ? 1 : 0;
            $symbols    = ($_POST['symbols'] ?? 0) ? 1 : 0;


            // validate pwd length int
            if (($_POST['pwd_length'] ?? 0) && !empty($_POST['pwd_length'])) {
                $pwd_length = $_POST['pwd_length'];
                if (preg_match("/^[0-9]*$/", $pwd_length)) {
                    $pwd_length = intval($_POST['pwd_length'], 10);

                    if ($pwd_length > self::MAX_LENGTH_PASSWORD) {
                        throw new \Exception('Password length argument should be <= 99!');
                    }
                } else {
                    throw new InputTypeException('You should supply an integer input.');
                }
            } else {
                throw new MissingInputException('Password length is not set.');
            }
        }
    } catch(InputTypeException $ex) {
        $this->exceptionLogger(AG_PASSWORD_GENERATOR_LOGGING, $ex);
        return array(
            'error' => $ex->getMessage()
        );
    } catch(MissingInputException $ex) {
        $this->exceptionLogger(AG_PASSWORD_GENERATOR_LOGGING, $ex);
        return array(
            'error' => $ex->getMessage()
        );
    } catch(\Exception $ex) {
        $this->exceptionLogger(AG_PASSWORD_GENERATOR_LOGGING, $ex);
        return array(
            'error' => $ex->getMessage()
        );
    }

        return array(
            'pwd_length' => filter_var($pwd_length, FILTER_SANITIZE_NUMBER_INT),
            'lowercase' => esc_html($lowercase),
            'uppercase' => esc_html($uppercase),
            'numbers'   => esc_html($numbers),
            'symbols'   => esc_html($symbols)
        );

    }
}

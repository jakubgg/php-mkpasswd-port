#!/usr/bin/env php
<?php
// mkpasswd defaults for SHA-512 for /etc/shadow on ubuntu and debian systems
$salt_min = 8;
$salt_max = 16;
$salt_valid_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789./';
$rounds = 5000;
$password = '';
$salt = '';

/**
 * Create salt for the hashing process, withing given character range constraints
 */
function makeSalt($length, $charset)
{
    $i = 0;
    $salt_string = '';

    while ($i < $length) {
        $random_byte = randomGenerator();
        if (strpos($charset, $random_byte)) {
            $salt_string .= $random_byte;
            $random_byte = '';
            $i++;
        }
    }

    return $salt_string;
}

/**
 * Generate 1 random byte for building salt string.
 */
function randomGenerator()
{
    if (function_exists('random_bytes')) {
        // random_bytes repaces mcrypt_create_iv from php7.0
        $random_char = random_bytes(1);
    } elseif (function_exists('mcrypt_create_iv')) {
        // only for compatibility with php5.6 and earlier.
        // DEPRICATED AND REMOVED AS OF PHP7.1
        $random_char = mcrypt_create_iv(1, MCRYPT_DEV_RANDOM);
        if ($random_char === false) {
            echo 'random generator failed';
            exit(1);
        }
    } else {
        echo 'No cryptographically safe random generator functions are available!';
        exit(1);
    }

    return $random_char;
}

function getHiddenInput()
{
    $stty_prefs = shell_exec('stty -g');

    exec('stty -echo');
    $string = rtrim(fgets(STDIN), "\n");
    exec('stty ' . $stty_prefs);

    return $string;
}

function getPassword()
{
    fwrite(STDOUT, "Password: \n");
    $password = getHiddenInput();

    fwrite(STDOUT, "Confirm password: \n");
    $password_confirm = getHiddenInput();

    if ($password !== $password_confirm) {
        fwrite(STDOUT, "Password mismatch \n");
        exit(1);
    }

    return $password;
}

function generateHash($pass, $salt, $rounds = 5000, $hash_type = '$6$')
{
    $rounds_str = ($rounds === 5000) ? '' : 'rounds=' . $rounds . '$';
    echo crypt($pass, $hash_type . $rounds_str . $salt . '$') . "\n";
}

$password = getPassword();
$salt = makeSalt(mt_rand($salt_min, $salt_max), $salt_valid_chars);
echo generateHash($password, $salt);

<?php 

namespace Gender\Classes\Supports;

use Gender\Classes\Supports\Config;

class Pkcs7 {


    /**
     * Right-pads the data string with 1 to n bytes according to PKCS#7,
     * where n is the block size.
     * The size of the result is x times n, where x is at least 1.
     * 
     * The version of PKCS#7 padding used is the one defined in RFC 5652 chapter 6.3.
     * This padding is identical to PKCS#5 padding for 8 byte block ciphers such as DES.
     *
     * @param string $plaintext the plaintext encoded as a string containing bytes
     * @param integer $blocksize the block size of the cipher in bytes
     * @return string the padded plaintext
     */
    public static function pad($plaintext, $blocksize)
    {   
        $padsize = $blocksize - (strlen($plaintext) % $blocksize);
        
        return $plaintext . str_repeat(chr($padsize), $padsize);
    }

    /**
     * Validates and unpads the padded plaintext according to PKCS#7.
     * The resulting plaintext will be 1 to n bytes smaller depending on the amount of padding,
     * where n is the block size.
     *
     * The user is required to make sure that plaintext and padding oracles do not apply,
     * for instance by providing integrity and authenticity to the IV and ciphertext using a HMAC.
     *
     * Note that errors during uppadding may occur if the integrity of the ciphertext
     * is not validated or if the key is incorrect. A wrong key, IV or ciphertext may all
     * lead to errors within this method.
     *
     * The version of PKCS#7 padding used is the one defined in RFC 5652 chapter 6.3.
     * This padding is identical to PKCS#5 padding for 8 byte block ciphers such as DES.
     *
     * @param string padded the padded plaintext encoded as a string containing bytes
     * @param integer $blocksize the block size of the cipher in bytes
     * @return string the unpadded plaintext
     * @throws Exception if the unpadding failed
     */
    public static function unpad($padded, $blocksize)
    {
        $l = strlen($padded);

        if ($l % $blocksize != 0) 
        {
            throw new Exception("Padded plaintext cannot be divided by the block size");
        }

        $padsize = ord($padded[$l - 1]);

        if ($padsize === 0)
        {
            throw new Exception("Zero padding found instead of PKCS#7 padding");
        }    

        if ($padsize > $blocksize)
        {
            throw new Exception("Incorrect amount of PKCS#7 padding for blocksize");
        }

        // check the correctness of the padding bytes by counting the occurance
        $padding = substr($padded, -1 * $padsize);
        if (substr_count($padding, chr($padsize)) != $padsize)
        {
            throw new Exception("Invalid PKCS#7 padding encountered");
        }

        return substr($padded, 0, $l - $padsize);
    }

}

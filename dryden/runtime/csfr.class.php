<?php

/**
 * Cross Site Forgery Request protection class.
 * @package zpanelx
 * @subpackage dryden -> runtime
 * @version 1.0.0
 * @author Bobby Allen (ballen@zpanelcp.com)
 * @copyright ZPanel Project (http://www.zpanelcp.com/)
 * @link http://www.zpanelcp.com/
 * @license GPL (http://www.gnu.org/licenses/gpl.html)
 */
class runtime_csfr {

    /**
     * Builds a 'hidden' form type which is populated with the generated token.
     * @author Bobby Allen (ballen@zpanelcp.com)
     * @return string The HTML form tag.
     */
    static function Token() {
        self::Tokeniser();
        $token = $_SESSION['zpcsfr'];
        return "<input type=\"hidden\" name=\"csfr_token\" value=\"" . $token . "\">";
    }

    /**
     * Generates a new CSFR token.
     * @author Bobby Allen (ballen@zpanelcp.com)
     * @return bool 
     */
    static function Tokeniser() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 14; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        $_SESSION['zpcsfr'] = implode($pass);
        return true;
    }

    /**
     * Verfies that the submitted form has a valid CSFR token.
     * @author Bobby Allen (ballen@zpanelcp.com)
     * @return bool
     */
    static function Protect() {
        if ($_POST['csfr_token'] == $_SESSION['zpcsfr']) {
            self::Tokeniser();
            return true;
        }
        die("CSFR Token failure!");
    }

}

?>

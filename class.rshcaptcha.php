<?php
/**
 * rshCaptcha - secure your forms.
 *
 * rshCaptcha - it generates an image readable only by humans securing a 
 * standard web forms from robots. So use this class to protect your web
 * site and visitors from malicious spamming bots.
 *
 * PHP version 4,5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Security
 * @package    rshCaptcha
 * @author     Iuhas Daniel <iuhas.daniel@igate.ro>
 * @copyright  2010-2011 Iuhas I. Daniel
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    SVN: $Id$
 * @link       http://pear.php.net/package/PackageName
 */

class rshCaptcha 
{
	var $chars_nr			= 5;
	var $width				= 100;
	var $height				= 30;
	var $lines				= 10;
	var $background_color	= array( "red" => 255, "green" => 255, "blue" => 255 );
	var $text_color			= array( "red" => 0, "green" => 0, "blue" => 0 );
	var $str				= null;
	var $characters			= '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRSTUVWXYZ';
	
	
	/**
     * Class constructor generates the CAPTCHA image.
     *
     * @return blob the image
     * @access public
     */
	function __construct()
	{
		session_start();
		$image		= imagecreate( $this->width, $this->height );
		$random_str = $this->gen_str( $this->chars_nr );#md5( microtime() );						// md5 to generate the random string
		$result_str = substr($random_str, 0, $this->chars_nr);	//trim $chars_nr digit 
		$bg_color	= imagecolorallocate(
						$image,
						$this->background_color['red'],
						$this->background_color['green'],
						$this->background_color['blue']);	// background color
		$tx_color	= imagecolorallocate(
						$image, 
						$this->text_color['red'], 
						$this->text_color['gree'], 
						$this->text_color['blue']);			// text color
						
		for ($i = 0; $i <= $this->lines; $i++)
		{
			$line_color = 
					imagecolorallocate(
						$image, 
						rand(0,255), 
						rand(0,255), 
						rand(0,255));						//line color 
					imageline(
						$image, 
						rand(rand(-10,100),rand(-10,100)), 
						rand(rand(-10,100),rand(-10,100)), 
						rand(rand(-10,100),rand(-10,100)), 
						rand(rand(-10,100),rand(-10,100)), 
						$line_color);						// Create lines on image 
		}
		
		imagestring($image, 5, 20, 10, $result_str, $tx_color); // Draw a random string horizontally 
		$_SESSION['key'] = $result_str;							// Carry the data through session
		
		header("Content-type: image/png");						// Out out the image 
		imagepng($image);										// Output image to browser 
	}
	
	/**
     * Registers the status of foo's universe
     *
     * @param string $arg1 the string to quote
     * @return int the integer of the set mode used. FALSE if foo
     * @access public
     */
	public function gen_str($length = 5)
	{
		for ($cnt = 0; $cnt < $length; $cnt++) {
			$this->str .= $this->characters[mt_rand(0, strlen($this->characters))];
		}
	
		return $this->str;
		
	}
	
	/**
     * Verify if the code in $_POST and the code in the $_SESSION are equals!
     *
     * @param string $value_name the $_POST value name.
     * @return TRUE if equals. FALSE if not equals
     * @access public
     */
	public function verify($value_name = 'number')
	{
		$result_str = $_SESSION['key'];
		$result_val = $_POST[$value_name];
		
		return $result_str == $result_val ? true : false;
	}
}

$img = new rshCaptcha();
?>

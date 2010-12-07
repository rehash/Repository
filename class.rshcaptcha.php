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
     * Registers the status of foo's universe
     *
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * Summaries should add description beyond the method's name. The
     * best method names are "self-documenting", meaning they tell you
     * basically what the method does.  If the summary merely repeats
     * the method name in sentence form, it is not providing more
     * information.
     *
     * Summary Examples:
     *   + Sets the label              (preferred)
     *   + Set the label               (avoid)
     *   + This method sets the label  (avoid)
     *
     * Below are the tags commonly used for methods.  A @param tag is
     * required for each parameter the method has.  The @return
     * and @access tags are mandatory.  The @throws tag is required if
     * the method uses exceptions.  @static is required if the method can
     * be called statically.  The remainder should only be used when
     * necessary.  Please use them in the order they appear here.
     * phpDocumentor has several other tags available, feel free to use
     * them.
     *
     * The @param tag contains the data type, then the parameter's
     * name, followed by a description.  By convention, the first noun in
     * the description is the data type of the parameter.  Articles like
     * "a", "an", and  "the" can precede the noun.  The descriptions
     * should start with a phrase.  If further description is necessary,
     * follow with sentences.  Having two spaces between the name and the
     * description aids readability.
     *
     * When writing a phrase, do not capitalize and do not end with a
     * period:
     *   + the string to be tested
     *
     * When writing a phrase followed by a sentence, do not capitalize the
     * phrase, but end it with a period to distinguish it from the start
     * of the next sentence:
     *   + the string to be tested. Must use UTF-8 encoding.
     *
     * Return tags should contain the data type then a description of
     * the data returned.  The data type can be any of PHP's data types
     * (int, float, bool, string, array, object, resource, mixed)
     * and should contain the type primarily returned.  For example, if
     * a method returns an object when things work correctly but false
     * when an error happens, say 'object' rather than 'mixed.'  Use
     * 'void' if nothing is returned.
     *
     * Here's an example of how to format examples:
     * <code>
     * require_once 'Net/Sample.php';
     *
     * $s = new Net_Sample();
     * if (PEAR::isError($s)) {
     *     echo $s->getMessage() . "\n";
     * }
     * </code>
     *
     * Here is an example for non-php example or sample:
     * <samp>
     * pear install net_sample
     * </samp>
     *
     * @param string $arg1 the string to quote
     * @param int    $arg2 an integer of how many problems happened.
     *                     Indent to the description's starting point
     *                     for long ones.
     *
     * @return int the integer of the set mode used. FALSE if foo
     *             foo could not be set.
     * @throws exceptionclass [description]
     *
     * @access public
     * @static
     * @see Net_Sample::$foo, Net_Other::someMethod()
     * @since Method available since Release 1.2.0
     * @deprecated Method deprecated in Release 2.0.0
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
     * Summaries for methods should use 3rd person declarative rather
     * than 2nd person imperative, beginning with a verb phrase.
     *
     * Summaries should add description beyond the method's name. The
     * best method names are "self-documenting", meaning they tell you
     * basically what the method does.  If the summary merely repeats
     * the method name in sentence form, it is not providing more
     * information.
     *
     * Summary Examples:
     *   + Sets the label              (preferred)
     *   + Set the label               (avoid)
     *   + This method sets the label  (avoid)
     *
     * Below are the tags commonly used for methods.  A @param tag is
     * required for each parameter the method has.  The @return
     * and @access tags are mandatory.  The @throws tag is required if
     * the method uses exceptions.  @static is required if the method can
     * be called statically.  The remainder should only be used when
     * necessary.  Please use them in the order they appear here.
     * phpDocumentor has several other tags available, feel free to use
     * them.
     *
     * The @param tag contains the data type, then the parameter's
     * name, followed by a description.  By convention, the first noun in
     * the description is the data type of the parameter.  Articles like
     * "a", "an", and  "the" can precede the noun.  The descriptions
     * should start with a phrase.  If further description is necessary,
     * follow with sentences.  Having two spaces between the name and the
     * description aids readability.
     *
     * When writing a phrase, do not capitalize and do not end with a
     * period:
     *   + the string to be tested
     *
     * When writing a phrase followed by a sentence, do not capitalize the
     * phrase, but end it with a period to distinguish it from the start
     * of the next sentence:
     *   + the string to be tested. Must use UTF-8 encoding.
     *
     * Return tags should contain the data type then a description of
     * the data returned.  The data type can be any of PHP's data types
     * (int, float, bool, string, array, object, resource, mixed)
     * and should contain the type primarily returned.  For example, if
     * a method returns an object when things work correctly but false
     * when an error happens, say 'object' rather than 'mixed.'  Use
     * 'void' if nothing is returned.
     *
     * Here's an example of how to format examples:
     * <code>
     * require_once 'Net/Sample.php';
     *
     * $s = new Net_Sample();
     * if (PEAR::isError($s)) {
     *     echo $s->getMessage() . "\n";
     * }
     * </code>
     *
     * Here is an example for non-php example or sample:
     * <samp>
     * pear install net_sample
     * </samp>
     *
     * @param string $arg1 the string to quote
     * @param int    $arg2 an integer of how many problems happened.
     *                     Indent to the description's starting point
     *                     for long ones.
     *
     * @return int the integer of the set mode used. FALSE if foo
     *             foo could not be set.
     * @throws exceptionclass [description]
     *
     * @access public
     * @static
     * @see Net_Sample::$foo, Net_Other::someMethod()
     * @since Method available since Release 1.2.0
     * @deprecated Method deprecated in Release 2.0.0
     */
	public function gen_str($length = 5)
	{
		for ($cnt = 0; $cnt < $length; $cnt++) {
			$this->str .= $this->characters[mt_rand(0, strlen($this->characters))];
		}
	
		return $this->str;
		
	}
	
	/**
     * Verify the code in $_POST and the code in the $_SESSION!
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

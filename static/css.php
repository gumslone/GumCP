<?php
$offset = 60 * 60 * 24 * 30; // Cache for a day
header("Content-type: text/css");
header ("Cache-Control: max-age=" . $offset . ", must-revalidate");
header ("Expires: " . gmdate ("D, d M Y H:i:s", time() + $offset) . " GMT");
function minify($css, $options = "remove-last-semicolon")
{
	$options = ($options == "") ? array() : (is_array($options) ? $options : explode(",", $options));
	if (in_array("preserve-urls", $options))
		{
		// Encode url() to base64
		$css = preg_replace_callback("/url\s*\((.*)\)/siU", "cssmin_encode_url", $css);
		}
	// Remove comments
	$css = preg_replace("/\/\*[\d\D]*?\*\/|\t+/", " ", $css);
	// Replace CR, LF and TAB to spaces
	$css = str_replace(array("\n", "\r", "\t"), " ", $css);
	// Replace multiple to single space
	$css = preg_replace("/\s\s+/", " ", $css);
	// Remove unneeded spaces
	$css = preg_replace("/\s*({|}|\[|\]|=|~|\+|>|\||;|:|,)\s*/", "$1", $css);
	if (in_array("remove-last-semicolon", $options))
		{
		// Removes the last semicolon of every style definition
		$css = str_replace(";}", "}", $css);
		}
	$css = trim($css);
	if (in_array("preserve-urls", $options))
		{
		// Decode url()
		$css = preg_replace_callback("/url\s*\((.*)\)/siU", "cssmin_encode_url", $css);
		}
	return $css;
}
function compress($buffer) {
	/* remove comments */
	$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
	/* remove tabs, spaces, newlines, etc. */
	$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
	$buffer = str_replace(array(";}", "; }"), '}', $buffer);
	$buffer = str_replace(array('} ', ' }'), '}', $buffer);
	$buffer = str_replace(array('{ ',' {'), '{', $buffer);
	$buffer = str_replace('( ', '(', $buffer);
	$buffer = str_replace(' )', ')', $buffer);
	$buffer = str_replace(array(': ',' :'), ':', $buffer);
	$buffer = str_replace(array('("','(\''), '(', $buffer); 
	$buffer = str_replace(array('")','\')'), ')', $buffer);
	$buffer = str_replace(array(', ',' ,'), ',', $buffer);
	$buffer = str_replace(array('; ',' ;'), ';', $buffer);
	
	//$buffer = preg_replace("/url\((\"|'|)((.*\.(png|gif|jpg))(\"|'|))\)/Uie", "image_to_base64('$3','$4')", $buffer);
	/*preg_match_all("/src=((\"|'|)?(.*\.(png|gif|jpg))(\"|'|))/Ui", $strHTML, $arrMatches);*/
	/*preg_match_all("/background=((\"|'|)?(.*\.(png|gif|jpg))(\"|'|))/Ui", $strHTML, $arrMatches);*/
	/*preg_match_all("/url\((\"|'|)?((.*\.(png|gif|jpg))(\"|'|))\)/Ui", $strHTML, $arrMatches);*/
	#$css = preg_replace("/url\(\"|'|?(.*\.(png|gif|jpg)\"|'|\)/Ui", $strHTML, $arrMatches);
	
	return $buffer;
}
function image_to_base64($image_url,$image_type)
{
	if(file_exists($image_url))
	{
		$size = filesize($image_url);
		if(round($size/1024, 2)<6)
		{
			$image_type = str_replace('jpg','jpeg',$image_type);
			return 'url(\'data:image/'.$image_type.';base64,'.base64_encode(file_get_contents($image_url)).'\')';
		}
		else
			return 'url(\''.$image_url.'\')';
	}
	else
		return 'url(\''.$image_url.'\')';
}

ob_start();

include('./css/animate.css');
include('./css/flags.css');
include('./css/bootstrap-theme.min.css');
include('./css/bootstrap.min.css');
include('./css/bootstrap-switch.min.css');
include('./css/style.css');
//include('./css/font-awesome.min.css');
$out = ob_get_contents();
ob_end_clean();
$out = compress($out);

if(strstr($_SERVER["HTTP_ACCEPT_ENCODING"],"gzip"))
{
	header("Content-Encoding: gzip");
	header("Vary: Accept-Encoding");
	ob_start('ob_gzhandler');
}
echo $out;

?>
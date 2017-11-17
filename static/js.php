<?php
$offset = 60 * 60 * 24 * 30; // Cache for a day
header("Content-type: text/javascript");
header ("Cache-Control: max-age=" . $offset . ", must-revalidate");
header ("Expires: " . gmdate ("D, d M Y H:i:s", time() + $offset) . " GMT");
function compress($buffer) {
	/* remove comments and empty lines */
	//$buffer = preg_replace('!/\*.*?\*/!s', '', $buffer);
	#$pattern = '/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\')\/\/.*))/';
	#$buffer = preg_replace($pattern, '', $buffer);
	//$buffer = preg_replace('/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\)\/\/[^"\'].*))/', '', $buffer);
	//$buffer = preg_replace( "/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:)\/\/.*))/", "", $buffer ); //Yancharuk's code/regex
	//$buffer = preg_replace("/\/\*[\s\S]*?\*\//", '', $buffer);

	//$buffer = preg_replace('/\/\*[*.\S\s]+[^*\/]/s', '', $buffer);
	
	$replace = array(
    '#\'([^\n\']*?)/\*([^\n\']*)\'#' => "'\1/'+\'\'+'*\2'", // remove comments from ' strings
    '#\"([^\n\"]*?)/\*([^\n\"]*)\"#' => '"\1/"+\'\'+"*\2"', // remove comments from " strings
    '#/\*.*?\*/#s'            => "",      // strip C style comments
    '#[\r\n]+#'               => "\n",    // remove blank lines and \r's
    '#\n([ \t]*//.*?\n)*#s'   => "\n",    // strip line comments (whole line only)
    '#([^\\])//([^\'"\n]*)\n#s' => "\\1\n",
                                          // strip line comments
                                          // (that aren't possibly in strings or regex's)
    '#\n\s+#'                 => "\n",    // strip excess whitespace
    '#\s+\n#'                 => "\n",    // strip excess whitespace
    '#(//[^\n]*\n)#s'         => "\\1\n", // extra line feed after any comments left
                                          // (important given later replacements)
    '#/([\'"])\+\'\'\+([\'"])\*#' => "/*" // restore comments in strings
  );

  #$search = array_keys( $replace );
  #$buffer = preg_replace( $search, $replace, $buffer );
	#$buffer = preg_replace("@/\*(.*?)\*/@s","\n",$buffer);
	$buffer = preg_replace('(// .+)', '', $buffer);
	$buffer = str_replace(array("//\r\n", "//\n", "\t"), '', $buffer);
	$buffer = preg_replace('/\n\s*\n/', "\n", $buffer);
	//$buffer = preg_replace('/\s+/', ' ', $buffer);
	
	return $buffer;
}
ob_start();
include('./js/wow.min.js');
include('./js/jquery-2.2.4.min.js');
include('./js/bootstrap.min.js');
include('./js/bootstrap-switch.js');
include('./js/jquery.easing.min.js');
include('./js/jquery.easypiechart.min.js');
include('./js/gumcp.js');

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
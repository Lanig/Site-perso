<?php

namespace Core\Service;

use Leafo\ScssPhp\Compiler;
use Leafo\ScssPhp\Server;

/**
* Stylesheet
*/
class Stylesheet extends Compiler
{
	private $debug;
	private $css_file;
	public function __construct($css_file, $debug = true)
	{
		$this->debug = $debug;
		$this->css_file = $css_file;
		if($debug) $this->setFormatter('Leafo\ScssPhp\Formatter\Expanded');
		else $this->setFormatter('Leafo\ScssPhp\Formatter\Crunched');
	}

	public function css($arg)
	{
		if(!is_array($arg)) $arg = [$arg];

		$css_url = dirname(dirname(dirname(__DIR__)))."/web/assets/css/".$this->css_file;

		if($this->debug) @unlink($css_url);

		if(!file_exists($css_url)) {
			foreach ($arg as $a) {
				if (preg_match('/.scss$/', $a)) {

					$url = dirname(dirname(dirname(__DIR__)))."/web/assets/css/".$a;

					if(file_exists($url)){
						$scss = file_get_contents($url);
						$css = @$this->compile($scss);
					}

				} else $css = file_get_contents(dirname(dirname(dirname(__DIR__)))."/web/assets/css/".$a);

				if ($css) file_put_contents($css_url, $css, FILE_APPEND);
			}
		}
		
		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/".BASE_DIR."css/".$this->css_file."\">\n";
		
	}
}
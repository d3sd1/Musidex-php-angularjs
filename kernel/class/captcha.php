<?php
class Securimage {
    public $perturbation = 0.5;
    public $image_bg_color = '#ffffff';
    public $text_color = '#000000';
    public $line_color = '#31c23c';
    public $noise_color = '#31c23c';
    public $code_length = 5;
    public $case_sensitive = false;
    public static $maxAttemptsPerCaptcha = 5;
    public $image_width = 215;
    public $image_height = 80;
    public $font_ratio = 0.4;
    public $num_lines = 2;
    public $noise_level = 10;
    public $ttf_file;
    public $namespace;
    protected static $_captchaId = null;
    protected $im;
    protected $tmpimg;
    protected $bgimg;
    protected $iscale = 5;
    public $securimage_path = null;
    protected $code;
    public $display_value;
    protected $captcha_code;
    protected $send_headers;
    protected $gdbgcolor;
    protected $gdtextcolor;
    protected $gdlinecolor;
    public function __construct($options = array())
    {
        $this->securimage_path = dirname(__FILE__);

        if (!is_array($options)) {
            trigger_error(
                    '$options passed to Securimage::__construct() must be an array.  ' .
                    gettype($options) . ' given',
                    E_USER_WARNING
            );
            $options = array();
        }

        if (is_array($options) && sizeof($options) > 0) {
            foreach($options as $prop => $val) {
                if ($prop == 'captchaId') {
                    Securimage::$_captchaId = $val;
                } else {
                    $this->$prop = $val;
                }
            }
        }

        $this->image_bg_color  = $this->initColor($this->image_bg_color,  '#ffffff');
        $this->text_color      = $this->initColor($this->text_color,      '#616161');
        $this->line_color      = $this->initColor($this->line_color,      '#616161');
        $this->noise_color     = $this->initColor($this->noise_color,     '#616161');
		$this->ttf_file = HOME.'/style/fonts/arefruqaa-regular.ttf';

        if (is_null($this->code_length) || (int)$this->code_length < 1) {
            $this->code_length = 6;
        }

        if (is_null($this->perturbation) || !is_numeric($this->perturbation)) {
            $this->perturbation = 0.75;
        }

        if (is_null($this->namespace) || !is_string($this->namespace)) {
            $this->namespace = 'default';
        }

        if (is_null($this->send_headers)) {
            $this->send_headers = true;
        }
    }
    public static function getPath()
    {
        return dirname(__FILE__);
    }

    public static function getCaptchaId($new = true, array $options = array())
    {
        if (is_null($new) || (bool)$new == true) {
            $id = sha1(uniqid($_SERVER['REMOTE_ADDR'], true));
            $si = new self();
            Securimage::$_captchaId = $id;
            $si->createCode();

            return $id;
        } else {
            return Securimage::$_captchaId;
        }
    }

    public function show()
    {
        if( ($this->bgimg != '') && function_exists('imagecreatetruecolor')) {
            $imagecreate = 'imagecreatetruecolor';
        } else {
            $imagecreate = 'imagecreate';
        }
        $this->im     = $imagecreate($this->image_width, $this->image_height);
        $this->tmpimg = $imagecreate($this->image_width * $this->iscale, $this->image_height * $this->iscale);
        $this->allocateColors();
        imagepalettecopy($this->tmpimg, $this->im);
        $this->setBackground();
        $code = null;
        if ($this->getCaptchaId(false) !== null) {
            if (is_string($this->display_value) && strlen($this->display_value) > 0) {
                $this->code         = ($this->case_sensitive) ?
                                       $this->display_value   :
                                       strtolower($this->display_value);
                $code = $this->code;
            }
        }

        if ($code == '') {
            $this->createCode();
        }

        if ($this->noise_level > 0) {
            $this->drawNoise();
        }

        $this->drawWord();

        if ($this->perturbation > 0 && is_readable($this->ttf_file)) {
            $numpoles = 3;
			for ($i = 0; $i < $numpoles; ++ $i) {
				$px[$i]  = mt_rand($this->image_width  * 0.2, $this->image_width  * 0.8);
				$py[$i]  = mt_rand($this->image_height * 0.2, $this->image_height * 0.8);
				$rad[$i] = mt_rand($this->image_height * 0.2, $this->image_height * 0.8);
				$tmp     = ((- $this->frand()) * 0.15) - .15;
				$amp[$i] = $this->perturbation * $tmp;
			}

			$bgCol = imagecolorat($this->tmpimg, 0, 0);
			$width2 = $this->iscale * $this->image_width;
			$height2 = $this->iscale * $this->image_height;
			imagepalettecopy($this->im, $this->tmpimg);
			for ($ix = 0; $ix < $this->image_width; ++ $ix) {
				for ($iy = 0; $iy < $this->image_height; ++ $iy) {
					$x = $ix;
					$y = $iy;
					for ($i = 0; $i < $numpoles; ++ $i) {
						$dx = $ix - $px[$i];
						$dy = $iy - $py[$i];
						if ($dx == 0 && $dy == 0) {
							continue;
						}
						$r = sqrt($dx * $dx + $dy * $dy);
						if ($r > $rad[$i]) {
							continue;
						}
						$rscale = $amp[$i] * sin(3.14 * $r / $rad[$i]);
						$x += $dx * $rscale;
						$y += $dy * $rscale;
					}
					$c = $bgCol;
					$x *= $this->iscale;
					$y *= $this->iscale;
					if ($x >= 0 && $x < $width2 && $y >= 0 && $y < $height2) {
						$c = imagecolorat($this->tmpimg, $x, $y);
					}
					if ($c != $bgCol) {
						imagesetpixel($this->im, $ix, $iy, $c);
					}
				}
			}
        }

        if ($this->num_lines > 0) {
            $this->drawLines();
        }

        $this->output();
    }
	
    public function check($code)
    {
        $this->code_entered = $code;
        $this->validate();
        return $this->correct_code;
    }
	
    public function setNamespace($namespace)
    {
        $namespace = preg_replace('/[^a-z0-9-_]/i', '', $namespace);
        $namespace = substr($namespace, 0, 64);

        if (!empty($namespace)) {
            $this->namespace = $namespace;
        } else {
            $this->namespace = 'default';
        }
    }
    public function getCode($array = false, $returnExisting = false)
    {
        $code = array();
        $disp = 'error';

        if ($returnExisting && strlen($this->code) > 0) {
            if ($array) {
                return array(
                    'code'         => $this->code);
            } else {
                return $this->code;
            }
        }

        
            if(sessionManager::issetSession('securimage_code_value')) {
				sessionManager::setSession('securimage_code_attempts',(sessionManager::getSession('securimage_code_attempts')+1));
                if ($this->isCodeExpired(sessionManager::getSession('securimage_code_attempts')) == false) {
                    $code['code'] = sessionManager::getSession('securimage_code_value');
                    $code['attempts'] = sessionManager::getSession('securimage_code_attempts');
                }
				else
				{
					$code['code'] = '{*CODE_HAS_BEEN_EXPIRED*}';
                    $code['attempts'] = 0;
				}
            }
        
        if ($array == true) {
            return $code;
        } else {
            return $code['code'];
        }
    }
	
    protected function allocateColors()
    {
        $this->gdbgcolor = imagecolorallocate($this->im,
                                              $this->image_bg_color->r,
                                              $this->image_bg_color->g,
                                              $this->image_bg_color->b);

        
            $this->gdtextcolor = imagecolorallocate($this->im,
                                                    $this->text_color->r,
                                                    $this->text_color->g,
                                                    $this->text_color->b);
            $this->gdlinecolor = imagecolorallocate($this->im,
                                                    $this->line_color->r,
                                                    $this->line_color->g,
                                                    $this->line_color->b);
            $this->gdnoisecolor = imagecolorallocate($this->im,
                                                          $this->noise_color->r,
                                                          $this->noise_color->g,
                                                          $this->noise_color->b);
        

    }
	
    protected function setBackground()
    {
        imagefilledrectangle($this->im, 0, 0,
                             $this->image_width, $this->image_height,
                             $this->gdbgcolor);
        imagefilledrectangle($this->tmpimg, 0, 0,
                             $this->image_width * $this->iscale, $this->image_height * $this->iscale,
                             $this->gdbgcolor);
    }
	
    public function createCode()
    {
        $this->code = false;
		$characters = '123456789abcdefghijklmnpqrstuvwxyz';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $this->code_length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		$this->code = $randomString;
		$this->code  = ($this->case_sensitive) ? $this->code : strtolower($this->code);

        $this->saveData();
    }

    protected function drawWord()
    {
        $width2  = $this->image_width * $this->iscale;
        $height2 = $this->image_height * $this->iscale;
        $ratio   = $this->font_ratio;

        if ((float)$ratio < 0.1 || (float)$ratio >= 1) {
            $ratio = 0.4;
        }

        if (!is_readable($this->ttf_file)) {
            imagestring($this->im, 4, 10, ($this->image_height / 2) - 5, 'Failed to load TTF font file!', $this->gdtextcolor);
        } else {
            if ($this->perturbation > 0) {
                $font_size = $height2 * $ratio;
                $bb = imageftbbox($font_size, 0, $this->ttf_file, $this->code);
                $tx = $bb[4] - $bb[0];
                $ty = $bb[5] - $bb[1];
                $x  = floor($width2 / 2 - $tx / 2 - $bb[0]);
                $y  = round($height2 / 2 - $ty / 2 - $bb[1]);

                imagettftext($this->tmpimg, $font_size, 0, (int)$x, (int)$y, $this->gdtextcolor, $this->ttf_file, $this->code);
            } else {
                $font_size = $this->image_height * $ratio;
                $bb = imageftbbox($font_size, 0, $this->ttf_file, $this->code);
                $tx = $bb[4] - $bb[0];
                $ty = $bb[5] - $bb[1];
                $x  = floor($this->image_width / 2 - $tx / 2 - $bb[0]);
                $y  = round($this->image_height / 2 - $ty / 2 - $bb[1]);

                imagettftext($this->im, $font_size, 0, (int)$x, (int)$y, $this->gdtextcolor, $this->ttf_file, $this->code);
            }
        }
    }
    protected function drawLines()
    {
        for ($line = 0; $line < $this->num_lines; ++ $line) {
            $x = $this->image_width * (1 + $line) / ($this->num_lines + 1);
            $x += (0.5 - $this->frand()) * $this->image_width / $this->num_lines;
            $y = mt_rand($this->image_height * 0.1, $this->image_height * 0.9);

            $theta = ($this->frand() - 0.5) * M_PI * 0.7;
            $w = $this->image_width;
            $len = mt_rand($w * 0.4, $w * 0.7);
            $lwid = mt_rand(0, 2);

            $k = $this->frand() * 0.6 + 0.2;
            $k = $k * $k * 0.5;
            $phi = $this->frand() * 6.28;
            $step = 0.5;
            $dx = $step * cos($theta);
            $dy = $step * sin($theta);
            $n = $len / $step;
            $amp = 1.5 * $this->frand() / ($k + 5.0 / $len);
            $x0 = $x - 0.5 * $len * cos($theta);
            $y0 = $y - 0.5 * $len * sin($theta);

            $ldx = round(- $dy * $lwid);
            $ldy = round($dx * $lwid);

            for ($i = 0; $i < $n; ++ $i) {
                $x = $x0 + $i * $dx + $amp * $dy * sin($k * $i * $step + $phi);
                $y = $y0 + $i * $dy - $amp * $dx * sin($k * $i * $step + $phi);
                imagefilledrectangle($this->im, $x, $y, $x + $lwid, $y + $lwid, $this->gdlinecolor);
            }
        }
    }
    protected function drawNoise()
    {
        if ($this->noise_level > 10) {
            $noise_level = 10;
        } else {
            $noise_level = $this->noise_level;
        }

        $t0 = microtime(true);

        $noise_level *= 125; 

        $points = $this->image_width * $this->image_height * $this->iscale;
        $height = $this->image_height * $this->iscale;
        $width  = $this->image_width * $this->iscale;
        for ($i = 0; $i < $noise_level; ++$i) {
            $x = mt_rand(10, $width);
            $y = mt_rand(10, $height);
            $size = mt_rand(7, 10);
            if ($x - $size <= 0 && $y - $size <= 0) continue;
            imagefilledarc($this->tmpimg, $x, $y, $size, $size, 0, 360, $this->gdnoisecolor, IMG_ARC_PIE);
        }

        $t1 = microtime(true);

        $t = $t1 - $t0;

        /*
        // DEBUG
        imagestring($this->tmpimg, 5, 25, 30, "$t", $this->gdnoisecolor);
        header('content-type: image/png');
        imagepng($this->tmpimg);
        exit;
        */
    }
    /**
     * Sends the appropriate image and cache headers and outputs image to the browser
     */
    protected function output()
    {
        if ($this->canSendHeaders() || $this->send_headers == false) {
            if ($this->send_headers) {
                header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
                header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
                header("Cache-Control: no-store, no-cache, must-revalidate");
                header("Cache-Control: post-check=0, pre-check=0", false);
                header("Pragma: no-cache");
            }

           
            if ($this->send_headers) { header("Content-Type: image/png"); }
            imagepng($this->im);
        } else {
            echo '<hr /><strong>'
                .'Failed to generate captcha image, content has already been '
                .'output.<br />This is most likely due to misconfiguration or '
                .'a PHP error was sent to the browser.</strong>';
        }

        imagedestroy($this->im);
        restore_error_handler();
    }
	
    protected function validate()
    {
        if (!is_string($this->code) || strlen($this->code) == 0) {
            $code = $this->getCode(true);
        } else {
            $code = $this->code;
        }
        if (is_array($code)) {
            if (!empty($code)) {
                $code  = $code['code'];
            } else {
                $code = '';
            }
        }

        if ($this->case_sensitive == false && preg_match('/[A-Z]/', $code)) {
            $this->case_sensitive = true;
        }

        $code_entered = trim( (($this->case_sensitive) ? $this->code_entered
                                                       : strtolower($this->code_entered))
                        );
        $this->correct_code = false;

        if ($code != '') {
            if (strpos($code, ' ') !== false) {
                $code_entered = preg_replace('/\s+/', ' ', $code_entered);
                $code_entered = strtolower($code_entered);
            }

            if ((string)$code === (string)$code_entered) {
                $this->correct_code = true;
            }
        }
		if($code == '{*CODE_HAS_BEEN_EXPIRED*}')
		{
			$this->correct_code = false;
		}
    }
	
    protected function saveData()
    {
            if (sessionManager::issetSession('securimage_code_value') && is_scalar(sessionManager::getSession('securimage_code_value'))) {
				sessionManager::delSession('securimage_code_value');
				sessionManager::delSession('securimage_code_attempts');
            }
			sessionManager::setSession('securimage_code_value', $this->code);
			sessionManager::setSession('securimage_code_attempts', 1);
    }
	
    protected function isCodeExpired($attempts)
    {
        $expired = false;
        if (!is_numeric($attempts)) {
            $expired = true;
        } else if ($attempts >= Securimage::$maxAttemptsPerCaptcha) {
            $expired = true;
        }

        return $expired;
    }
    protected function canSendHeaders()
    {
        if (headers_sent()) {
            return false;
        } else if (strlen((string)ob_get_contents()) > 0) {
            return false;
        }

        return true;
    }

    
    function frand()
    {
        return 0.0001 * mt_rand(0,9999);
    }
    protected function initColor($color, $default)
    {
        if ($color == null) {
            return new Securimage_Color($default);
        } else if (is_string($color)) {
            try {
                return new Securimage_Color($color);
            } catch(Exception $e) {
                return new Securimage_Color($default);
            }
        } else if (is_array($color) && sizeof($color) == 3) {
            return new Securimage_Color($color[0], $color[1], $color[2]);
        } else {
            return new Securimage_Color($default);
        }
    }
    public function errorHandler($errno, $errstr, $errfile = '', $errline = 0, $errcontext = array())
    {
        $level = error_reporting();
		if ($level == 0 || ($level & $errno) == 0) {
            return true;
        }

        return false;
    }
}
class Securimage_Color
{
    public function __construct($color = '#ffffff')
    {
        $args = func_get_args();

        if (sizeof($args) == 0) {
            $this->r = 255;
            $this->g = 255;
            $this->b = 255;
        } else if (sizeof($args) == 1) {
            if (substr($color, 0, 1) == '#') {
                $color = substr($color, 1);
            }

            if (strlen($color) != 3 && strlen($color) != 6) {
                throw new InvalidArgumentException(
                  'Invalid HTML color code passed to Securimage_Color'
                );
            }

			if (strlen($color) == 3) {
            $red   = str_repeat(substr($color, 0, 1), 2);
            $green = str_repeat(substr($color, 1, 1), 2);
            $blue  = str_repeat(substr($color, 2, 1), 2);
			} else {
				$red   = substr($color, 0, 2);
				$green = substr($color, 2, 2);
				$blue  = substr($color, 4, 2);
			}

			$this->r = hexdec($red);
			$this->g = hexdec($green);
			$this->b = hexdec($blue);
        } else if (sizeof($args) == 3) {;
			if ($args[0] < 0)     $args[0]   = 0;
        if ($args[0] > 255)   $args[0]   = 255;
        if ($args[1] < 0)   $args[1] = 0;
        if ($args[1] > 255) $args[1] = 255;
        if ($args[2] < 0)    $args[2]  = 0;
        if ($args[2] > 255)  $args[2]  = 255;

        $this->r = $args[0];
        $this->g = $args[1];
        $this->b = $args[2];
        } else {
            throw new InvalidArgumentException(
              'Securimage_Color constructor expects 0, 1 or 3 arguments; ' . sizeof($args) . ' given'
            );
        }
    }
}

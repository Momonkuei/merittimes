<?php

class Load_other_file
{
	function __construct()
	{
		//$CI =& get_instance();
		//$this->ci = $CI;
		//$this->db = $CI->db;
		$this->db = Yii::app()->db;
		$this->session = Yii::app()->session;
	}

	public function getip() {
		$ip = '';
		if (getenv("HTTP_CLIENT_IP"))
			$ip = getenv("HTTP_CLIENT_IP");
		else if(getenv("HTTP_X_FORWARDED_FOR"))
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		else if(getenv("REMOTE_ADDR"))
			$ip = getenv("REMOTE_ADDR");
		else
			$ip = "";
		return $ip;
	} 

	// 2017-08-29
	public function getip2() {
		$ip = 'UNKNOWN';
		$list = array(
			'HTTP_CLIENT_IP',
			'HTTP_X_FORWARDED_FOR', // 2017-07-31 李哥 HAPROXY
			'HTTP_X_FORWARDED',
			'HTTP_X_CLUSTER_CLIENT_IP', // http://devco.re/blog/2014/06/19/client-ip-detection/
			'HTTP_FORWARDED_FOR',
			'HTTP_FORWARDED',
			'REMOTE_ADDR',
			'HTTP_VIA', // http://devco.re/blog/2014/06/19/client-ip-detection/
		);  

		foreach($list as $v){
			if(isset($_SERVER[$v])){
				$ip = $_SERVER[$v];
				break;
			}
		}   

		return $ip;
	}

	public function post($url, $postfield = array()){
		$postdata = http_build_query($postfield);

		$opts = array(
			'http' => array(
				'method'  => 'POST',
				'header'  => 'Content-type: application/x-www-form-urlencoded',
				'content' => $postdata
			)
		);

		$context = stream_context_create($opts);
		$content = file_get_contents($url, false, $context);
		if(is_array($content)){
			return false;
		} else {
			return $content;
		}
	}

	/*
	 * @string
	 * @is_cache
	 * @is_return string 1就是return結果，2就是執行它，其它就是直接echo content
	 */
	public function load($string = '', $is_cache = '', $is_return = '')
	{
		//$this->ci->benchmark->mark('custom_loadotherfile_head_start');
		// 如果最後是A，就代表，在HTTP的模式下，公司內部會直接讀取該檔案
		$is_direct = '';
		if($string != '' and substr($string, -1) == 'A'){
			$is_direct = '1';
			// 把A截掉
			$string = substr($string, 0, strlen($string)-1);
		}

		// 接下來，看一下它有沒有做cache
		if(substr($string, strlen($string)-4) == '___1'){
			$is_cache = '1';
			// 把cache截掉
			$string = substr($string, 0, strlen($string)-4);
		} elseif(substr($string, strlen($string)-8) == '___cache'){
			$is_cache = '1';
			// 把cache截掉
			$string = substr($string, 0, strlen($string)-8);
		}

		// 如果is_cache最後是A，就不理它(自從loadfile2有做切割分析網址後，這個判斷式就不需要了)
		//if(strlen($is_cache) > 1 and substr($string, -1) == 'A'){
		//	return;
		//}

		$clientip = $this->getip();

		//$this->ci->benchmark->mark('custom_loadotherfile_head_end');

		if($string != ''){
			$strings = explode('__', $string);
			$protocol = $strings[0];
			unset($strings[0]);

			// // 解析一下protocol的文字，看有沒有額外功能，例如中繼的功能
			// $protocols = explode('_', $protocol);
			// // zX
			// $protocol_external = '';
			// // z1_http__...
			// if(count($protocols) > 0 and preg_match('/^z(.*)$/', $protocols[0], $matches)){
			// 	$protocol = $protocols[1];
			// 	$protocol_external = 'z'.$matches[1];
			// }

			// 存放原本$string的文字
			// $string_old = $protocol.'__'.$string;

			$fullname_with_path = '';
			$content = '';

			$is_private = 0;
			if(preg_match('/^(192.168)/', $clientip)
				or $clientip == '122.117.7.209'
				or $clientip == '122.117.7.208' 
				or $clientip == '59.126.194.16' 
			){
				$is_private = 1;
			}

			// 如果公司又有增加對外切換的IP，可以從這裡看多少　
			if($protocol == 'ip'){
				if($is_return == '1'){
					return $clientip;
				} else {
					echo $clientip;
				} // end is_return
				die;
			} elseif($protocol == 'is_private'){
				if($is_return == '1'){
					return $is_private;
				} else {
					echo $is_private;
				} // end is_return
				die;
			} elseif($protocol == 'httpr'){
				$host = $strings[1];
				unset($strings[1]);

				$fullname = implode('/', $strings);

				// 取得副檔名
				$fullnames = explode('.', $fullname);
				$subname = $fullnames[count($fullnames) - 1];
				$subname = strtolower($subname);

				$fullname_with_path = 'http://'.$host.'/'.$fullname;

				/*
				 * 檢查是否為聖僑內部網址，如果是，那就讓使用者端直接連線抓檔案
				 */
				// 當直接連接的檢查，遇到了暫存，就直接失效
				if($is_direct == '1' and $is_cache == '1'){
					return;
				}
				if($is_direct == '1'){
					// 如果是內部網路，就回應路徑，讓本地端的使用者，能夠回應最快的速度
					if($is_private){
						return $fullname_with_path;
					} else {
						// 如果是外部網路
						// 回應短網址或是加密網址
					}
					return;
				}

				$filepath2 = FCPATH.customer_public_path.'load_file';
				if(!file_exists($filepath2)){
					mkdir($filepath2, 0777, true);
				}
				$file2 = $filepath2.ds('/').md5($fullname_with_path).'.'.$subname;

				if($is_cache == '1'){
					if(file_exists($file2)){
						$fullname_with_path = $file2;
					}
				}

				if($is_direct == '1') return;

			} elseif($protocol == 'http'){

				$host = $strings[1];
				unset($strings[1]);

				$fullname = implode('/', $strings);

				// 取得副檔名
				$fullnames = explode('.', $fullname);
				$subname = $fullnames[count($fullnames) - 1];
				$subname = strtolower($subname);

				$fullname_with_path = 'http://'.$host.'/'.$fullname;

				$filepath2 = FCPATH.customer_public_path.'load_file';

				if(!file_exists($filepath2)){
					mkdir($filepath2, 0777, true);
				}
				$file2 = $filepath2.ds('/').md5($fullname_with_path).'.'.$subname;

				if($is_cache == '1'){
					if(file_exists($file2)){
						if($is_direct == '1'){
							return '/'.$this->ci->session->userdata('load_file_path').'/'.md5($fullname_with_path).'.'.$subname;
						}
						$fullname_with_path = $file2;
					}
				} else {
					if($is_private == false and file_exists($file2) and $is_direct == '1'){
						// 如果是外部網路，而且不是cache的狀況
						// 回應短網址或是加密網址
						return '/'.$this->ci->session->userdata('load_file_path').'/'.md5($fullname_with_path).'.'.$subname;
					}
				}

				// 雖然支援直接連線，但是如果還跑到這裡，代表direct判斷失敗，所以還是得結束
				if($is_direct == '1') return;

				//$content = file_get_contents($fullname_with_path);
				//if($is_cache == ''){
				//	file_put_contents($file2, $content);
				//}
			} elseif($protocol == 'smbopen'){

				$host = $strings[1];
				unset($strings[1]);

				$fullname = implode('/', $strings);

				// 取得副檔名
				$fullnames = explode('.', $fullname);
				$subname = $fullnames[count($fullnames) - 1];
				$subname = strtolower($subname);

				$fullname_with_path = 'smb://'.$host.'/'.$fullname;
				//$fullname_with_path_try = 'smb://gisanfu:1234@'.$host.'/'.$fullname;
				//$this->load->library('M_smbwrapper');
				//echo file_get_contents('smb://192.168.8.2/download/abc.txt');

				// 先準備好另一個路徑
				$filepath2 = FCPATH.customer_public_path.'load_file';
				if(!file_exists($filepath2)){
					mkdir($filepath2, 0777, true);
				}
				$file2 = $filepath2.ds('/').md5($fullname_with_path).'.'.$subname;

				if($is_cache == '1'){
					if(file_exists($file2)){
						if($is_direct == '1'){
							return '/'.$this->ci->session->userdata('load_file_path').'/'.md5($fullname_with_path).'.'.$subname;
						}
						$fullname_with_path = $file2;
					}
				} else {
					if($is_private == false and file_exists($file2) and $is_direct == '1'){
						// 如果是外部網路，而且不是cache的狀況
						// 回應短網址或是加密網址
						return '/'.$this->ci->session->userdata('load_file_path').'/'.md5($fullname_with_path).'.'.$subname;
					}
				}

				if($is_direct == '1') return;

				require FCPATH.'../sys/libraries/M_smbwrapper.php';
				//$content = file_get_contents($fullname_with_path);
				//if($is_cache == ''){
				//	file_put_contents($file2, $content);
				//}
			} elseif($protocol == 'smb'){

				$host = $strings[1];
				unset($strings[1]);

				$user = $strings[2];
				unset($strings[2]);
				$user = str_replace('_AT_', '\\', $user);

				$pass = $strings[3];
				unset($strings[3]);

				$fullname = implode('/', $strings);

				// 取得副檔名
				$fullnames = explode('.', $fullname);
				$subname = $fullnames[count($fullnames) - 1];
				$subname = strtolower($subname);

				$fullname_with_path = 'smb://'.$user.':'.$pass.'@'.$host.'/'.$fullname;
				//echo $fullname_with_path;
				//$this->load->library('M_smbwrapper');
				//echo file_get_contents('smb://192.168.8.2/download/abc.txt');

				// 先準備好另一個路徑
				$filepath2 = FCPATH.customer_public_path.'load_file';
				if(!file_exists($filepath2)){
					mkdir($filepath2, 0777, true);
				}
				$file2 = $filepath2.ds('/').md5($fullname_with_path).'.'.$subname;

				if($is_cache == '1'){
					if(file_exists($file2)){
						if($is_direct == '1'){
							return '/'.$this->ci->session->userdata('load_file_path').'/'.md5($fullname_with_path).'.'.$subname;
						}
						$fullname_with_path = $file2;
					}
				} else {
					if($is_private == false and file_exists($file2) and $is_direct == '1'){
						// 如果是外部網路，而且不是cache的狀況
						// 回應短網址或是加密網址
						return '/'.$this->ci->session->userdata('load_file_path').'/'.md5($fullname_with_path).'.'.$subname;
					}
				}

				if($is_direct == '1') return;

				require FCPATH.'../sys/libraries/M_smbwrapper.php';
				//$fullname_with_path = 'smb://sj\gisanfu:1234@192.168.1.130/Front-end-Template_Css/siteDemo.css';
				//$content = file_get_contents($fullname_with_path);
				//if($is_cache == ''){
				//	file_put_contents($file2, $content);
				//}
			} elseif($protocol == 'smbg'){

				$this->ci->benchmark->mark('custom_loadotherfile_smbg_start');

				$host = $strings[1];
				unset($strings[1]);

				$user = 'sj\\gisanfu';
				$pass = '1234';

				$fullname = implode('/', $strings);

				// 取得副檔名
				$fullnames = explode('.', $fullname);
				$subname = $fullnames[count($fullnames) - 1];
				$subname = strtolower($subname);

				$fullname_with_path = 'smb://'.$user.':'.$pass.'@'.$host.'/'.$fullname;
				//echo $fullname_with_path;
				//$this->load->library('M_smbwrapper');
				//echo file_get_contents('smb://192.168.8.2/download/abc.txt');

				// 先準備好另一個路徑
				$filepath2 = FCPATH.customer_public_path.'load_file';
				if(!file_exists($filepath2)){
					mkdir($filepath2, 0777, true);
				}
				$file2 = $filepath2.ds('/').md5($fullname_with_path).'.'.$subname;

				if($is_cache == '1'){
					if(file_exists($file2)){
						if($is_direct == '1'){
							return '/'.$this->ci->session->userdata('load_file_path').'/'.md5($fullname_with_path).'.'.$subname;
						}
						$fullname_with_path = $file2;
					}
				} else {
					if($is_private == false and file_exists($file2) and $is_direct == '1'){
						// 如果是外部網路，而且不是cache的狀況
						// 回應短網址或是加密網址
						return '/'.$this->ci->session->userdata('load_file_path').'/'.md5($fullname_with_path).'.'.$subname;
					}
				}

				if($is_direct == '1') return;

				require FCPATH.'../sys/libraries/M_smbwrapper.php';

				$this->ci->benchmark->mark('custom_loadotherfile_smbg_end');
				//echo $this->ci->benchmark->elapsed_time('custom_loadotherfile_smbg_start', 'custom_loadotherfile_smbg_end');
				//echo $this->ci->benchmark->elapsed_time('custom_loadotherfile_head_start', 'custom_loadotherfile_head_end');

			// 這個是放在windows在使用的，而不是Linux
			// smb + userpass(me) + domain + windows
			} elseif($protocol == 'smbwg' or $protocol == 'smbwwg'){
				$host = $strings[1];
				unset($strings[1]);

				$user = 'sj\\gisanfu';
				$pass = '1234';

				$run = "net use \\\\$host $pass /user:$user";
				`$run`;

				$fullname = implode('\\', $strings);

				// 取得副檔名
				$fullnames = explode('.', $fullname);
				$subname = $fullnames[count($fullnames) - 1];
				$subname = strtolower($subname);

				$fullname_with_path = '\\\\'.$host.'\\'.$fullname;
				if($protocol == 'smbwwg'){
					$fullname_with_path2 = '\\\\'.$host.'\\'.$fullname;
				}

				// 先準備好另一個路徑
				$filepath2 = FCPATH.customer_public_path.'load_file';
				if(!file_exists($filepath2)){
					mkdir($filepath2, 0777, true);
				}
				$file2 = $filepath2.ds('/').md5($fullname_with_path).'.'.$subname;

				if($is_cache == '1'){
					if(file_exists($file2)){
						if($is_direct == '1'){
							return '/'.$this->ci->session->userdata('load_file_path').'/'.md5($fullname_with_path).'.'.$subname;
						}
						$fullname_with_path = $file2;
					}
				}

				if($is_direct == '1') return;

				// Window，可以直接用file_get_contents來讀\\xxx\a\a\a.txt的檔案，而不用透過smbwrapper
				if($protocol == 'smbwg'){
					require FCPATH.'../sys/libraries/M_smbwrapper.php';
				}
			} elseif($protocol == 'z1smbwg'){
				$host = $strings[1];
				unset($strings[1]);
				$fullname = implode('\\', $strings);

				// 取得副檔名
				$fullnames = explode('.', $fullname);
				$subname = $fullnames[count($fullnames) - 1];
				$subname = strtolower($subname);

				$fullname_with_path = '\\\\'.$host.'\\'.$fullname;

				// 先準備好另一個路徑
				$filepath2 = FCPATH.customer_public_path.'load_file';
				if(!file_exists($filepath2)){
					mkdir($filepath2, 0777, true);
				}
				$file2 = $filepath2.ds('/').md5($fullname_with_path).'.'.$subname;

				if($is_cache == '1'){
					if(file_exists($file2)){
						if($is_direct == '1'){
							return '/'.$this->ci->session->userdata('load_file_path').'/'.md5($fullname_with_path).'.'.$subname;
						}
						$fullname_with_path = $file2;
					}
				} else {
					$postfield = array(
						'string' => str_replace($protocol, 'smbwg', $string),
						'is_cache' => $is_cache,
						'is_return' => '1',
						//'is_return' => $is_return,
					);
					$content = $this->post('http://a1.cloud3.gisanfu.idv.tw/load_file/protocol_external', $postfield);
				}

				// 這個比較特別，等一下才結尾
				//if($is_direct == '1') return;
			} elseif($protocol == 'z1smbwgtw'){
				$host = $strings[1];
				unset($strings[1]);
				$fullname = implode('\\', $strings);

				// 取得副檔名
				$fullnames = explode('.', $fullname);
				$subname = $fullnames[count($fullnames) - 1];
				$subname = strtolower($subname);

				$fullname_with_path = '\\\\'.$host.'\\'.$fullname;
				//echo urldecode($fullname_with_path);

				// 先準備好另一個路徑
				$filepath2 = FCPATH.customer_public_path.'load_file';
				if(!file_exists($filepath2)){
					mkdir($filepath2, 0777, true);
				}
				$file2 = $filepath2.ds('/').md5($fullname_with_path).'.'.$subname;

				if($is_cache == '1'){
					if(file_exists($file2)){
						if($is_direct == '1'){
							return '/'.$this->ci->session->userdata('load_file_path').'/'.md5($fullname_with_path).'.'.$subname;
						}
						$fullname_with_path = $file2;
					}
				} else {
					$postfield = array(
						'string' => str_replace($protocol, 'smbwwg', urldecode($string)),
						//'string' => str_replace($protocol, 'smbwg', $string),
						'is_cache' => $is_cache,
						'is_return' => '1',
						//'is_return' => $is_return,
					);
					$content = $this->post('http://a1.cloud3.gisanfu.idv.tw/load_file/protocol_external', $postfield);
				}

				// 這個比較特別，等一下才結尾
				//if($is_direct == '1') return;
			}

			// 上面只是先準備好，這裡才開始去取content
			if($fullname_with_path != '' and $content == ''){
				$content = '';
				if(isset($fullname_with_path2) and $fullname_with_path2 != ''){
					$postfield = array(
						'uni' => $fullname_with_path2,
					);
					$content = $this->post('http://a1.cloud3.gisanfu.idv.tw/ggg.php', $postfield);
				} else {
					$this->ci->benchmark->mark('custom_loadotherfile_getcontent1_start');
					$content = @file_get_contents($fullname_with_path);
					$this->ci->benchmark->mark('custom_loadotherfile_getcontent1_end');
					//echo $this->ci->benchmark->elapsed_time('custom_loadotherfile_getcontent1_start', 'custom_loadotherfile_getcontent1_end');
				}
				//if(!preg_match('/^z(.*)$/', $protocol_external)){
				//	$content = @file_get_contents($fullname_with_path);
				//}

				// 專為http而寫的個案，當讀取失敗的時候，試著讀暫存看看
				//if($content == false and ($protocol == 'http' or $protocol == 'httpr') ){


				// 第一次試著讀暫存看看
				if($content == false){
					if(file_exists($file2)){
						$fullname_with_path = $file2;
						$content = @file_get_contents($fullname_with_path);
						//if($content == false){
						//	$content = '';
						//}
					}
				}
				// 第二次試著讀暫存看看(向下相容)
				if($content == false){
					if(file_exists($file2)){
						$fullname_with_path = str_replace('.'.$subname, '', $file2);
						$content = @file_get_contents($fullname_with_path);
						//if($content == false){
						//	$content = '';
						//}
					}
				}
				// 沒辦法的話...
				if($content == false){
					$content = '';
				}
				if($is_cache == ''){
					file_put_contents($file2, $content);
				}
			} elseif($fullname_with_path != '' and $content != ''){
				// 給z1smbwg所使用(應該這樣寫才對，未測試)
				if($is_cache == ''){
					file_put_contents($file2, $content);
					if($is_private == false and file_exists($file2) and $is_direct == '1'){
						// 如果是外部網路，而且不是cache的狀況
						// 回應短網址或是加密網址
						return '/'.$this->ci->session->userdata('load_file_path').'/'.md5($fullname_with_path).'.'.$subname;
					}
				}
				// z1smbwg的is_direct結尾
				if($is_direct == '1') return;
			}

			// 取得副檔名
			//$fullnames = explode('.', $fullname);
			//$subname = $fullnames[count($fullnames) - 1];
			//$subname = strtolower($subname);

			if($subname == 'css'){
				header('Content-Type: text/css');
			} elseif($subname == 'png'){
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
				header("Cache-Control: no-store, no-cache, must-revalidate"); 
				header("Cache-Control: post-check=0, pre-check=0", false);
				header("Pragma: no-cache");
				header('Content-type: image/png');
			}

			if($is_return == '1'){
				return $content;
			} elseif($is_return == '2'){
				echo `$content`;
			} else {
				//$this->ci->benchmark->mark('custom_loadotherfile_outputcontent_start');
				echo $content;
				//$this->ci->benchmark->mark('custom_loadotherfile_outputcontent_end');
				//echo $this->ci->benchmark->elapsed_time('custom_loadotherfile_outputcontent_start', 'custom_loadotherfile_outputcontent_end');
			} // end is_return

		} // end string if
	} // end load
} // end

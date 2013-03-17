<?php

class Router
{
	protected $routes;
	
	public function __construct($definitions)
	{
		$this->routes = $this->compileRoutes($definitions);
	}
	//ルーティング定義配列を変換する
	public function compileRoutes($definitions)
	{
		$routes = array();
		
		foreach ($definitions as $url => $params) {
			$tokens = explode('/', ltrim($url, '/'));
			foreach ($tokens as $i => $token) {
				if (0 === strpos($token,':')) {
					$name = substr($token,1);
					$token = '(?P<' . $name . '>[^/]+)';
				}
				
				$token[$i] = $token;
			}
			
			$pattern = '/' . implode('/',$token);
			$routes[$pattern] = $params;
		}
		
		return $routes;
	}
	//マッチングを行う
	public function resolve($path_info)
	{
		if ('/' !== substr($path_info,0,1)) {
			$path_info = '/' . $path_info;
		}
		
		foreach ($this->routes as $pattern => $params) {
			if (preg_match('#^' . $pattern . '#$' ,$path_info,$matches)) {
				$params = array_merge($params,$matches);
				
				return $params;
			}
		}
		
		return false;
	}

}
				
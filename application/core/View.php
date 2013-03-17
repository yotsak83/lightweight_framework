<?php

class View
{
	protected $base_dir;
	protected $defaults;
	protected $layout_variables = array();
	
	public function __construct($base_dir, $defaults = array())
	{
		$this->base_dir = $base_dir;
		$this->defaults = $defaults;
	}
	
	public function setLayoutVar($name, $value)
	{
		$this->layout_variables[$name] = $value;
	}
	
	public function render($_path, $_variables = array(), $_layout = false)
	{
		$_file = $base_dir . '/' . $_path . '.php';
		
		extract(array_merge($this->defaults, $_valiables));
		
		ob_start();
		ob_implicit_flush(0);
		
		require $file;
		
		$content = ob_get_clean();
		
		if ($_layout) {
			$content = $this->render($_layout,
			                         array_merge($this->layout_valiables,
									     array(
					                         '_content' => $content,
										     )
									     )
									 );
		}

		return $content;
    }
	
	public function excape($string)
	{
		return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
	}

}
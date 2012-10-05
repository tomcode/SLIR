<?php

/**
 * PNG to JPG conversion
 *
 * @author Thomas Traub
 */	
class ConvertPng2Jpg
{
	private $enabled = false;
	
	protected $required_configs = array
	(
		'path_parts' => 'is_array',
		'root_img_folder' => 'is_string',
		'path_to_root' => 'is_string'
	);

	protected $config = array();
	
	protected $original_path = '';
	
	public function __construct($configs = array())
	{
		$this->enabled = $this->set_configs($configs);
	}
	
	private function set_configs($configs)
	{
		$complete_counter = 0;
		
		foreach($this->required_configs as $config_item => $is_type)
		{
			if(isset($configs[$config_item]) && 
				! empty($configs[$config_item]) &&
				$is_type($configs[$config_item]))
			{
				$complete_counter++;

				$this->config[$config_item] = $configs[$config_item];
			}
		}
		
		return $complete_counter === count($this->required_configs);
	}
	
	public function convert2jpg($jpg_ext)
	{
		if( ! $this->enabled || ! $this->original_path)
		{
			return false;
		}
		
		$jpeg_path = $this->jpeg_path($jpg_ext);

		if(file_exists($jpeg_path))
		{
			return $jpeg_path;
		}
		
		$success = false;
		
		$img_rsc = @imagecreatefrompng($this->original_path);
	
		if($img_rsc)
		{
			$success = imagejpeg($img_rsc, $jpeg_path, 100);

			imagedestroy($img_rsc);
		}
		
		return $success;
	}
	
	protected function jpeg_path($jpg_ext)
	{
		$original_parts = pathinfo($this->original_path);
		
		return $original_parts['dirname']
				.'/'
				.$original_parts['filename'] .'.' .$jpg_ext;
	}
	
	public function original_exists($png_ext)
	{
		$original_path = '';

		if( ! $this->enabled)
		{
			return $original_path;
		}

		$path_parts = $this->config['path_parts'];
		$root_img_folder = $this->config['root_img_folder'];
		$path_to_root = $this->config['path_to_root'];

		$dir_names = explode('/', $path_parts['dirname']);

		$dir_name_index = array_flip($dir_names);
	
		if(isset($dir_name_index[$root_img_folder]))
		{
			$index = $dir_name_index[$root_img_folder];
			$original_parts = array_slice($dir_names, $index);

			$original_parts[] = $path_parts['filename'] .'.' .$png_ext;
			
			$original_path = $path_to_root 
							.'/'
							.implode('/', $original_parts);
			
			if( ! file_exists($original_path))
			{
				$original_path = '';
			}
		}
		
		$this->original_path = $original_path;

		return $original_path;
	}
}
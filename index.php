<?php
/**
 * Main file for SLIR (Smart Lencioni Image Resizer)
 *
 * This file is part of SLIR (Smart Lencioni Image Resizer).
 *
 * SLIR is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * SLIR is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with SLIR.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright Copyright © 2011, Joe Lencioni
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License version 3 (GPLv3)
 * @since 2.0
 * @package SLIR
 */

/**
 * PNG to JPG conversion hook
 *
 * @author Thomas Traub
 */
if(isset($_SERVER['REQUEST_URI']))
{
	$request_uri = trim($_SERVER['REQUEST_URI'], '/');

	$path_parts = pathinfo($request_uri);

	if(isset($path_parts['extension']))
	{
		$ext = $path_parts['extension'];

		if($ext === 'jpg')
		{
			require_once 'sem/ConvertPng2Jpg.php';

			$Converter = new ConvertPng2Jpg(array(
				'path_parts' => $path_parts,
				'root_img_folder' => 'files',
				'path_to_root' => realpath('../')
			));

			$original_exists = $Converter->original_exists('png');

			if($original_exists)
			{
				$success = $Converter->convert2jpg($ext);
			}
		}
	}
}

/**
 * Main file for SLIR (Smart Lencioni Image Resizer)
 *
 * This file is part of SLIR (Smart Lencioni Image Resizer).
 *
 * SLIR is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * SLIR is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with SLIR.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright Copyright © 2011, Joe Lencioni
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License version 3 (GPLv3)
 * @since 2.0
 * @package SLIR
 */

// define('SLIR_CONFIG_FILENAME', 'slir-config-alternate.php');

require_once 'core/slir.class.php';
$slir = new SLIR();
$slir->processRequestFromURL();
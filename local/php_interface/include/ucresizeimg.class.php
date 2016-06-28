<?php

/*------------------------------------------*
 |                                          |
 |    ucResizeImg class v2.0                |
 |    Made by unclechu, May 2011            |
 |    Contact E-Mail: lotsmanov-va@ya.ru    |
 |    Blog: unclechumind.blogspot.com       |
 |                                          |
 *------------------------------------------*/

class C_ucResizeImg {
	#set default parameters
	private $defParams = array(
		'INPUT_FILE' => '', #path to resizing file from site root

		/*	CLASSIC: is standard resize mode, sizes of returned image won't exceed your values (WIDTH and HEIGHT)
			STRONG: returned image will have strong sizes and superfluous area will cut out according to CONTENT_ZONE_X(Y) parameter */
		'RESIZE_MODE' => 'CLASSIC',

		/*	if RESIZE_MODE = STRONG you can change this parameter
			if set X is LEFT right area will cut off
			is set X is RIGHT left area will cut off
			if set Y is TOP bottom area will cut off
			if set Y is BOTTOM top area will cut off */
		'CONTENT_ZONE_X' => 'CENTER',
		'CONTENT_ZONE_Y' => 'CENTER',

		'KEEP_SIZE' => false, #if resized width or height less specified - residual area will filled by FILL_COLOR parameter

		'BITRIX_MODE' => false, #set this as true if you used bitrix and have many sites on one copy

		/*	if WIDTH and HEIGHT set zero you will get jpeg of your image without resizing
			if one of plane set zero this plane is unlimited size and resize check only another plane	*/
		'WIDTH' => 0,
		'HEIGHT' => 0,

		'QUALITY' => 85, #quality of returned jpeg file

		/*	set path from site root, there will be created folder _thumbs (if don't exists) for cache resized pictures
			if any folder is absent that this folder and all children folders will be created	*/
		'PATH_TO_SAVE' => '',

		'CACHE' => true, #if it is set false and if this file resized earlier before next resize - delete cached file

		/*	if set false folder _thumbs will not be created, files will save to folder that writed in PATH_TO_SAVE parameter
			if set string value will be created folder with this name	*/
		'CREATE_SUBFOLDER' => true,

		'FILE_PREFIX' => false, #you can set true for prefix: thumb_ or set string with prefix that you wish

		/*	if set true you will return array from GetResized function with structure:
			array(
				'OUTPUT_FILE' => (string)$PATH_TO_RESIZED_FILE,
				'WIDTH' => (int)$RESIZED_FILE_WIDTH,
				'HEIGHT' => (int)$RESIZED_FILE_HEIGHT,
				'FILE_SIZE' => (int)$BYTES_OF_RESIZED_FILE,
			)	*/
		'RETURN_COMPLEX' => false,

		'DEBUG' => false, #if error will create and return picture with error message, you can set value 'TEXT' for return string value

		#set color for background of output image
		'FILL_COLOR' => array(
			'R' => 255,
			'G' => 255,
			'B' => 255,
		),
	);
	private $errorFileName = 'ucresizeimg.class.error.jpg';

	#func to resize image and getting resized file path
	public function GetResized($params = array()) {
		$resizeParams = array();
		if (is_array($params)) {
			$resizeParams = array_merge($this->defParams, $params);
		} elseif (is_string($params)) {
			$resizeParams = array_merge($this->defParams, array('INPUT_FILE'=>$params));
		} else {
			return $this->ShowErrorMessage(array(
				'MESSAGE' => 'Undefined type of parameters for GetResized function.',
			));
		}

		if ($resizeParams['BITRIX_MODE']) {
			$rsSite = CSite::GetByID(SITE_ID);
			$arSite = $rsSite->Fetch();
			$rootPath = $arSite["ABS_DOC_ROOT"];
		} else {
			$rootPath = $_SERVER['DOCUMENT_ROOT'];
		}

		$inputFileRootPath = preg_replace('/(\/)+/', '/', $rootPath.'/'.$resizeParams['INPUT_FILE']);
		if (!is_file($inputFileRootPath)) {
			return $this->ShowErrorMessage(array(
				'DEBUG' => $resizeParams['DEBUG'],
				'BITRIX_MODE' => $resizeParams['BITRIX_MODE'],
				'MESSAGE' => 'Input file not exists: '.$inputFileRootPath,
			));
		}

		if (!empty($resizeParams['PATH_TO_SAVE'])) {
			$pathToSave = '/'.$resizeParams['PATH_TO_SAVE'];
			$pathToSave = preg_replace('/(\/)+/', '/', $pathToSave);
		} else {
			$pathToSave = '';
		}

		if ($resizeParams['FILE_PREFIX'] === true) {
			$filePrefix = 'thumb_';
		} elseif (is_string($resizeParams['FILE_PREFIX'])) {
			$filePrefix = $resizeParams['FILE_PREFIX'];
		} else {
			$filePrefix = '';
		}
		$resizedFileName = $filePrefix.md5($resizeParams['INPUT_FILE']).'.jpg';

		if ($resizeParams['CREATE_SUBFOLDER'] === true) {
			$subFolder = '_thumbs';
		} elseif (is_string($resizeParams['CREATE_SUBFOLDER'])) {
			$subFolder = $resizeParams['CREATE_SUBFOLDER'];
		} else {
			$subFolder = '';
		}
		$resizedFilePath = $pathToSave.'/'.$subFolder.'/'.$resizedFileName;
		$resizedFilePath = preg_replace('/(\/)+/', '/', $resizedFilePath);
		$resizedFileRootPath = $rootPath.$resizedFilePath;

		$pathToSaveArr = explode('/', $pathToSave);
		$currentFolder = $rootPath;
		for ($i=1; $i<count($pathToSaveArr); $i++) {
			if (!empty($pathToSaveArr[$i])) {
				$currentFolder .= '/'.$pathToSaveArr[$i];
				if (!is_dir($currentFolder) && !@mkdir($currentFolder, 0755)) {
					return $this->ShowErrorMessage(array(
						'DEBUG' => $resizeParams['DEBUG'],
						'BITRIX_MODE' => $resizeParams['BITRIX_MODE'],
						'MESSAGE' => 'Can\'t create this folder: '.$currentFolder,
					));
				}
			}
		}

		if (!empty($subFolder)) {
			$subFolderPath = $rootPath.$pathToSave.'/'.$subFolder;
			if (!is_dir($subFolderPath) && !@mkdir($subFolderPath, 0755)) {
				return $this->ShowErrorMessage(array(
					'DEBUG' => $resizeParams['DEBUG'],
					'BITRIX_MODE' => $resizeParams['BITRIX_MODE'],
					'MESSAGE' => 'Can\'t create this folder: '.$subFolderPath,
				));
			}
		}

		if ($resizeParams['CACHE'] == false) {
			if (is_file($resizedFileRootPath)) {
				if (!@unlink($resizedFileRootPath)) {
					return $this->ShowErrorMessage(array(
						'DEBUG' => $resizeParams['DEBUG'],
						'BITRIX_MODE' => $resizeParams['BITRIX_MODE'],
						'MESSAGE' => 'Can\'t delete this file: '.$resizedFileRootPath,
					));
				}
			}
		}

		if (!is_file($resizedFileRootPath)) {
			$inputFileArr = PathInfo($inputFileRootPath);
			if (!$inputFileSize = GetImageSize($inputFileRootPath)) {
				return $this->ShowErrorMessage(array(
					'DEBUG' => $resizeParams['DEBUG'],
					'BITRIX_MODE' => $resizeParams['BITRIX_MODE'],
					'MESSAGE' => 'Input file is not image or not supported image type: '.$inputFileRootPath,
					'FILE_PATH' => $resizedFilePath,
				));
			}
			$inputWidth = $inputFileSize[0];
			$inputHeight = $inputFileSize[1];

			$outputPosX = 0;
			$outputPosY = 0;

			if ($resizeParams['WIDTH'] < 1) {
				$outputWidth = $inputWidth;
			} else {
				$outputWidth = $resizeParams['WIDTH'];
			}
			if ($resizeParams['HEIGHT'] < 1) {
				$outputHeight = $inputHeight;
			} else {
				$outputHeight = $resizeParams['HEIGHT'];
			}

			$resizeMode = StrToUpper($resizeParams['RESIZE_MODE']);
			$contentZoneX = StrToUpper($resizeParams['CONTENT_ZONE_X']);
			$contentZoneY = StrToUpper($resizeParams['CONTENT_ZONE_Y']);
			switch ($resizeMode) {
			case 'STRONG':
				if ($outputWidth > $inputWidth || $outputHeight > $inputHeight) {
					if ($outputWidth > $inputWidth && $outputHeight > $inputHeight) {
						return $this->GetResized(array_merge(
							$resizeParams,
							array('RESIZE_MODE'=>'CLASSIC')
						));
					} else {
						if ($outputWidth > $inputWidth) {
							$newWidth = $inputWidth;
							$newHeight = $inputHeight * $newWidth / $inputWidth;
						} elseif ($outputHeight > $inputHeight) {
							$newHeight = $inputHeight;
							$newWidth = $inputWidth * $newHeight / $inputHeight;
						}

						if ($contentZoneX == 'LEFT') {
							$outputPosX = 0;
						} elseif ($contentZoneX == 'RIGHT') {
							$outputPosX = -($newWidth - $outputWidth);
						} else { #CENTER
							$outputPosX = -(($newWidth - $outputWidth) / 2);
						}

						if ($contentZoneY == 'TOP') {
							$outputPosY = 0;
						} elseif ($contentZoneY == 'BOTTOM') {
							$outputPosY = -($newHeight - $outputHeight);
						} else { #CENTER
							$outputPosY = -(($newHeight - $outputHeight) / 2);
						}
					}
				} else {
					$newWidth = $outputWidth;
					$newHeight = $inputHeight * $newWidth / $inputWidth;

					$outputPosX = 0;
					$outputPosY = -(($newHeight - $outputHeight) / 2);
					if ($contentZoneY == 'TOP') {
						$outputPosY = 0;
					} elseif ($contentZoneY == 'BOTTOM') {
						$outputPosY = -($newHeight - $outputHeight);
					}

					if ($outputWidth > $newWidth || $outputHeight > $newHeight) {
						$newHeight = $outputHeight;
						$newWidth = $inputWidth * $newHeight / $inputHeight;

						$outputPosX = -(($newWidth - $outputWidth) / 2);
						$outputPosY = 0;
						if ($contentZoneX == 'LEFT') {
							$outputPosX = 0;
						} elseif ($contentZoneX == 'RIGHT') {
							$outputPosX = -($newWidth - $outputWidth);
						}
					}
				}
				break;

			default: #CLASSIC mode
				if ($inputWidth > $outputWidth || $inputHeight > $outputHeight) {
					if ($inputWidth > $outputWidth && $inputHeight > $outputHeight) {
						$newWidth = $outputWidth;
						$newHeight = $inputHeight * $newWidth / $inputWidth;
						if ($newHeight > $outputHeight) {
							$newHeight = $outputHeight;
							$newWidth = $inputWidth * $newHeight / $inputHeight;
						}
					} elseif ($inputWidth > $outputWidth) {
						$newWidth = $outputWidth;
						$newHeight = $inputHeight * $newWidth / $inputWidth;
					} elseif ($inputHeight > $outputHeight) {
						$newHeight = $outputHeight;
						$newWidth = $inputWidth * $newHeight / $inputHeight;
					}
				} else {
					$newWidth = $inputWidth;
					$newHeight = $inputHeight;
				}

				if ($outputWidth > $newWidth || $outputHeight > $newHeight) {
					if ($resizeParams['KEEP_SIZE']) {
						if ($outputWidth > $newWidth) {
							if ($contentZoneX == 'LEFT') {
								$outputPosX = 0;
							} elseif ($contentZoneX == 'RIGHT') {
								$outputPosX = -($newWidth - $outputWidth);
							} else { #CENTER
								$outputPosX = -(($newWidth - $outputWidth) / 2);
							}
						}

						if ($outputHeight > $newHeight) {
							if ($contentZoneY == 'TOP') {
								$outputPosY = 0;
							} elseif ($contentZoneY == 'BOTTOM') {
								$outputPosY = -($newHeight - $outputHeight);
							} else { #CENTER
								$outputPosY = -(($newHeight - $outputHeight) / 2);
							}
						}
					} else {
						$outputWidth = $newWidth;
						$outputHeight = $newHeight;
					}
				}

			}

			$outputWidth = round($outputWidth);
			$outputHeight = round($outputHeight);
			$newWidth = round($newWidth);
			$newHeight = round($newHeight);
			$outputPosX = round($outputPosX);
			$outputPosY = round($outputPosY);

			$outputImage = ImageCreateTrueColor($outputWidth, $outputHeight);
			ImageFill($outputImage, 0, 0, ImageColorAllocate($outputImage,
				$resizeParams['FILL_COLOR']['R'], $resizeParams['FILL_COLOR']['G'], $resizeParams['FILL_COLOR']['B']));

			switch (StrToUpper($inputFileArr['extension'])) {
			case 'JPEG':
			case 'JPG':
				$inputImage = ImageCreateFromJPEG($inputFileRootPath);
				break;

			case 'PNG':
				$inputImage = ImageCreateFromPNG($inputFileRootPath);
				break;

			case 'GIF':
				$inputImage = ImageCreateFromGIF($inputFileRootPath);
				break;

			default:
				return $this->ShowErrorMessage(array(
					'DEBUG' => $resizeParams['DEBUG'],
					'BITRIX_MODE' => $resizeParams['BITRIX_MODE'],
					'MESSAGE' => 'Undefined mime-type of input file: '.$inputFileRootPath,
					'FILE_PATH' => $resizedFilePath,
				));
			}

			ImageCopyResampled($outputImage, $inputImage, $outputPosX, $outputPosY, 0, 0,
				$newWidth, $newHeight, $inputWidth, $inputHeight);
			ImageJPEG($outputImage, $resizedFileRootPath, $resizeParams['QUALITY']);
			ImageDestroy($inputImage);
			ImageDestroy($outputImage);

			if (!$resizeParams['DEBUG']) {
				$errorFilePath = $rootPath.'/'.$this->errorFileName;
				if (is_file($errorFilePath)) {
					@unlink($errorFilePath);
				}
			}
		}

		if ($resizeParams['RETURN_COMPLEX']) {
			$outData = GetImageSize($resizedFileRootPath);
			return array (
				'OUTPUT_FILE' => $resizedFilePath,
				'WIDTH' => $outData[0],
				'HEIGHT' => $outData[1],
				'FILE_SIZE' => filesize($resizedFileRootPath),
			);
		} else {
			return $resizedFilePath;
		}
	}

	#func to set default parameters for always new resizes
	public function SetDefParams($params = array()) {
		if (is_array($params)) {
			$this->defParams = array_merge($this->defParams, $params);
		} else {
			return $this->ShowErrorMessage(array(
				'MESSAGE' => 'Undefined type of parameters for SetDefParams function.',
			));
		}
		return $this->defParams;
	}

	#func to get array of default parameters
	public function GetDefParams() {
		return $this->defParams;
	}

	#func to create image with error message
	private function ShowErrorMessage($params = array()) {
		if (!isset($params['DEBUG'])) {
			$params['DEBUG'] = $this->defParams['DEBUG'];
		}
		if ($params['DEBUG'] === 'TEXT') {
			return 'Error: '.$params['MESSAGE'];
		} elseif (!$params['DEBUG']) {
			return 'error';
		}

		if (!isset($params['BITRIX_MODE'])) {
			$params['BITRIX_MODE'] = $this->defParams['BITRIX_MODE'];
		}
		if ($params['BITRIX_MODE']) {
			$rsSite = CSite::GetByID(SITE_ID);
			$arSite = $rsSite->Fetch();
			$rootPath = $arSite["ABS_DOC_ROOT"];
		} else {
			$rootPath = $_SERVER['DOCUMENT_ROOT'];
		}

		if (!isset($params['FILE_PATH']) || empty($params['FILE_PATH'])) {
			$return_val = '/'.$this->errorFileName;
			$params['FILE_PATH'] = $rootPath.'/'.$this->errorFileName;
		} else {
			$return_val = $params['FILE_PATH'];
			$params['FILE_PATH'] = $rootPath.'/'.$params['FILE_PATH'];
		}
		$params['FILE_PATH'] = preg_replace('/(\/)+/', '/', $params['FILE_PATH']);

		$x = (StrLen('Error: ') + StrLen($params['MESSAGE'])) * 10;
		$y = 16;
		$image = ImageCreateTrueColor($x, $y);
		ImageFill($image, 0, 0, ImageColorAllocate($image, 255, 255, 255));
		ImageString($image, 5, 0, 0, 'Error: ', ImageColorAllocate($image, 255, 0, 0));
		ImageString($image, 4, 70, 0, $params['MESSAGE'], ImageColorAllocate($image, 0, 0, 0));
		ImageJPEG($image, $params['FILE_PATH'], 50);
		ImageDestroy($image);
		return $return_val;
	}
}

#default example of class, you can create more examples of class, sample: $RI = new C_ucResizeImg;
$ucResizeImg = new C_ucResizeImg;

?>
<?php
namespace schoolmanage\widgets\xupload\actions;
use Exception;
use stdClass;
use Yii;
use yii\base\Action;
use yii\log\Logger;
use yii\web\HttpException;
use yii\web\UploadedFile;

/**
 * XUploadAction
 * =============
 * Basic upload functionality for an action used by the xupload extension.
 *
 * XUploadAction is used together with XUpload and XUploadForm to provide file upload funcionality to any application
 *
 * You must configure properties of XUploadAction to customize the folders of the uploaded files.
 *
 * Using XUploadAction involves the following steps:
 *
 * 1. Override CController::actions() and register an action of class XUploadAction with ID 'upload', and configure its
 * properties:
 * ~~~
 * [php]
 * class MyController extends CController
 * {
 *     public function actions()
 *     {
 *         return array(
 *             'upload'=>array(
 *                 'class'=>'xupload.actions.XUploadAction',
 *                 'path' =>Yii::app() -> getBasePath() . "/../uploads",
 *                 'publicPath' => Yii::app() -> getBaseUrl() . "/uploads",
 *                 'subfolderVar' => "parent_id",
 *             ),
 *         );
 *     }
 * }
 *
 * 2. In the form model, declare an attribute to store the uploaded file data, and declare the attribute to be validated
 * by the 'file' validator.
 * 3. In the controller view, insert a XUpload widget.
 *
 * ###Resources
 * - [xupload](http://www.yiiframework.com/extension/xupload)
 *
 * @version 0.3
 * @author Asgaroth (http://www.yiiframework.com/user/1883/)
 */
class XUploadAction extends Action
{
	// PHP File Upload error message codes:
	// http://php.net/manual/en/features.file-upload.errors.php
	protected $error_messages = array(
		1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
		2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
		3 => 'The uploaded file was only partially uploaded',
		4 => 'No file was uploaded',
		6 => 'Missing a temporary folder',
		7 => 'Failed to write file to disk',
		8 => 'A PHP extension stopped the file upload',
		'post_max_size' => '上传文件超过服务器限制',
		'max_file_size' => '文件太大',
		'min_file_size' => '文件太小',
		'accept_file_types' => '文件类型不允许',
		'max_number_of_files' => 'Maximum number of files exceeded',
		'max_width' => 'Image exceeds maximum width',
		'min_width' => 'Image requires a minimum width',
		'max_height' => 'Image exceeds maximum height',
		'min_height' => 'Image requires a minimum height',
		'abort' => 'File upload aborted',
		'image_resize' => 'Failed to resize image'
	);
	/**
	 * XUploadForm (or subclass of it) to be used.  Defaults to XUploadForm
	 * @see XUploadAction::init()
	 * @var string
	 * @since 0.5
	 */
	public $formClass = 'schoolmanage\widgets\xupload\models\XUploadForm';

	/**
	 * Name of the model attribute referring to the uploaded file.
	 * Defaults to 'file', the default value in XUploadForm
	 * @var string
	 * @since 0.5
	 */
	public $fileAttribute = 'file';

	/**
	 * Name of the model attribute used to store mimeType information.
	 * Defaults to 'mime_type', the default value in XUploadForm
	 * @var string
	 * @since 0.5
	 */
	public $mimeTypeAttribute = 'mime_type';

	/**
	 * Name of the model attribute used to store file size.
	 * Defaults to 'size', the default value in XUploadForm
	 * @var string
	 * @since 0.5
	 */
	public $sizeAttribute = 'size';

	/**
	 * Name of the model attribute used to store the file's display name.
	 * Defaults to 'name', the default value in XUploadForm
	 * @var string
	 * @since 0.5
	 */
	public $displayNameAttribute = 'name';

	/**
	 * Name of the model attribute used to store the file filesystem name.
	 * Defaults to 'filename', the default value in XUploadForm
	 * @var string
	 * @since 0.5
	 */
	public $fileNameAttribute = 'filename';

	/**
	 * The query string variable name where the subfolder name will be taken from.
	 * If false, no subfolder will be used.
	 * Defaults to null meaning the subfolder to be used will be the result of date("mdY").
	 *
	 * @see XUploadAction::init().
	 * @var string
	 * @since 0.2
	 */
	public $subfolderVar;

	/**
	 * Path of the main uploading folder.
	 * @see XUploadAction::init()
	 * @var string
	 * @since 0.1
	 */
	public $path;

	/**
	 * Public path of the main uploading folder.
	 * @see XUploadAction::init()
	 * @var string
	 * @since 0.1
	 */
	public $publicPath;

	/**
	 * @var boolean dictates whether to use sha1 to hash the file names
	 * along with time and the user id to make it much harder for malicious users
	 * to attempt to delete another user's file
	 */
	public $secureFileNames = false;

	/**
	 * Name of the state variable the file array is stored in
	 * @see XUploadAction::init()
	 * @var string
	 * @since 0.5
	 */
	public $stateVariable = 'xuploadFiles';

	/**
	 * 图片宽度
	 * @var
	 */
	public $width;

	/**
	 * 图片高度
	 * @var
	 */
	public $height;

	/**
	 * The resolved subfolder to upload the file to
	 * @var string
	 * @since 0.2
	 */
	private $_subfolder = "";

	/**
	 * The form model we'll be saving our files to
	 * @var Model (or subclass)
	 * @since 0.5
	 */
	private $_formModel;

	//校验操作
	public $options = array();

	//文件联结字符

	public $endStr='';

	/**
	 * Initialize the propeties of pthis action, if they are not set.
	 *
	 * @since 0.1
	 */
	public function init()
	{

		if (!isset($this->path)) {
			$this->path = realpath(Yii::$app->getBasePath() . "/../uploads");
		}

		if (!is_dir($this->path)) {
			mkdir($this->path, 0777, true);
			chmod($this->path, 0777);
		} else if (!is_writable($this->path)) {
			chmod($this->path, 0777);
		}
		if ($this->subfolderVar === null) {
			$this->_subfolder = Yii::$app->request->getQueryParam($this->subfolderVar, date("mdY"));
		} else if ($this->subfolderVar !== false) {
			$this->_subfolder = date("mdY");
		}

		if (!isset($this->_formModel)) {
			$this->formModel = \Yii::createObject(['class'=>$this->formClass]);
		}

		if ($this->secureFileNames) {
			$this->formModel->secureFileNames = true;
		}
	}

	/**
	 * The main action that handles the file upload request.
	 * @since 0.1
	 * @author Asgaroth
	 */
	public function run()
	{
		$this->sendHeaders();

		$this->handleDeleting() or $this->handleUploading();
	}

	protected function sendHeaders()
	{
		header('Vary: Accept');
		if (isset($_SERVER['HTTP_ACCEPT']) && (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
			header('Content-type: application/json');
		} else {
			header('Content-type: text/plain');
		}
	}

	/**
	 * Removes temporary file from its directory and from the session
	 *
	 * @return bool Whether deleting was meant by request
	 */
	protected function handleDeleting()
	{
		if (isset($_GET["_method"]) && $_GET["_method"] == "delete") {
			$success = false;
			if ($_GET["file"][0] !== '.' && Yii::$app->user->hasState($this->stateVariable)) {
				// pull our userFiles array out of state and only allow them to delete
				// files from within that array
				$userFiles = Yii::$app->session->get($this->stateVariable, array());

				if ($this->fileExists($userFiles[$_GET["file"]])) {
					$success = $this->deleteFile($userFiles[$_GET["file"]]);
					if ($success) {
						unset($userFiles[$_GET["file"]]); // remove it from our session and save that info
						Yii::$app->user->setState($this->stateVariable, $userFiles);
					}
				}
			}
			echo json_encode($success);
			return true;
		}
		return false;
	}


	/**
	 *  校验
	 * @param $model
	 * @param $file
	 * @param $error
	 * @return bool
	 */
	protected function validate($model, $file, $error)
	{

//        $model->{$this->mimeTypeAttribute} = $model->{$this->fileAttribute}->getType();
//        $model->{$this->sizeAttribute} = $model->{$this->fileAttribute}->getSize();
//        $model->{$this->displayNameAttribute} = $model->{$this->fileAttribute}->getName();
//        $model->{$this->fileNameAttribute} = $model->{$this->displayNameAttribute};

		//todo 补允其他条件
		$file_size = $model->{$this->sizeAttribute};
//        if ($error) {
//            $file->error = $this->get_error_message($error);
//            return false;
//        }
//        $content_length = $this->fix_integer_overflow(intval(
//            $this->get_server_var('CONTENT_LENGTH')
//        ));
//        $post_max_size = $this->get_config_bytes(ini_get('post_max_size'));
//        if ($post_max_size && ($content_length > $post_max_size)) {
//            $file->error = $this->get_error_message('post_max_size');
//            return false;
//        }
		if (isset($this->options['accept_file_types']) && !preg_match($this->options['accept_file_types'], $model->{$this->displayNameAttribute})) {
			$file->error = $this->get_error_message('accept_file_types');
			return false;
		}

		if (isset($this->options['max_file_size']) && (
				$file_size > $this->options['max_file_size'])
		) {
			$file->error = $this->get_error_message('max_file_size');
			return false;
		}

		if (isset($this->options['min_file_size']) &&
			$file_size < $this->options['min_file_size']
		) {
			$file->error = $this->get_error_message('min_file_size');
			return false;
		}
		return true;
	}

	protected function get_error_message($error)
	{
		return array_key_exists($error, $this->error_messages) ?
			$this->error_messages[$error] : $error;
	}

	/**
	 * Uploads file to temporary directory
	 *
	 * @throws HttpException
	 */
	protected function handleUploading()
	{
		$file = new stdClass();
		$this->init();
		$model = $this->_formModel;
		$model->{$this->fileAttribute} = UploadedFile::getInstance($model, $this->fileAttribute);
		if ($model->{$this->fileAttribute} !== null) {
			$model->{$this->mimeTypeAttribute} = $model->{$this->fileAttribute}->type;
			$model->{$this->sizeAttribute} = $model->{$this->fileAttribute}->size;
			$model->{$this->displayNameAttribute} = $model->{$this->fileAttribute}->name;
			$model->{$this->fileNameAttribute} = $model->{$this->displayNameAttribute};

			if (!$this->validate($model, $file, "")) {
				echo json_encode(array($file));
				exit;
			}


			//    var_dump(time(). $model->{$this->mimeTypeAttribute});
            list($usec) = explode(" ", microtime());
            $randNum = $usec * 1000000;
			$model->{$this->fileNameAttribute} = date("YymdHis") . substr($randNum, 0, 4).$this->endStr . "." . $model->{$this->fileAttribute}->getExtension();


			if ($model->validate()) {

				$path = $this->getPath();

				if (!is_dir($path)) {
					mkdir($path, 0777, true);
					chmod($path, 0777);
				}

				$model->{$this->fileAttribute}->saveAs($path . $model->{$this->fileNameAttribute});
				chmod($path . $model->{$this->fileNameAttribute}, 0777);


				//图片缩放
				if (isset($this->width) || isset($this->height)) {
					$image = \Gregwar\Image\Image::open($path . $model->{$this->fileNameAttribute});
					$image->cropResize($this->width, $this->height)->save($path . $model->{$this->fileNameAttribute});

				}


				$returnValue = $this->beforeReturn();
				if ($returnValue === true) {
					$file->name = $model->{$this->displayNameAttribute};
					$file->type = $model->{$this->mimeTypeAttribute};
					$file->size = $model->{$this->sizeAttribute};
					$file->url = $this->getFileUrl($model->{$this->fileNameAttribute});
					$file->thumbnail_url = $model->getThumbnailUrl($this->getPublicPath());
					$file->delete_url = \Yii::$app->getUrlManager()->createUrl($this->getUniqueId(), array(
						"_method" => "delete",
						"file" => $model->{$this->fileNameAttribute},
					));
					$file->delete_type = "POST";

					try {
						$image = \Gregwar\Image\Image::open($path . $model->{$this->fileNameAttribute});
						$file->width = $image->width();
						$file->height = $image->height();


					} catch (Exception $e) {

					}


					echo json_encode(array($file));

				} else {
					$file->error = $returnValue;
					echo json_encode(array($file));
					\Yii::trace("XUploadAction: " . $returnValue, Logger::LEVEL_ERROR);
				}
			} else {
				$file->error = $model->getErrors($this->fileAttribute);
				echo json_encode(array($file));
				\Yii::trace("XUploadAction: " .  \yii\helpers\VarDumper::dumpAsString($model->getErrors()), Logger::LEVEL_ERROR);
			}
		} else {
			throw new HttpException(500, "Could not upload file");
		}
	}

	/**
	 * We store info in session to make sure we only delete files we intended to
	 * Other code can override this though to do other things with state, thumbnail generation, etc.
	 * @since 0.5
	 * @author acorncom
	 * @return boolean|string Returns a boolean unless there is an error, in which case it returns the error message
	 */
	protected function beforeReturn()
	{
		$path = $this->getPath();

		// Now we need to save our file info to the user's session
		$userFiles = Yii::$app->session->get($this->stateVariable, array());

		$userFiles[$this->formModel->{$this->fileNameAttribute}] = array(
			"path" => $path . $this->formModel->{$this->fileNameAttribute},
			//the same file or a thumb version that you generated
			"thumb" => $path . $this->formModel->{$this->fileNameAttribute},
			"filename" => $this->formModel->{$this->fileNameAttribute},
			'size' => $this->formModel->{$this->sizeAttribute},
			'mime' => $this->formModel->{$this->mimeTypeAttribute},
			'name' => $this->formModel->{$this->displayNameAttribute},
		);


		return true;
	}

	/**
	 * Returns the file URL for our file
	 * @param $fileName
	 * @return string
	 */
	protected function getFileUrl($fileName)
	{
		return $this->getPublicPath() . $fileName;
	}

	/**
	 * Returns the file's path on the filesystem
	 * @return string
	 */
	protected function getPath()
	{
		$path = ($this->_subfolder != "") ? "{$this->path}/{$this->_subfolder}/" : "{$this->path}/";
		return $path;
	}

	/**
	 * Returns the file's relative URL path
	 * @return string
	 */
	protected function getPublicPath()
	{
		return ($this->_subfolder != "") ? "{$this->publicPath}/{$this->_subfolder}/" : "{$this->publicPath}/";
	}

	/**
	 * Deletes our file.
	 * @param $file
	 * @since 0.5
	 * @return bool
	 */
	protected function deleteFile($file)
	{
		return unlink($file['path']);
	}

	/**
	 * Our form model setter.  Allows us to pass in a instantiated form model with options set
	 * @param $model
	 */
	public function setFormModel($model)
	{
		$this->_formModel = $model;
	}

	public function getFormModel()
	{
		return $this->_formModel;
	}

	/**
	 * Allows file existence checking prior to deleting
	 * @param $file
	 * @return bool
	 */
	protected function fileExists($file)
	{
		return is_file($file['path']);
	}
}

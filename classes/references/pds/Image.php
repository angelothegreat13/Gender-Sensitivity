<?php 

namespace App\Models\Pds;

use Core\Model;
use Supports\Config;

class Image extends Model
{   
    private $_file;

    public function __construct()
    {
        parent::__construct(Config::get('mysql/workforcedb'));
    }

    public function upload($appno,$img_file,$location,$column)
    {   
        $file = $img_file;
        $fileName = $img_file['name'];
        $fileTmpName = $img_file['tmp_name'];
        $fileSize = $img_file['size'];
        $fileError = $img_file['error'];
        $fileType = $img_file['type'];
        $fileExt = explode('.',$fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg','jpeg','png','gif');

        if (in_array($fileActualExt,$allowed)) 
        {
            if ($fileError === 0) {
                if ($fileSize < 5000000) {
                    $fileNameNew = $appno.md5(microtime()).".".$fileActualExt;
                    $fileDestination = DR.'/miaa/assets/images/pds/'.$location.'/'.$fileNameNew;
                    move_uploaded_file($fileTmpName,$fileDestination);
                    $img_path = '/miaa/assets/images/pds/'.$location.'/'.$fileNameNew;
                    
                    $this -> deleteFormerImage($column,$location,$appno);
                    $this -> saveChanges($appno,$column,$img_path);
                }
                else {
                    $_SESSION['error'] = "Your file is too big";
                }
            }
            else {
                $_SESSION['error'] = "There was an error uploading your file!";
            }
        }
        else {
            $_SESSION['error'] = "You cannot upload files of this Type";
        }
    }

    public function deleteFormerImage($column,$location,$appno)
    {
        $formerImg = $this -> getImage($column,$appno);
        if ($formerImg != '') {
            $this -> unload($location,$formerImg);
        } 
    }

    public function getImage($column,$appno)
    {
        $sql = "SELECT {$column} FROM tpdsmaininfo WHERE appno = ?";
        return $this -> _db -> query($sql,[$appno]) -> first() -> $column;   
    }

    public function unload($location,$image)
    {
        unlink(DR.'/miaa/assets/images/pds/'.$location.'/'.imgURL($image));
    }

    public function download($app_number,$img,$location)
    {   
        $upload_dir = DR.'/miaa/assets/images/pds/'.$location.'/';
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $this -> _file = $file = $upload_dir.$app_number.md5(microtime()).'.png';
        $success = file_put_contents($file, $data);
    }

    public function file()
    {
        return $this -> _file;
    }

    public function saveChanges($appno,$column,$img_path)
    {
        $this -> _db -> update('tpdsmaininfo',$appno,[$column => $img_path],'appno');
    }

}



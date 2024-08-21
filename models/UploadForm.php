<?php

namespace app\models;

use yii\base\Model;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'txt'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return $this->afterUpload('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
        } else {
            return false;
        }
    }

    public function afterUpload($path)
    {
        $h = fopen(\Yii::getAlias($path), 'r');
        $fileLinesArr = [];
        while (($buffer = fgets($h)) !== false) {
            $countDigits = mb_strlen(preg_replace('/[^0-9]/', '', $buffer));
            $fileLinesArr[] = "$buffer=$countDigits";
        }
        if (!feof($h)) {
            return false;
        }
        fclose($h);

        return $fileLinesArr;
    }
}
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\classes;

/**
 * Description of KNFileUpload
 *
 * @author chanpan
 */
class KNFileUpload{
    /**
     * 
     * @param type $form | ตัวอย่าง $form
     * @param type $model | $model
     * @param type $field | string ตัวอย่าง 'photo'
     * @param type $modelField | ตัวอย่าง $model->bill_upload 
     * @param type $modelFileName $model['bill_upload'] หรือ $model->bill_upload
     * @return render file upload kartik
     */
    public static function renderFileUploadSignle($form, $model, $field, $modelField){
        //$storageUrl = isset(\Yii::$app->params['storageUrl']) ? \Yii::$app->params['storageUrl'] : '';
        $storageUrl = \Yii::getAlias('@storageUrl');
        $html = '';
        
        $path = '/uploads/';
        $pluginOptions = [];
        if ($modelField != '') { //$model->bill_upload
            $pluginOptions = [
                'showUpload'=> false,
                'showRemove'=> false,
                'actionUpload'=> false,
                'btnUpload' => false,
                'showPreview' => false,
                'showCaption' => false,
                'previewFileIconSettings'=>[],
                'preferIconicPreview'=>false,
                'allowedFileExtensions'=> ['jpg', 'png', 'gif'],
                'initialPreview' => [
                    "{$storageUrl}/{$path}/{$modelField}" //$model['bill_upload']
                ],
                'initialPreviewAsData' => true,
            ];
        }
        $html .= "<div>";
        $src = "{$storageUrl}/{$path}/{$modelField}";
        $defaultImage = \yii\helpers\Url::to('@web/img/default_profile.png');
        if($modelField == ''){
            $src = $defaultImage;
        }
        $html .= \yii\helpers\Html::img($src,['class'=>'img img-responsive img-rounded img-preview','style'=>'width:150px;']);
            $html .= "<div class='hidden'>";
                $html .= $form->field($model, $field)
                        ->fileInput(['class'=>'img-uploads','extensions' => 'jpg, png', 'mimeTypes' => 'image/jpeg, image/png']);
            $html .= "</div>";
            $html .= "<div>";
                if($modelField != ''){
                    $html .= "<i class='fa fa-trash btn-delete' style='color:#afafaf;cursor:pointer;margin-top: 5px;font-size:14pt;'></i>";
                    $html .= " ";
                }
                $html .= "<i class='fa fa-picture-o btn-uploads' style='color:#afafaf;cursor:pointer;margin-top: 5px;font-size:14pt;'></i>";
            $html .= "</div>";
        $html .= "</div>";
        $html .= "
            <script>
                $('.img-preview').css({'cursor':'pointer'});
                $('.btn-uploads , .img-preview').on('click',function(){
                    $('.img-uploads').trigger( 'click');
                    return false;
                });
                $('.btn-delete').on('click',function(){
                    $('.img-preview').attr('src','{$defaultImage}');
                    return false;
                });
                $('.img-uploads').on('change',function(){
                    readURL(this);
                });
                 function readURL(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function (e) {
                            $('.img-preview').attr('src', e.target.result);
                        }

                        reader.readAsDataURL(input.files[0]);
                    }
                }
            </script>
        ";
        return $html;
    }
    
    /**
     * 
     * @param type $model | ตัวอย่าง $model
     * @param type $field | ตัวอย่าง 'photo'
     * @return type
     */
    public static function upload($model, $field){
        $file = \yii\web\UploadedFile::getInstance($model, $field);
        
        if ($file) {
            $real_file_name = \appxq\sdii\utils\SDUtility::getMillisecTime();
            $folder = "/web/uploads/";
            $path = \Yii::getAlias('@storage') . "{$folder}";
            
            @unlink("{$path}/$model[$field]");
            //\appxq\sdii\utils\VarDumper::dump("{$path}/$model[$field]");
            $type = $file->extension;
            $filePath = "{$path}/{$real_file_name}.{$type}";
            if ($file->saveAs("{$filePath}")) {
                return ['success'=>TRUE, 'msg'=>"{$real_file_name}.{$type}", "path"=>$path];
            }else{
                return ['success'=>FALSE, 'msg'=>'ไม่สามารถอัปโหลดไฟล์ได้'];
            }
        }
    }
    
    //put your code here
}

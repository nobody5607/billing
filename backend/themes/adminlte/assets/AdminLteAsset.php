<?php
namespace backend\themes\adminlte\assets;

use yii\base\Exception;
use yii\web\AssetBundle as BaseAdminLteAsset;

/**
 * AdminLte AssetBundle
 * @since 0.1
 */
class AdminLteAsset extends BaseAdminLteAsset
{
    public $sourcePath = '@backend/themes/adminlte/assets';
    public $css = [
        'css/AdminLTE.min.css',
        'css/style.css'
    ];
    public $js = [
        'js/adminlte.min.js',
        'https://cdn.jsdelivr.net/npm/vue/dist/vue.js',
        'https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.1/axios.js',
        'https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.11.10/xlsx.core.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/blob-polyfill/1.0.20150320/Blob.js',
        'https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.3/FileSaver.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/TableExport/4.0.11/js/tableexport.min.js',
        'https://cdn.jsdelivr.net/npm/chart.js@2.8.0'
    ];
    public $depends = [
        'rmrevin\yii\fontawesome\AssetBundle',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

    /**
     * @var string|bool Choose skin color, eg. `'skin-blue'` or set `false` to disable skin loading
     * @see https://almsaeedstudio.com/themes/AdminLTE/documentation/index.html#layout
     */
    public $skin = '_all-skins';

    /**
     * @inheritdoc
     */
    public function init()
    {
        // Append skin color file if specified
        if ($this->skin) {
            if (('_all-skins' !== $this->skin) && (strpos($this->skin, 'skin-') !== 0)) {
                throw new Exception('Invalid skin specified');
            }

            $this->css[] = sprintf('css/skins/%s.min.css', $this->skin);
        }

        parent::init();
    }
}

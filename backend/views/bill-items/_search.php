<div class="row">
    <div class="col-md-3">
        <?php
        $addon = <<< HTML
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar-alt"></i>
                                        </span>
                                    </div>
HTML;
        echo '<label class="control-label">วันที่</label>';
        echo '<div class="input-group drp-container">';
        echo \kartik\daterange\DateRangePicker::widget([
                'name' => 'date_range_1',
                'value' => date('Y-m-d') . ' ' . date('Y-m-d'),//'01-Jan-14 to 20-Feb-14',
                'convertFormat' => true,
                'useWithAddon' => true,
                'pluginOptions' => [
                    'locale' => [
                        'format' => 'd-m-Y',//d-M-y
                        'separator' => ' ',
                    ],
                    'opens' => 'left'
                ]
            ]) . $addon;
        echo '</div>';

        ?>
    </div>
</div>
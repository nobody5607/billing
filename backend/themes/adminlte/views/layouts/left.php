<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <div class="slimScrollDiv" >
        <section class="sidebar" >
            <!-- Sidebar user panel -->
            <?php if(!Yii::$app->user->isGuest):?>
            <?php
                $storageUrl = isset(Yii::$app->params['storageUrl'])?Yii::$app->params['storageUrl']:'';
                $login = "{$storageUrl}/images/logo.png";
            ?>
                <div class="user-panel">
                    <div class="pull-left image">
                      <img src="<?= "{$login}";?>" class="img img-responsive" alt="Logo">
                    </div>

                </div>
            <?php endif; ?>
            
            <!-- search form -->

                <div class="input-group">

                </div>

            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            
            <?= dmstr\widgets\Menu::widget(
                    \backend\components\AppComponent::navbarLeft()

                ) ?>
            
        </section>
        <div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 90.1955px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
    <!-- /.sidebar -->
</aside>
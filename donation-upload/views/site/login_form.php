<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
?>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="row" style="margin:20px 0;">
                    <center>
                    <img src="<?php echo Url::to('@web/'); ?>static/images/logo.png" style="margin-top:120px" />
                    </center>
                </div>
                <div class="clearfix"></div>
                <div class="row">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Please Sign In</h3>
                        </div>

                        <div class="panel-body">
                            <form role="form" method="post" action="<?php echo Url::to('@web/site/login')?>">
                                <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="E-mail" name="LoginForm[username]" type="text" autofocus="" >
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Password" name="LoginForm[password]" type="password" value="" required>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                        </label>
                                    </div>
                                    <!-- Change this to a button or input when using this as a form -->
                                    <input type="submit" id="submit" class="btn btn-lg btn-success btn-block" value="Login" />
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal hide" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-header">
            <h1>Processing...</h1>
        </div>
        <div class="modal-body">
            <div class="progress progress-striped active">
                <div class="bar" style="width: 100%;"></div>
            </div>
        </div>
    </div>

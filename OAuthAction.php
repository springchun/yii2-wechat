<?php
namespace springchun\yii2\wechat;

use EasyWeChat\Foundation\Application;
use EasyWeChat\Foundation\Config;
use Overtrue\Socialite\User;
use Symfony\Component\HttpFoundation\Response;
use yii\base\Action;
use yii\base\InvalidParamException;
use yii\helpers\Url;


class OAuthAction extends Action
{
    public $scopes = ['snsapi_userinfo'];
    public $callbackParamName = 'return';
    public $successCallback;

    /**
     * @return \yii\web\Response
     */
    public function run()
    {
        if (!$this->successCallback) {
            exit("还未设置成功回调函数");
        } else if (!\Yii::$app->get('wechat', false)) {
            exit("还未配置微信组件");
        }
        /** @var Application $application */
        $application = \Yii::$app->wechat->application;
        if (!\Yii::$app->request->get($this->callbackParamName)) {
            /** @var Config $config */
            $config = $application['config'];
            $config->set('oauth.callback', Url::to([
                '/' . $this->uniqueId,
                $this->callbackParamName => time()
            ]));
            /** @var Response $response */
            $response = $application->oauth->scopes($this->scopes)->redirect();
            $response->send();
        } else {
            /** @var User $user */
            if (!$user = $application->oauth->user()) {
                return $this->controller->redirect([
                    '/' . $this->uniqueId
                ]);
            } else {
                return call_user_func($this->successCallback, $user);
            }
        }
    }
}
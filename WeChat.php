<?php
namespace springchun\yii2\wechat;

use EasyWeChat\Foundation\Application;
use yii\base\Component;

/**
 * Class     WeChat
 * @package springchun\yii\wechat
 * @property Application $application
 */
class WeChat extends Component
{
    public $params = [];

    /** @var  Application */
    private $_application;

    /**
     * @return Application
     */
    public function getApplication()
    {
        return $this->_application ?
            $this->_application :
            $this->_application = new Application($this->params);
    }
}
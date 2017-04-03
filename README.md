easywechat for yii2  
   
oauth登录的使用  
  
class WechatController extends Controller  
{  
    public function actions()  
    {  
        return [  
            'login'=>[  
                'class'=>OAuthAction::class,  
                'successCallback'=>function($user){  
                    print_r($user);  
                    /** @var User $user */  
                    \Yii::$app->session->open_id = $user->getId();  
                    return $this->redirect([  
                        '/'  
                    ]);  
                }  
            ]  
        ];  
    }  
}  

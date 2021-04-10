<?php
namespace App\Plugins\Biubiubiu\src;

use Illuminate\Support\Str;
use App\Plugins\Biubiubiu\src\Models\BiubiubiuCi;

class PrivatesMessageController {
    /**
     * 接收到的数据
     *
     * @var object
     */
    public $data;

    /**
     * 插件信息
     *
     * @var array
     */
    public $value;

    /**
     * 插件注册
     *
     * @param object 接收到的数据 $data
     * @param array 插件信息 $value
     * @return void
     */
    public function register($data, $value)
    {
        $this->data = $data;
        $this->value = $value;
        $this->jingque();
        $this->mohu();
    }

    // 精确回复
    public function jingque(){
        if(get_options("Biubiubiu_Switch_Private_exact")){
            $get = BiubiubiuCi::where(['order' => $this->data->message,'type' => 'exact','class' => "private"])->get();
            foreach ($get as $value) {
                sendMsg([
                    'user_id' => $this->data->user_id,
                    'message' => "{$value->content}"
                ], "send_private_msg");
            }
        }
    }

    // 模糊回复
    public function mohu(){
        if(get_options("Biubiubiu_Switch_Private_blurry")){
            $get = BiubiubiuCi::where(['type' => 'blurry','class' => "private"])->get();
            foreach ($get as $value) {
                $contains = Str::of($this->data->message)->contains($value->order);
                if($contains){
                    sendMsg([
                        'user_id' => $this->data->user_id,
                        'message' => $value->content
                    ], "send_private_msg");
                }
            }
        }
    }
}
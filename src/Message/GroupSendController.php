<?php

namespace App\Plugins\Biubiubiu\src\Message;

use Illuminate\Support\Str;
use App\Plugins\Biubiubiu\src\Models\BiubiubiuCi;

class GroupSendController
{

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
        if(get_options("Biubiubiu_Switch_Group_exact")){
            $at = get_options('Biubiubiu_Switch_ReAt');
            $get = BiubiubiuCi::where(['order' => $this->data->message,'type' => 'exact','class' => "group"])->get();
            foreach ($get as $value) {
                if($at){
                    sendMsg([
                        'group_id' => $this->data->group_id,
                        'message' => "[CQ:at,qq={$this->data->user_id}]{$value->content}"
                    ], "send_group_msg");
                }else{
                    sendMsg([
                        'group_id' => $this->data->group_id,
                        'message' => $value->content
                    ], "send_group_msg");
                }
            }
        }
    }

    // 模糊回复
    public function mohu(){
        if(get_options("Biubiubiu_Switch_Group_blurry")){
            $at = get_options('Biubiubiu_Switch_ReAt');
            $get = BiubiubiuCi::where(['type' => 'blurry','class' => "group"])->get();
            foreach ($get as $value) {
                $contains = Str::of($this->data->message)->contains($value->order);
                if($contains){
                    if($at){
                        sendMsg([
                            'group_id' => $this->data->group_id,
                            'message' => "[CQ:at,qq={$this->data->user_id}]{$value->content}"
                        ], "send_group_msg");
                    }else{
                        sendMsg([
                            'group_id' => $this->data->group_id,
                            'message' => $value->content
                        ], "send_group_msg");
                    }
                }
            }
        }
    }
}

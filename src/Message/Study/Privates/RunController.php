<?php
namespace App\Plugins\Biubiubiu\src\Message\Study\Privates;

use Illuminate\Support\Facades\Cache;

class RunController{
    
    public $data;

    public $value;

    public $order;

    public $orderCount;

    public function register($data, $value, $order, $orderCount)
    {
        $this->data = $data;
        $this->value = $value;
        $this->order = $order;
        $this->orderCount = $orderCount;
        $this->run();
    }
    public function run()
    {
        if ($this->orderCount >= 2) {
            if ($this->order[0] == "模糊学习") {
                if ($this->order[1]) {
                    $this->mohu();
                }
            }
            if ($this->order[0] == "精确学习") {
                if ($this->order[1]) {
                    $this->jingque();
                }
            }
        }
    }

    // 模糊学习
    public function mohu()
    {
        Cache::put('Biubiubiu.Cache.Mohu.Private.QQ.' . $this->data->user_id, $this->order, 120);
        sendMsg([
            'message' => "当机器人收到内容包含:「{$this->order[1]}」时回复什么? 请在两分钟内发送",
            'user_id' => $this->data->user_id
        ], 'send_private_msg');
    }

    // 精确学习
    public function jingque(){
        Cache::put('Biubiubiu.Cache.Jingque.Private.QQ.' . $this->data->user_id, $this->order, 120);
        sendMsg([
            'message' => "当机器人收到:「{$this->order[1]}」时回复什么? 请在两分钟内发送",
            'user_id' => $this->data->user_id
        ], 'send_private_msg');
    }

}
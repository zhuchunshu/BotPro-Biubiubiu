<?php

namespace App\Plugins\Biubiubiu\src\Message\Study\Group;

use Illuminate\Support\Facades\Cache;

class RunController
{

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
        Cache::put('Biubiubiu.Cache.Mohu.QQ.' . $this->data->user_id, $this->order, 120);
        sendMsg([
            'message' => "[CQ:reply,id={$this->data->message_id}]当机器人收到内容包含:「{$this->order[1]}」时回复什么? 请在两分钟内发送",
            'group_id' => $this->data->group_id
        ], 'send_group_msg');
    }

    // 精确学习
    public function jingque(){
        Cache::put('Biubiubiu.Cache.Jingque.QQ.' . $this->data->user_id, $this->order, 120);
        sendMsg([
            'message' => "[CQ:reply,id={$this->data->message_id}]当机器人收到:「{$this->order[1]}」时回复什么? 请在两分钟内发送",
            'group_id' => $this->data->group_id
        ], 'send_group_msg');
    }
}

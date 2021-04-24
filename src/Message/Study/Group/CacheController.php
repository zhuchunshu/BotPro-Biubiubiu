<?php
namespace App\Plugins\Biubiubiu\src\Message\Study\Group;

use App\Plugins\Biubiubiu\src\Models\BiubiubiuCi;
use Illuminate\Support\Facades\Cache;

class CacheController{

    public function mohu($data){
        $order = Cache::get('Biubiubiu.Cache.Mohu.QQ.'.$data->user_id);
        BiubiubiuCi::insert([
            'order' => $order[1],
            'content' => $data->message,
            'type' => 'blurry',
            'class' => 'group',
            'created_at' => date("Y-m-d H:i:s")
        ]);
        sendMsg([
            'message' => "[CQ:reply,id={$data->message_id}]学习成功!\n当机器人收到内容包含:「{$order[1]}」时\n回复:「{$data->message}」",
            'group_id' => $data->group_id
        ],'send_group_msg');
        Cache::forget('Biubiubiu.Cache.Mohu.QQ.'.$data->user_id);
    }

    public function jingque($data){
        $order = Cache::get('Biubiubiu.Cache.Jingque.QQ.'.$data->user_id);
        BiubiubiuCi::insert([
            'order' => $order[1],
            'content' => $data->message,
            'type' => 'exact',
            'class' => 'group',
            'created_at' => date("Y-m-d H:i:s")
        ]);
        sendMsg([
            'message' => "[CQ:reply,id={$data->message_id}]学习成功!\n当机器人收到:「{$order[1]}」时\n回复:「{$data->message}」",
            'group_id' => $data->group_id
        ],'send_group_msg');
        Cache::forget('Biubiubiu.Cache.Jingque.QQ.'.$data->user_id);
    }

}
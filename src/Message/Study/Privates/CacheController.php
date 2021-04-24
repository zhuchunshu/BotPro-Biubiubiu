<?php
namespace App\Plugins\Biubiubiu\src\Message\Study\Privates;

use Illuminate\Support\Facades\Cache;
use App\Plugins\Biubiubiu\src\Models\BiubiubiuCi;

class CacheController{
    public function mohu($data){
        $order = Cache::get('Biubiubiu.Cache.Mohu.Private.QQ.'.$data->user_id);
        BiubiubiuCi::insert([
            'order' => $order[1],
            'content' => $data->message,
            'type' => 'blurry',
            'class' => 'private',
            'created_at' => date("Y-m-d H:i:s")
        ]);
        sendMsg([
            'message' => "[CQ:reply,id={$data->message_id}]学习成功!\n当机器人收到内容包含:「{$order[1]}」时\n回复:「{$data->message}」",
            'user_id' => $data->user_id
        ],'send_private_msg');
        Cache::forget('Biubiubiu.Cache.Mohu.Private.QQ.'.$data->user_id);
    }

    public function jingque($data){
        $order = Cache::get('Biubiubiu.Cache.Jingque.Private.QQ.'.$data->user_id);
        BiubiubiuCi::insert([
            'order' => $order[1],
            'content' => $data->message,
            'type' => 'exact',
            'class' => 'private',
            'created_at' => date("Y-m-d H:i:s")
        ]);
        sendMsg([
            'message' => "[CQ:reply,id={$data->message_id}]学习成功!\n当机器人收到:「{$order[1]}」时\n回复:「{$data->message}」",
            'user_id' => $data->user_id
        ],'send_private_msg');
        Cache::forget('Biubiubiu.Cache.Jingque.Private.QQ.'.$data->user_id);
    }
}
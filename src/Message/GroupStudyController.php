<?php
namespace App\Plugins\Biubiubiu\src\Message;

use App\Models\BotCore;
use App\Plugins\Biubiubiu\src\Message\Study\Group\RunController;
use App\Plugins\Biubiubiu\src\Message\Study\Group\CacheController;
use Illuminate\Support\Facades\Cache;


class GroupStudyController{

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
    
    public $order;

    public $orderCount;

    /**
     * 注册方法
     *
     * @param object 接收到的数据 $data
     * @param array 插件信息 $value
     * @return void
     */
    public function register($data,$value){
        $this->data = $data;
        $this->value = $value;
        $this->order = $order = GetZhiling($data,"#");
        $this->orderCount = count($order);
        $this->boot();
    }

    public function boot(){

        if(Cache::has('Biubiubiu.Cache.Mohu.QQ.'.$this->data->user_id)){
            (new CacheController())->mohu($this->data);
        }

        if(Cache::has('Biubiubiu.Cache.Jingque.QQ.'.$this->data->user_id)){
            (new CacheController())->jingque($this->data);
        }

        //群内学习(大于等于管理员权限) 
        if(get_options('Biubiubiu_Switch_Group_study_admin')){
            $quanxian = true;
            if($this->data->sender->role=="member"){
                $quanxian = false;
            }
            if($quanxian===true){
                (new RunController())->register($this->data,$this->value,$this->order,$this->orderCount);
            }
        }
        //群内学习(群主权限)
        if(get_options('Biubiubiu_Switch_Group_study_owner')){
            $quanxian = false;
            if($this->data->sender->role=="owner"){
                $quanxian = true;
            }
            if($quanxian===true){
                (new RunController())->register($this->data,$this->value,$this->order,$this->orderCount);
            }
        }
        //群内学习(主人权限)
        if(get_options('Biubiubiu_Switch_Group_study_zhuren')){
            $quanxian = false;
            if(BotCore::where(['type' => 'qq','value' => $this->data->user_id])->count()){
                $quanxian = true;
            }
            if($quanxian===true){
                (new RunController())->register($this->data,$this->value,$this->order,$this->orderCount);
            }
        }
        //群内学习(群员权限)
        if(get_options('Biubiubiu_Switch_Group_study_mumber')){
            (new RunController())->register($this->data,$this->value,$this->order,$this->orderCount);
        }
    }

}
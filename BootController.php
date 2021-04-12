<?php
namespace App\Plugins\Biubiubiu;

use App\Plugins\Biubiubiu\src\Controller\BiubiubiuCiController;
use Dcat\Admin\Admin;
use Dcat\Admin\Layout\Menu;
use Illuminate\Support\Facades\Route;
use App\Plugins\Biubiubiu\src\Controller\IndexController;
use App\Plugins\Biubiubiu\src\Controller\SwitchController;
use App\Plugins\Biubiubiu\src\database\CreateBiubiubiuCiTable;

class BootController {

    public function handle(){
        $this->menu(); // 注册菜单
        $this->route(); //注册路由
        $this->sqlMigrate(); // 数据库迁移
    }

    public function route(){
        Route::group([
            'prefix'     => config('admin.route.prefix')."/biubiubiu",
            'middleware' => config('admin.route.middleware'),
        ], function () {
            Route::get('/', [IndexController::class,'show']); // 插件信息
            Route::get('/switch', [SwitchController::class,'index']); // 插件功能开关 
            Route::put('/switch/{name}', [SwitchController::class,'update']); // 插件功能开关 

            Route::get('keywords', [BiubiubiuCiController::class,'index']); // 关键词
            Route::post('keywords', [BiubiubiuCiController::class,'store']); // 关键词
            Route::get('keywords/create', [BiubiubiuCiController::class,'create']); // 关键词
            Route::get('keywords/{id}/edit', [BiubiubiuCiController::class,'edit']); // 编辑
            Route::get('keywords/{id}', [BiubiubiuCiController::class,'show']); // 查看
            Route::delete('keywords/{id}', [BiubiubiuCiController::class,'destroy']); // 删除
            Route::put('/keywords/{id}', [BiubiubiuCiController::class,'update']); //更新
        });
    }

    public function menu(){
        Admin::menu(function (Menu $menu) {
            $menu->add([
                [
                    'id'            => 100, // 此id只要保证当前的数组中是唯一的即可
                    'title'         => 'Biubiubiu',
                    'icon'          => 'feather icon-sunrise',
                    // 'uri'           => 'fuduji',
                    'parent_id'     => 0, 
                    'permission_id' => 'administrator', // 与权限绑定
                    'roles'         => 'administrator', // 与角色绑定
                ],   
                [
                    'id'            => 101, // 此id只要保证当前的数组中是唯一的即可
                    'title'         => '插件信息',
                    'icon'          => '',
                    'uri'           => 'biubiubiu',
                    'parent_id'     => 100, 
                    'permission_id' => 'administrator', // 与权限绑定
                    'roles'         => 'administrator', // 与角色绑定
                ],
                [
                    'id'            => 102, // 此id只要保证当前的数组中是唯一的即可
                    'title'         => '功能开关',
                    'icon'          => '',
                    'uri'           => 'biubiubiu/switch',
                    'parent_id'     => 100, 
                    'permission_id' => 'administrator', // 与权限绑定
                    'roles'         => 'administrator', // 与角色绑定
                ],
                [
                    'id'            => 103, // 此id只要保证当前的数组中是唯一的即可
                    'title'         => '关键词',
                    'icon'          => '',
                    'uri'           => 'biubiubiu/keywords',
                    'parent_id'     => 100, 
                    'permission_id' => 'administrator', // 与权限绑定
                    'roles'         => 'administrator', // 与角色绑定
                ],
            ]);
        });
    }
    // 数据库迁移
    public function sqlMigrate(){
        $cr = new CreateBiubiubiuCiTable();
        $cr->up();
    }
}
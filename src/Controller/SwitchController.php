<?php
namespace App\Plugins\Biubiubiu\src\Controller;
use ZipArchive;
use Faker\Factory;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Illuminate\Http\Request;
use Dcat\Admin\Layout\Content;
use App\Services\PluginManager;
use Madnest\Madzipper\Madzipper;
use App\Admin\Repositories\Plugin;
use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Plugin as ModelsPlugin;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
class SwitchController {

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return new Grid(null, function (Grid $grid) {
            $grid->column('id', '标识')->explode()->label();
            $grid->column('name', '名称')->explode('\\')->label();
            $grid->column('status', '开启/关闭')->switch();
            $grid->disableRowSelector();
            //$grid->disableCreateButton();
            $grid->disableActions();
            $grid->disableCreateButton();
            $grid->disableBatchDelete();
            $grid->disablePagination();
            $grid->model()->setData($this->generate());
        });
    }

    /**
     * 获取所有插件
     *
     * @return array
     */
    public function generate()
    {
        $PluginManager = new PluginManager();
        $data = [
            [
                "id" => "Biubiubiu_Switch_Group_exact",
                "name" => "群精确回复",
                'status' => get_options("Biubiubiu_Switch_Group_exact"),
            ],
            [
                "id" => "Biubiubiu_Switch_Group_blurry",
                "name" => "群模糊回复",
                'status' => get_options("Biubiubiu_Switch_Group_blurry"),
            ],
            [
                "id" => "Biubiubiu_Switch_Private_exact",
                "name" => "私聊精确回复",
                'status' => get_options("Biubiubiu_Switch_Private_exact"),
            ],
            [
                "id" => "Biubiubiu_Switch_Private_blurry",
                "name" => "私聊模糊回复",
                'status' => get_options("Biubiubiu_Switch_Private_blurry"),
            ],
            [
                "id" => "Biubiubiu_Switch_Group_study_admin",
                "name" => "群内学习(大于等于管理员权限)",
                'status' => get_options("Biubiubiu_Switch_Group_study_admin"),
            ],
            [
                "id" => "Biubiubiu_Switch_Group_study_owner",
                "name" => "群内学习(群主权限)",
                'status' => get_options("Biubiubiu_Switch_Group_study_owner"),
            ],
            [
                "id" => "Biubiubiu_Switch_Group_study_zhuren",
                "name" => "群内学习(主人权限)",
                'status' => get_options("Biubiubiu_Switch_Group_study_zhuren"),
            ],
            [
                "id" => "Biubiubiu_Switch_Group_study_mumber",
                "name" => "群内学习(所有人权限)",
                'status' => get_options("Biubiubiu_Switch_Group_study_mumber"),
            ],
            [
                "id" => "Biubiubiu_Switch_Private_study_zhuren",
                "name" => "私聊学习(主人权限)",
                'status' => get_options("Biubiubiu_Switch_Private_study_zhuren"),
            ],
            [
                "id" => "Biubiubiu_Switch_ReAt",
                "name" => "回复时艾特",
                'status' => get_options("Biubiubiu_Switch_ReAt"),
            ],
            [
                "id" => "Biubiubiu_Switch_Study_f",
                "name" => "禁止重复学习同一指令",
                'status' => get_options("Biubiubiu_Switch_Study_f"),
            ],
        ];
        return $data;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Plugin(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('path');
            $show->field('class');
            $show->field('status');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Plugin(), function (Form $form) {
            $form->file('file', '选择插件')->accept('zip')->removable();
            $form->disableFooter();
        });
    }
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title="功能开关";

    /**
     * Set description for following 4 action pages.
     *
     * @var array
     */
    protected $description = [
        //        'index'  => 'Index',
        //        'show'   => 'Show',
        //        'edit'   => 'Edit',
        //        'create' => 'Create',
    ];

    /**
     * Get content title.
     *
     * @return string
     */
    protected function title()
    {
        return $this->title ?: admin_trans_label();
    }

    /**
     * Get description for following 4 action pages.
     *
     * @return array
     */
    protected function description()
    {
        return $this->description;
    }

    /**
     * Index interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description()['index'] ?? trans('admin.list'))
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed   $id
     * @param Content $content
     *
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description()['show'] ?? trans('admin.show'))
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed   $id
     * @param Content $content
     *
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description()['edit'] ?? trans('admin.edit'))
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description()['create'] ?? trans('admin.create'))
            ->body($this->form());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update($name, Form $form)
    {
        $status = request()->input('status', 0);
        if (get_options_count($name)) {
            // 存在
            Option::where('name', $name)->update([
                'value' => $status
            ]);
            if ($status) {
                $ev = "启用";
            } else {
                $ev = "禁用";
            }
        } else {
            // 不存在
            Option::insert([
                'name' => $name,
                'value' => $status,
                'created_at' => date("Y-m-d H:i:s")
            ]);
            $ev = "禁用";
        }
        return [
            'status' => true,
            'data' => [
                'message' => "标识为:" . $name . "的功能" .$ev . '成功!',
                'type' => 'success'
            ]
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        //$path = $request->file('_file_')->store('file');
        $file = $request->_file_;
        $file->move(app_path("Plugins"), $file->getClientOriginalName());
        $path = app_path("Plugins/" . $file->getClientOriginalName());
        //实例化ZipArchive类
        $zip = new ZipArchive();
        //打开压缩文件，打开成功时返回true
        if ($zip->open($path) === true) {
            //解压文件到获得的路径a文件夹下
            $zip->extractTo(app_path("Plugins/"));
            //关闭
            $zip->close();
            File::delete($path);
            return Json_Api(true,"插件安装成功!","success");
        } else {
            return Json_Api(true,"插件上传失败!","error");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->form()->destroy($id);
    }

}
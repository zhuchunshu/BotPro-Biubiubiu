<?php

namespace App\Plugins\Biubiubiu\src\Controller;

use Dcat\Admin\Widgets\Card;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Markdown;

class IndexController {

    public function show(Content $content){
        $content->title('Biubiubiu');
        $content->header('Biubiubiu');
        $content->description('Biubiubiu插件信息');
        $content->body(Card::make(
            Markdown::make(read_file(plugin_path("Biubiubiu/README.md")))
        ));
        return $content;
    }

}
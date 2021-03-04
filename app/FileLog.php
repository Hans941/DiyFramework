<?php
namespace App;

use App\MyInterface\Log;

// 文件记录日志
class FileLog implements Log
{
    public function write(){
        echo 'file log write...';
    }
}
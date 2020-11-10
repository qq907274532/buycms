<?php
/**
 * Created by PhpStorm.
 *
 * @author svip_zx<907274532@qq.com>
 * @email  907274532@qq.com
 * User: svip_zx
 * Date: 2018/11/19
 * Time: 17:35
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * App\Http\Controllers HomeController.
 */
class CommonController extends Controller
{
    /**
     * 上传图片
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImg(Request $request)
    {
        $file = $request->file('file');

        $result = $this->upload($file);

        $data = [
            'code'   => 200,
            'status' => false,
            'url'    => '',
        ];
        if ($result) {
            $data['status'] = true;
            $data['url'] = $result;
        }

        return response()->json($data);
    }

    /**
     * 上传视频
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadVideo(Request $request)
    {
        $file = $request->file('file');

        $result = $this->upload($file, 'video');

        $data = [
            'code'   => 200,
            'status' => false,
            'url'    => '',
        ];
        if ($result) {
            $data['status'] = true;
            $data['url'] = $result;
        }

        return response()->json($data);
    }

    /**
     * 文件上传
     */
    public function uploadFile(Request $request)
    {
        $file = $request->file('file');
        // 此时 $this->upload如果成功就返回文件名不成功返回false
        $fileName = $this->upload($file);
        if ($fileName) {
            return $fileName;
        }

        return '上传失败';
    }

    /**
     * 获取类型
     *
     * @return string
     */
    private static function getFileSystemsType()
    {
        return 'public';
    }


    /**
     * @param        $file
     * @param string $type
     *
     * @return bool
     */
    private function upload($file, $type = 'image')
    {
        // 1.是否上传成功
        if (!$file->isValid()) {
            return false;
        }

        // 2.是否符合文件类型 getClientOriginalExtension 获得文件后缀名
        $fileExtension = $file->getClientOriginalExtension();
        switch ($type) {
            case 'video':
                if (!in_array($fileExtension, ['mp4','avi','wmv','rm','rmvb','mkv','mp3','wma','wav'])) {
                    return false;
                }
                break;
            case 'file':
                break;
            default:
                if (!in_array($fileExtension, ['jpg','jpeg','png','gif','bmp4'])) {
                    return false;
                }
                break;

        }
        //        // 3.判断大小是否符合 2M
        $tmpFile = $file->getRealPath();
        //        if (filesize($tmpFile) >= 2048000) {
        //            return false;
        //        }

        // 4.是否是通过http请求表单提交的文件
        if (!is_uploaded_file($tmpFile)) {
            return false;
        }

        // 5.每天一个文件夹,分开存储, 生成一个随机文件名
        $fileName = date('Ymd') . '/' . $type . '/' . md5(time()) . mt_rand(0, 9999) . '.' . $fileExtension;
        if (Storage::disk(self::getFileSystemsType())->put($fileName, file_get_contents($tmpFile))) {
            return Storage::url($fileName);
        }

        return false;
    }
}

<?php
class Thumb
{
    public static function get($image_url,$width=100,$height=100)
    {
        $ext = strrchr($image_url,'.');
        $end = intval("-".strlen($ext));
        $real_url = substr($image_url,0,$end)."_{$width}_{$height}".$ext;
        if(file_exists($real_url)) return IUrl::creatUrl("").$real_url;
        return IUrl::creatUrl("").PhotoUpload::thumb($image_url,$width,$height,"_{$width}_{$height}");
    }
}
?>
<?php
declare(strict_types=1);
final class ArtworkStorage {
    private const TYPES=['application/pdf'=>'pdf','image/png'=>'png','image/jpeg'=>'jpg','image/tiff'=>'tif','application/postscript'=>'eps'];
    public static function collect(array $input): array {
        if (!isset($input['name']) || !is_array($input['name'])) return [];
        $maxCount=max(1,min(10,(int)envv('MAX_UPLOAD_COUNT','5')));$maxBytes=max(1,min(50,(int)envv('MAX_UPLOAD_MB','25')))*1024*1024;$result=[];
        foreach($input['name'] as $i=>$name){if(($input['error'][$i]??UPLOAD_ERR_NO_FILE)===UPLOAD_ERR_NO_FILE)continue;if(count($result)>=$maxCount)throw new RuntimeException('Attach no more than '.$maxCount.' artwork files.');if(($input['error'][$i]??UPLOAD_ERR_NO_FILE)!==UPLOAD_ERR_OK)throw new RuntimeException('An artwork file could not be uploaded. Check its size and try again.');$tmp=(string)($input['tmp_name'][$i]??'');$size=(int)($input['size'][$i]??0);if($size<1||$size>$maxBytes||!is_uploaded_file($tmp))throw new RuntimeException('Each artwork file must be under '.(int)envv('MAX_UPLOAD_MB','25').' MB.');$finfo=new finfo(FILEINFO_MIME_TYPE);$mime=$finfo->file($tmp);if(!isset(self::TYPES[$mime]))throw new RuntimeException('Use a PDF, PNG, JPEG, TIFF or EPS artwork file.');$original=trim(basename((string)$name));$result[]=['tmp'=>$tmp,'size'=>$size,'mime'=>$mime,'extension'=>self::TYPES[$mime],'original'=>$original!==''?$original:'artwork'];}
        return $result;
    }
    public static function store(array $files): array {
        $path=envv('UPLOAD_DIR','storage/private-artwork');$dir=str_starts_with($path,DIRECTORY_SEPARATOR)?$path:ROOT.'/'.trim($path,'/');if(!is_dir($dir)&&!mkdir($dir,0700,true)&&!is_dir($dir))throw new RuntimeException('Private artwork storage is not available.');if(!is_writable($dir))throw new RuntimeException('Private artwork storage is not writable.');$saved=[];
        foreach($files as $file){$key=bin2hex(random_bytes(24)).'.'.$file['extension'];$target=$dir.'/'.$key;if(!move_uploaded_file($file['tmp'],$target)){foreach($saved as $p)@unlink($p['path']);throw new RuntimeException('An artwork file could not be safely stored.');}chmod($target,0600);$saved[]=$file+['key'=>$key,'path'=>$target];}
        return $saved;
    }
}

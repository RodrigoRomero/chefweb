<?php
/* VERSION: 1.2.1
 * 
 * 
 */
ini_set("memory_limit","100M");
include("resize.php");
class UploadManager{
    
    var $batch_file = "resize_batch.txt";
    function upload(){       
        $newName    = $_FILES['Filedata']['name'];
        $f          = file_put_contents("upload_debug_1", $newName);
        $arr_ext    = explode(".", $newName);
        $ext        = array_pop($arr_ext);
        $ext        = strtolower($ext);
        $newName    = "tmp_".date("YmdHis").".".$ext;
         
        $resize     = (!empty($_REQUEST['resize'])) ? explode(",", str_replace(" ", "", $_REQUEST['resize'])) : "";
        $original   = (!empty($resize)) ? "original/" : "";
        $ratio      = (isset($_REQUEST['ratio'])) ? explode("x", strtolower($_REQUEST['ratio'])) : ""; 
        if(!empty($ratio)){
            $mw = $ratio[0];
            $mh = $ratio[1];
            list($width, $height, $type, $w) = getimagesize($_FILES['Filedata']['tmp_name']);
            if($width < $mw || $height < $mh){
                $data = array("success"=>false, "error"=>"size", "msg"=>"($width x $height)");
                echo json_encode($data);die;
            }else if(round(($width/$height) ,2)!= round(($mw/$mh),2)){
                $data = array("success"=>false, "error"=>"ratio", "msg"=>"($width x $height)");
                echo json_encode($data);die;
            }else if($height > 2000){
                $data = array("success"=>false, "error"=>"maxsize", "msg"=>"($width x $height)");
                echo json_encode($data);die;
            }
        }
        
          
        $file_path  = $_REQUEST['sistem_path'].$_REQUEST['fodler'].$original.$newName;    
        $f    = file_put_contents("upload_debug", $file_path);
            
        $ret        = move_uploaded_file($_FILES['Filedata']['tmp_name'], $file_path);
        
        
		@chmod($file_path, 0644);
        $row = array("file"=>$file_path, "resize"=>$resize, "pos" => $_REQUEST['pos']);
        $fp  = fopen($this->batch_file, 'a+') or die("can't open file");
        fwrite($fp, json_encode($row)."\n");
        fclose($fp);
        
        $data       = array("file_path" => $file_path, "file_name" => $newName, "success"=>true);
        if(isset($width) && !empty($width)) $data["w"] = $width;
        echo json_encode($data);
    }
    
    function resize($id, $path=""){        
        //http://server/server/Desarrollo/VIRTUACOMMERCE/Develop/bin/rr-admin/assets/widgets/uploadManager/UploadManager.php?a=resize&id=10
        $this->batch_file = $path.$this->batch_file;
        if(!file_exists($this->batch_file)) return false;
        $batch = file_get_contents($this->batch_file);
        $batch = explode("\n", $batch);
        array_pop($batch);
        foreach($batch as $row){
            $data       = json_decode($row);
            $file_arr   = explode("/", $data->file);
            $file_name  = array_pop($file_arr);
            $thumb_path = implode("/", str_replace("original", "thumbs", $file_arr))."/";
            $file_ext   = explode(".", $file_name);
            if(!empty($data->resize)){
                foreach($data->resize as $size){
                    $newName    = $id."_".$data->pos."_".$size.".".$file_ext[1];
                    $thumb = new thumbnail($data->file);
                    $thumb->size_width($size);
                    $thumb->save("$thumb_path/$newName");
                }
            }
            $rename_file = $id."_".$data->pos.".".$file_ext[1];
            $rename_file = implode("/", $file_arr)."/".$rename_file;
            rename($data->file, $rename_file);
        }
        unlink($this->batch_file);
        return true;
    }
    
    function batch($folder="", $size=""){
        
        $f    = file_put_contents("upload_debug", 'b');
        //http://server/server/Desarrollo/VIRTUACOMMERCE/Develop/bin/vc-admin/assets/widgets/uploadManager/UploadManager.php?a=batch&folder=uploads/productos/original&size=20,30
        $or_size       = $size;
        $sistem_path   = str_replace("assets/widgets/uploadManager/UploadManager.php", "", $_SERVER["SCRIPT_FILENAME"]);
        $size          = str_replace(" ", "", $size);
        $size_arr      = explode(",", $size);
        $relative_path = "../../../../";
        if ($handle = opendir($relative_path.$folder)) {
            $count = 1;
            while (false !== ($file = readdir($handle)) && $count<50) {
                $tmp_f     = strtolower($file);
				$tmp_f_arr = explode(".", $tmp_f);
				$fl        = (count($tmp_f_arr)<2) ? false : true;
				if(!in_array(array_pop($tmp_f_arr), array("jpg", "jpeg", "png", "gif"))){
					$fl = false;
				}
                if ($file != "." && $file != ".." && $fl) {
                    $original_path = $sistem_path.$folder."/";
                    if(preg_match("/[A-Z]/", $file)===0){
                        rename($original_path.$file, strtolower($original_path.$file));
					}
                    $thumb_path    = str_replace("batch", "thumbs", $original_path);
                    $thumb_arr     = explode(".", $file);
                    foreach($size_arr as $s){
                        $thumb_name    = $thumb_arr[0]."_".$s.".".$thumb_arr[1];
                        $thumb_name    = strtolower($thumb_name);
                        if(!file_exists($thumb_path.$thumb_name)){
                            $thumb = new thumbnail($original_path.$file);  
                            $thumb->size_width($s);
                            $thumb->save($thumb_path.$thumb_name);
                            //echo $count.": ".$thumb_name."<br/>"; 
                            $count++;
                        }
                    }
					rename($original_path.$file, $original_path."../original/".$file);
                }
            }
            closedir($handle);
            if($count>1){
                echo "El proceso no ha terminado. <b>No cierre esta pagina</b>";
                echo "<script>setTimeout( 'location.reload()', 4*1000 );</script>";
            }else{
                echo "<h3>Proceso terminado. Ya puede cerrar esta pagina.</h3>";
            }
        }
    }
    
    function remove_batch(){
    	if(file_exists($this->batch_file))
        	unlink($this->batch_file);
    }
    
    function test(){
        echo "test";
    }
    
    function delete($file, $resize=""){
        unlink($file);
        if(!empty($resize)){
            $file_arr    = explode(".", $file);
            $ext         = array_pop($file_arr);
            $file_name   = implode(".", $file_arr);
            $file_name   = str_replace("original/", "thumbs/", $file_name);
            $resize      = explode(",", $resize);
            foreach($resize as $row){
                $nf = $file_name."_".$row.".".$ext;
                unlink($nf);
            }
        }
    }
}
//
$action = $_REQUEST['a'];
$up     = new UploadManager();
switch($action){
    case "upload":        
        $up->upload();
        break;
	case "delete":
        $up->delete($_REQUEST['file'], $_REQUEST['resize']);
        break;
    case "resize":
        if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
            $up->resize($_REQUEST['id']);
        break;
    case "batch":
        $up->batch($_REQUEST['folder'], $_REQUEST['size']);
        break;
    case "remove_batch":
        $up->remove_batch();
        break;
}

?>
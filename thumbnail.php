<?php
function generate_thumb_now($field_name = 'name',$target_folder ='upload',$file_name = 'upload', $thumb = FALSE, $thumb_folder = 'thumbnail', $thumb_width = '50px',$thumb_height = '50px'){
         //folder path setup
         $target_path = $target_folder;
         $thumb_path = $thumb_folder;   
         //file name setup
    $filename_err = explode(".",$_FILES[$field_name]['name']);
    $filename_err_count = count($filename_err);
    $file_ext = $filename_err[$filename_err_count-1];
     if($file_name != '')
     {
        $fileName = $file_name.'.'.$file_ext;
      }
    else
    {
        $fileName = $_FILES[$field_name]['name'];
    }   
    //upload image path
    $upload_image = $target_path.basename($fileName);   
    //upload image
    if(move_uploaded_file($_FILES[$field_name]['tmp_name'],$upload_image))
    {
         //thumbnail creation
        if($thumb == TRUE)
        {
            $thumbnail = $thumb_path.$fileName;
            list($width,$height) = getimagesize($upload_image);
            $thumb_create = imagecreatetruecolor($thumb_width,$thumb_height);
            switch($file_ext){
                case 'jpg':
                    $source = imagecreatefromjpeg($upload_image);
                    break;
                case 'jpeg':
                    $source = imagecreatefromjpeg($upload_image);
                    break;
                case 'png':
                    $source = imagecreatefrompng($upload_image);
                    break;
                case 'gif':
                    $source = imagecreatefromgif($upload_image);
                     break;
                default:
                    $source = imagecreatefromjpeg($upload_image);
            }
       imagecopyresized($thumb_create, $source, 0, 0, 0, 0, $thumb_width, $thumb_height, $width,$height);
            switch($file_ext){
                case 'jpg' || 'jpeg':
                    imagejpeg($thumb_create,$thumbnail,100);
                    break;
                case 'png':
                    imagepng($thumb_create,$thumbnail,100);
                    break;
                case 'gif':
                    imagegif($thumb_create,$thumbnail,100);
                     break;
                default:
                    imagejpeg($thumb_create,$thumbnail,100);
            }
        }
        return $fileName;
     }
    else
    {
        return false;
     }
    }
   
    if(!empty($_FILES['image']['name'])){       
    $upload_img = generate_thumb_now('image','upload/','',TRUE,'upload/thumbnail/','100','100');

    //full path of the thumbnail image
    $thumb_src = 'upload/thumbnail/'.$upload_img;
    


    //set success and error messages
    $message = $upload_img?"<span style='color:#008000;'>Image thumbnail created successfully.</span>":"<span style='color:#F00000;'>Some error occurred, please try again.</span>";

    }else{

    //if form is not submitted, below variable should be blank
    $thumb_src = '';
    
    $message = '';
    }
    ?>

    <html>
    <head>Image upload and generate thumbnail</head>
     <body>
     <div class="messages"><?php echo $message; ?></div>
      <form method="post" enctype="multipart/form-data">
      <input type="file" name="image"/>
      <input type="submit" name="submit" value="upload"/>
    </form>
    <?php if($thumb_src!= ''){ ?>
    <div class="gallery">
    <ul>
        <li><img src="<?php echo $thumb_src; ?>" alt=""></li>
       
    </ul>
   </div>
    <?php } ?>
    </body>
    </html>
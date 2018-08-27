<?php




    class Photo{

        private $target_dir = "personal_images/";

        private $uploadOk = 1;

        private $target_file = null;

        private $files = null;

        public function __construct($files, $umid, $db_link){
            $this->files = $files; 

            $this->target_file = $this->target_dir . sha1(time(). basename($this->files["image"]["name"]));

            $imageFileType = strtolower(pathinfo(basename($this->files["image"]["name"]),PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
            echo '<pre>';
            var_dump($this->files);
                echo $this->files["image"]["tmp_name"] ."<br />";
                $check = getimagesize($this->files["image"]["tmp_name"]);
                if($check !== false) {
                    // echo "File is an image - " . $check["mime"] . ".";
                    $this->uploadOk = 1;
                } else {
                     echo "File is an image - " . $check["mime"] . ".";
                    throw new Exception("Bestand is geen plaatje");
                    $this->uploadOk = 0;
                }
            
            // Check if file already exists
            if (file_exists($this->target_file)) {
                throw new Exception("Bestand bestaat al");
                $this->uploadOk = 0;
            }
            // Check file size
            if ($this->files["image"]["size"] > 4000000) {
                throw new Exception("Bestand is te groot > 4MB");
                $this->uploadOk = 0;
            }
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                echo "exten";
                throw new Exception("Bestand is geen plaatje");
                $this->uploadOk = 0;
            }
            // Check if $this->uploadOk is set to 0 by an error
            if ($this->uploadOk == 0) {
                throw new Exception("Bestand word niet geupload");
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($this->files["image"]["tmp_name"], $this->target_file)) {
                    // echo "The file ". basename( $this->files["image"]["name"]). " has been uploaded.";


                        $qry = $db_link->prepare("INSERT INTO users_models_images (umg_id, um_id, upload_date, image_path) 
                                                VALUES (NULL, :umid, :upload_date,:image_path)");
                        $qry->execute(array(':umid'=>$umid, 
                                             ':upload_date'=>time(),
                                                ':image_path'=>$this->target_file));

                } else {
                    throw new Exception("Algemene error");
                }
            
            }


            return true;
        }               
                        
                        
                        





    }
?>
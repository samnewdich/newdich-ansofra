<?php
namespace NewdichFiles;
use NewdichSchema\Settings;

class Upload{
    private $filesUploading;
    private $uploadDir = Settings::UPLOAD_DIRECTIORY; //folder where the files will be uploaded to
    
    //NOTE: THE REQUEST COMING MUST NOT COME VIA DTO, IT MUST COME AS NORMAL REQUEST DIRECTLY TO THE CONTROLLER
    //THEN FROM THE CONTROLLER, THE REQUEST COMES HERE.
    //CHECK THE DIRECTORY Controller/App/UploadExampleController.php TO SEE EXAMPLE OF HOW THE CONTROLLER FOR UPLOADING FILES SHOULD BE
    public function __construct(array $filesUploading){
        $this->filesUploading = $filesUploading;
        //NOTE THE FILE(S) TO UPLOAD SHOULD COME AS AN ARRAY;
    }

    public function process(){
        // Configuration
        $uploadDir = $this->uploadDir;
        $maxFiles  = 20;
        $allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/webp',
            'image/gif',
            'video/mp4',
            'video/webm',
            'video/ogg'
        ];


        // Validate input
        if (count($this->filesUploading) < 1) {
            return json_encode([
                "status" => "failed",
                "response" => "No media files received"
            ], JSON_PRETTY_PRINT);
        }


        $files = $this->filesUploading; 

        // Count uploaded files
        $fileCount = count(array_filter($files['name'])); 
        

        if ($fileCount > $maxFiles) {
            return json_encode([
                "status" => "failed",
                "response" => "Maximum of {$maxFiles} files allowed"
            ], JSON_PRETTY_PRINT);
        }


        $uploadedFiles = [];
        $errors = [];


        for ($i = 0; $i < $fileCount; $i++) {

            if ($files['error'][$i] !== UPLOAD_ERR_OK) {
                $errors[] = "Error uploading file: " . $files['name'][$i];
                continue;
            }

            // Validate MIME type
            $tmpName = $files['tmp_name'][$i];
            $mimeType = mime_content_type($tmpName);

            if (!in_array($mimeType, $allowedTypes)) {
                $errors[] = "Invalid file type: " . $files['name'][$i];
                continue;
            }

            // Get extension safely
            $extension = pathinfo($files['name'][$i], PATHINFO_EXTENSION);

            // Generate unique file name
            $newName = uniqid("media_", true) . "." . $extension;

            $destination = $uploadDir . $newName;

            if (move_uploaded_file($tmpName, $destination)) {
                $uploadedFiles[] = $newName;
            } else {
                $errors[] = "Failed to move file: " . $files['name'][$i];
            }
        }

        
        if(count($uploadedFiles) > 0){
            return json_encode([
                "status"=>"success",
                "response"=>$uploadedFiles
            ], JSON_PRETTY_PRINT);
            //array of the files that was uploaded was sent back
        }
        else{
            return json_encode(array("status"=>"failed", "response"=>$errors), JSON_PRETTY_PRINT);
        }
    }
}
?>
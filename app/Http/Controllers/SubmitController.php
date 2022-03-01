<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubmitController extends Controller
{
    public function submit(Request $request){
        $request->validate(
            [
                'zip_file' => 'required|file|mimes:zip',
                'type'=>"required|string",
            ]
        );
        $submission_folder = uniqid();
        $message = "";
        if($request->hasFile("zip_file")){
            $zip = new \ZipArchive();
            $file = $request->file("zip_file");
            $res  = $zip->open($file->path());
            $filesInside = [];
            if ($res === TRUE) {
                $path_to_jplag = env("JPLAG_PATH");
                $submission_root_folder = public_path("submissions");
                mkdir(public_path("submissions/$submission_folder"));
                $extract_dir_path = public_path("submissions/$submission_folder");
                $zip->extractTo($extract_dir_path);
                $zip->close();
                $submission_root_folder = str_replace("\\","/", $submission_root_folder);
                $extract_dir_path = str_replace("\\", "/", $extract_dir_path);
                $x = shell_exec("java -jar $path_to_jplag -r $submission_root_folder/$submission_folder-results -m 99999 -l $request->type -s $extract_dir_path/*");
                $errors = ["Error: Not enough valid submissions!"];
                if(strpos($x,$errors[0])){
                    $message = "Error: Not enough valid submissions!<br>Check submission type";
                }
            } else {
                return FALSE;
            }
        }else{
            dd("x");
        }
        if(strlen($message) > 0 ){
            return redirect()->back()->with(["message" => $message]);
        }else{
            return redirect()->back()->with(["unique_id" => $submission_folder]);
        }
    }
}

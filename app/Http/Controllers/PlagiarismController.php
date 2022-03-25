<?php


namespace App\Http\Controllers;
session_start();
use Illuminate\Http\Request;
use File;
use ZipArchive;
use Illuminate\Filesystem\Filesystem;
use App\Models\Questions;
use App\Models\Submission;
class PlagiarismController extends Controller
{
    // To Do
    // Pass The assignment name as parameter
    // At some time move Distinct submissions to Plagiarism folder
    // Pass The parameters of the Run Plagiarism Button 
    // Result Folder didn't generate

    public function formZip()
    {
        $zip = new ZipArchive;
   
        $fileName = 'Assignment.zip';
   
        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
        {
            $files = File::files(public_path('Plagiarism'));
   
            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip->addFile($value, $relativeNameInZipFile);
            }
            
             
            $zip->close();
        }

        File::move(public_path($fileName), public_path('PlagiarismZipped/'.$fileName));

        $file = new Filesystem;
        $file->cleanDirectory(public_path('Plagiarism'));
    }

    public function run_plag($zipPath, $type, $question_id){
        $zipPath = public_path("PlagiarismZipped/Assignment.zip");
        $type = 'java17';
        $submission_folder = uniqid();
        // $submission_folder = "bodda";


        

        $question = Questions::with('assignment')->find($question_id);
        $assignment_name = $question->assignment->name;
        $question_name = $question->name;

        $submission_dir = public_path('assignment_submissions/'.$assignment_name.'/'.$question_name);
        $destination_dir = public_path('PlagiarismZipped/');
        mkdir($destination_dir.'/'.$submission_folder);
        // copy();
        // File::copyDirectory($submission_dir,$destination_dir.'/'.$submission_folder);

        $subs = Submission::latest()->get()->unique('user_id');

        foreach($subs as $sub) {
            File::copy(public_path($sub->submitted_code), $destination_dir.'/'.$submission_folder.'/'.$sub->id.'.java');
        }



        // dd($submission_dir);
        $message = "";
        if(true){
            $zip = new \ZipArchive();
            $res = $zip->open($zipPath);
            $filesInside = [];
            if ($res === TRUE) {
                $path_to_jplag = env("JPLAG_PATH");
                $submission_root_folder = public_path("submissions");
                mkdir(public_path("submissions/$submission_folder"));
                $extract_dir_path = $destination_dir.'/'.$submission_folder;
                // $zip->extractTo($extract_dir_path);
                // $zip->close();
                $submission_root_folder = str_replace("\\","/", $submission_root_folder);
                $extract_dir_path = str_replace("\\", "/", $extract_dir_path);
                $x = shell_exec("java -jar $path_to_jplag -r $submission_root_folder/$submission_folder-results -m 99999 -l $type -s $extract_dir_path");
                dd($x);
                $_SESSION['plag'] = $submission_root_folder.'/'.$submission_folder.'-results/';
                
                $_SESSION['plag'] = file_get_contents($_SESSION['plag'].'match3-link.html');
                $errors = ["Error: Not enough valid submissions!"];
                if(strpos($x,$errors[0])){
                    $message = "Error: Not enough valid submissions!<br>Check submission type";
                }
                return redirect()->back()->with('success','Plagiarism Done');
            } else {
                return FALSE;
            }
        }else{
            dd("x");
        }
        // if(strlen($message) > 0 ){
        //     return redirect()->back()->with("Plagiarism Detection Is Succuss");
        // }else{
        //     return redirect()->back()->with(["unique_id" => $submission_folder]);
        // }
    }

    public function plagiarism_report() {
        return view('admin.plagiarism-report');
    }
}

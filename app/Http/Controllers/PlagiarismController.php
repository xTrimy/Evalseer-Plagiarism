<?php


namespace App\Http\Controllers;
session_start();

use App\Models\PlagiarismReport;
use Illuminate\Http\Request;
use File;
use ZipArchive;
use Illuminate\Filesystem\Filesystem;
use App\Models\Questions;
use App\Models\Submission;
use Illuminate\Support\Facades\DB;

class PlagiarismController extends Controller
{
    // ? To Do
    // Pass The assignment name as parameter
    // At some time move Distinct submissions to Plagiarism folder
    // Pass The parameters of the Run Plagiarism Button 
    // Result Folder didn't generate

    public function formZip()
    {
        $zipPath = " ";

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

    public function run_plag($zipPath, $type, $question_id) {

        $zipPath = public_path("PlagiarismZipped/Assignment.zip");
        $lang = 'c/c++';
        $submission_folder = uniqid();

        $report_path = "";
        // $submission_folder = "bodda";

        $question = Questions::with('assignment')->find($question_id);
        $assignment_name = $question->assignment->name;
        $question_name = $question->name;

        $submission_dir = public_path('assignment_submissions/'.$assignment_name.'/'.$question_name);
        $destination_dir = public_path('PlagiarismZipped/');
        mkdir($destination_dir.'/'.$submission_folder);
        // copy();
        // File::copyDirectory($submission_dir,$destination_dir.'/'.$submission_folder);

        $subs = Submission::latest()->where('question_id',$question_id)->get()->unique('user_id');

        foreach($subs as $sub) {
            File::copy(public_path($sub->submitted_code), $destination_dir.'/'.$submission_folder.'/'.$sub->id.'.'.$type);
        }

        // dd($submission_dir);
        $message = "";
        if(true){
            $zip = new \ZipArchive();
            $res = $zip->open($zipPath);
            $filesInside = [];
            $filesInside = scandir($destination_dir.'/'.$submission_folder, 1);
            $filesCount = count($filesInside);
            $filesCount -= 3;
            if ($res === TRUE) {
                $path_to_jplag = env("JPLAG_PATH");
                $submission_root_folder = public_path("submissions");
                mkdir(public_path("submissions/$submission_folder"));
                $extract_dir_path = $destination_dir.'/'.$submission_folder;
                // $zip->extractTo($extract_dir_path);
                // $zip->close();
                $submission_root_folder = str_replace("\\","/", $submission_root_folder);
                $extract_dir_path = str_replace("\\", "/", $extract_dir_path);
                $x = shell_exec("java -jar $path_to_jplag -r $submission_root_folder/$submission_folder-results -m 99999 -l $lang -s $extract_dir_path");
                $_SESSION['plag'] = $submission_root_folder.'/'.$submission_folder.'-results/';
                $report_path = $submission_root_folder.'/'.$submission_folder.'-results/index.html';
                $errors = ["Error: Not enough valid submissions!"];
                if(strpos($x,$errors[0])){
                    $message = "Error: Not enough valid submissions!<br>Check submission type";
                }

                $date = date('Y/m/d h:i:s', time());
                
                for($i=0;$i<=$filesCount;$i++) {
                    $ext = '.'.$type;
                    $filesInside[$i] = str_replace($ext,"", $filesInside[$i]);
                    $report_path = str_replace("/", "\\", $report_path);
                    $report_path = str_replace(public_path(),"",$report_path);
                    $report_path = $submission_folder."-results";
                    DB::table('plagiarism_reports')->insert([
                        'id' => null,
                        'question_id' => $question_id,
                        'submission_id' => $filesInside[$i],
                        'report' => $report_path,
                        'created_at' => $date,
                        'updated_at' => $date
                    ]);

                    $submi = Submission::find($filesInside[$i]);
                    $submi->plagiarism = $report_path;
                    $submi->save();
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

    public function report($report) {
        $report = $report;
        return view('admin.report',['report'=>$report]);
    }

    public function check_submissions_plagiarism($id){
        $question = Questions::with(['assignment','programming_language'])->findOrFail($id);
        $lang = $question->programming_language->acronym;
        if($lang == "c++"){
            $lang = "cpp";
        }
        $lang = strtolower($lang);

        $directory = public_path('assignment_submissions/'.$question->assignment->name.'/'.$question->name);
        $python = env('PYTHON_EXE_PATH');
        $plagiarism_checker = env('SCOSS_PLAGIARISM_CHECKER');
        $results = shell_exec($python." ". $plagiarism_checker. " -l $lang -p \"$directory\" 2>&1");
        $results = json_decode($results);
        if($results)
        foreach($results as $result){
            $source1 = $result->source1;
            $source2 = $result->source2;
            $source1 = str_replace(public_path(),'',$source1);
            $source2 = str_replace(public_path(), '', $source2);
            $source1 = str_replace('\\', '/', $source1);
            $source2 = str_replace('\\', '/', $source2);
            $submission1 = Submission::where('submitted_code',$source1)->first();
            $submission2 = Submission::where('submitted_code', $source2)->first();
            if($submission1){
                $check_plagiarism_report_exists = PlagiarismReport::where('source_1',$source1)->where('source_2',$source2)->first();
                if(!$check_plagiarism_report_exists){
                    $plagiarism_report = new PlagiarismReport();
                    $plagiarism_report->submission_id = $submission1->id;
                    $plagiarism_report->question_id = $question->id;
                    $plagiarism_report->report = "";
                    $plagiarism_report->source_1 = $source1;
                    $plagiarism_report->source_2 = $source2;
                    $plagiarism_report->score = serialize($result->scores);
                    $plagiarism_report->save();
                }
            }
            if ($submission2) {
                $check_plagiarism_report_exists = PlagiarismReport::where('source_1', $source2)->where('source_2', $source1)->first();
                if (!$check_plagiarism_report_exists) {
                    $plagiarism_report = new PlagiarismReport();
                    $plagiarism_report->submission_id = $submission2->id;
                    $plagiarism_report->question_id = $question->id;
                    $plagiarism_report->report = "";
                    $plagiarism_report->source_1 = $source2;
                    $plagiarism_report->source_2 = $source1;
                    $plagiarism_report->score = serialize($result->scores);
                    $plagiarism_report->save();
                }
            }
        }
        return redirect()->back()->with('success',"Plagiarism reports generated");
    }

    public function compare_files($id){
        $plagiarism_report = PlagiarismReport::with('question.programming_language')->findOrFail($id);
        $source1 = public_path($plagiarism_report->source_1);
        $source2 = public_path($plagiarism_report->source_2);
        $lang = $plagiarism_report->question->programming_language->acronym;
        $lang = strtolower($lang);
        if($lang == "c++") {
            $lang = "cpp";
        }
        $python = env('PYTHON_EXE_PATH');
        $compare_files = env("FILES_COMPARER");
        $result = shell_exec("$python $compare_files -l \"$lang\" -f \"$source1\" -s \"$source2\" 2>&1");
        $data = ["similarities"=>[]];
        if($result)
            $data = json_decode($result);
        return view('instructor.compare-code',["data"=>$data,'s1'=> $plagiarism_report->source_1,'s2'=> $plagiarism_report->source_2,'scores'=> $plagiarism_report->score]);
    }

    public function view_plagiarism_reports() {
        // $plagiarism_reports = PlagiarismReport::with('questions.*')->get();

        $plagiarism_reports = DB::table('plagiarism_reports')
                            // ->where('id',$question_id)
                            ->leftJoin('questions', 'plagiarism_reports.question_id', '=', 'questions.id')
                            ->select('plagiarism_reports.*','questions.name')
                            ->get();
        // dd($plagiarism_reports);
        return view('instructor.view-plagiarism-reports',['plagiarism_reports'=>$plagiarism_reports]);
    }
}

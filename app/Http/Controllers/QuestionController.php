<?php
namespace App\Http\Controllers;
session_start();
use App\Models\Assignments;
use App\Models\GradingCriteria;
use App\Models\ProgrammingLanguage;
use App\Models\QuestionFeature;
use App\Models\Questions;
use App\Models\QuestionTestCases;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RuntimeException;
use Illuminate\Support\Facades\DB;
use stdClass;
use File;

class QuestionController extends Controller
{
    private $grading_criterias = [
        'compiling',
        'styling',
        // 'logic',
        'not_hidden_test_cases',
        // 'hidden_test_cases',
        'features',
    ];
    public function add($id){

        $assignment = Assignments::with('course.programming_languages')->find($id);
        $programming_languages = ProgrammingLanguage::all();
        return view('instructor.add-question',["programming_languages"=>$programming_languages,"assignment"=>$assignment,'grading_criterias'=>$this->grading_criterias]);
    }
    public function store(Request $request){
        $request->validate([
            'assignment_id'=>"required|exists:assignments,id",
            'name'=>"required|string",
            'description' => "required|string",
            'grade' => "required|numeric",
            'input' => "nullable|array",
            'output' => "nullable|array",
            'programming_language' => "required|exists:programming_languages,id",
            'main_file' => "nullable",
            'base_skeleton' => "nullable|string",
        ]);
        $total_grading_criteria=0;
        foreach($this->grading_criterias as $grading_criteria){
            $total_grading_criteria += $request[$grading_criteria];
        }
        if($total_grading_criteria != 100){
            return redirect()->back()->with('error','Total grading criteria percentage must be "100%"')->withInput();
        }
        $question = new Questions();
        $question->name = $request->name;
        $question->assignment_id = $request->assignment_id;
        $question->description = $request->description;
        $question->grade = $request->grade;
        $question->programming_language_id = $request->programming_language;
        if($request->hasFile('main_file')){
            $filenameWithExt = $request->file('main_file')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('main_file')->getClientOriginalExtension();
            $fileNameToStore = $filename . '.' . $extension;
            $path = $request->file('main_file')->storeAs('public/file', $fileNameToStore);
            $path = public_path('main_files/'. time());
            $request->file('main_file')->move($path , $fileNameToStore);
            $NameToStore = $path.'/'.$fileNameToStore;
            $NameToStore = str_replace(public_path(), '', $NameToStore);
            $NameToStore = str_replace('\main_files', '', $NameToStore);
            $question->main_file = $NameToStore;
        }
        if(strlen($request->base_skeleton) > 5 ){
            $question->skeleton = $request->base_skeleton;
        }
        $question->save();
        $i = 0;
        foreach($request->input as $input){
            //skipping first hidden inputs
            if($i>0){
                $question_test_case = new QuestionTestCases();
                $question_test_case->inputs = $input;
                $question_test_case->output = $request->output[$i];
                $question_test_case->question_id = $question->id;
                $question_test_case->save();
            }
            $i++;
        }
        $i=0;
        foreach ($request->feature as $feature) {
            //skipping first hidden inputs
            if ($i > 0) {
                $feature = explode(",",$feature);
                foreach($feature as $splitted_feature){
                    $question_feature = new QuestionFeature();
                    $question_feature->feature = $splitted_feature;
                    $question_feature->occurrences = $request->occurrences[$i];
                    $question_feature->question_id = $question->id;
                    $question_feature->save();
                }
            }
            $i++;
        }
        if(count($this->grading_criterias)>0){
            $grading_criteria_record = new GradingCriteria();
            foreach ($this->grading_criterias as $grading_criteria) {
                $grading_criteria_record["${grading_criteria}_weight"] = $request["${grading_criteria}"];
            }
            $grading_criteria_record->question_id = $question->id;
            $grading_criteria_record->save();
        }
        return redirect()->back()->with('success',"Question added successfully");
    }

    /**
     * Save student submission file(s) when uploading an answer
     * Returns Submission File Path
     * 
     * @param  Request  $request
     * @param  Question  $question
     * @param  Submission  $submission
     * @return string
     *
     */
    public function save_submission_file($file, $question, &$submission, $from_ide = false, $extension = "cpp") {
        $user_name = Auth::user()->name;
        $submission_number = count($question->submissions) + 1;
        if ($from_ide) {
            $assignment_submission_path = "/assignment_submissions/{$question->assignment->name}/{$question->name}/$user_name/$submission_number";
            $assignment_p = [];
            foreach(explode('/', $assignment_submission_path) as $directory){
                $assignment_p[] = $directory;
                if($directory != ""){
                    $directory_name = implode('/',$assignment_p);
                    if(!is_dir(public_path($directory_name))){
                        mkdir(public_path($directory_name));
                    }
                }
            }
            foreach($file as $f){
                $fileNameToStore = $f[0];
                $full_path = $assignment_submission_path . "/" . $fileNameToStore;
                file_put_contents(public_path($full_path), $f[1]);

            }
            $full_path = $assignment_submission_path . "/" . $file[0][0];
            $submission->submitted_code = $full_path;
        }else{
            $extension = $file->file('submission')->getClientOriginalExtension();
            $fileNameToStore = $file->file('submission')->getClientOriginalName();
            $assignment_submission_path = "/assignment_submissions/{$question->assignment->name}/{$question->name}/$user_name/$submission_number";
            $file->submission->move(public_path($assignment_submission_path), $fileNameToStore);

            if($question->main_file != null) {
                $main_file = $question->main_file;
                $main_file = public_path('main_files'.$main_file);
                // $main_file = str_replace("\\","/", $main_file);
                $main_to_file_path = public_path($assignment_submission_path)."";
                $file = basename($main_file); 
                // dd($main_file);
                File::copy($main_file, public_path($assignment_submission_path)."/".$file);
            }
            if ($extension != "zip") {
                $submission->submitted_code = $assignment_submission_path . '/' . $fileNameToStore;
                $submission->question_id = $question->id;
                return $assignment_submission_path;
            } else {
                $full_path = $assignment_submission_path . "/" . $fileNameToStore;
                // dd($full_path);
                // $this->compile_zip_file("java",$assignment_submission_path,$assignment_submission_path."/".$fileNameToStore);
                $submission->submitted_code = $full_path;
                $this->unZip($assignment_submission_path, $full_path);

                // $submission->submitted_code = $assignment_submission_path . '/main.java';
                $submission->question_id = $question->id;
                return $assignment_submission_path;
            }
        }
    }

    public function unZip(string $file_path,string $file) {
        $zip = new \ZipArchive();

        $file = public_path($file);
        $file = str_replace("\\","/", $file);
        $res = $zip->open($file);


        $file_path = public_path($file_path);
        $file_path = str_replace("\\","/", $file_path);
        $zip->extractTo($file_path);
        
        $zip->close();
    }
    

    public function compile_zip_file($language,string $file_path,string $file_directory) {
        $java_executable = env('JAVA_COMPILER_PATH');
        // $submission_folder = uniqid();
        // $zip = new \ZipArchive();
        // $res  = $zip->open($file_path);
        $filesInside = array();
        if (TRUE) {
            $submission_root_folder = public_path("zip_submissions");
            // mkdir(public_path("zip_submissions/$submission_folder"));
            // $extract_dir_path = public_path("zip_submissions/$submission_folder");
            // $zip->extractTo($extract_dir_path);
            // $zip->close();
            $submission_root_folder = str_replace("\\","/", $submission_root_folder);

            
            $extract_dir_path = $file_path;
            $extract_dir_path = str_replace("\\", "/", $extract_dir_path);


            $extract_dir_path = dirname($extract_dir_path);

            foreach(glob($extract_dir_path.'/*.*') as $file) {
                array_push($filesInside,$file);
            }

          

            $filesInside = scandir($extract_dir_path, 1);
            $filesCount = count($filesInside);
            $filesCount -= 3;
            
            // Check if the folder has a main.java (ToDo)
            
            // $extract_dir_path = str_replace(" ", "%", $extract_dir_path);
            $compiling_command = "$java_executable"." \"$extract_dir_path"."/main.java\" ";
            
            
            for($i=0;$i<=$filesCount;$i++) {
                $ext = substr($filesInside[$i], -4);
                if($filesInside[$i] != "main.java" && $ext == "java") {
                    $compiling_command .= "\"$extract_dir_path\\$filesInside[$i]\"";
                }
            }
            $compiling_command .= " 2>&1 ";
            // $compiling_command = "javac C:/xampp/htdocs/Evalseer-Plagiarism/public/assignment_submissions/Rectangle Problem/Rectangle Problem/Abdelrahman/7/main.java C:/xampp/htdocs/Evalseer-Plagiarism/public/assignment_submissions/Rectangle Problem/Rectangle Problem/Abdelrahman/7/Rectangle.java  2>&1 ";
            // dd($compiling_command);
            $output = shell_exec($compiling_command);
            // dd($output);
            return $output;
        } else {
            return FALSE;
        }
    }

    /**
     * Compile code file
     * Returns the compilation output
     *
     * @param  string  $language
     * @param  string  $file_path
     * @param  string  $file_directory
     * @param  bool    $run_file = false
     * @return string
     *
     * @throws RuntimeException
     */

    public function give_compiling_grade_to_submission($question, Submission &$submission, $compiler_feedback){
        $submission->compiling_grade = 0;
        if ($compiler_feedback == false || empty($compiler_feedback)) {
            // Give grade for compiling if the criteria exists
            if ($question->grading_criteria->last()) {
                if ($question->grading_criteria->last()->compiling_weight) {
                    //Grade = Grading_percentage/100 * Total_Grade
                    $submission->compiling_grade += $question->grading_criteria->last()->compiling_weight / 100 * $question->grade;
                    $submission->total_grade += $submission->compiling_grade;
                }
            }
        }
    }
    
    public function compile_file($language,string $file_path,string $file_directory, bool $run_file = false, $question, Submission &$submission) {
        $ext = substr($file_path, -4);
        // TODO: Make languages more dynamic
        if($language == 'c++'){
            $cpp_executable = env('CPP_EXE_PATH');
            $files = [];
            foreach(glob("$file_directory/*.cpp") as $file){
                array_push($files, '"'.$file.'"');
            }
            $output = shell_exec("$cpp_executable " . implode(" ",$files) . " -o \"" . $file_directory . "/output\" 2>&1");
            $this->give_compiling_grade_to_submission($question,$submission,$output);
            if(strlen($output) == 0){
                if($run_file){
                    $output = shell_exec(public_path($file_directory."/output")." 2>&1");
                    return $output;
                }
            }
            return $output;
        }else if($language == 'java'){
            if($ext == ".zip") {
                if($question->main_file != null) {
                } else {
                    
                }
                $output = $this->compile_zip_file($language,$file_path,$file_directory);
                return $output;
            } else {

                if($question->main_file != null) {
                    $java_executable = env('JAVA_COMPILER_PATH');
                    $main_file = $question->main_file;
                    $main_file = public_path('main_files'.$main_file);
                    $main_file_name = basename($main_file); 

                    $main_file_path = dirname($main_file);
                    $file_path_path = dirname($file_path);

                    $main_file = $file_path_path."/".$main_file_name;
                    $main_file = str_replace("\\", "/", $main_file);
                    // dd($main_file);
                    $output = shell_exec("javac ".$main_file);
                    // $output = shell_exec("$java_executable \"". $file_path . "\" 2>&1 ");
                    // dd($output);
                    $this->give_compiling_grade_to_submission($question, $submission, $output);
                    // dd($output);
                    return $output;
                } else {
                    $java_executable = env('JAVA_COMPILER_PATH');
                    $output = shell_exec("cd $file_directory && $java_executable *.java 2>&1 ");
                    if($output == ""){
                        $file_path = str_replace('\\','/',$file_path);
                        $file_path = str_replace('.java', '', $file_path);
                        $output = shell_exec("cd $file_directory && java  \"" . @end(explode('/',$file_path))  . "\" 2>&1 ");
                        $this->give_compiling_grade_to_submission($question, $submission, $output);
                    }
                    return $output;
                }
            }
        }else if($language == "PHP"){ //PHP code isn't compiled but at least we can check for syntax errors here
            $output = shell_exec("php -l \"" . $file_path . "\" 2>&1");
            if(strpos($output, "No syntax") !== false){
                $output = "";
            }
            $this->give_compiling_grade_to_submission($question, $submission, $output);
            if (strlen($output) == 0) {
                if ($run_file) {
                    $output = shell_exec("php \"" . $file_path . "\" 2>&1");
                    return $output;
                }
            }
            return $output;
        }
        else{
            throw new RuntimeException('Language '.$language.' is undefiened');
        }
    }
    /**
     * Run test cases on submission and return total test cases passed
     *
     * @param  array  $test_cases
     * @param  string  $file_directory
     * @param  Submission  $submission
     * @param  string  $language
     * @return int $number_of_test_cases_passed
     *
     */
    public function run_test_cases_on_submission($question, $test_cases,string $file_directory, Submission &$submission, $language = 'c++', $testing = false){
        if (count($test_cases) <= 0) {
            return 0;
        }
        $isZip = false;
        //Running Test Cases
        $number_of_test_cases_passed = 0;
        $total_excectution_time = 0;
        foreach ($test_cases as $test_case) {
            //Calculating runtime of the submitted program
            $start_time = microtime(true);
            if($testing){
                $test_case_file = public_path($file_directory . "/test_case_" . time());
                file_put_contents($test_case_file, $test_case["inputs"]);
            } else {
                $test_case_file = public_path($file_directory . "/test_case_" . $test_case->id);
                file_put_contents($test_case_file, $test_case->inputs);
            }
            if($language == "c++"){
                $output = shell_exec("\"" . public_path($file_directory) . "/output\" < \"" . $test_case_file . "\"");
                
            }else if($language == "PHP"){
                $output = shell_exec("php " . public_path($submission->submitted_code) . " < \"" . $test_case_file . "\"");
                
            }else if($language == "java"){
                $filesInside = scandir(public_path($file_directory), 1);
                for($i=0;$i<count($filesInside);$i++) {
                    $ext = substr($filesInside[$i], -3);
                    if($ext == "zip") {
                        $isZip = false;
                    }
                }

                if($isZip) {
                    $java_exe = env('JAVA_EXE_PATH');
                    $commandd = "cd \"".public_path($file_directory)."\" && $java_exe " . "javaapp.java"." < \"" . $test_case_file . "\"";
                    $output = shell_exec($commandd);
                } else {
                    $java_exe = env('JAVA_EXE_PATH');
                    $output = shell_exec("cd \"".public_path($file_directory)."\" && $java_exe " . @end(explode('/', str_replace('.java','',$submission->submitted_code)))." < \"" . $test_case_file . "\"");
                }
            }
            if($testing) {
                if ($output == $test_case["output"]) {
                    $number_of_test_cases_passed += 1;
                }
            }else{
                if ($output == $test_case->output) {
                    $number_of_test_cases_passed += 1;
                }
            }
            $submission->meta .= "\n" . $output;
            $end_time = microtime(true);
            $execution_time = ($end_time - $start_time);
            $execution_time = number_format((float)$execution_time, 4, '.', '');
            $total_excectution_time += $execution_time;
        }
        
        $avg_execution_time = $total_excectution_time / count($test_cases);
        $submission->execution_time = $avg_execution_time;
        if ($question->grading_criteria->last() && count($question->test_cases) > 0) {
            if ($question->grading_criteria->last()->not_hidden_test_cases_weight) {
                $number_of_test_cases = count($question->test_cases);
                //Give grade for Test Cases Passed:
                //Test_Cases_Grade = Passed_Test_Cases/Total_Test_Cases * Grading_Percentage_for_Test_Cases
                //Test_Cases_Grade_Total = Test_Cases_Grade/100 * Total_Grade
                $total_test_cases_grade = ($number_of_test_cases_passed / $number_of_test_cases) * $question->grading_criteria->last()->not_hidden_test_cases_weight;
                $total_test_cases_grade_total = $total_test_cases_grade / 100 * $question->grade;
                $submission->not_hidden_logic_grade = $total_test_cases_grade_total;
                $submission->total_grade += $submission->not_hidden_logic_grade;
            }
        }
        return $number_of_test_cases_passed;
    }
    public function edit($question_id){
        $questions = DB::table('questions')
        ->where('id',$question_id)
        // ->leftJoin('courses', 'assignments.course_id', '=', 'courses.id')
        ->select('questions.*')
        ->first();

       
        $assignment = Assignments::with('course.programming_languages')->find($questions->assignment_id);

        $test_cases = DB::table('question_test_cases')
        ->where('question_id',$question_id)
        ->select('question_test_cases.*')
        ->get();

        $grading_criterias = GradingCriteria::where('question_id',$questions->id)->get()->last();
        $programming_languages = ProgrammingLanguage::all();
        return view('admin.edit-question',["grading_crit"=> $grading_criterias,"test_cases"=>$test_cases,"programming_languages"=>$programming_languages,'questions'=>$questions,'assignment'=>$assignment,'grading_criterias'=>$this->grading_criterias]);
        // return redirect()->back()->with('success',"Question Edited successfully");
    }

    public function edit_question(Request $request){
        // dd($request);

        $request->validate([
            // 'assignment_id'=>"required|exists:assignments,id",
            'name'=>"required|string",
            'description' => "required|string",
            'grade' => "required|numeric",
            // 'input' => "nullable|array",
            // 'output' => "nullable|array",
        ]);
        $total_grading_criteria=0;
        // foreach($this->grading_criterias as $grading_criteria){
        //     $total_grading_criteria += $request[$grading_criteria];
        // }
        foreach ($this->grading_criterias as $grading_criteria) {
            echo ($grading_criteria); echo ($request[$grading_criteria]);
            $total_grading_criteria += $request[$grading_criteria];
        }
        if($total_grading_criteria != 100){
            return redirect()->back()->with('error','Total grading criteria percentage must be "100%"')->withInput();
        }
        $question = Questions::find($request->question_id);
        $question->name = $request->name;
        $question->assignment_id = $request->assignment_id;
        $question->description = $request->description;
        $question->grade = $request->grade;
        $question->save();
        $i = 0;
        foreach($request->input as $input){
            if($i>0){
                $question_test_case = new QuestionTestCases();
                $question_test_case->inputs = $input;
                $question_test_case->output = $request->output[$i];
                $question_test_case->question_id = $question->id;
                $question_test_case->save();
            }
            $i++;
        }
        $i=0;
        foreach ($request->feature as $feature) {
            //skipping first hidden inputs
            if ($i > 0) {
                $feature = explode(",",$feature);
                foreach($feature as $splitted_feature){
                    $question_feature = new QuestionFeature();
                    $question_feature->feature = $splitted_feature;
                    $question_feature->occurrences = $request->occurrences[$i];
                    $question_feature->question_id = $question->id;
                    $question_feature->save();
                }
            }
            $i++;
        }
        if (count($this->grading_criterias) > 0) {
            $grading_criteria_record = new GradingCriteria();
            foreach ($this->grading_criterias as $grading_criteria) {
                $grading_criteria_record["${grading_criteria}_weight"] = $request["${grading_criteria}"];
            }
            $grading_criteria_record->question_id = $question->id;
            $grading_criteria_record->save();
        }
        return redirect()->back()->with('success',"Question Edited Successfully");
    }
    private function run_basic_compiling_error_checker(&$compiler_feedback, Submission &$submission, $language = 'c++' ){
        if($language == "c++"){
            $evalseer_feedback = shell_exec(env('BASIC_SYNTAX_PY') . " \"" . public_path($submission->submitted_code) . "\" 2>&1");
			
			$evalseer_feedback = json_decode($evalseer_feedback, true);
			
			if($evalseer_feedback["status"] == "success"){
                return true;
                $compiler_feedback["basic_checking"] = false;
            } else {
                $compiler_feedback["basic_checking"][] = $evalseer_feedback;
                return false;
            }
        }
        $evalseer_feedback['status'] = "success";
        return true;
    }

    public function style_check(Submission &$submission, $assignment_submission_path, $lang="c++", $filter_file_name = false){
        $python = env("PYTHON_EXE_PATH");
        if ($lang == "java") {
            $javafb = shell_exec("java -jar " . env("CHECKSTYLE_PATH") . " -c" . env("SUNCHECKS_PATH") . " \"" . public_path(str_replace('/', '/', $submission->submitted_code)) . "\" 2>&1");
            $javafb = str_replace(public_path(), '', $javafb);
            $javafb = str_replace('\\', '/', $javafb);
            $javafb = str_replace($submission->submitted_code, '', $javafb);
            $javafb = str_replace('[ERROR] ', '', $javafb);
            $javafb = str_replace('Starting audit...', '', $javafb);
            $javafb = str_replace('Audit done.', '', $javafb);
            $javafb = str_replace('Checkstyle ends with ', '', $javafb);
            $submission->style_feedback = $javafb;
            return $javafb;
        } else if ($lang == "c++") {
            $stylefb = shell_exec($python . " " . public_path('/cpplint-file/cpplint.py') . " \"" . public_path(str_replace('/', '/', $submission->submitted_code)) . "\" 2>&1");
            if(!$filter_file_name)
            $stylefb = str_replace(public_path(str_replace("/", "\\", $assignment_submission_path)), '', $stylefb);
            $stylefb = str_replace(public_path($submission->submitted_code), '', $stylefb);
            $stylefb = str_replace('Done processing', '', $stylefb);
            $submission->style_feedback = $stylefb;
            return $stylefb;
        } else if($lang == "PHP"){
            $stylefb = shell_exec("php" . " " . env("CHECKSTYLE_PHP_PATH") . 
            " \"" . public_path(str_replace('/', '/', $submission->submitted_code)) 
            . "\" text cleancode 2>&1");
            //text & cleancode arguemenets can be changed, refer to `php phpmd.phar --help`
            $stylefb = str_replace(public_path(), '', $stylefb);
            $stylefb = str_replace(str_replace('/','\\',strtolower($submission->submitted_code)), '', $stylefb);
            $stylefb = str_replace(public_path($submission->submitted_code), '', $stylefb);
            $submission->style_feedback = $stylefb;
        } else {
            $submission->style_feedback = "No Style Feedback";
            return redirect()->back()->with('error', "This question has not been configured correctly, please refer to your instructor");
        }
    }

    public function run_feature_checking_on_submission($question, $submission){
        $count_features_passed = 0;
        foreach ($question->features as $feature) {
            $feature_text = $feature->feature;
            if (strpos($feature_text, 'regex:') === 0) {
                $file = (file_get_contents(public_path($submission->submitted_code)));
                $feature_text = str_replace('regex:', "", $feature_text);
                $count_occur = preg_match_all("/" . $feature_text . "/im", $file);
                if ($count_occur == $feature->occurrences) {
                    $count_features_passed++;
                }
            }
        }

        if ($question->grading_criteria->last()->features_weight && count($question->features) > 0) {
            $number_of_features = count($question->features);
            $feature_passed_grade = ($count_features_passed / $number_of_features) * $question->grading_criteria->last()->features_weight;
            $total_features_grade_total = $feature_passed_grade / 100 * $question->grade;
            if($count_features_passed != $number_of_features){
                $submission->feature_feedback = "You didn't get the code features full grades. Please follow the question description and try again";
            }
            $submission->features_grade = $total_features_grade_total;
            $submission->total_grade += $submission->features_grade;
        }

        return $count_features_passed;
    }
    public function student_submit(Request $request){
        $request->validate([
            'question_id'=>'required|exists:questions,id',
            'submission'=>'file|required'
        ]);
        $question = Questions::with(['programming_language','assignment','submissions', 'test_cases','features', 'grading_criteria'])->find($request->question_id);
        $submission = new Submission();
        $assignment_submission_path = $this->save_submission_file($request, $question, $submission);
        if($question->programming_language == null){
            return redirect()->back()->with('error', "This question has not been configured correctly, please refer to your instructor");
        }
        $lang = $question->programming_language->acronym;
        $output_1 = $this->compile_file($lang, public_path($submission->submitted_code), public_path($assignment_submission_path),false,$question,$submission);
        // dd($submission->submitted_code);

        // ! To Be Changed
        // $submission->submitted_code = $_SESSION['submited_code'];

        $compiler_feedback = false;
        
        /**  
         * *Saving compiler error if exists
         * Check if compiler throws any errors
         * 
        **/
        // dd($output_1);
        if($output_1 != null || strlen($output_1)>0) {
            $output_1 = str_replace(public_path($submission->submitted_code),'',$output_1);
            $compiler_feedback = [];
            $compiler_feedback["compiler_feedback"] = $output_1;
            
            $basic_syntax_checking = $this->run_basic_compiling_error_checker($compiler_feedback,$submission, $lang);

            if($lang == "c++"){
                $evalseer_feedback = shell_exec(env('SYNTAX_CORRECTION_PY')." \"". public_path($submission->submitted_code) . "\" 2>&1");
                $evalseer_feedback = json_decode($evalseer_feedback,true);
                foreach ($evalseer_feedback as $key => $value){
                    $compiler_feedback[$key] =$value;
                }
                if($compiler_feedback["status"] == "success"){
                    $corrected_code_path = public_path($assignment_submission_path)."/fixed.cpp";
                    $file = fopen($corrected_code_path,'w');
                    fwrite($file,$compiler_feedback["solution"]);
                    fclose($file);
                    $cpp_executable = env('CPP_EXE_PATH');
                    $output_1 = shell_exec("$cpp_executable \"" . $corrected_code_path . "\" -o \"" . public_path($assignment_submission_path) . "/output\" 2>&1");
                }
            }
            $submission->compile_feedback = json_encode($compiler_feedback);
        }
        
        //style_feedback
        $this->style_check($submission, $assignment_submission_path, $lang);

        //If no compiler error (The output file won't exist unless no errors found)
        

        //Calculating feature grade
        $count_features_passed = $this->run_feature_checking_on_submission($question,$submission);
        
        $number_of_test_cases_passed = $this->run_test_cases_on_submission($question, $question->test_cases, $assignment_submission_path,$submission, $lang);
        $number_of_test_cases = count($question->test_cases);
        $submission->logic_feedback = "Number of Test Cases Passed: $number_of_test_cases_passed/$number_of_test_cases";
       

        $submission->user_id = Auth::user()->id;
        $submission->is_blocked = false;
        $submission->save();
        
        return redirect()->back()->with('question_'.$request->question_id,"Answer Submitted for {$question->name}");
    }

    public function delete_question($question_id){
        $question = Questions::find($question_id);
        $question->delete();

        return redirect()->back()->with('success',"Question deleted successfully");
    }

    public function fetch_external_plagiarism_files(Request $request){
        $keyword = $request->only('keyword')["keyword"];
        $python = env("PYTHON_EXE_PATH");
        $searcher_path = env("EXTERNAL_SOURCE_CODE_SEARCHER_PY");
        $files = shell_exec($python . " $searcher_path \"$keyword\" 2>&1");
        if(json_decode($files) != null){
            return json_decode($files);
        }
        return ["error"=>"Something went wrong"];
    }
}

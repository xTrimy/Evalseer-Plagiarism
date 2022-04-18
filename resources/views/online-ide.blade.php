@extends('layout.app')
@section('title')
IDE
@endsection
@section('content')
    <canvas id="confetti" class="hidden z-50 w-full h-full fixed top-0 left-0"></canvas>
   <div class="flex pb-12" style="min-height: 500px;max-height: 700px;">
    <div class="w-1/3 px-8 overflow-y-auto ">
        <h1 class="text-2xl font-bold">Question: {!! $question->name !!}</h1>
        <p>{!! $question->description !!}</p>
    </div>
        <div class="w-2/3 relative ">
            <div class="w-full flex bg-slate-600">
                <div class="flex overflow-x-auto">
                    <div data-file-order="1" class="flex items-center relative file_tab py-2 px-4 cursor-pointer bg-slate-800 hover:bg-slate-800 border-b-2 text-white border-b-orange-500">
                        <div class="icon w-6 h-6 mr-2"></div>
                        <div class="file_name">Main.php</div>
                        <input type="text" class="border-0 hidden absolute bg-transparent w-1/2 ml-8 p-0">
                    </div>
                </div>
                
                <div id="add_file_button" class="current_file_tab flex file_tab py-4 px-4 bg-slate-700 hover:bg-green-800 cursor-pointer  text-white">
                    <i class="las la-plus"></i>
                </div>
            </div>
            <div class="w-full h-full">
                <div onkeydown="editor_keyboard_shortcuts(event,this,0)" onkeyup="editor_keyboard_shortcuts(event,this,1)" id="editor" class="w-full h-5/6">
                    <div id="editor-1" class="current_editor ace_file_editor w-full h-full">{{ $question->skeleton }}</div>
                </div>
                <div id="bottom_bar" class="h-1/6">
                    <div class=" w-full py-2 bg-gray-500 left-0 flex px-4 justify-end items-center">
                        <div class="flex-1 text-white">
                            <div class="flex">
                                <button id="output_button" class="bg-gray-600 hover:bg-gray-700 mr-2 py-2 px-4" data-active="false" onclick="show_close_output(this)">
                                    Output <i class="las la-caret-down text-lg "></i>
                                </button>
                                <button id="test_cases_window_button" class=" bg-gray-600  hover:bg-gray-700 mr-2 py-2 px-4" onclick="show_close_output(this, 2)" data-active="false">Test Cases <i class="las la-caret-down text-lg "></i></button>
                                <button  id="test_cases" class="hidden text-green-500 bg-gray-600 hover:bg-gray-700 mr-2 py-2 px-4"></button>
                            </div>
                        </div>
                        <button onclick="run_code(this, false, false)" class="group bg-gray-200 relative overflow-hidden py-2 px-4 text-green-500 rounded-md hover:bg-gray-300">
                            <div class="loading group-disabled:block hidden absolute top-0 left-0 w-full h-full bg-gray-700 ">
                                <div class="lds-ring small"><div></div><div></div><div></div><div></div></div>
                            </div>
                            <i class="las la-play"></i> Run
                        </button>
                        <button  onclick="run_code(this, true, false)" class="group bg-blue-500 relative overflow-hidden py-2 px-4 ml-4 text-white rounded-md hover:bg-blue-600">
                            <div class="loading group-disabled:block hidden absolute top-0 left-0 w-full h-full bg-gray-700 ">
                                <div class="lds-ring small"><div></div><div></div><div></div><div></div></div>
                            </div>
                            <i class="las la-play"></i> Test
                        </button>
                        <button  onclick="run_code(this, true, true)" class="group bg-green-500 py-2 px-4 relative  text-white rounded-md ml-4 hover:bg-green-600">
                            <div id="not_submitted_pop_up" class="hidden absolute top-full mt-4 z-50 right-0 w-64 bg-gray-800">
                                Not Submitted
                            </div> 
                            <div id="submissions_pop_up" class="hidden group-hover:block absolute top-full mt-4 z-50 right-0 w-64 bg-gray-800">
                                {{ $question->assignment->submissions - count($question->submissions) }} Submissions Left
                            </div> 
                            <div class="loading rounded-md group-disabled:block hidden absolute top-0 left-0 w-full h-full bg-gray-700 ">
                                <div class="lds-ring small"><div></div><div></div><div></div><div></div></div>
                            </div>
                            <i class="las la-file-import"></i> Submit
                        </button>
                    </div>
                    <div id="test_cases_window" class=" relative hidden overflow-y-auto break-words h-full p-4 w-full bg-gray-700 text-white">
                        <h1 class="text-xl font-bold mb-4">Set question Test Cases</h1>
                        @php
                            $i=1;
                        @endphp
                        @foreach ($question->test_cases as $test_case)
                        <div class="mb-4">
                            <p class="font-bold">Test case <span class="test-case-number">{{ $i++ }}</span>:</p>
                            <label>
                                <span class="w-16 inline-block">Input</span>
                                <input type="text" value="{{ $test_case->inputs }}" class="bg-gray-600" name="input[]" id=""><br>
                            </label>
                            <label>
                                <span class="w-16 inline-block">Output</span>
                                <input type="text" value="{{ $test_case->output }}" class="bg-gray-600" name="output[]" id=""><br>
                            </label>
                        </div>
                        @endforeach
                    </div>
                    <pre id="results" class=" relative hidden overflow-y-auto break-words h-full p-4 w-full bg-gray-700 text-white">
                    </pre>
                </div>
                
            </div>
            
        </div>
        
   </div>
   <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <script src="{{ asset('ace/build/src/ace.js') }}" type="text/javascript" charset="utf-8"></script>
   <script src="{{ asset('ace/build/src/ext-language_tools.js') }}" type="text/javascript" charset="utf-8"></script>
   <script src="{{ asset('ace/build/src/ext-error_marker.js') }}" type="text/javascript" charset="utf-8"></script>
   <script>
        var ace_editor;
       window.onload=function(){
             ace_editor = ace.edit("editor-1");
            ace_editor.setTheme("ace/theme/monokai");
            @if ($question->programming_language->acronym == "HTML")
                ace_editor.session.setMode("ace/mode/html");
            @elseif ($question->programming_language->acronym == "c++")
                ace_editor.session.setMode("ace/mode/c_cpp");
            @elseif ($question->programming_language->acronym == "java")
                ace_editor.session.setMode("ace/mode/java");
            @elseif ($question->programming_language->acronym == "PHP")
                ace_editor.session.setMode("ace/mode/php");
            @endif
            ace_editor.setOptions({
                
                enableBasicAutocompletion: true,
                enableSnippets: true,
                enableLiveAutocompletion: true
            });
            // ace_editor.getSession().setAnnotations([{
            //     row: 1,
            //     column: 0,
            //     text: "Error Message", 
            //     type: "warning" //This would give a red x on the gutter
            // }]);
       }
        var test_cases_window_button = document.getElementById('test_cases_window_button');
        var test_cases_window = document.getElementById('test_cases_window');
 

        var editor = document.getElementById('editor');
        var results = document.getElementById('results');
        var bottom_bar = document.getElementById('bottom_bar');
        var output_window_button = document.getElementById('output_button');
        var myCanvas = document.getElementById('confetti');
        var myConfetti = confetti.create(myCanvas, {
        resize: true,
        useWorker: true
        });
        function show_close_output(e, window=1){
            if(e.getAttribute('data-active') == "false"){
                editor.classList.remove('h-5/6');
                editor.classList.add('h-3/6');
                if(window == 1){
                    results.classList.remove('hidden');
                    test_cases_window.classList.add('hidden');
                    test_cases_window_button.setAttribute('data-active',"false");

                    test_cases_window_button.querySelector('i').classList.remove('la-times-circle');
                    test_cases_window_button.querySelector('i').classList.add('la-caret-down');
                }
                else if(window == 2){
                    test_cases_window.classList.remove('hidden');
                    results.classList.add('hidden');
                    output_window_button.setAttribute('data-active',"false");

                    output_window_button.querySelector('i').classList.remove('la-times-circle');
                    output_window_button.querySelector('i').classList.add('la-caret-down');
                }
               
                bottom_bar.classList.remove('h-1/6');
                bottom_bar.classList.add('h-3/6');
                e.querySelector('i').classList.remove('la-caret-down');
                e.querySelector('i').classList.add('la-times-circle');
                e.setAttribute('data-active',"true");
            }else{
                editor.classList.add('h-5/6');
                editor.classList.remove('h-3/6');
                results.classList.add('hidden');
                test_cases_window.classList.add('hidden');
                bottom_bar.classList.add('h-1/6');
                bottom_bar.classList.remove('h-3/6');
                e.querySelector('i').classList.remove('la-times-circle');
                e.querySelector('i').classList.add('la-caret-down');
                e.setAttribute('data-active',"false");
            }
        }
        
        function run_code(e, testing=false, submitting=false){
            console.log(ace_editor);
            e.disabled = true;
            var inputs = $('input[name="input[]"]').map(function(){ 
                    return this.value; 
                }).get();
            var output =  $('input[name="output[]"]').map(function(){ 
                    return this.value; 
                }).get();
            console.log(inputs, output);
            var ace_editors_values = get_ide_editors_values();
            console.log(ace_editors_values);
            $.ajax({
                url:"{{ route('ide',$question->id) }}",
                method:"POST",
                data:{
                    _token:"{{ csrf_token() }}",
                    id:"{{ $question->id }}",
                    inputs:inputs,
                    output:output,
                    testing:testing,
                    submitting:submitting,
                    language:"{{ $question->programming_language->acronym }}",
                    code: ace_editors_values,
                },
                success: function(response){
                    
                    e.disabled = false;
                    if(output_window_button.getAttribute('data-active') == "false"){
                        show_close_output(output_window_button);
                    }
                    response = JSON.parse(JSON.stringify(response));
                    
                    document.getElementById('test_cases').classList.add('hidden');
                    document.getElementById('test_cases').classList.remove('text-green-500');
                    document.getElementById('test_cases').classList.remove('text-yellow-500');
                    document.getElementById('test_cases').classList.remove('text-red-500');
                    if(response["html"] == "true"){
                        $('#results').html('<iframe src="{{ asset("") }}'+response["html_file"]+'" width="100%" height="100%" scrolling="yes" id="myFrame"></iframe>');
                    }else{
                        $("#results").html(response["output"] );
                    }

                    if(response["testing"] == "true"){
                        console.log(response["no_submissions_left"]);
                        if(response["submitting"] == "false" || response["no_submissions_left"] == "true"){
                            document.getElementById('not_submitted_pop_up').classList.remove('hidden');
                            setTimeout(function(){
                                document.getElementById('not_submitted_pop_up').classList.add('hidden');
                            },3000);
                        }else{
                            var submissions_left = response["submissions_left"] + " Submissions Left";
                            document.getElementById('submissions_pop_up').innerHTML = submissions_left; 
                            document.getElementById('submissions_pop_up').classList.remove('hidden');
                            setTimeout(function(){
                                document.getElementById('submissions_pop_up').classList.add('hidden');
                            },3000);
                        }

                        $("#results").html("<span class='font-bold'>Test Cases Passed: " + response["test_cases_passed"] + "</span>" + "\n\n" + response["output"] );
                        if(response["full_marks"]){
                        document.getElementById('test_cases').classList.remove('hidden');
                        document.getElementById('test_cases').innerHTML = "All Test Cases Passed";
                        document.getElementById('test_cases').classList.add('text-green-500');
                        
                        myCanvas.classList.remove('hidden');
                        myConfetti({
                            particleCount: 100,
                            spread: 160
                            // any other options from the global
                            // confetti function
                        });
                        setTimeout(() => {
                            myCanvas.classList.add('hidden');
                        }, 2000);

                    
                        }else if(response["some_test_cases_failed"]){
                            document.getElementById('test_cases').classList.remove('hidden');
                            document.getElementById('test_cases').innerHTML = "Some Test Cases Passed";
                            document.getElementById('test_cases').classList.add('text-yellow-500');
                        }else if(response["all_test_cases_failed"]){
                            document.getElementById('test_cases').classList.remove('hidden');
                            document.getElementById('test_cases').innerHTML = "All Test Cases Failed";
                            document.getElementById('test_cases').classList.add('text-red-500');
                        }
                        }
                     var style_feedback = response["style_feedback"].split("\n:");
                     var annotations = [];
                     for(let i =0; i<style_feedback.length;i++){
                        let feedback = style_feedback[i].split(":");
                        let annotation = {
                            row: parseInt((feedback[0] == "")?feedback[1]:feedback[0])-1,
                            column: 0,
                            text: (feedback[0] == "")?feedback[2].split('[')[0]:feedback[1].split('[')[0], 
                            type: "warning" //This would give a yellow x on the gutter
                        };
                        annotations.push(annotation);
                     }
                     ace_editor.getSession().setAnnotations(annotations);
                     console.log(style_feedback);
                },
            });
        }
       
</script>

<script>
var message = "Are you sure you want to discard your progress?";
window.onbeforeunload = function(event) {
    var e = e || window.event;
    if (e) {
        e.returnValue = message;
    }
    return message;
};
</script>
@endsection
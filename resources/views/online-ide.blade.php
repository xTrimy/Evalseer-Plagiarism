@extends('layout.app')
@section('title')
IDE
@endsection
@section('content')
    <canvas id="confetti" class="hidden z-50 w-full h-full fixed top-0 left-0"></canvas>
   <div class="flex pb-12" style="min-height: 500px;max-height: 700px;">
    <div class="w-1/3 px-8 overflow-y-auto ">
        <h1 class="text-2xl font-bold">{!! $question->name !!}</h1>
        <p>{!! $question->description !!}</p>
    </div>
        <div class="w-2/3 relative ">

            <div class="w-full h-full">
                <div id="editor" class=" w-full h-5/6">
{{$question->skeleton}}
                </div>
                <div id="bottom_bar" class="h-1/6  overflow-hidden">
                    <div class=" w-full py-2 bg-gray-500 left-0 flex px-4 justify-end items-center">
                        <div class="flex-1 text-white">
                            <div class="flex">
                                <button id="output_button" class="bg-gray-600 hover:bg-gray-700 mr-2 py-2 px-4" data-active="false" onclick="show_close_output(this)">Output <i class="las la-caret-down"></i></button>
                                <button  class="hidden text-green-500 bg-gray-600 hover:bg-gray-700 mr-2 py-2 px-4">Test Cases Passed <span id="test_cases"> </span> </button>
                            </div>
                        </div>
                        <button onclick="run_code()" class="bg-blue-500 py-2 px-4 text-white rounded-md hover:bg-blue-600">
                            <i class="las la-play"></i> Run
                        </button>
                        <button class="bg-green-500 py-2 px-4 text-white rounded-md ml-4 hover:bg-green-600">
                             <i class="las la-file-import"></i> Submit
                        </button>
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
   <script>
        var ace_editor;
       window.onload=function(){
             ace_editor = ace.edit("editor");
            ace_editor.setTheme("ace/theme/monokai");
            ace_editor.session.setMode("ace/mode/c_cpp");
            // ace_editor.getSession().setAnnotations([{
            //     row: 1,
            //     column: 0,
            //     text: "Error Message", 
            //     type: "warning" //This would give a red x on the gutter
            // }]);
       }

        var editor = document.getElementById('editor');
        var results = document.getElementById('results');
        var bottom_bar = document.getElementById('bottom_bar');
        var output_window_button = document.getElementById('output_button');
        var myCanvas = document.getElementById('confetti');
        var myConfetti = confetti.create(myCanvas, {
        resize: true,
        useWorker: true
        });
        function show_close_output(e){
            if(e.getAttribute('data-active') == "false"){
                editor.classList.remove('h-5/6');
                editor.classList.add('h-3/6');
                results.classList.remove('hidden');
                bottom_bar.classList.remove('h-1/6');
                bottom_bar.classList.add('h-3/6');
                e.setAttribute('data-active',"true");
            }else{
                editor.classList.add('h-5/6');
                editor.classList.remove('h-3/6');
                results.classList.add('hidden');
                bottom_bar.classList.add('h-1/6');
                bottom_bar.classList.remove('h-3/6');
                e.setAttribute('data-active',"false");
            }
        }
        
        function run_code(){
            $.ajax({
                url:"{{ route('ide',$question->id) }}",
                method:"POST",
                data:{
                    _token:"{{ csrf_token() }}",
                    id:"{{ $question->id }}",
                    language:"cpp",
                    code: ace_editor.getSession().getValue(),
                },
                success: function(response){
                    if(output_window_button.getAttribute('data-active') == "false"){
                        show_close_output(output_window_button);
                    }
                    response = JSON.parse(JSON.stringify(response));
                    
                    $("#results").html("<span class='font-bold'>Test Cases Passed: " + response["test_cases_passed"] + "</span>" + "\n\n" + response["output"] );
                    if(response["full_marks"]){
                    document.getElementById('test_cases').parentElement.classList.remove('hidden');

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
@endsection
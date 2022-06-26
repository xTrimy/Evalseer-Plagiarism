<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Compare {{ $s1 }} to {{ $s2 }}</title>
</head>
<body>

    <div class="px-4 py-4">
        <div>
            <h1 class="font-bold text-lg">Comparing <a class="text-blue-500" href="{{ asset($s1) }}">{{ $s1 }}</a> to <a class="text-blue-500" href="{{ asset($s2) }}">{{ $s2 }}</a></h1>
        </div>
        <h2>Scores:</h2>
        @foreach (unserialize($scores) as $key=>$score)
            {{ ucfirst($key) }} -> <span class="font-bold" style="color:hsl(0,100%,{{ round($score*100/2) }}%)">{{ round($score*100) }}%</span> <br>
        @endforeach
        <div class="flex">
            <div class="w-1/2 bg-slate-800 py-4 border-r-4 border-white">
                <pre class="text-white"><code>@php
                    $similarities = $data->similarities;
                    $i = 0;
                    foreach ($data->source_code_1 as $line){
                        $similar =false;
                        foreach($similarities as $similarity){
                            if($i == $similarity[0]){
                                $similar =true;
                            }
                        }
                        $i++;
                    if($similar){
                        $line = "<p class='bg-green-800'>".htmlspecialchars($line)."</p>";
                    }else{
                        $line = htmlspecialchars($line) . "<br>";
                    }
                        echo  $line;
                    }
                    @endphp</code></pre>
            </div>
            <div class="w-1/2 bg-slate-800 py-4 border-l-4 border-white">
                <pre class="text-white"><code>@php
                    $similarities = $data->similarities;
                    $i = 0;
                    foreach ($data->source_code_2 as $line){
                        $similar =false;
                        foreach($similarities as $similarity){
                            if($i == $similarity[1]){
                                $similar =true;
                            }
                        }
                        $i++;
                    if($similar){
                        $line = "<p class='bg-green-800'>".htmlspecialchars($line)."</p>";
                    }else{
                        $line = htmlspecialchars($line) . "<br>";
                    }
                        echo  $line;
                    }
                    @endphp</code></pre>
            </div>
        </div>
    </div>




    <main class="h-full pb-16 overflow-y-auto">
          <div class="container grid px-6 mx-auto">
            <div class="flex mt-8 items-center">
              <div class="flex-1">
                 <h2
                class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
                >
                Plagiarism Report
                </h2>
              </div>
               <div class="flex-1 text-right">
                  <a href="#">
                      <button class="py-2 px-8 text-white rounded-lg bg-blue-600 hover:bg-blue-500 active:bg-blue-400 text-lg ring-0 transition-all active:ring-4 ring-orange-200 dark:ring-orange-800">
                          <i class="fas fa-download"></i> Download PDF
                      </button>
                  </a>
               </div>
            </div>
           
            
            <div class="w-full overflow-hidden rounded-lg shadow-sm">
              <div class="w-full overflow-x-auto">
              </div>
              <div class="mt-4 p-4 bg-white rounded-md shadow-sm">
                    <p class="font-bold">Students Information</p>
                    <hr class="my-4">
                    <div class="flex">
                        <div class="flex-1">
                            <table class="w-full">
                                <tr>
                                    <td class="font-bold w-1/4">Student 1 </td>
                                    <td>Abdelrahman Sayed Abdelhamid</td>
                                </tr>
                                <tr>
                                    <td class="font-bold w-1/4">Plagiarism Percentage</td>
                                    <td>67%</td>
                                </tr>
                                <tr>
                                    <td class="font-bold w-2/4">Submission Date</td>
                                    <td>2022-03-04 04:08:29</td>
                                </tr>
                                <tr>
                                    <td class="font-bold w-2/4">Number Of Submissions</td>
                                    <td>3</td>
                                </tr>
                            </table>
                        </div>
                        <div class="flex-1">
                            <table class="w-full">
                                <tr>
                                    <td class="font-bold w-1/4">Student 2</td>
                                    <td>Mohammed Tarek Mohammed</td>
                                </tr>
                                <tr>
                                    <td class="font-bold w-1/4">Plagiarism Percentage</td>
                                    <td>67%</td>
                                </tr>
                                <tr>
                                    <td class="font-bold w-2/4">Submission Date</td>
                                    <td>2022-03-01 23:11:32</td>
                                </tr>
                                <tr>
                                    <td class="font-bold w-2/4">Number Of Submissions</td>
                                    <td>1</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
              </div>
              
                <div class="flex mt-7">
                    <div class="flex-1 bg-white rounded-xl shadow-lg p-3 mr-5">
                        <p class="font-bold">Submitted Code</p>
                        <hr class="my-3">
                        <pre><code>import java.util.Scanner;
public class test {
    public static void main(String args[]){
        Scanner input = new Scanner(System.in);
        int i, fact = 1;
        int number = input.nextInt();
        for(i=1;i<=number;i++){    
                fact=fact*i;    
        }    
        System.out.println(fact);
    }  
    
}</code></pre>
                    </div>
                    <div class="flex-1 bg-white rounded-xl shadow-lg p-3">
                        <p class="font-bold">Submitted Code</p>
                        <hr class="my-3">
                        <pre><code>import java.util.Scanner;
public class test {
    public static void main(String args[]){
        <span class=" bg-gray-300">Scanner input = new Scanner(System.in);</span> 
        int i, fact = 1;
       <span class=" bg-gray-300">int number = input.nextInt();</span> 
        for(i=1;i<=number;i++){    
                fact=fact*i;    
        }    
        System.out.println(fact);
    }  
    
}</code></pre>
                    </div>
                </div>
                <div class="mt-4 p-4 bg-white rounded-md shadow-sm">
                    <p class="font-bold">Instrunctor Comments</p>
                    <hr class="my-4">
                    No Comments.
              </div>
                <style>
                    pre {
                      background-color:#ffff;
                      overflow:auto;
                      margin:0 0 1em;
                      padding:.5em 1em;
                    }

                    pre code,
                    pre .line-number {
                      font:normal normal 14px/16px "Courier New",Courier,Monospace;
                      color:black;
                      display:block;
                    }

                    pre .line-number {
                      float:left;
                      margin:0 1em 0 -1em;
                      border-right:1px solid;
                      text-align:right;
                    }

                    pre .line-number span {
                      display:block;
                      padding:0 .5em 0 1em;
                    }

                    pre .cl {
                      display:block;
                      clear:both;
                    }
                  </style>
                 
                 <script>
                  (function() {
                      var pre = document.getElementsByTagName('pre'),pl = pre.length;
                      for (var i = 0; i < pl; i++) {
                        pre[i].innerHTML = '<span class="line-number"></span>' + pre[i].innerHTML + '<span class="cl"></span>';
                        var num = pre[i].innerHTML.split(/\n/).length;
                        for (var j = 0; j < num; j++) {
                          var line_num = pre[i].getElementsByTagName('span')[0];
                          line_num.innerHTML += '<span>' + (j + 1) + '</span>';
                        }
                      }
                  })();
              </script>

            </div>
          </div>
        </main>
</body>
</html>
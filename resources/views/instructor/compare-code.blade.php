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
</body>
</html>
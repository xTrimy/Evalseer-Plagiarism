<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Evalseer Plagiarism</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>
    <div class="w-full h-96 bg-white p-8 relative">
        <div class="text-3xl absolute  text-center top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" >
            <h1 class="text-5xl font-bold">
            EVALSEER Plagiarism
            </h1>
            <p class="mt-4">A source code <span class="underline decoration-purple-600">Plagiarism Checking</span> tool based on <span class="underline decoration-rose-600">JPlag</span>.</p>
        </div>
    </div>
    <div class="flex text-center justify-center items-center">
        
        <div>
            @if (Session::get('message'))
       
        <p class="text-red-500 text-4xl">
            {!! Session::get('message') !!}
        </p>
        @endif
        @if (Session::get('unique_id'))
        @php
            $unique_id = Session::get('unique_id');
        @endphp
        <p class="text-green-500 text-4xl">
            Your submission result is ready: <a href="{{ asset("submissions/$unique_id-results/index.html") }}"><span class="text-white bg-green-500 p-4 m-8">View Now</span></a>
        </p>
        @endif
        <h1 class="text-5xl">Try it NOW!</h1>
        <form method="POST" class="p-8" enctype="multipart/form-data">
            @csrf
            @if ($errors->any())
                <div class="text-red-500">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <label for="">Upload a ZIP file containing all the submissions to check for plagiarism</label><br>
            <div class="flex justify-center items-center">
                <i class="las la-file text-3xl mr-4"></i>
                <input type="file" required name="zip_file" accept=".zip" class="border border-gray-400">
            </div>
            <label for="">Submission Type</label><br>
             <div class="flex justify-center items-center">
                <i class="las la-code text-3xl mr-4"></i>
                @php
                    $types = ['java17','java15','java15dm','java12','java11','python3','c/c++','c#-1.2','text','scheme'];
                @endphp
                {{-- java17 (default), java15, java15dm, java12, java11, python3, c/c++, c#-1.2, char, text, scheme --}}
                <select name="type" required id="" class="border border-gray-400 py-2 px-8">
                    @foreach ($types as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                </select>
            </div>
            <input type="submit" class="bg-green-500 py-2 px-8 rounded border ring-1 ring-green-500 text-white mt-8 cursor-pointer hover:ring-4 hover:border-4 transition-all">
        </form>
        </div>
    </div>
</body>
</html>

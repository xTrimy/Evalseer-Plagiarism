@php
    $page = app()->view->getSections()['title'] ?? null;
    $page = rtrim($page);
@endphp
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body class="h-full">
    <div class="flex xl:h-full w-full xl:flex-nowrap flex-wrap">
        <div class="xl:h-full xl:w-1/3 w-full relative xl:overflow-hidden">
            <div class="xl:h-full flex flex-col-reverse xl:flex-row xl:flex-nowrap flex-wrap left-0 xl:fixed w-full xl:w-auto top-0">
                <div class="xl:flex  xl:h-full w-full xl:w-auto items-center">
                    <div class="m-auto">
                        <a href="{{ route('login') }}"><div class="{{ $page == "Login" ? "text-text border-primary":"" }} text-2xl xl:my-16 border-l-2  w-40 text-center py-7 font-bold">
                            Sign in
                        </div></a>
                        <a href="{{ route('signup') }}"><div class="{{ $page == "Signup" ? "text-text border-primary":"" }} text-2xl xl:my-16 border-l-2  w-40 text-center py-7 font-bold">
                            Sign Up
                        </div></a>
                    </div>
                </div>
                <div class="bg-primary flex xl:h-full w-full xl:w-auto items-center px-32">
                    <div>
                        <img src="{{ asset('png/logo.png') }}" width="180" alt="logo">
                    </div>
                </div>
            </div>
        </div>
        <div class="xl:w-2/3 w-full pb-8">
            @yield('content')
        </div>
    </div>
</body>
</html>

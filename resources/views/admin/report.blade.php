@extends('layout.dashboard.app')
@section('page')
plagiarism-report
@endsection
@section('title')
Plagiarism Report
@endsection
@section('content')
    <main class="h-full pb-16 overflow-y-auto">
        <iframe src="{{ '/submissions/'.$report.'/index.html' }}" class="w-full h-full" style="border:none;" title="Iframe Example"></iframe>
    </main>
@endsection
@extends('layout.app')
@section('title')
{{ $assignment->name }}
@endsection
@section('content')
    <div class="flex w-full">
            <div class="w-3/4 p-8 bg-gray-200 m-auto rounded-3xl my-14">
            <div class="flex-1 flex py-2 px-8 bg-gray-200 rounded-3xl mr-10 items-center mb-8">
                <table class="w-full">
                    <tr class="mb-6">
                        <td >
                            <div class="mr-12 text-center">
                                <i class="fas fa-book text-green-600 text-4xl"></i>
                            </div>
                        </td>
                        <td>
                            <div class="text-center w-full">
                                <p class="w-full text-left font-bold text-xl">{{ $assignment->name }}</p>
                                <p class="text-left font-bold text-xl">Opened: <span class="text-left font-normal">{{ $assignment->start_time->format('l, d F, H:i A') }}</span> </p>
                                <p class="w-full text-left font-bold text-xl">Due: <span class="text-left font-normal">{{ $assignment->end_time->format('l, d F, H:i A') }}</span></p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                            <table class="mt-6 space-y-4 w-full">
                                <tr class="mb-8 bg-gray-300 ">
                                    <td class="font-bold text-xl pr-12 py-4 px-3">Submission status</td>
                                    <td class="text-xl">No attempt</td>
                                </tr>
                                <tr class=" h-4"></tr>
                                <tr class="bg-gray-300">
                                    <td class="font-bold text-xl pr-12  py-4 px-3">Grade</td>
                                    <td class="text-xl">Not graded</td>
                                </tr>
                                <tr class=" h-4"></tr>
                                <tr class="bg-gray-300">
                                    <td class="font-bold text-xl pr-12  py-4 px-3">Time remaining</td>
                                    {{-- <td class="text-xl text-red-800">Assignment is overdue by: 53 days 18 hours</td> --}}
                                    <td class="text-xl ">{{ $assignment->end_time->diffForHumans() }}</td>
                                </tr>
                                <tr class=" h-4"></tr>
                                <tr class="bg-gray-300">
                                    <td class="font-bold text-xl pr-12  py-4 px-3">Last modified</td>
                                    <td class="text-xl">-</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                
                
            </div>
            <form method="POST">
            @csrf
            @foreach ($assignment->questions as $question)
                <div class="w-full text-center block my-8">
                    <label class=" bg-text text-white px-10 py-3 rounded-lg font-bold text-sm cursor-pointer">
                        Add Submission for {{ $question->name }}
                        <input type="file" class="hidden" name="submission[]" >
                    </label>
                </div>
            @endforeach
                <div class="w-full text-center block my-8">
                    <input type="submit" class=" bg-green-700 hover:bg-green-600 text-white px-10 py-3 rounded-lg font-bold text-sm cursor-pointer"name="submission[]" >
                </div>
            </form>
        </div>
    </div>
@endsection
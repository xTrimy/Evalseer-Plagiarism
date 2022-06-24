@extends('layout.dashboard.app')

@section('content')
@php
$user = Auth::user();
@endphp
<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
      <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Dashboard
      </h2>
      <!-- Cards -->
      <div class="flex mb-8 md:grid-cols-2 xl:grid-cols-4 justify-center">
        <!-- Card -->
        <div class="flex items-center p-4 bg-white rounded-lg dark:bg-gray-800 w-1/4 mx-7 shadow-sm cursor-pointer" onclick="window.location='{{ route('dashboard.users.students.view') }}'">
          <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
            </svg>
          </div>
          <div>
            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
              Total Students
            </p>
            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
              {{ $users }}
            </p>
          </div>
        </div>
        <!-- Card -->
        <div class="flex items-center p-4 bg-white rounded-lg dark:bg-gray-800 w-1/4 mx-7 shadow-sm cursor-pointer" onclick="window.location='{{ route('dashboard.users.instructors.view_all_assignments') }}'">
            <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
              <i class="w-5 h-5 text-center fas fa-align-center"></i>
            </div>
            <div>
              <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                Total Assignments
              </p>
              <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                {{ $assignments }}
              </p>
            </div>
          </div>
        <!-- Card -->
        <div class="flex items-center p-4 bg-white rounded-lg dark:bg-gray-800 w-1/4 mx-7 shadow-sm">
            <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
              <i class="w-5 h-5 text-center fas fa-upload"></i>
            </div>
            <div>
              <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                Total Submissions
              </p>
              <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                {{ $submissions }}
              </p>
            </div>
        </div>

    </div>
    <div class="flex h-96">

    
      <div class="shadow-lg rounded-lg overflow-hidden">
      <canvas class="p-3 h-full" id="chartBar"></canvas>
      </div>
    </div>

    <!-- Required chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Chart bar -->
    <script>
      const labelsBarChart = [
        "SWE211",
        "SWE212",
        "SE305",
      ];
      const dataBarChart = {
        labels: labelsBarChart,
        datasets: [
          {
            label: "Course Submissions",
            backgroundColor: "hsl(252, 82.9%, 67.8%)",
            borderColor: "hsl(252, 82.9%, 67.8%)",
            data: [{{ $swe211 }}, {{ $swe212 }}, {{ $se305 }},],
          },
        ],
      };

      const configBarChart = {
        type: "bar",
        data: dataBarChart,
        options: {},
      };

      var chartBar = new Chart(
        document.getElementById("chartBar"),
        configBarChart
      );
    </script>
    
  </main>
@endsection
<div>
    <table class="table w-full">
        <thead>
            <tr>
                <th class="text-left text-yellow-800">Test Inputs</th>
                <th class="text-left text-red-600">Your Outputs:</th>
                <th class="text-left text-green-600">Solution Outputs:</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($test_cases as $key=>$test_case)
                <tr>
                    <td>
                        {{$test_case->inputs}}
                    </td>
                    <td>
                        @if (array_key_exists($key,$outputs))
                            {{ $outputs[$key] }}
                        @endif
                    </td>
                    <td>
                    {{ $test_case->output }}<br>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if($output_string !== false)
        <div class="mt-8">
            Your output contains an unnecessary string <span class="p-1 bg-gray-400 font-bold">{{ $output_string }}</span>. Try removing it and try again.
        </div>
    @endif
</div>
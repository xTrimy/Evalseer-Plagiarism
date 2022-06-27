<div id="modal" class="fixed z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4 modal">
    <div class="relative top-40 mx-auto shadow-xl rounded-md bg-white w-2/3">

        <div class="flex justify-center items-center bg-text text-white text-3xl rounded-t-md px-4 py-4">
            <h3>Congratulations ! </h3>
        </div>

        <div class="h-full  p-4">
            <div class="text-center">
                    <div class="mb-5 text-xl">
                        You Have Earned The <b>Top Achiever</b> Badge:
                    </div>
                    <div class="w-1/4 bg-white shadow-md rounded-lg text-center p-4 m-auto">
                        <div class="w-3/4 m-auto">
                            <img src="{{ asset("png/Top_Achiever_1.png") }}" alt="">
                        </div>
                        <p class="font-bold my-3">Top Achiever</p>
                        <div class="relative h-6 text-white rounded-3xl overflow-hidden">
                            <div class="absolute top-0 left-0 w-full h-full bg-gray-400"></div>
                           
                            <div style="width:20%" class=" absolute top-0 left-0 bg-text h-full "></div>
                            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">1/5</div>
                        </div>
                    </div>
                    <div class="my-4 text-lg">
                        When obtaining the highest grade in one assignment (given for the first three).
                    </div>
            </div>
        </div>

        <div class="px-4 py-2 border-t border-t-gray-500 flex justify-end items-center space-x-4">
            <button class="bg-text text-white px-4 py-2 rounded-md hover:bg-primary transition" onclick="closeModal('modal')">Close</button>
        </div>
    </div>
</div>
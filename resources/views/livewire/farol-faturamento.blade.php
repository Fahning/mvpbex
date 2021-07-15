<x-app-layout>
        <div class="flex flex-col justify-center h-screen items-center">
            <div class='flex max-w-sm w-full h-64 justify-center bg-white shadow-md rounded-lg overflow-hidden mx-auto flex flex-col p-5'>
                <!-- This is the input component -->
                <div class="relative h-10 input-component empty">
                    <input
                        id="address"
                        type="text"
                        name="address"
                        class="h-full w-full border-gray-300 px-2 transition-all border-blue rounded-full"
                    />
                    <label for="address" class="absolute left-2 transition-all bg-white px-1">
                        Address
                    </label>
                </div>
                <div class="relative h-10 mt-5 input-component ">
                    <select  class="ml-2 font-bold h-full w-full border-gray-300 px-2 transition-all border-blue rounded-full"  name="ano" id="ano" empty wire:model="ano">
                        <option value="" selected disabled hidden></option>
                        <option value="2021">2021</option>
                        <option value="2020">2020</option>
                        <option value="2019">2019</option>
                        <option value="2018">2018</option>
                        <option value="2017">2017</option>
                    </select>
                    <label for="address" class="absolute left-4 transition-all bg-white px-1">
                        Address
                    </label>
                </div>
            </div>
        </div>

</x-app-layout>


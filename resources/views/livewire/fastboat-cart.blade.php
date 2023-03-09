<x-modal 
    blur 
    wire:model="show"
    spacing="p-0"
    align="center"
>
    <div class="relative w-full h-full max-w-2xl md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow items-center h-full md:h-auto">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
                <div class="flex flex-col">
                    <h3 class="text-xl font-semibold text-gray-900 flex flex-row items-center gap-2" wire:loading.remove>
                        Head
                    </h3>
                </div>
            </div>
            
            <!-- no content -->
            <p class="w-full text-center py-20">no content</p>
            @php
            dump(session()->get('fastboat_cart_1'));
            dump(session()->get('fastboat_cart_2'));
            @endphp
        </div>
    </div>
</x-modal>

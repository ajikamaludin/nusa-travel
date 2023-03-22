<div class="flex flex-col gap-1 w-full row-span-2">
    <div>
        <label>Adults</label>
        <x-input 
            type="number"
            placeholder="Adults" 
            name="no_passengers" 
            wire:model.debounce.300ms="passengers"
            required="true"
            min="1"
            right-icon="user"
        />
    </div>
    <div>
        <label>Infants <span class="text-sm text-gray-400">(under 3 years)</span></label>
        <x-input 
            type="number"
            placeholder="Infant" 
            name="infants" 
            wire:model="infants"
            required="true"
            min="0"
            right-icon="user"
        />
    </div>
</div>
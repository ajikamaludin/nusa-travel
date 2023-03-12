<div>
    <label>No. of Passengers</label>
    <x-input 
        type="number"
        placeholder="No. of Passengers" 
        name="no_passengers" 
        wire:model.debounce.300ms="passengers"
        required="true"
        min="1"
        right-icon="user"
    />
</div>
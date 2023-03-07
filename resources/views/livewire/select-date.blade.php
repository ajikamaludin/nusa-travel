<div>
    <label>Departure Date</label>
    <x-datetime-picker
        placeholder="Departure Date"
        wire:model="date"
        :min="$min"
        :without-time="true"
        name="date"
    />
</div>
<div>
    <label>Return Date</label>
    <x-datetime-picker
        placeholder="Return Date"
        wire:model="rdate"
        :min="$min"
        :without-time="true"
        :clearable="false"
        name="return_date"
    />
</div>
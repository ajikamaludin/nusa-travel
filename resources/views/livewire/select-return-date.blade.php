
<label>Return Date</label>
<x-datetime-picker
    placeholder="Return Date"
    wire:model="rdate"
    :min="$min"
    :without-time="true"
    name="return_date"
/>
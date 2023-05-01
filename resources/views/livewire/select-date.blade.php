<div>
    <label>{{ __('website.Departure Date')}}</label>
    <x-datetime-picker
        placeholder="{{ __('website.Departure Date')}}"
        wire:model="date"
        :min="$min"
        :without-time="true"
        :clearable="false"
        name="date"
        display-format="DD/MM/YYYY"
    />
</div>
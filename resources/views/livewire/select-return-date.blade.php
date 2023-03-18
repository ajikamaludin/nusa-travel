<div>
    <label>{{ __('website.Return Date')}}</label>
    <x-datetime-picker
        placeholder="{{ __('website.Return Date')}}"
        wire:model="rdate"
        :min="$min"
        :without-time="true"
        :clearable="false"
        name="return_date"
    />
</div>
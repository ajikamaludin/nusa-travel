<div>
    <label>{{ __('website.Destination')}}</label>
    <x-select
        wire:model="dest"
        placeholder="{{ __('website.Destination')}}"
        :options="$places"
        :min-items-for-search="5"
        :clearable="true"
        option-label="name"
        option-value="name"
        name="to"
        required="true"
        autocomplate="off"
        right-icon="location-marker"
    />
</div>
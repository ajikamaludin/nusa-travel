<div>
    <label>{{ __('website.Origin')}}</label>
    <x-select
        wire:model="origin"
        placeholder="{{ __('website.Origin')}}"
        :options="$places"
        :min-items-for-search="5"
        :clearable="true"
        option-label="name"
        option-value="name"
        name="from"
        required="true"
        autocomplate="off"
        right-icon="location-marker"
    />
</div>
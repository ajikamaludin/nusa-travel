<div>
    <x-select
        wire:model="dropoff"
        placeholder="Origin"
        :options="$dropoffs"
        :min-items-for-search="5"
        :clearable="false"
        option-label="name"
        option-value="name"
        name="from"
        required="true"
        autocomplate="off"
        right-icon="location-marker"
    />
</div>
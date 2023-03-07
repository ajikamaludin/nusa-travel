<div>
    <label>Origin</label>
    <x-select
        wire:model="origin"
        placeholder="Origin"
        :options="$places"
        :min-items-for-search="5"
        option-label="name"
        option-value="name"
        name="from"
        required="true"
        autocomplate="off"
    />
</div>
<x-mail::message>
# Introduction

The body of your message.
{{-- TODO: make this email is conditional for payment status --}}

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

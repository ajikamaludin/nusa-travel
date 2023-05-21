<x-mail::message>
# Hai, {{ $customer->name }}

## Your password has been change.
If you didn't change your password, your account might have been hijacked. To get back into your account, you'll need to contact us via 
<a href="{{  route('page.show', ['locale'=> 'en', 'page' => 'aboutus']) }}">this link</a>.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

@component('mail::message')
    Hi there,

    We noticed you haven't logged in for a while and we just wanted to send you a little reminder.

    Compliance to your Boots and Bars directly affects the outcome of the treatment,
    using your Club Foot dashboard will help you keep track of how the treatment is progressing.

@component('mail::button', ['url' => 'https://salty-gorge-09035.herokuapp.com/welcome'])
    View your Dashboard
@endcomponent

    Thanks,
    {{ config('app.name') }}
@endcomponent


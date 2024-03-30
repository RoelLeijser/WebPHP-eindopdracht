<!DOCTYPE html>
<html>
<head>
    <title>{{__('contract.title')}}</title>
</head>
<body>
    <h1>{{__('contract.name')}} {{ $name }}</h1>
    <h2>{{__('contract.email')}} {{ $email }}</h2>
    <p>{{__('contract.message_rights')}}</p>
    <p>{{__('contract.if')}} {{$name}} {{__('contract.message_violation')}}</p>
    <span>{{ __('contract.signature')}} ____________________________________</span>
</body>
</html>
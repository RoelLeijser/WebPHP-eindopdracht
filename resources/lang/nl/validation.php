<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Een :attribute moet geaccepteerd zijn',
    'accepted_if' => 'Een :attribute moet geaccepteerd zijn wanneer :other gelijk is aan :value.',
    'active_url' => ':attribute is geen valide link.',
    'after' => ':attribute moet een datum na :date zijn.',
    'after_or_equal' => 'De :attribute moet een datum na of tijgelijk met :date zijn.',
    'alpha' => 'Een :attribute mag alleen letters bevatten.',
    'alpha_dash' => 'Een :attribute mag alleen letters, nummers, streepjes en onderstrepingstekens bevatten.',
    'alpha_num' => 'Een :attribute mag alleen letters en nummers bevatten.',
    'array' => 'De :attribute moet een array zijn.',
    'before' => ':attribute moet een datum voor :date zijn.',
    'before_or_equal' => ':attribute moet een datum voor of gelijk aan :date. zijn',
    'between' => [
        'numeric' => 'Het:attribute moet tussen :min en :max liggen.',
        'file' => 'Het :attribute moet tussen :min en :max kilobytes zijn.',
        'string' => 'De :attribute moet tussen :min en :max karakters lang zijn.',
        'array' => 'De :attribute moet tussen :min en :max items bevatten.',
    ],
    'boolean' => 'De :attribute veld moet true of false zijn.',
    'confirmed' => 'Het :attribute komt niet overeen.',
    'current_password' => 'Het wachtwoord is incorrect.',
    'date' => 'De :attribute geen correcte datum.',
    'date_equals' => 'De :attribute moet een datum gelijk aan :date zijn.',
    'date_format' => 'De :attribute past niet bij het verwachte format :format.',
    'declined' => 'De :attribute moet afgewezen zijn.',
    'declined_if' => 'De :attribute moet afgwezen zijn als :other is :value.',
    'different' => 'De :attribute en :other moeten verschillen .',
    'digits' => 'De :attribute moet een cijfer zijn :digits .',
    'digits_between' => 'De :attribute moet tussen :min en :max cijfers lang zijn.',
    'dimensions' => 'De :attribute heeft incorrecte demensies.',
    'distinct' => 'De :attribute veld heeft een niet unieke waarde.',
    'email' => 'De :attribute moet een valide email zijn.',
    'ends_with' => 'De :attribute moet eindigen met een van de volgende waardes: :values.',
    'enum' => 'De geselecteerde :attribute is invalide.',
    'exists' => 'De geselecteerde :attribute is invalide.',
    'file' => 'De :attribute moet een file zijn.',
    'filled' => 'De :attribute veld moet een warde hebben.',
    'gt' => [
        'numeric' => 'De :attribute moet groter zijn dan :value.',
        'file' => 'De :attribute moet groter zijn dan :value kilobytes.',
        'string' => 'De :attribute moet langer zijn dan :value karakters.',
        'array' => 'De :attribute moet meer dan :value items hebben.',
    ],
    'gte' => [
        'numeric' => 'De :attribute moet groter of gelijk aan :value zijn.',
        'file' => 'De :attribute moet groter of gelijk aan :value kilobytes.',
        'string' => 'De :attribute moet langer of gelijk aan :value karakters.',
        'array' => 'De :attribute moet meer dan of gelijk aan :value items hebben.',
    ],
    'image' => 'De :attribute moet een foto zijn.',
    'in' => 'De geselecteerde :attribute is invalide.',
    'in_array' => 'De :attribute veld bestaat niet in :other.',
    'integer' => 'De :attribute moet een cijfer zijn.',
    'ip' => 'De :attribute moet een valide IP adres zijn.',
    'ipv4' => 'De :attribute moet een valide IPv4 adres zijn.',
    'ipv6' => 'De :attribute moet een valide IPv6 adres zijn.',
    'mac_address' => 'De :attribute moet een valide MAC adres zijn.',
    'json' => 'De :attribute moet een valide JSON string zijn.',
    'lt' => [
        'numeric' => 'De :attribute moet minder dan :value zijn.',
        'file' => 'De :attribute moet minder dan :value kilobytes zijn.',
        'string' => 'De :attribute moet korter dan :value karakters.',
        'array' => 'De :attribute moet meer dan :value items bevatten.',
    ],
    'lte' => [
        'numeric' => 'De :attribute moet kleiner of gelijk aan :value zijn.',
        'file' => 'De :attribute moet kleiner of gelijk aan :value kilobytes zijn.',
        'string' => 'De :attribute moet korter of even lang als :value karakters zijn.',
        'array' => 'De :attribute moet kleiner of gelijk aan :value items.',
    ],
    'max' => [
        'numeric' => 'De :attribute mag niet groter dan :max zijn zijn.',
        'file' => 'De :attribute mag niet groter dan :max kilobytes zijn.',
        'string' => 'Een :attribute mag niet langer dan :max karakters zijn.',
        'array' => 'De :attribute mag niet groter dan :max items zijn.',
    ],
    'mimes' => 'De :attribute moet een file met het type: :values. zijn',
    'mimetypes' => 'De :attribute moet een file met het type: :values zijn.',
    'min' => [
        'numeric' => ':attribute moet minstens :min zijn.',
        'file' => 'De :attribute moet minstens :min kilobytes zijn.',
        'string' => ':attribute moet minstens :min karakters lang zijn.',
        'array' => 'De :attribute moet minstens :min items bevatten.',
    ],
    'multiple_of' => 'De :attribute moet een multiplicatie van :value zijn.',
    'not_in' => 'De geselecteerde :attribute is invalide.',
    'not_regex' => 'De :attribute format is invalide.',
    'numeric' => 'De :attribute moet een nummer zijn.',
    'password' => 'Het wachtwoord is incorrect.',
    'present' => 'De :attribute veld moet aanwezig zijn.',
    'prohibited' => 'De :attribute veld is niet toegestaan.',
    'prohibited_if' => 'De :attribute veld is niet toegestaan als hij :other of :value is.',
    'prohibited_unless' => 'De :attribute veld is niet toegestaan als hij niet :other of :values is.',
    'prohibits' => 'De :attribute veld staat niet toe dat :other aanwezig is.',
    'regex' => 'De :attribute format is invalide.',
    'required' => ':attribute veld is verplicht.',
    'required_if' => ':attribute veld is verplicht wanneer :other is :value.',
    'required_unless' => 'De :attribute veld is verplicht tenzij :other in :values is.',
    'required_with' => 'De :attribute veld is verplicht wanneer :values aanwezig is.',
    'required_with_all' => 'De :attribute veld is verplicht wanneer :values aanwezig zijn.',
    'required_without' => 'De :attribute veld is verplicht wanneer :values niet aanwezig is.',
    'required_without_all' => 'De :attribute veld is verplicht wanneer geen van deze :values aanwezig zijn.',
    'same' => 'De :attribute en :other moeten overeenkomen.',
    'size' => [
        'numeric' => 'De :attribute moet :size.',
        'file' => 'De :attribute moet :size kilobytes.',
        'string' => 'De :attribute moet :size karakters bevatten.',
        'array' => 'De :attribute moet :size items bevatten.',
    ],
    'starts_with' => 'De :attribute moet met een van de volgende waardes starten: :values.',
    'string' => 'Een :attribute moet een string zijn.',
    'timezone' => ':attribute moet een valide timezone.',
    'unique' => 'Het opgegeven :attribute is al in bezit.',
    'uploaded' => 'De :attribute is gefaald met uploaden.',
    'url' => 'De :attribute moet een valide URL zijn.',
    'uuid' => 'De :attribute moet een valide URL UUID zijn.',
    'postal_code' => 'De :attribute moet een valide postcode zijn.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    'permissions' => [
        'permissions' => 'De :attribute moeten bestaan.',
    ],

    'password' => [
        'ul' => 'Het wachtwoord moet op zijn minst een hoofdletter en kleine letter bevatten.',
        'one_letter' => 'Het wachtwoord moet op zijn minst een letter bevatten.',
        'one_symbol' => 'Het wachtwoord moet op zijn minst een speciaal symbool bevatten.',
        'one_number' => 'Het watchwoord moet op zijn minst een nummer bevatten.'
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'name' => 'naam',
        'password' => 'wachtwoord',
        'role' => 'rol',
        'permissions' => 'rechten',
    ],

];

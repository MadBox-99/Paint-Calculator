<x-mail::message>
<x-slot name="header">
<x-mail::header :url="config('app.url')">
Harzo Kft.
</x-mail::header>
</x-slot>

Kedves {{ $data['full_name'] }},

A HARZO az általad megadott adatok alapján feldolgoztuk és elkészítettük a Bevásárlólistádat, amit a levélhez csatoltunk. Nyisd meg a csatolt dokumentumot és töltsd le a listát, hogy a vásárlás során ne maradj le semmiről!

**Teljes Név:** {{ $data['full_name'] }}

**Email:** {{ $data['email'] }}

**Kiválasztott kategória:** {{ $data['selectedPaintCategory']->name }}

**Kiválasztott csomag:** {{ $data['tilePaint']->name }}

**Megadott felület területe:** {{ $data['area'] }} m²

@isset($data['region'])
**Település, ahol vásárolni szeretnél:** {{ $data['region']?->name }}

**Festékbolt, ahol a vásárlást tervezed:** {{ $data['store']?->name }} {{ $data['store']?->address }}
@endisset

A Bevásárlólistád a csatolmányban található!

Üdvözlettel,<br>
HARZO csapat

<x-slot name="footer">
<x-mail::footer>
&copy; {{ date('Y') }} Harzo. Minden jog fenntartva.
</x-mail::footer>
</x-slot>
</x-mail::message>

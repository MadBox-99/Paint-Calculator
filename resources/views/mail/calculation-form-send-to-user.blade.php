<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bevásárlólista</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
            margin-bottom: 20px;
        }
        .content {
            padding: 20px 0;
        }
        .info-box {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .info-box p {
            margin: 8px 0;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #eee;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
        strong {
            color: #222;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Harzo Kft.</h2>
    </div>

    <div class="content">
        <p>Kedves {{ $data['full_name'] }},</p>

        <p>A HARZO az általad megadott adatok alapján feldolgoztuk és elkészítettük a Bevásárlólistádat, amit a levélhez csatoltunk. Nyisd meg a csatolt dokumentumot és töltsd le a listát, hogy a vásárlás során ne maradj le semmiről!</p>

        <div class="info-box">
            <p><strong>Teljes Név:</strong> {{ $data['full_name'] }}</p>
            <p><strong>Email:</strong> {{ $data['email'] }}</p>
            <p><strong>Kiválasztott kategória:</strong> {{ $data['selectedPaintCategory']->name }}</p>
            <p><strong>Kiválasztott csomag:</strong> {{ $data['tilePaint']->name }}</p>
            <p><strong>Megadott felület területe:</strong> {{ $data['area'] }} m²</p>
            @isset($data['region'])
            <p><strong>Település:</strong> {{ $data['region']?->name }}</p>
            <p><strong>Festékbolt:</strong> {{ $data['store']?->name }} {{ $data['store']?->address }}</p>
            @endisset
        </div>

        <p>A Bevásárlólistád a csatolmányban található!</p>

        <p>Üdvözlettel,<br>HARZO csapat</p>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} Harzo. Minden jog fenntartva.
    </div>
</body>
</html>

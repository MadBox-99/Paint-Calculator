<!DOCTYPE html>
<html lang="hu">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Számítás</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f4f4;
            }

            .container {
                width: 80%;
                margin: 0 auto;
                background-color: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            h1,
            h2 {
                color: #333;
            }

            p {
                line-height: 1.6;
                color: #666;
            }

            .header {
                text-align: center;
                margin-bottom: 20px;
            }

            .header img {
                max-width: 150px;
            }

            .details {
                margin-bottom: 20px;
            }

            .details p {
                margin: 5px 0;
            }

            .footer {
                text-align: center;
                margin-top: 20px;
                font-size: 12px;
                color: #999;
            }

            .page-break {
                page-break-after: always;
            }

            .hidden {
                display: none;
            }
        </style>
        @vite('resources/css/app.css')
    </head>

    <body>
        <div class="container">
            <div class="header">
                <img src="https://harzo.hu/wp-content/uploads/2022/10/HARZO_uj_logo-1024x835.png" alt="Harzo Kft. logo"
                    style="width: 100px; height: 100px;">
                <h1>Árajánlat Részletek</h1>
            </div>
            <div class="">
                <div class="p-8 bg-gray-100 rounded-lg description">
                    <h2 class="mb-4 font-semibold">
                        {{ $data['selectedPaintDescription']?->min }} -
                        {{ $data['selectedPaintDescription']?->max }} m2
                        felületre az alább felsorolt anyagokat szükséges megvásárolni
                    </h2>
                    <p class="mb-2 details">{!! $data['selectedPaintDescription']?->description !!}</p>

                </div>
                <div class="thank-you p-8 bg-gray-100 rounded-lg mt-8 text-center">
                    <h2 class="text-xl font-semibold mb-4">Köszönjük az árajánlat kérését!</h2>
                    <p class="mb-2">
                        További lépések miatt vegye fel a kapcsolatot az üzlettel
                    </p>
                    <p class="mb-2">Amennyiben bármilyen kérdése van, kérjük, lépjen kapcsolatba velünk az alábbi
                        elérhetőségek egyikén:</p>
                    <ul class="list-none list-inside mb-4" style="list-style-type: none;">
                        <li class="mb-2" style="padding: 2px;margin: 5px;">Email: info@harzo.hu</li>
                        <li class="mb-2" style="padding: 2px;margin: 5px;">Telefon: +36 70 6237610</li>
                    </ul>
                    <p>Köszönjük, hogy minket választott!</p>
                </div>
                <p class="footer">&copy; {{ date('Y') }} Harzo. Minden jog fenntartva.</p>
            </div>
        </div>
    </body>

</html>

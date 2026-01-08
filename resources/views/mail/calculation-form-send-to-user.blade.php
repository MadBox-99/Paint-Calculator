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

            .warning-box {
                background-color: #fff3cd;
                padding: 15px;
                border-radius: 5px;
                margin: 20px 0;
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

            ul {
                margin: 10px 0;
                padding-left: 20px;
            }

            a {
                color: #007bff;
                text-decoration: none;
            }

            a:hover {
                text-decoration: underline;
            }

            .description-content {
                margin: 20px 0;
            }

            .description-content h1,
            .description-content h2,
            .description-content h3,
            .description-content h4 {
                color: #222;
                margin-top: 20px;
                margin-bottom: 10px;
            }

            .description-content p {
                margin: 10px 0;
            }

            .description-content ul,
            .description-content ol {
                margin: 10px 0;
                padding-left: 25px;
            }

            .description-content li {
                margin: 5px 0;
            }
        </style>
    </head>

    <body>
        <div class="header">
            <h2>HARZO Megoldásválasztó & Anyagkalkulátor</h2>
        </div>

        <div class="content">
            <p>Kedves {{ $data['full_name'] }}!</p>

            <p>Köszönjük, hogy használtad a HARZO Megoldásválasztó & Anyagkalkulátort!</p>

            <p>Az alábbi e-mailben összegyűjtöttük az általad kiválasztott feladathoz szükséges anyaglistát, a javasolt
                rétegrendet, valamint azokat az információkat, amelyek segítenek a felújítás megtervezésében és
                kivitelezésében.</p>

            <p>A kalkulátor célja, hogy érthetően, lépésről lépésre mutassa meg, milyen anyagokra van szükséged az adott
                megoldáshoz.</p>

            <div class="description-content">
                {!! $data['selectedPaintDescription']->description !!}
            </div>

            <div class="warning-box">
                <p><strong>Fontos tudnivaló:</strong></p>
                <p>A kalkulátor nem tartalmaz árakat. A pontos árakat a kiszámolt anyaglista alapján festékboltban
                    vagy online vásárlási ponton tudják megmondani Neked.</p>
            </div>

            <p>Ha kérdésed merül fel a kivitelezéssel, a termékekkel vagy a megfelelő megoldás kiválasztásával
                kapcsolatban, fordulj bizalommal alkalmazástechnikusainkhoz az <a
                    href="mailto:info@harzo.hu">info@harzo.hu</a> e-mail címen vagy hívd a <a href="tel:+36706237610">06
                    70 623 7610</a> telefonszámot.</p>

            <p>Sok sikert kívánunk a felújításhoz, és örömteli alkotást kívánunk a HARZO megoldásaival!</p>

            <p>Üdvözlettel,<br><strong>HARZO csapata</strong></p>
        </div>

        <div class="footer">
            <p><strong>HARZO EURÓPA Kft.</strong></p>
            <p>H-2142 Nagytarcsa, Felső ipari körút 2/c B ép. 16.</p>
            <p>
                <a href="tel:+36706237610">+36-70-623-7610</a> |
                <a href="mailto:info@harzo.hu">info@harzo.hu</a> |
                <a href="https://harzo.hu" target="_blank" rel="noopener noreferrer">harzo.hu</a>
            </p>
            <p>
                <a href="https://facebook.com/harzofestek" target="_blank" rel="noopener noreferrer">Facebook</a> |
                <a href="https://instagram.com/harzofestek" target="_blank" rel="noopener noreferrer">Instagram</a> |
                <a href="https://youtube.com/@harzo6330" target="_blank" rel="noopener noreferrer">YouTube</a>
            </p>
            <p>&copy; {{ date('Y') }} HARZO. Minden jog fenntartva.</p>
        </div>
    </body>

</html>

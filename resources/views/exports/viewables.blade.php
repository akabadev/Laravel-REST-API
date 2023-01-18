<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? "Exportation des données" }}</title>
    <style>
        * {
            font-size: 12px;
        }

        body {
            padding: 10px 7px;
            font-family: sans-serif, Verdana;
        }

        header h1 {
            font-weight: bold;
            font-size: large;
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            border: 2px solid #1a2d40;
            border-radius: 4px;
            overflow: hidden;
        }

        table thead tr {
            background-color: #1a2d41;
            color: navajowhite;
            font-weight: bold;
            text-transform: uppercase;
            text-align: left;
        }

        table th, table td {
            border: 2px solid #1a2d40;
            padding: 4px 3px;
        }

    </style>
</head>
<body style="max-width: 100vw; overflow: hidden;">
<div style="display: flex; justify-content: space-between; align-items: center; border: 2px solid #1a2d40 !important;">
    <div>
        <img
            style="width: 100px; height: 50px"
            src="https://c.woopic.com/logo-orange.png"
            alt="Orange"
        />
    </div>

    <h1>{{$title ?? "Exportation des données"}}</h1>
    <div>
        <img
            style="width: 100px; height: 50px"
            src="https://c.woopic.com/logo-orange.png"
            alt="Orange"
        />
    </div>
</div>
<main>
    <table>
        @isset($columns)
            <thead>
            <tr>
                @foreach($columns as $column)
                    <th class="">{{ $headers[$column]['label'] }}</th>
                @endforeach
            </tr>
            </thead>
        @endisset

        @isset($tuples)
            <tbody>
            @foreach($tuples as $tuple)
                <tr>
                    @foreach($tuple as $column)
                        <td>{{ $column }}</td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        @endisset
    </table>
</main>
</body>
</html>

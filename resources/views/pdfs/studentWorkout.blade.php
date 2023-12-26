<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
        }
    </style>
    <title>Academia Total Power</title>
</head>

<body>

    <h1>Ficha de Treino: {{ ucwords($name) }}</h1>


    @if (count($segunda) == 0 &&
            count($terca) == 0 &&
            count($quarta) == 0 &&
            count($quinta) == 0 &&
            count($sexta) == 0 &&
            count($sabado) == 0 &&
            count($domingo) == 0)
        <h1>NAO HÁ TREINOS CADASTRADOS</h1>
    @endif



    @if (count($segunda) > 0)
        <table>
            <h2>Segunda-feira</h2>
            <thead>

                <tr>
                    <th>Exercício</th>
                    <th>Peso</th>
                    <th>Repetições</th>
                    <th>Descanso</th>
                    <th>Tempo</th>
                    <th>Observações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($segunda as $dia)
                    <tr>
                        <td>{{ $dia->exercise->description }} </td>
                        <td>{{ $dia->weight }} </td>
                        <td>{{ $dia->repetitions }} </td>
                        <td>{{ $dia->break_time }} seg </td>
                        <td> {{ $dia->time }} min </td>
                        <td> {{ $dia->observations }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif


    @if (count($terca) > 0)
        <table>
            <h2>Terça-feira</h2>
            <thead>

                <tr>
                    <th>Exercício</th>
                    <th>Peso</th>
                    <th>Repetições</th>
                    <th>Descanso</th>
                    <th>Tempo</th>
                    <th>Observações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($terca as $dia)
                    <tr>
                        <td>{{ $dia->exercise->description }} </td>
                        <td>{{ $dia->weight }} </td>
                        <td>{{ $dia->repetitions }} </td>
                        <td>{{ $dia->break_time }} seg </td>
                        <td> {{ $dia->time }} min </td>
                        <td> {{ $dia->observations }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif



    @if (count($quarta) > 0)
        <table>
            <h2>Quarta-feira</h2>
            <thead>

                <tr>
                    <th>Exercício</th>
                    <th>Peso</th>
                    <th>Repetições</th>
                    <th>Descanso</th>
                    <th>Tempo</th>
                    <th>Observações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quarta as $dia)
                    <tr>
                        <td>{{ $dia->exercise->description }} </td>
                        <td>{{ $dia->weight }} </td>
                        <td>{{ $dia->repetitions }} </td>
                        <td>{{ $dia->break_time }} seg </td>
                        <td> {{ $dia->time }} min </td>
                        <td> {{ $dia->observations }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif


    @if (count($quinta) > 0)
        <table>
            <h2>Quinta-feira</h2>
            <thead>

                <tr>
                    <th>Exercício</th>
                    <th>Peso</th>
                    <th>Repetições</th>
                    <th>Descanso</th>
                    <th>Tempo</th>
                    <th>Observações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quinta as $dia)
                    <tr>
                        <td>{{ $dia->exercise->description }} </td>
                        <td>{{ $dia->weight }} </td>
                        <td>{{ $dia->repetitions }} </td>
                        <td>{{ $dia->break_time }} seg </td>
                        <td> {{ $dia->time }} min </td>
                        <td> {{ $dia->observations }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif


    @if (count($sexta) > 0)
        <table>
            <h2>Sexta-feira</h2>
            <thead>

                <tr>
                    <th>Exercício</th>
                    <th>Peso</th>
                    <th>Repetições</th>
                    <th>Descanso</th>
                    <th>Tempo</th>
                    <th>Observações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sexta as $dia)
                    <tr>
                        <td>{{ $dia->exercise->description }} </td>
                        <td>{{ $dia->weight }} </td>
                        <td>{{ $dia->repetitions }} </td>
                        <td>{{ $dia->break_time }} seg </td>
                        <td> {{ $dia->time }} min </td>
                        <td> {{ $dia->observations }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif


    @if (count($sabado) > 0)
        <table>
            <h2>Sabado</h2>
            <thead>

                <tr>
                    <th>Exercício</th>
                    <th>Peso</th>
                    <th>Repetições</th>
                    <th>Descanso</th>
                    <th>Tempo</th>
                    <th>Observações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sabado as $dia)
                    <tr>
                        <td>{{ $dia->exercise->description }} </td>
                        <td>{{ $dia->weight }} </td>
                        <td>{{ $dia->repetitions }} </td>
                        <td>{{ $dia->break_time }} seg </td>
                        <td> {{ $dia->time }} min </td>
                        <td> {{ $dia->observations }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif


    @if (count($domingo) > 0)

        <table>
            <h2>Domingo</h2>
            <thead>

                <tr>
                    <th>Exercício</th>
                    <th>Peso</th>
                    <th>Repetições</th>
                    <th>Descanso</th>
                    <th>Tempo</th>
                    <th>Observações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($domingo as $dia)
                    <tr>
                        <td>{{ $dia->exercise->description }} </td>
                        <td>{{ $dia->weight }} </td>
                        <td>{{ $dia->repetitions }} </td>
                        <td>{{ $dia->break_time }} seg </td>
                        <td> {{ $dia->time }} min </td>
                        <td> {{ $dia->observations }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @endif

</body>

</html>

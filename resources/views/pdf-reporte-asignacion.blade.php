<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <meta http-equiv="X-UA-Compatible" content="ie=edge"> --}}
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte de Ventas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tfoot {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .header-table {
            width: 100%;
            margin-bottom: 20px;
            border: none;
        }
        .header-table td {
            border: none;
            padding: 5px;
            width: 50%;
        }
        .total-row td {
            text-align: right;
        }
        .reporte-venta {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-family: Arial, sans-serif;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .reporte-venta h1 {
            text-align: center;
            color: #333;
        }
        .reporte-venta .info {
            margin: 15px 0;
            font-size: 16px;
        }
        .reporte-venta .info span {
            font-weight: bold;
        }
        .reporte-venta .empresa {
            background-color: #f9f9f9;
            padding: 10px;
            border: 1px dashed #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <div class="reporte-venta">
        <h1>Reporte de Asignacion(Activos)</h1>
        <div class="info">
            <p><span>Fecha:</span> {{$fecha}}</p>
            <p><span>Tipo:</span> {{ $reporte['tipoReporte'] }}</p>
        </div>
        <div class="empresa">
            @if ($empleado->employee())
            <p><span>Nombre del Empleado:</span> {{ $empleado->employee->nombre  }}</p>
            <p><span>Codigo de Empleado:</span> {{ $empleado->employee->codigo_empleado}}</p>
            
            @endif
           <p>Usuario: {{auth()->user()->name}}</p>
            <p><span>Correo:</span> {{auth()->user()->email}}</p>
            <p><span>Posicion:</span>{{ auth()->user()->rol}}</p>
            {{-- <p><span>Correo:</span>{{auth()->user()->store->correo}}</p> --}}
        </div>
    </div>
    
    <table>
        <tr>
          <th>ID</th>
          <th>Fecha Asignacion</th>
          {{-- <th>Empleado</th> --}}
          <th>Ubicacion</th>
          <th>Activo</th>
          <th>Fecha Finalizacion</th>
          <th>Devuelto</th>
          <th>Nota</th>
        </tr>

        @foreach ($records as $item)
            <tr>
                <td>{{$item->id}}</td>
                <td>{{$item->fecha_asignacion}}</td>
                {{-- <td>{{$item->employee->nombre}} - Codigo: {{$item->employee->codigo_empleado}}</td> --}}
                <td>{{$item->ubicacion->area}}</td>
                <td>{{ $item->product->name }} - folio: {{$item->product->folio}}</td>
                <td>{{$item->fecha_finalizacion ?? 'En uso'}}</td>
                <td>{{$item->devuelto ? 'Si' : 'No'}}</td>
                <td>{{$item->nota}}</td>
            </tr>
        @endforeach
       
          <!-- Footer -->
          <tfoot>
            <tr>
                <td colspan="5" style="text-align: right; font-weight: bold;">Total de Activos:</td>
                <td colspan="2">{{ $cantidad }}</td>
            </tr>
           
            <tr>
                <td colspan="5" style="text-align: right; font-weight: bold;">Rango de Fechas de asginacion de activos</td>

            </tr>
            <tr>
                <td colspan="5" style="text-align: right; font-weight: bold;">Fecha de Inicio:</td>
                <td colspan="2">{{ $minDate }}</td>
            </tr>
            <tr>
                <td colspan="5" style="text-align: right; font-weight: bold;">Fecha de Finalizacion:</td>
                <td colspan="2">{{ $maxDate }}</td>
            </tr>
            tr>
                <td colspan="5" style="text-align: right; font-weight: bold;">Nota de Reporte:</td>
                <td colspan="2">{{ $reporte['nota'] }}</td>
            </tr>
        </tfoot>
        
      </table>
</body>
</html>
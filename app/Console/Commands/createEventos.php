<?php

namespace App\Console\Commands;

use App\Models\Evento;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

use function Ramsey\Uuid\v1;

class createEventos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'month:evento';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea Eventos basados en las Actividades activas para los siguientes 30 dias';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $actividades = DB::table('actividades')
            ->select(DB::raw('actividades.id, salones.capacidad, actividades.fecha_inicio, actividades.fecha_fin, actividades.dias'))
            ->join('salones', 'salones.id', '=', 'actividades.salon_id')
            ->whereRaw('actividades.estado = \'1\'
                        AND actividades.fecha_inicio <= now()::DATE
                        AND (actividades.fecha_fin >= now()::DATE OR actividades.fecha_fin IS NULL)')
            ->get();

        $eventos = DB::TABLE('eventos')
            ->select(DB::raw('fecha, actividad_id'))
            ->whereRaw('fecha >= now()::DATE')
            ->get();

        DB::transaction(function () use ($actividades, $eventos) {
            $isDuplicated = false;
            if ($actividades->count() > 0) {
                for ($i = 0; $i <= 365; $i++) {
                    $fecha = $this->generarDia($i);
                    foreach ($actividades as $actividad) {
                        foreach ($eventos as $key => $evento) {
                            if ($evento->actividad_id == $actividad->id && $evento->fecha == $fecha) {

                                $isDuplicated = true;
                                $eventos->pull($key);
                                break;
                            }
                        }
                        if (!$isDuplicated) {
                            if (
                                $this->esDiaActivo($actividad->dias, $fecha) &&
                                ((isset($actividad->fecha_fin) && $actividad->fecha_fin >= $fecha && $actividad->fecha_inicio <= $fecha)
                                    || (!isset($actividad->fecha_fin) && $actividad->fecha_inicio <= $fecha))
                            ) {
                                $evento_nuevo = $this->crearEvento($actividad, $fecha);
                                $evento_nuevo->save();
                            }
                        } else {
                            $isDuplicated = false;
                        }
                    }
                }
            }
        });
        echo 'Eventos generados correctamente.';
        return 0;
    }

    private function crearEvento($actividad, $fecha)
    {
        $evento = new Evento();
        $evento->fecha = $fecha;
        $evento->estado = '1'; //activo
        $evento->lugares_disponibles = $actividad->capacidad;
        $evento->actividad_id = $actividad->id;
        return $evento;
    }

    private function generarDia($dias_a_sumar)
    {
        if ($dias_a_sumar == 0) {
            return Date('Y-m-d');
        } else {
            return Date('Y-m-d', strtotime("+" . $dias_a_sumar . " days"));
        }
    }

    private function esDiaActivo($dias, $fecha)
    {
        $dia_semana = date('w', strtotime($fecha));
        return substr($dias, $dia_semana, 1) == '1';
    }
}

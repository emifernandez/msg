<?php

namespace App\Console\Commands;

use App\Models\Evento;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class createEventos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:evento';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea diariamente Eventos basados en las Actividades activas';

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
            ->select(DB::raw('actividades.id, salones.capacidad'))
            ->join('salones', 'salones.id', '=', 'actividades.salon_id')
            ->whereRaw('actividades.estado = \'1\'
                        AND actividades.fecha_inicio <= now()::DATE
                        AND (actividades.fecha_fin >= now()::DATE OR actividades.fecha_fin IS NULL)
                        AND SUBSTRING(actividades.dias FROM EXTRACT(DOW FROM now())::INTEGER +1 FOR 1) = \'1\'')
            ->get();
        DB::transaction(function () use ($actividades) {
            if ($actividades->count() > 0) {
                foreach ($actividades as $actividad) {
                    $evento = new Evento();
                    $evento->fecha = now();
                    $evento->estado = '1'; //activo
                    $evento->lugares_disponibles = $actividad->capacidad;
                    $evento->actividad_id = $actividad->id;
                    $evento->save();
                }
            }
        });
        echo 'Eventos generados correctamente.';
        return 0;
    }
}

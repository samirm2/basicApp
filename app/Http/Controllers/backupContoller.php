<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Alert;
use Storage;

class backupContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $backups_path = "../storage/app/";
    protected $backups_folder_name = "Backups/";

    public function index()
    {
        
        $disk = Storage::disk('local');
        $files = $disk->files($this->backups_folder_name);
        $backups = [];
        
        foreach ($files as $k => $f) {
            if ($disk->exists($f)) {
                $backups[] = [
                    'file_path' => $f,
                    'file_name' => str_replace($this->backups_folder_name, '', $f),
                    'file_size' => $disk->size($f),
                    'last_modified' => $disk->lastModified($f),
                ];
            }
        }
        // reverse the backups, so the newest one would be on top
        $backups = array_reverse($backups);
        
        return view("Administrador.backup")->with('arrayBackups',$backups);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $db_host = env('DB_HOST');
        $db_name = env('DB_DATABASE');
        $db_user = env('DB_USERNAME');
        $db_pass = env('DB_PASSWORD');

        $fecha = date("Y-m-d_H.i.s");

        $carpeta = $this->backups_path.$this->backups_folder_name;
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true);
        }
        
        $salida_sql = $this->backups_path.$this->backups_folder_name.$db_name.'_'.$fecha.'.sql'; 

        if (env('DB_CONNECTION') == 'pgsql') {
            $dump = 'PGPASSWORD="'.$db_pass.'" pg_dump --dbname='.$db_name.' --username='.$db_user.' --host='.$db_host.' --port='.env('DB_PORT').' > '.$salida_sql;
        } else {
            $dump = "mysqldump --user=".$db_user." --password=".$db_pass." --host=".$db_host." ".$db_name." > $salida_sql";
        }

        exec($dump, $outpt, $return_var);
        
        if ($return_var == 0) {
            Alert::success('Copia de seguridad realizada correctamente','¡Enhorabuena!');
            return back();
        }else {
            Alert::error('Ocurrió un error al realizar la copia de seguridad','Opps!');
            return back();
        }
    }

    public function download($file_name)
    {
        $file = $this->backups_folder_name . $file_name;
        $disk = Storage::disk('local');
        if ($disk->exists($file)) {
            $fs = Storage::disk('local')->getDriver();
            $stream = $fs->readStream($file);
            return \Response::stream(function () use ($stream) {
                fpassthru($stream);
            }, 200, [
                "Content-Type" => $fs->getMimetype($file),
                "Content-Length" => $fs->getSize($file),
                "Content-disposition" => "attachment; filename=\"" . basename($file) . "\"",
            ]);
        } else {
            abort(404, "The backup file doesn't exist.");
        }
    }
    /**
     * Deletes a backup file.
     */
    public function delete($file_name)
    {
        $disk = Storage::disk('local');
        if ($disk->exists($this->backups_folder_name . $file_name)) {
            $disk->delete($this->backups_folder_name . $file_name);
            Alert::success('Copia de seguridad eliminada correctamente','¡Enhorabuena!');
            return redirect()->back();
        } else {
            abort(404, "The backup file doesn't exist.");
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

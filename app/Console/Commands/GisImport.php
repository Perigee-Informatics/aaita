<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GisImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:gis_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importing Gis data from json files';

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
       $this->import();
    }

    public function import(){
        ini_set( 'precision', 17 );
        ini_set( 'serialize_precision', -1 );
  
        // province data import
        // $data=json_decode(\file_get_contents(public_path().'/gis_data/Sudurpashchim_Province.json'));
        // foreach($data->features as $dt){
        //          DB::table('mst_fed_coordinates')->where('id',7)->update([
        //             "coordinates"=>json_encode($dt->geometry->coordinates[0])
        //          ]);
        // }

        // district data import
        // $data=json_decode(\file_get_contents(public_path().'/gis_data/Darchula_District.json'));
        // foreach($data->features as $dt){
        //          DB::table('mst_fed_coordinates')->where('id',168)->update([
        //             "coordinates"=>json_encode($dt->geometry->coordinates[0])
        //          ]);
        // }

        // district data import
        $data=json_decode(\file_get_contents(public_path().'/gis_data/Byas_Gaunpalika.json'));
        foreach($data->features as $dt){
                 DB::table('mst_fed_coordinates')->where('id',8660)->update([
                    "coordinates"=>json_encode($dt->geometry->coordinates[0])
                 ]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

class changelogController extends Controller
{
    public function localadress()
    {
        $json = database_path('changelog.json');
        $data = json_decode(file_get_contents($json), true);
        $data = array_reverse($data);
        return $data;
        
    }

    public function info_update()
    {
        $data = $this->localadress();
        $data = $data[0];
        $date = Carbon::parse($data["date"])->format("d M Y");
        $data["date"] = $date;
        return $data;
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GithubController extends Controller
{
    public function url_default()
    {
        return "https://api.github.com/repos/alexcaussades/bg";
    }

    public function release_last()
    {
        $url = $this->url_default() . "/releases/latest";
        $response = Http::get($url)->json();
        if (isset($response['tag_name'])) {
            $info = $response['tag_name'];
            return $info;
        } else {
             $info = "Version Inconnue";
            return $info;
        }
    }

    public function open_issues()
    {
        $url = $this->url_default();
        $response = Http::get($url)->json();
        if (isset($response['open_issues'])) {
            $info = $response['open_issues'];
            return $info;
        } else {
            $info = "--";
            return $info;
        }
    }
}

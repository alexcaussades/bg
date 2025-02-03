<?php


namespace App\Models;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use function Laravel\Prompts\note;

class NoteModel extends Model
{
    use HasFactory;

    protected $table = 'notes';

    protected $fillable = [
        'title',
        'content',
        'status',
        'puits_id',
        'uuid'
    ];

    public function storeNote($title, $content, $puits_id)
    {
        $this->title = $title;
        $this->uuid = $this->uuid();
        $this->puits_id = $puits_id;
        $this->content = $content;
        $this->save();
    }

    public function uuid()
    {
        $uuid = Str::uuid(6);
        return $uuid;
    }


    public function getNoteById($id)
    {
        return $this->find($id);
    }


}

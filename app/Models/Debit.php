<?php



namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debit extends Model
{
    use HasFactory;

    protected $table = 'debit';

    protected $fillable = [
        'type',
        'dimension',
        'ms',
        'debit'
    ];

    public function storeDebit($type, $dimension, $ms, $debit)
    {
        $this->type = $type;
        $this->dimension = $dimension;
        $this->ms = $ms;
        $this->debit = $debit;
        $this->save();
    }

    public function getDebit()
    {
        return $this->all()->orderBy('id', 'desc')->get();
    }
}
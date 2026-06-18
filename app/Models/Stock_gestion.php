<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock_gestion extends Model
{
    use HasFactory;

    protected $table = 'stocks';

    protected $fillable = [
        'name',
        'minimal_quantity',
        'quantity',
        'unit',
        'description',
        'etat_stock'
    ];

    public function getAllStocks()
    {
        return $this->all();
    }

    public function getStockById(int $id)
    {
        return $this->find($id);
    }

    public function updateStock(string $name, int $quantity)
    {
        $this->name = $name;
        $this->quantity = $quantity;
        $this->save();
    }

    public function sortieStock(string $name, int $quantity)
    {
        $stock = $this->where('name', $name)->first();
        if ($stock) {
            $stock->quantity -= $quantity;
            $stock->save();
        }
    }

    public function lastStock()
    {
        return $this->latest()->first();
    }

    public function last10StocksSortie()
    {
        return $this->orderBy('updated_at', 'desc')->take(10)->get();
    }

    public function storeStock(string $name, int $minimal_quantity, int $quantity, string $unit, string $description, string $etat_stock): void
    {
        $this->name = $name;
        $this->minimal_quantity = $minimal_quantity;
        $this->quantity = $quantity;
        $this->unit = $unit;
        $this->description = $description;
        $this->etat_stock = $etat_stock;
        $this->save();
    }

    /** faire une liste unique des etats de stock */
    public function getUniqueStockStates()
    {
        return $this->distinct()->pluck('etat_stock');
    }

    /** faire un array etat de stock avec "Sur site", "en commande", "En rupture", "Critique" */
    public function getStockStatesArray()
    {
        return ["Sur site", "en commande", "En rupture", "Critique"];
    }

    public function unitsArray()
    {
        return ["kg", "L", "m", "m²", "barre", "pièce", "palette", "carton"];
    }

    public function categoriesArray()
    {
        return ["Matériaux Gaziers", "Équipements Torchère", "Produits Attelier", "Autres"];
    }
}

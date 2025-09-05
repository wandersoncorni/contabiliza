<?php

namespace App\Application\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class TiposPagamento extends Model
{
    /**
     * Desabilita tabela física
     */
    protected $table = null;
    public $timestamps = false;
    protected $guarded = [];
    /**
     * "Registros fixos"
     */
    private static array $data = [
        ['id' => 1, 'nome' => 'Débito'],
        ['id' => 2, 'nome' => 'Crédito'],
        ['id' => 4, 'nome' => 'Boleto'],
        ['id' => 5, 'nome' => 'Pix'],
    ];
    /**
     * Retorna todos os registros como Collection de Models
     */
    public static function all($columns = ['*']): Collection
    {
        return collect(self::$data)->map(fn($item) => new static($item));
    }
    /**
     * Busca por ID
     */
    public static function find($id, $columns = ['*']): ?self
    {
        $item = collect(self::$data)->firstWhere('id', $id);
        return $item ? new static($item) : null;
    }
    /**
     * Busca pelo nome
     */
    public static function findByName(string $name): ?self
    {
        $item = collect(self::$data)->firstWhere('name', $name);
        return $item ? new static($item) : null;
    }
    /**
     * Query fake (para usar where, pluck, etc.)
     */
    public static function query(): Collection
    {
        return collect(self::$data)->map(fn($item) => new static($item));
    }
}

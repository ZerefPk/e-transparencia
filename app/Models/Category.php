<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model
{
    use HasFactory, HasSlug;

    protected $table = 'categories';

    protected $fillable = [

        'slug',
        'category',
        'color',
        'order',
        'deleted',
        'in_grafic',
        'special_field',
        'type',
        'status'

    ];

    protected $primaryKey = 'id';

    public static function types()
    {
        return [
            'Licitação' => [
                'bidding_modality' => 'Modalidade de Licitação',
                'bidding_type' => 'Tipo de Licitação',
                'bidding_situation' => 'Situação da Licitação',
                'bidding_finality'  => 'Finalidade de Licitação',
                'bidding_document'  => 'Documento de Licitação',
                'bidding_unity'     => 'Unidade de Medida',

            ],
            'Perguntas Frequentes' => [
                'faq' => 'Perguntas Frequentes',
            ],
            'Contratos' => [
                'contract_form' => 'Forma de Contratação',
                'contract_payment' => 'Forma de Pagamento',
                'contract_situation' => 'Situação do Contrato',
                'contract_finality' => 'Finalidade do Contrato',
                'contract_document' => 'Tipo de Documento',
                'contract_unity' => 'Unidade de Medida',
            ]


        ];

    }
    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('category')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(70);
    }
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

}

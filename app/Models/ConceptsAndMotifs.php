<?php

namespace App\Models;

use Kitar\Dynamodb\Model\Model;

class ConceptsAndMotifs extends Model
{
    protected $table = 'ConceptsAndMotifs';
    protected $primaryKey = 'PK';
    protected $sortKey = 'SK';
    protected $fillable = [
        'PK',
        'SK',
        'EntityType',
        'JobId',
        'ConceptId',
        'MotifId',
        'ConceptName',
        'MotifName',
        'Prompt',
        'Status',
        'ImageUrls',
        'CreatedAt',
        'UpdatedAt',
    ];
    protected $keyType = 'string';  // Specify the key type as string
    public $incrementing = false;
    public $timestamps = true;
}

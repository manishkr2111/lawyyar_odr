<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseModel extends Model
{
    use HasFactory;

    protected $table = 'cases';

    protected $fillable = [
        'user_id',
        'assigned_to',
        'loan_id',
        'full_name',
        'email',
        'amount',
        'due_date',
        'loan_agreement',
        'phone',
        'category',
        'title',
        'description',
        'loan_amount',
        'recovered_loan_amount',
        'file',
        'status'
    ];
}

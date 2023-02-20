<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

use GuzzleHttp\Psr7\Request;

class Todo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'ToDos';
    protected $primaryKey = 'id';

    protected $fillable = [
        'content',
        'status',
        'due_date',
    ];

    const STATUS = [
        1 => ['label' => '未完了', 'class' => 'label-danger'],
        2 => ['label' => '取り込み中', 'class' => 'label-info'],
        3 => ['label' => '完了', 'class' => ''],
    ];

    public function getStatusLabel()
    {

        $status = $this->attributes['status'];

        if (!isset(self::STATUS[$status])) {

            return '';
        }

        return self::STATUS[$status]['label'];
    }

    public function getStatusClass()
    {

        $status = $this->attributes['status'];

        if (!isset(self::STATUS[$status])) {

            return '';
        }

        return self::STATUS[$status]['class'];
    }

    public function getFormattedDueDateAttribute()
    {

        return  Carbon::createFromFormat('Y-m-d', $this->attributes['due_date'])
            ->format('Y/m/d');
    }

}

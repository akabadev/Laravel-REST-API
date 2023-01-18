<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ImportProcessing extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'line',
        'content',
        'has_error',
        'errors',
        'message',
    ];

    protected $casts = ["errors" => "array"];

    protected $table = "import_processing";

    /**
     * @param Task $task
     * @param int $line
     * @param string $content
     * @param array|null $errors
     * @param string $message
     * @return ImportProcessing
     */
    public static function init(Task &$task, int $line, string $content, ?array $errors = null, string $message = ""): static
    {
        $task_id = $task->id;
        $has_error = null !== $errors || (is_array($errors) && count($errors) > 0);

        return static::create(compact(
            'task_id',
            'line',
            'has_error',
            'content',
            'errors',
            'message',
        ));
    }
}

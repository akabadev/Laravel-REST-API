<?php

namespace App\Models;

use App\Jobs\Job;
use App\Models\Concerns\HasListing;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Queue;
use ReflectionClass;
use ReflectionException;

/**
 * @OA\Schema(
 *     @OA\Xml(name="Task"),
 *     @OA\Property(property="comment", type="string", example="Comment here ..."),
 *     @OA\Property(property="attempts", type="integer", example="1"),
 *     @OA\Property(property="payload", type="array", example="[]", @OA\Items()),
 *     @OA\Property(property="status_id", type="integer", example="1"),
 *     @OA\Property(property="process_id", type="integer", example="1"),
 *     @OA\Property(property="limited_at", type="string", format="datetime", description="Limit timestamp", readOnly="true"),
 *     @OA\Property(property="available_at", type="string", format="datetime", description="Available timestamp", readOnly="true"),
 *     @OA\Property(property="queued_at", type="string", format="datetime", description="Queue timestamp", readOnly="true"),
 *     @OA\Property(property="started_at", type="string", format="datetime", description="Start timestamp", readOnly="true"),
 *     @OA\Property(property="ended_at", type="string", format="datetime", description="End timestamp", readOnly="true"),
 *     @OA\Property(property="status", ref="#/components/schemas/Listing")
 * )
 *
 * Class Task
 * @property Process $process
 * @property array payload
 * @property Carbon limited_at
 * @property Carbon available_at
 * @property string concrete
 * @package App\Models
 */
class Task extends Model
{
    use HasFactory, HasListing {
        setListingState as baseSetListingState;
    }

    protected $table = 'tasks';

    protected $fillable = [
        'process_id',
        'status_id',
        'payload',
        'attempts',
        'limited_at',
        'available_at',
        'queued_at',
        'started_at',
        'ended_at',
        'comment',
        'concrete',
    ];

    protected $hidden = [
        'process_id',
        'status_id',
        'payload',
        'deleted_at',
        'created_at',
        'updated_at',
        'concrete',
    ];

    protected $appends = ['status', 'process'];

    protected $casts = [
        'payload' => 'array',
        'available_at' => 'datetime',
        'limited_at' => 'datetime',
        'queued_at' => 'datetime',
        'started_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    protected static array $comments = [];

    protected static function boot()
    {
        parent::boot();
        self::saving(fn (Task $task) => $task->concrete = static::class);
    }

    /**
     * @param Process $process
     * @param Listing $listing
     * @param array $payload
     * @param Carbon|null $available_at
     * @param string $comment
     * @return static
     */
    public static function softCreate(Process $process, Listing $listing, array $payload = [], ?Carbon $available_at = null, string $comment = ""): static
    {
        return static::create([
            'process_id' => $process->id,
            'status_id' => $listing->id,
            'payload' => $payload,
            'available_at' => $available_at ?: now(),
            'comment' => $comment ?: self::getComment("-"),
            'concrete' => static::class,
        ]);
    }

    /**
     * @return string
     */
    protected function listingKeyName(): string
    {
        return 'status_id';
    }

    /**
     * @return BelongsTo
     */
    public function process(): BelongsTo
    {
        return $this->belongsTo(Process::class, 'process_id', 'id');
    }

    /**
     * @return Listing
     */
    public function getStatusAttribute(): Listing
    {
        return $this->getCurrentStep();
    }

    /**
     * @return Process
     */
    public function getProcessAttribute(): Process
    {
        return $this->process()->firstOrFail();
    }

    /**
     * @return Job|null
     * @throws ReflectionException
     */
    public function invokable(): ?Job
    {
        $reflection = (new ReflectionClass($this->process->invokable));

        if ($reflection->getMethod('instance')) {
            $job = $reflection->getMethod('instance')->invoke(null, $this);
        } else {
            $job = app($this->process->invokable, [$this]);
        }

        return $job;
    }

    /**
     * @return bool
     */
    public function isPast(): bool
    {
        return $this->limited_at && $this->limited_at->isPast();
    }

    /**
     * @return bool
     */
    public function isQueued(): bool
    {
        return !!$this->queued_at;
    }

    public function onQueue()
    {
        $this->toNextStep();
    }

    /**
     * @return Task
     */
    public function concrete(): mixed
    {
        return !$this->concrete ? $this : call_user_func("$this->concrete::findOrFail", $this->id);
    }

    private function baseToArray(): array
    {
        return parent::toArray();
    }

    public function toArray()
    {
        return Task::class === $this->concrete ? $this->baseToArray() : $this->concrete()->concreteToArray();
    }

    protected function concreteToArray(): array
    {
        return parent::toArray();
    }

    /**
     * @param string $queue
     * @throws ReflectionException
     */
    public function queue(string $queue = 'tasks')
    {
        Queue::laterOn($queue, $this->available_at, $this->invokable(), $this->payload);
        $this->tapDateTime("queued_at");
        $this->onQueue();
    }

    public function failed()
    {
        $this->end();
    }

    public function succeeded()
    {
        $this->end();
    }

    public function start()
    {
        $this->increment('attempts');
        $this->tapDateTime("started_at");
    }

    public function end()
    {
        $this->tapDateTime('ended_at');
    }

    /**
     * @param string $code
     */
    public function setListingState(string $code)
    {
        $this->update(["comment" => $this->getComment($code)]);
        $this->baseSetListingState($code);
    }

    public static function getComment(string $code)
    {
        return self::$comments[$code] ?? '-';
    }
}

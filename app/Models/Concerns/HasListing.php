<?php

namespace App\Models\Concerns;

use App\Models\Listing;
use App\Models\Model;

trait HasListing
{
    /**
     * @param string $code
     * @param bool $orFail
     * @return Listing
     */
    public static function getListingByCode(string $code, bool $orFail = true): Listing
    {
        $builder = Listing::where('code', $code);
        return $orFail ? $builder->firstOrFail() : $builder->first();
    }

    /**
     * @return Model|Listing
     */
    public function getCurrentStep(): Listing|Model
    {
        return Listing::findOrFail($this->{$this->listingKeyName()});
    }

    /**
     * @return Listing|null
     */
    final public function getNextStep(): ?Listing
    {
        return $this->getCurrentStep()->next();
    }

    /**
     * @return Listing|null
     */
    final public function getPreviousStep(): ?Listing
    {
        return $this->getCurrentStep()->previous();
    }

    final public function toNextStep(): void
    {
        $next = $this->getNextStep();
        if ($next) {
            $this->update([$this->listingKeyName() => $next->id]);
        }
    }

    final public function toPreviousStep(): void
    {
        $previous = $this->getPreviousStep();
        if ($previous) {
            $this->update([$this->listingKeyName() => $previous->id]);
        }
    }

    public function setListingState(string $code)
    {
        $this->update([$this->listingKeyName() => static::getListingByCode($code)->id]);
    }

    /**
     * @return string
     */
    protected function listingKeyName(): string
    {
        return 'sequence_id';
    }
}

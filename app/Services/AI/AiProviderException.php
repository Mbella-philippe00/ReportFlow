<?php

namespace App\Services\AI;

use RuntimeException;
use Throwable;

class AiProviderException extends RuntimeException
{
    public function __construct(
        protected string $provider,
        string $message,
        protected int $httpStatus = 503,
        protected ?string $reason = null,
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, 0, $previous);
    }

    public function provider(): string
    {
        return $this->provider;
    }

    public function httpStatus(): int
    {
        return $this->httpStatus;
    }

    public function reason(): ?string
    {
        return $this->reason;
    }

    public function isGeminiQuotaExceeded(): bool
    {
        return $this->provider === ProviderResolver::PROVIDER_GEMINI
            && $this->reason === 'resource_exhausted';
    }

    public static function combined(self $primary, self $fallback): self
    {
        return new self(
            provider: $primary->provider(),
            message: $primary->getMessage().' '.$fallback->getMessage(),
            httpStatus: 503,
            reason: 'providers_unavailable',
            previous: $fallback,
        );
    }
}

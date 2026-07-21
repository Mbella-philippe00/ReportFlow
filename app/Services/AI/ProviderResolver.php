<?php

namespace App\Services\AI;

class ProviderResolver
{
    public const PROVIDER_OPENAI = 'openai';

    public const PROVIDER_GEMINI = 'gemini';

    public function activeProvider(): string
    {
        $provider = strtolower((string) config('ai.provider', self::PROVIDER_GEMINI));

        if (! in_array($provider, $this->supportedProviders(), true)) {
            throw new AiProviderException(
                provider: $provider,
                message: 'Provider unavailable.',
                reason: 'unsupported_provider',
            );
        }

        return $provider;
    }

    public function supportedProviders(): array
    {
        return [
            self::PROVIDER_OPENAI,
            self::PROVIDER_GEMINI,
        ];
    }

    public function isConfigured(string $provider): bool
    {
        return filled($this->apiKey($provider)) && filled($this->model($provider));
    }

    public function label(string $provider): string
    {
        return match ($provider) {
            self::PROVIDER_OPENAI => 'OpenAI',
            self::PROVIDER_GEMINI => 'Google Gemini',
            default => 'Unknown Provider',
        };
    }

    public function apiKey(string $provider): ?string
    {
        return $this->configValue($provider, 'api_key');
    }

    public function model(string $provider): ?string
    {
        return $this->configValue($provider, 'model');
    }

    public function baseUri(string $provider): string
    {
        return rtrim((string) $this->configValue($provider, 'base_uri'), '/');
    }

    public function timeout(string $provider): int
    {
        return (int) ($this->configValue($provider, 'timeout') ?: 30);
    }

    public function providers(): array
    {
        $activeProvider = $this->activeProvider();

        return array_map(
            fn (string $provider): array => [
                'name' => $provider,
                'label' => $this->label($provider),
                'configured' => $this->isConfigured($provider),
                'active' => $provider === $activeProvider,
                'models' => array_values(array_filter([
                    $this->model($provider),
                ])),
                'default_model' => $this->model($provider),
            ],
            $this->supportedProviders(),
        );
    }

    private function configValue(string $provider, string $key): ?string
    {
        $value = config("ai.providers.{$provider}.{$key}");

        return is_scalar($value) ? (string) $value : null;
    }
}

<?php

namespace App\Services\AI;

use App\Models\WeeklyReport;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class WeeklyReportAiService
{
    protected ?array $lastProvider = null;

    public function __construct(
        protected AiPromptCatalog $prompts,
        protected ProviderResolver $providers,
    ) {}

    public function generateExecutiveSummary(
        WeeklyReport $report
    ): string {
        return $this->generateFromPrompt(
            $this->prompts->executiveSummary($report),
        );
    }

    public function generateFromPrompt(string $prompt): string
    {
        $this->lastProvider = null;
        $provider = $this->providers->activeProvider();

        try {
            return $this->generateWithProvider($provider, $prompt);
        } catch (AiProviderException $exception) {
            $fallbackProvider = $this->fallbackProvider($provider, $exception);

            if ($fallbackProvider === null) {
                throw $exception;
            }

            try {
                return $this->generateWithProvider($fallbackProvider, $prompt);
            } catch (AiProviderException $fallbackException) {
                throw AiProviderException::combined($exception, $fallbackException);
            }
        }
    }

    public function lastProviderName(): ?string
    {
        return $this->lastProvider['provider'] ?? null;
    }

    public function lastModelName(): ?string
    {
        return $this->lastProvider['model'] ?? null;
    }

    private function generateWithProvider(string $provider, string $prompt): string
    {
        return match ($provider) {
            ProviderResolver::PROVIDER_OPENAI => $this->generateWithOpenAi($prompt),
            ProviderResolver::PROVIDER_GEMINI => $this->generateWithGemini($prompt),
            default => throw new AiProviderException(
                provider: $provider,
                message: 'Provider unavailable.',
                reason: 'unsupported_provider',
            ),
        };
    }

    private function generateWithGemini(string $prompt): string
    {
        $apiKey = $this->providers->apiKey(ProviderResolver::PROVIDER_GEMINI);
        $model = $this->providers->model(ProviderResolver::PROVIDER_GEMINI);

        if (blank($apiKey)) {
            throw new AiProviderException(
                provider: ProviderResolver::PROVIDER_GEMINI,
                message: 'Gemini API key missing.',
                reason: 'missing_api_key',
            );
        }

        if (blank($model)) {
            throw new AiProviderException(
                provider: ProviderResolver::PROVIDER_GEMINI,
                message: 'Gemini model missing.',
                reason: 'missing_model',
            );
        }

        $response = Http::timeout($this->providers->timeout(ProviderResolver::PROVIDER_GEMINI))
            ->post(
                $this->providers->baseUri(ProviderResolver::PROVIDER_GEMINI)
                    .'/models/'
                    .$model
                    .':generateContent?key='
                    .$apiKey,
                [
                    'contents' => [
                        [
                            'parts' => [
                                [
                                    'text' => $prompt,
                                ],
                            ],
                        ],
                    ],
                ],
            );

        if (! $response->successful()) {
            throw $this->geminiException($response);
        }

        $text = $response->json('candidates.0.content.parts.0.text');

        if (! is_string($text) || trim($text) === '') {
            throw new AiProviderException(
                provider: ProviderResolver::PROVIDER_GEMINI,
                message: 'Gemini provider unavailable.',
                reason: 'empty_response',
            );
        }

        $this->lastProvider = [
            'provider' => ProviderResolver::PROVIDER_GEMINI,
            'model' => $model,
        ];

        return trim($text);
    }

    private function generateWithOpenAi(string $prompt): string
    {
        $apiKey = $this->providers->apiKey(ProviderResolver::PROVIDER_OPENAI);
        $model = $this->providers->model(ProviderResolver::PROVIDER_OPENAI);

        if (blank($apiKey)) {
            throw new AiProviderException(
                provider: ProviderResolver::PROVIDER_OPENAI,
                message: 'OpenAI API key missing.',
                reason: 'missing_api_key',
            );
        }

        if (blank($model)) {
            throw new AiProviderException(
                provider: ProviderResolver::PROVIDER_OPENAI,
                message: 'OpenAI model missing.',
                reason: 'missing_model',
            );
        }

        $response = Http::timeout($this->providers->timeout(ProviderResolver::PROVIDER_OPENAI))
            ->withToken($apiKey)
            ->acceptJson()
            ->post(
                $this->providers->baseUri(ProviderResolver::PROVIDER_OPENAI).'/responses',
                [
                    'model' => $model,
                    'input' => [
                        [
                            'role' => 'user',
                            'content' => [
                                [
                                    'type' => 'input_text',
                                    'text' => $prompt,
                                ],
                            ],
                        ],
                    ],
                ],
            );

        if (! $response->successful()) {
            throw $this->openAiException($response);
        }

        $text = $this->extractOpenAiText($response);

        if (! is_string($text) || trim($text) === '') {
            throw new AiProviderException(
                provider: ProviderResolver::PROVIDER_OPENAI,
                message: 'OpenAI provider unavailable.',
                reason: 'empty_response',
            );
        }

        $this->lastProvider = [
            'provider' => ProviderResolver::PROVIDER_OPENAI,
            'model' => $model,
        ];

        return trim($text);
    }

    private function fallbackProvider(string $provider, AiProviderException $exception): ?string
    {
        if (
            $provider === ProviderResolver::PROVIDER_GEMINI
            && $exception->isGeminiQuotaExceeded()
            && $this->providers->isConfigured(ProviderResolver::PROVIDER_OPENAI)
        ) {
            return ProviderResolver::PROVIDER_OPENAI;
        }

        if (
            $provider === ProviderResolver::PROVIDER_OPENAI
            && $this->providers->isConfigured(ProviderResolver::PROVIDER_GEMINI)
        ) {
            return ProviderResolver::PROVIDER_GEMINI;
        }

        return null;
    }

    private function geminiException(Response $response): AiProviderException
    {
        $reason = $response->json('error.status');

        if ($response->status() === 429 && $reason === 'RESOURCE_EXHAUSTED') {
            return new AiProviderException(
                provider: ProviderResolver::PROVIDER_GEMINI,
                message: 'Gemini quota exceeded.',
                httpStatus: 429,
                reason: 'resource_exhausted',
            );
        }

        if (in_array($response->status(), [401, 403], true)) {
            return new AiProviderException(
                provider: ProviderResolver::PROVIDER_GEMINI,
                message: 'Invalid Gemini API key.',
                httpStatus: 401,
                reason: 'invalid_api_key',
            );
        }

        return new AiProviderException(
            provider: ProviderResolver::PROVIDER_GEMINI,
            message: 'Gemini provider unavailable.',
            reason: 'provider_unavailable',
        );
    }

    private function openAiException(Response $response): AiProviderException
    {
        if (in_array($response->status(), [401, 403], true)) {
            return new AiProviderException(
                provider: ProviderResolver::PROVIDER_OPENAI,
                message: 'Invalid OpenAI API key.',
                httpStatus: 401,
                reason: 'invalid_api_key',
            );
        }

        if ($response->status() === 429) {
            return new AiProviderException(
                provider: ProviderResolver::PROVIDER_OPENAI,
                message: 'OpenAI rate limit exceeded.',
                httpStatus: 429,
                reason: 'rate_limited',
            );
        }

        return new AiProviderException(
            provider: ProviderResolver::PROVIDER_OPENAI,
            message: 'OpenAI provider unavailable.',
            reason: 'provider_unavailable',
        );
    }

    private function extractOpenAiText(Response $response): ?string
    {
        $text = $response->json('output_text')
            ?? $response->json('output.0.content.0.text')
            ?? $response->json('choices.0.message.content');

        return is_string($text) ? $text : null;
    }
}
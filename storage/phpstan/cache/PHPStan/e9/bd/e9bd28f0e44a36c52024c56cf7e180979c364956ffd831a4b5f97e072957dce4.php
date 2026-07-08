<?php declare(strict_types = 1);

// osfsl-/var/www/html/vendor/composer/../laravel/framework/src/Illuminate/Http/Client/PendingRequest.php-PHPStan\BetterReflection\Reflection\ReflectionClass-Illuminate\Http\Client\PendingRequest
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-afec38eacf1401327792d4cbd94e65b82516e6e995291419245755b8efcd3fda-8.5.7-6.70.0.1',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'Illuminate\\Http\\Client\\PendingRequest',
        'filename' => '/var/www/html/vendor/composer/../laravel/framework/src/Illuminate/Http/Client/PendingRequest.php',
      ),
    ),
    'namespace' => 'Illuminate\\Http\\Client',
    'name' => 'Illuminate\\Http\\Client\\PendingRequest',
    'shortName' => 'PendingRequest',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 0,
    'docComment' => '/**
 * @template TAsync of bool = false
 */',
    'attributes' => 
    array (
    ),
    'startLine' => 40,
    'endLine' => 2135,
    'startColumn' => 1,
    'endColumn' => 1,
    'parentClassName' => NULL,
    'implementsClassNames' => 
    array (
    ),
    'traitClassNames' => 
    array (
      0 => 'Illuminate\\Support\\Traits\\Conditionable',
      1 => 'Illuminate\\Support\\Traits\\Macroable',
    ),
    'immediateConstants' => 
    array (
    ),
    'immediateProperties' => 
    array (
      'factory' => 
      array (
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'name' => 'factory',
        'modifiers' => 2,
        'type' => NULL,
        'default' => NULL,
        'docComment' => '/**
 * The factory instance.
 *
 * @var \\Illuminate\\Http\\Client\\Factory|null
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 49,
        'endLine' => 49,
        'startColumn' => 5,
        'endColumn' => 23,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'client' => 
      array (
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'name' => 'client',
        'modifiers' => 2,
        'type' => NULL,
        'default' => NULL,
        'docComment' => '/**
 * The Guzzle client instance.
 *
 * @var \\GuzzleHttp\\Client
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 56,
        'endLine' => 56,
        'startColumn' => 5,
        'endColumn' => 22,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'handler' => 
      array (
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'name' => 'handler',
        'modifiers' => 2,
        'type' => NULL,
        'default' => NULL,
        'docComment' => '/**
 * The Guzzle HTTP handler.
 *
 * @var callable
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 63,
        'endLine' => 63,
        'startColumn' => 5,
        'endColumn' => 23,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'baseUrl' => 
      array (
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'name' => 'baseUrl',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => '\'\'',
          'attributes' => 
          array (
            'startLine' => 70,
            'endLine' => 70,
            'startTokenPos' => 207,
            'startFilePos' => 1712,
            'endTokenPos' => 207,
            'endFilePos' => 1713,
          ),
        ),
        'docComment' => '/**
 * The base URL for the request.
 *
 * @var string
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 70,
        'endLine' => 70,
        'startColumn' => 5,
        'endColumn' => 28,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'urlParameters' => 
      array (
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'name' => 'urlParameters',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => '[]',
          'attributes' => 
          array (
            'startLine' => 77,
            'endLine' => 77,
            'startTokenPos' => 218,
            'startFilePos' => 1849,
            'endTokenPos' => 219,
            'endFilePos' => 1850,
          ),
        ),
        'docComment' => '/**
 * The parameters that can be substituted into the URL.
 *
 * @var array
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 77,
        'endLine' => 77,
        'startColumn' => 5,
        'endColumn' => 34,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'bodyFormat' => 
      array (
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'name' => 'bodyFormat',
        'modifiers' => 2,
        'type' => NULL,
        'default' => NULL,
        'docComment' => '/**
 * The request body format.
 *
 * @var string
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 84,
        'endLine' => 84,
        'startColumn' => 5,
        'endColumn' => 26,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'pendingBody' => 
      array (
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'name' => 'pendingBody',
        'modifiers' => 2,
        'type' => NULL,
        'default' => NULL,
        'docComment' => '/**
 * The raw body for the request.
 *
 * @var \\Psr\\Http\\Message\\StreamInterface|string
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 91,
        'endLine' => 91,
        'startColumn' => 5,
        'endColumn' => 27,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'pendingFiles' => 
      array (
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'name' => 'pendingFiles',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => '[]',
          'attributes' => 
          array (
            'startLine' => 98,
            'endLine' => 98,
            'startTokenPos' => 244,
            'startFilePos' => 2211,
            'endTokenPos' => 245,
            'endFilePos' => 2212,
          ),
        ),
        'docComment' => '/**
 * The pending files for the request.
 *
 * @var array
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 98,
        'endLine' => 98,
        'startColumn' => 5,
        'endColumn' => 33,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'cookies' => 
      array (
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'name' => 'cookies',
        'modifiers' => 2,
        'type' => NULL,
        'default' => NULL,
        'docComment' => '/**
 * The request cookies.
 *
 * @var array
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 105,
        'endLine' => 105,
        'startColumn' => 5,
        'endColumn' => 23,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'transferStats' => 
      array (
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'name' => 'transferStats',
        'modifiers' => 2,
        'type' => NULL,
        'default' => NULL,
        'docComment' => '/**
 * The transfer stats for the request.
 *
 * @var \\GuzzleHttp\\TransferStats
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 112,
        'endLine' => 112,
        'startColumn' => 5,
        'endColumn' => 29,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'options' => 
      array (
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'name' => 'options',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => '[]',
          'attributes' => 
          array (
            'startLine' => 119,
            'endLine' => 119,
            'startTokenPos' => 270,
            'startFilePos' => 2539,
            'endTokenPos' => 271,
            'endFilePos' => 2540,
          ),
        ),
        'docComment' => '/**
 * The request options.
 *
 * @var array
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 119,
        'endLine' => 119,
        'startColumn' => 5,
        'endColumn' => 28,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'throwCallback' => 
      array (
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'name' => 'throwCallback',
        'modifiers' => 2,
        'type' => NULL,
        'default' => NULL,
        'docComment' => '/**
 * A callback to run when throwing if a server or client error occurs.
 *
 * @var \\Closure
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 126,
        'endLine' => 126,
        'startColumn' => 5,
        'endColumn' => 29,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'throwIfCallback' => 
      array (
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'name' => 'throwIfCallback',
        'modifiers' => 2,
        'type' => NULL,
        'default' => NULL,
        'docComment' => '/**
 * A callback to check if an exception should be thrown when a server or client error occurs.
 *
 * @var \\Closure
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 133,
        'endLine' => 133,
        'startColumn' => 5,
        'endColumn' => 31,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'tries' => 
      array (
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'name' => 'tries',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => '1',
          'attributes' => 
          array (
            'startLine' => 140,
            'endLine' => 140,
            'startTokenPos' => 296,
            'startFilePos' => 2978,
            'endTokenPos' => 296,
            'endFilePos' => 2978,
          ),
        ),
        'docComment' => '/**
 * The number of times to try the request.
 *
 * @var int
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 140,
        'endLine' => 140,
        'startColumn' => 5,
        'endColumn' => 25,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'retryDelay' => 
      array (
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'name' => 'retryDelay',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => '100',
          'attributes' => 
          array (
            'startLine' => 147,
            'endLine' => 147,
            'startTokenPos' => 307,
            'startFilePos' => 3135,
            'endTokenPos' => 307,
            'endFilePos' => 3137,
          ),
        ),
        'docComment' => '/**
 * The number of milliseconds to wait between retries.
 *
 * @var (Closure(int, mixed): int)|int
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 147,
        'endLine' => 147,
        'startColumn' => 5,
        'endColumn' => 32,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'retryThrow' => 
      array (
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'name' => 'retryThrow',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => 'true',
          'attributes' => 
          array (
            'startLine' => 154,
            'endLine' => 154,
            'startTokenPos' => 318,
            'startFilePos' => 3269,
            'endTokenPos' => 318,
            'endFilePos' => 3272,
          ),
        ),
        'docComment' => '/**
 * Whether to throw an exception when all retries fail.
 *
 * @var bool
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 154,
        'endLine' => 154,
        'startColumn' => 5,
        'endColumn' => 33,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'retryWhenCallback' => 
      array (
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'name' => 'retryWhenCallback',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => 'null',
          'attributes' => 
          array (
            'startLine' => 161,
            'endLine' => 161,
            'startTokenPos' => 329,
            'startFilePos' => 3475,
            'endTokenPos' => 329,
            'endFilePos' => 3478,
          ),
        ),
        'docComment' => '/**
 * The callback that will determine if the request should be retried.
 *
 * @var (callable(\\Throwable, static, string|null): bool)|null
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 161,
        'endLine' => 161,
        'startColumn' => 5,
        'endColumn' => 40,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'beforeSendingCallbacks' => 
      array (
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'name' => 'beforeSendingCallbacks',
        'modifiers' => 2,
        'type' => NULL,
        'default' => NULL,
        'docComment' => '/**
 * The callbacks that should execute before the request is sent.
 *
 * @var \\Illuminate\\Support\\Collection
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 168,
        'endLine' => 168,
        'startColumn' => 5,
        'endColumn' => 38,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'afterResponseCallbacks' => 
      array (
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'name' => 'afterResponseCallbacks',
        'modifiers' => 2,
        'type' => NULL,
        'default' => NULL,
        'docComment' => '/**
 * The callbacks that should execute after the Laravel Response is built.
 *
 * @var \\Illuminate\\Support\\Collection<int, (callable(\\Illuminate\\Http\\Client\\Response, \\Illuminate\\Http\\Client\\Request): \\Illuminate\\Http\\Client\\Response|null)>
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 175,
        'endLine' => 175,
        'startColumn' => 5,
        'endColumn' => 38,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'stubCallbacks' => 
      array (
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'name' => 'stubCallbacks',
        'modifiers' => 2,
        'type' => NULL,
        'default' => NULL,
        'docComment' => '/**
 * The stub callables that will handle requests.
 *
 * @var \\Illuminate\\Support\\Collection|null
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 182,
        'endLine' => 182,
        'startColumn' => 5,
        'endColumn' => 29,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'preventStrayRequests' => 
      array (
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'name' => 'preventStrayRequests',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => 'false',
          'attributes' => 
          array (
            'startLine' => 189,
            'endLine' => 189,
            'startTokenPos' => 361,
            'startFilePos' => 4278,
            'endTokenPos' => 361,
            'endFilePos' => 4282,
          ),
        ),
        'docComment' => '/**
 * Indicates that an exception should be thrown if any request is not faked.
 *
 * @var bool
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 189,
        'endLine' => 189,
        'startColumn' => 5,
        'endColumn' => 44,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'allowedStrayRequestUrls' => 
      array (
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'name' => 'allowedStrayRequestUrls',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => '[]',
          'attributes' => 
          array (
            'startLine' => 196,
            'endLine' => 196,
            'startTokenPos' => 372,
            'startFilePos' => 4463,
            'endTokenPos' => 373,
            'endFilePos' => 4464,
          ),
        ),
        'docComment' => '/**
 * A list of URL patterns that are allowed to bypass the stray request guard.
 *
 * @var array<int, string>
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 196,
        'endLine' => 196,
        'startColumn' => 5,
        'endColumn' => 44,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'middleware' => 
      array (
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'name' => 'middleware',
        'modifiers' => 2,
        'type' => NULL,
        'default' => NULL,
        'docComment' => '/**
 * The middleware callables added by users that will handle requests.
 *
 * @var \\Illuminate\\Support\\Collection
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 203,
        'endLine' => 203,
        'startColumn' => 5,
        'endColumn' => 26,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'async' => 
      array (
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'name' => 'async',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => 'false',
          'attributes' => 
          array (
            'startLine' => 210,
            'endLine' => 210,
            'startTokenPos' => 391,
            'startFilePos' => 4753,
            'endTokenPos' => 391,
            'endFilePos' => 4757,
          ),
        ),
        'docComment' => '/**
 * Whether the requests should be asynchronous.
 *
 * @var TAsync
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 210,
        'endLine' => 210,
        'startColumn' => 5,
        'endColumn' => 29,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'attributes' => 
      array (
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'name' => 'attributes',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => '[]',
          'attributes' => 
          array (
            'startLine' => 217,
            'endLine' => 217,
            'startTokenPos' => 402,
            'startFilePos' => 4897,
            'endTokenPos' => 403,
            'endFilePos' => 4898,
          ),
        ),
        'docComment' => '/**
 * The attributes to track with the request.
 *
 * @var array<array-key, mixed>
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 217,
        'endLine' => 217,
        'startColumn' => 5,
        'endColumn' => 31,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'promise' => 
      array (
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'name' => 'promise',
        'modifiers' => 2,
        'type' => NULL,
        'default' => NULL,
        'docComment' => '/**
 * The pending request promise.
 *
 * @var \\GuzzleHttp\\Promise\\PromiseInterface
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 224,
        'endLine' => 224,
        'startColumn' => 5,
        'endColumn' => 23,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'request' => 
      array (
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'name' => 'request',
        'modifiers' => 2,
        'type' => NULL,
        'default' => NULL,
        'docComment' => '/**
 * The sent request object, if a request has been made.
 *
 * @var \\Illuminate\\Http\\Client\\Request|null
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 231,
        'endLine' => 231,
        'startColumn' => 5,
        'endColumn' => 23,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'mergeableOptions' => 
      array (
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'name' => 'mergeableOptions',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => '[\'cookies\', \'form_params\', \'headers\', \'json\', \'multipart\', \'query\']',
          'attributes' => 
          array (
            'startLine' => 238,
            'endLine' => 245,
            'startTokenPos' => 428,
            'startFilePos' => 5347,
            'endTokenPos' => 448,
            'endFilePos' => 5468,
          ),
        ),
        'docComment' => '/**
 * The Guzzle request options that are mergeable via array_merge_recursive.
 *
 * @var array
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 238,
        'endLine' => 245,
        'startColumn' => 5,
        'endColumn' => 6,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'truncateExceptionsAt' => 
      array (
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'name' => 'truncateExceptionsAt',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => 'null',
          'attributes' => 
          array (
            'startLine' => 252,
            'endLine' => 252,
            'startTokenPos' => 459,
            'startFilePos' => 5633,
            'endTokenPos' => 459,
            'endFilePos' => 5636,
          ),
        ),
        'docComment' => '/**
 * The length at which request exceptions will be truncated.
 *
 * @var int<1, max>|false|null
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 252,
        'endLine' => 252,
        'startColumn' => 5,
        'endColumn' => 43,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
    ),
    'immediateMethods' => 
    array (
      '__construct' => 
      array (
        'name' => '__construct',
        'parameters' => 
        array (
          'factory' => 
          array (
            'name' => 'factory',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 260,
                'endLine' => 260,
                'startTokenPos' => 477,
                'startFilePos' => 5853,
                'endTokenPos' => 477,
                'endFilePos' => 5856,
              ),
            ),
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionUnionType',
              'data' => 
              array (
                'types' => 
                array (
                  0 => 
                  array (
                    'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                    'data' => 
                    array (
                      'name' => 'Illuminate\\Http\\Client\\Factory',
                      'isIdentifier' => false,
                    ),
                  ),
                  1 => 
                  array (
                    'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                    'data' => 
                    array (
                      'name' => 'null',
                      'isIdentifier' => true,
                    ),
                  ),
                ),
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 260,
            'endLine' => 260,
            'startColumn' => 33,
            'endColumn' => 56,
            'parameterIndex' => 0,
            'isOptional' => true,
          ),
          'middleware' => 
          array (
            'name' => 'middleware',
            'default' => 
            array (
              'code' => '[]',
              'attributes' => 
              array (
                'startLine' => 260,
                'endLine' => 260,
                'startTokenPos' => 484,
                'startFilePos' => 5873,
                'endTokenPos' => 485,
                'endFilePos' => 5874,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 260,
            'endLine' => 260,
            'startColumn' => 59,
            'endColumn' => 74,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Create a new HTTP Client instance.
 *
 * @param  \\Illuminate\\Http\\Client\\Factory|null  $factory
 * @param  array  $middleware
 */',
        'startLine' => 260,
        'endLine' => 282,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'baseUrl' => 
      array (
        'name' => 'baseUrl',
        'parameters' => 
        array (
          'url' => 
          array (
            'name' => 'url',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 290,
            'endLine' => 290,
            'startColumn' => 29,
            'endColumn' => 39,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Set the base URL for the pending request.
 *
 * @param  string  $url
 * @return $this
 */',
        'startLine' => 290,
        'endLine' => 295,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'withBody' => 
      array (
        'name' => 'withBody',
        'parameters' => 
        array (
          'content' => 
          array (
            'name' => 'content',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 304,
            'endLine' => 304,
            'startColumn' => 30,
            'endColumn' => 37,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'contentType' => 
          array (
            'name' => 'contentType',
            'default' => 
            array (
              'code' => '\'application/json\'',
              'attributes' => 
              array (
                'startLine' => 304,
                'endLine' => 304,
                'startTokenPos' => 684,
                'startFilePos' => 7064,
                'endTokenPos' => 684,
                'endFilePos' => 7081,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 304,
            'endLine' => 304,
            'startColumn' => 40,
            'endColumn' => 72,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Attach a raw body to the request.
 *
 * @param  \\Psr\\Http\\Message\\StreamInterface|string  $content
 * @param  string  $contentType
 * @return $this
 */',
        'startLine' => 304,
        'endLine' => 317,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'asJson' => 
      array (
        'name' => 'asJson',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Indicate the request contains JSON.
 *
 * @return $this
 */',
        'startLine' => 324,
        'endLine' => 327,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'asForm' => 
      array (
        'name' => 'asForm',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Indicate the request contains form parameters.
 *
 * @return $this
 */',
        'startLine' => 334,
        'endLine' => 337,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'attach' => 
      array (
        'name' => 'attach',
        'parameters' => 
        array (
          'name' => 
          array (
            'name' => 'name',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 348,
            'endLine' => 348,
            'startColumn' => 28,
            'endColumn' => 32,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'contents' => 
          array (
            'name' => 'contents',
            'default' => 
            array (
              'code' => '\'\'',
              'attributes' => 
              array (
                'startLine' => 348,
                'endLine' => 348,
                'startTokenPos' => 814,
                'startFilePos' => 8070,
                'endTokenPos' => 814,
                'endFilePos' => 8071,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 348,
            'endLine' => 348,
            'startColumn' => 35,
            'endColumn' => 48,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
          'filename' => 
          array (
            'name' => 'filename',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 348,
                'endLine' => 348,
                'startTokenPos' => 821,
                'startFilePos' => 8086,
                'endTokenPos' => 821,
                'endFilePos' => 8089,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 348,
            'endLine' => 348,
            'startColumn' => 51,
            'endColumn' => 66,
            'parameterIndex' => 2,
            'isOptional' => true,
          ),
          'headers' => 
          array (
            'name' => 'headers',
            'default' => 
            array (
              'code' => '[]',
              'attributes' => 
              array (
                'startLine' => 348,
                'endLine' => 348,
                'startTokenPos' => 830,
                'startFilePos' => 8109,
                'endTokenPos' => 831,
                'endFilePos' => 8110,
              ),
            ),
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 348,
            'endLine' => 348,
            'startColumn' => 69,
            'endColumn' => 87,
            'parameterIndex' => 3,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Attach a file to the request.
 *
 * @param  string|array  $name
 * @param  string|resource  $contents
 * @param  string|null  $filename
 * @param  array  $headers
 * @return $this
 */',
        'startLine' => 348,
        'endLine' => 373,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'asMultipart' => 
      array (
        'name' => 'asMultipart',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Indicate the request is a multi-part form request.
 *
 * @return $this
 */',
        'startLine' => 380,
        'endLine' => 383,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'bodyFormat' => 
      array (
        'name' => 'bodyFormat',
        'parameters' => 
        array (
          'format' => 
          array (
            'name' => 'format',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 391,
            'endLine' => 391,
            'startColumn' => 32,
            'endColumn' => 45,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Specify the body format of the request.
 *
 * @param  string  $format
 * @return $this
 */',
        'startLine' => 391,
        'endLine' => 396,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'withQueryParameters' => 
      array (
        'name' => 'withQueryParameters',
        'parameters' => 
        array (
          'parameters' => 
          array (
            'name' => 'parameters',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 404,
            'endLine' => 404,
            'startColumn' => 41,
            'endColumn' => 57,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Set the given query parameters in the request URI.
 *
 * @param  array  $parameters
 * @return $this
 */',
        'startLine' => 404,
        'endLine' => 411,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'contentType' => 
      array (
        'name' => 'contentType',
        'parameters' => 
        array (
          'contentType' => 
          array (
            'name' => 'contentType',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 419,
            'endLine' => 419,
            'startColumn' => 33,
            'endColumn' => 51,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Specify the request\'s content type.
 *
 * @param  string  $contentType
 * @return $this
 */',
        'startLine' => 419,
        'endLine' => 424,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'acceptJson' => 
      array (
        'name' => 'acceptJson',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Indicate that JSON should be returned by the server.
 *
 * @return $this
 */',
        'startLine' => 431,
        'endLine' => 434,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'accept' => 
      array (
        'name' => 'accept',
        'parameters' => 
        array (
          'contentType' => 
          array (
            'name' => 'contentType',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 442,
            'endLine' => 442,
            'startColumn' => 28,
            'endColumn' => 39,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Indicate the type of content that should be returned by the server.
 *
 * @param  string  $contentType
 * @return $this
 */',
        'startLine' => 442,
        'endLine' => 445,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'withHeaders' => 
      array (
        'name' => 'withHeaders',
        'parameters' => 
        array (
          'headers' => 
          array (
            'name' => 'headers',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 453,
            'endLine' => 453,
            'startColumn' => 33,
            'endColumn' => 46,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Add the given headers to the request.
 *
 * @param  array  $headers
 * @return $this
 */',
        'startLine' => 453,
        'endLine' => 460,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'withHeader' => 
      array (
        'name' => 'withHeader',
        'parameters' => 
        array (
          'name' => 
          array (
            'name' => 'name',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 469,
            'endLine' => 469,
            'startColumn' => 32,
            'endColumn' => 36,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'value' => 
          array (
            'name' => 'value',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 469,
            'endLine' => 469,
            'startColumn' => 39,
            'endColumn' => 44,
            'parameterIndex' => 1,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Add the given header to the request.
 *
 * @param  string  $name
 * @param  mixed  $value
 * @return $this
 */',
        'startLine' => 469,
        'endLine' => 472,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'replaceHeaders' => 
      array (
        'name' => 'replaceHeaders',
        'parameters' => 
        array (
          'headers' => 
          array (
            'name' => 'headers',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 480,
            'endLine' => 480,
            'startColumn' => 36,
            'endColumn' => 49,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Replace the given headers on the request.
 *
 * @param  array  $headers
 * @return $this
 */',
        'startLine' => 480,
        'endLine' => 485,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'withBasicAuth' => 
      array (
        'name' => 'withBasicAuth',
        'parameters' => 
        array (
          'username' => 
          array (
            'name' => 'username',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 494,
            'endLine' => 494,
            'startColumn' => 35,
            'endColumn' => 50,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'password' => 
          array (
            'name' => 'password',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 494,
            'endLine' => 494,
            'startColumn' => 53,
            'endColumn' => 68,
            'parameterIndex' => 1,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Specify the basic authentication username and password for the request.
 *
 * @param  string  $username
 * @param  string  $password
 * @return $this
 */',
        'startLine' => 494,
        'endLine' => 499,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'withDigestAuth' => 
      array (
        'name' => 'withDigestAuth',
        'parameters' => 
        array (
          'username' => 
          array (
            'name' => 'username',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 508,
            'endLine' => 508,
            'startColumn' => 36,
            'endColumn' => 44,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'password' => 
          array (
            'name' => 'password',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 508,
            'endLine' => 508,
            'startColumn' => 47,
            'endColumn' => 55,
            'parameterIndex' => 1,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Specify the digest authentication username and password for the request.
 *
 * @param  string  $username
 * @param  string  $password
 * @return $this
 */',
        'startLine' => 508,
        'endLine' => 513,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'withNtlmAuth' => 
      array (
        'name' => 'withNtlmAuth',
        'parameters' => 
        array (
          'username' => 
          array (
            'name' => 'username',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 522,
            'endLine' => 522,
            'startColumn' => 34,
            'endColumn' => 42,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'password' => 
          array (
            'name' => 'password',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 522,
            'endLine' => 522,
            'startColumn' => 45,
            'endColumn' => 53,
            'parameterIndex' => 1,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Specify the NTLM authentication username and password for the request.
 *
 * @param  string  $username
 * @param  string  $password
 * @return $this
 */',
        'startLine' => 522,
        'endLine' => 527,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'withToken' => 
      array (
        'name' => 'withToken',
        'parameters' => 
        array (
          'token' => 
          array (
            'name' => 'token',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 536,
            'endLine' => 536,
            'startColumn' => 31,
            'endColumn' => 36,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'type' => 
          array (
            'name' => 'type',
            'default' => 
            array (
              'code' => '\'Bearer\'',
              'attributes' => 
              array (
                'startLine' => 536,
                'endLine' => 536,
                'startTokenPos' => 1428,
                'startFilePos' => 12261,
                'endTokenPos' => 1428,
                'endFilePos' => 12268,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 536,
            'endLine' => 536,
            'startColumn' => 39,
            'endColumn' => 54,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Specify an authorization token for the request.
 *
 * @param  string  $token
 * @param  string  $type
 * @return $this
 */',
        'startLine' => 536,
        'endLine' => 541,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'withUserAgent' => 
      array (
        'name' => 'withUserAgent',
        'parameters' => 
        array (
          'userAgent' => 
          array (
            'name' => 'userAgent',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 549,
            'endLine' => 549,
            'startColumn' => 35,
            'endColumn' => 44,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Specify the user agent for the request.
 *
 * @param  string|bool  $userAgent
 * @return $this
 */',
        'startLine' => 549,
        'endLine' => 554,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'withUrlParameters' => 
      array (
        'name' => 'withUrlParameters',
        'parameters' => 
        array (
          'parameters' => 
          array (
            'name' => 'parameters',
            'default' => 
            array (
              'code' => '[]',
              'attributes' => 
              array (
                'startLine' => 562,
                'endLine' => 562,
                'startTokenPos' => 1514,
                'startFilePos' => 12880,
                'endTokenPos' => 1515,
                'endFilePos' => 12881,
              ),
            ),
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 562,
            'endLine' => 562,
            'startColumn' => 39,
            'endColumn' => 60,
            'parameterIndex' => 0,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Specify the URL parameters that can be substituted into the request URL.
 *
 * @param  array  $parameters
 * @return $this
 */',
        'startLine' => 562,
        'endLine' => 567,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'withCookies' => 
      array (
        'name' => 'withCookies',
        'parameters' => 
        array (
          'cookies' => 
          array (
            'name' => 'cookies',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 576,
            'endLine' => 576,
            'startColumn' => 33,
            'endColumn' => 46,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'domain' => 
          array (
            'name' => 'domain',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 576,
            'endLine' => 576,
            'startColumn' => 49,
            'endColumn' => 62,
            'parameterIndex' => 1,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Specify the cookies that should be included with the request.
 *
 * @param  array  $cookies
 * @param  string  $domain
 * @return $this
 */',
        'startLine' => 576,
        'endLine' => 583,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'maxRedirects' => 
      array (
        'name' => 'maxRedirects',
        'parameters' => 
        array (
          'max' => 
          array (
            'name' => 'max',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'int',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 591,
            'endLine' => 591,
            'startColumn' => 34,
            'endColumn' => 41,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Specify the maximum number of redirects to allow.
 *
 * @param  int  $max
 * @return $this
 */',
        'startLine' => 591,
        'endLine' => 596,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'withoutRedirecting' => 
      array (
        'name' => 'withoutRedirecting',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Indicate that redirects should not be followed.
 *
 * @return $this
 */',
        'startLine' => 603,
        'endLine' => 608,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'withoutVerifying' => 
      array (
        'name' => 'withoutVerifying',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Indicate that TLS certificates should not be verified.
 *
 * @return $this
 */',
        'startLine' => 615,
        'endLine' => 620,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'sink' => 
      array (
        'name' => 'sink',
        'parameters' => 
        array (
          'to' => 
          array (
            'name' => 'to',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 628,
            'endLine' => 628,
            'startColumn' => 26,
            'endColumn' => 28,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Specify the path where the body of the response should be stored.
 *
 * @param  string|resource  $to
 * @return $this
 */',
        'startLine' => 628,
        'endLine' => 633,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'timeout' => 
      array (
        'name' => 'timeout',
        'parameters' => 
        array (
          'seconds' => 
          array (
            'name' => 'seconds',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionUnionType',
              'data' => 
              array (
                'types' => 
                array (
                  0 => 
                  array (
                    'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                    'data' => 
                    array (
                      'name' => 'int',
                      'isIdentifier' => true,
                    ),
                  ),
                  1 => 
                  array (
                    'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                    'data' => 
                    array (
                      'name' => 'float',
                      'isIdentifier' => true,
                    ),
                  ),
                ),
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 641,
            'endLine' => 641,
            'startColumn' => 29,
            'endColumn' => 46,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Specify the timeout (in seconds) for the request.
 *
 * @param  int|float  $seconds
 * @return $this
 */',
        'startLine' => 641,
        'endLine' => 646,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'connectTimeout' => 
      array (
        'name' => 'connectTimeout',
        'parameters' => 
        array (
          'seconds' => 
          array (
            'name' => 'seconds',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionUnionType',
              'data' => 
              array (
                'types' => 
                array (
                  0 => 
                  array (
                    'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                    'data' => 
                    array (
                      'name' => 'int',
                      'isIdentifier' => true,
                    ),
                  ),
                  1 => 
                  array (
                    'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                    'data' => 
                    array (
                      'name' => 'float',
                      'isIdentifier' => true,
                    ),
                  ),
                ),
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 654,
            'endLine' => 654,
            'startColumn' => 36,
            'endColumn' => 53,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Specify the connect timeout (in seconds) for the request.
 *
 * @param  int|float  $seconds
 * @return $this
 */',
        'startLine' => 654,
        'endLine' => 659,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'retry' => 
      array (
        'name' => 'retry',
        'parameters' => 
        array (
          'times' => 
          array (
            'name' => 'times',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionUnionType',
              'data' => 
              array (
                'types' => 
                array (
                  0 => 
                  array (
                    'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                    'data' => 
                    array (
                      'name' => 'array',
                      'isIdentifier' => true,
                    ),
                  ),
                  1 => 
                  array (
                    'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                    'data' => 
                    array (
                      'name' => 'int',
                      'isIdentifier' => true,
                    ),
                  ),
                ),
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 670,
            'endLine' => 670,
            'startColumn' => 27,
            'endColumn' => 42,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'sleepMilliseconds' => 
          array (
            'name' => 'sleepMilliseconds',
            'default' => 
            array (
              'code' => '0',
              'attributes' => 
              array (
                'startLine' => 670,
                'endLine' => 670,
                'startTokenPos' => 1831,
                'startFilePos' => 15334,
                'endTokenPos' => 1831,
                'endFilePos' => 15334,
              ),
            ),
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionUnionType',
              'data' => 
              array (
                'types' => 
                array (
                  0 => 
                  array (
                    'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                    'data' => 
                    array (
                      'name' => 'Closure',
                      'isIdentifier' => false,
                    ),
                  ),
                  1 => 
                  array (
                    'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                    'data' => 
                    array (
                      'name' => 'int',
                      'isIdentifier' => true,
                    ),
                  ),
                ),
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 670,
            'endLine' => 670,
            'startColumn' => 45,
            'endColumn' => 78,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
          'when' => 
          array (
            'name' => 'when',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 670,
                'endLine' => 670,
                'startTokenPos' => 1841,
                'startFilePos' => 15355,
                'endTokenPos' => 1841,
                'endFilePos' => 15358,
              ),
            ),
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionUnionType',
              'data' => 
              array (
                'types' => 
                array (
                  0 => 
                  array (
                    'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                    'data' => 
                    array (
                      'name' => 'callable',
                      'isIdentifier' => true,
                    ),
                  ),
                  1 => 
                  array (
                    'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                    'data' => 
                    array (
                      'name' => 'null',
                      'isIdentifier' => true,
                    ),
                  ),
                ),
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 670,
            'endLine' => 670,
            'startColumn' => 81,
            'endColumn' => 102,
            'parameterIndex' => 2,
            'isOptional' => true,
          ),
          'throw' => 
          array (
            'name' => 'throw',
            'default' => 
            array (
              'code' => 'true',
              'attributes' => 
              array (
                'startLine' => 670,
                'endLine' => 670,
                'startTokenPos' => 1850,
                'startFilePos' => 15375,
                'endTokenPos' => 1850,
                'endFilePos' => 15378,
              ),
            ),
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'bool',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 670,
            'endLine' => 670,
            'startColumn' => 105,
            'endColumn' => 122,
            'parameterIndex' => 3,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Specify the number of times the request should be attempted.
 *
 * @param  array|int  $times
 * @param  (Closure(int, mixed): int)|int  $sleepMilliseconds
 * @param  (callable(\\Throwable, static, string|null): bool)|null  $when
 * @param  bool  $throw
 * @return $this
 */',
        'startLine' => 670,
        'endLine' => 678,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'withOptions' => 
      array (
        'name' => 'withOptions',
        'parameters' => 
        array (
          'options' => 
          array (
            'name' => 'options',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 686,
            'endLine' => 686,
            'startColumn' => 33,
            'endColumn' => 46,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Replace the specified options on the request.
 *
 * @param  array  $options
 * @return $this
 */',
        'startLine' => 686,
        'endLine' => 694,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'withMiddleware' => 
      array (
        'name' => 'withMiddleware',
        'parameters' => 
        array (
          'middleware' => 
          array (
            'name' => 'middleware',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'callable',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 702,
            'endLine' => 702,
            'startColumn' => 36,
            'endColumn' => 55,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Add new middleware the client handler stack.
 *
 * @param  callable  $middleware
 * @return $this
 */',
        'startLine' => 702,
        'endLine' => 707,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'withRequestMiddleware' => 
      array (
        'name' => 'withRequestMiddleware',
        'parameters' => 
        array (
          'middleware' => 
          array (
            'name' => 'middleware',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'callable',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 715,
            'endLine' => 715,
            'startColumn' => 43,
            'endColumn' => 62,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Add new request middleware the client handler stack.
 *
 * @param  callable  $middleware
 * @return $this
 */',
        'startLine' => 715,
        'endLine' => 720,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'withResponseMiddleware' => 
      array (
        'name' => 'withResponseMiddleware',
        'parameters' => 
        array (
          'middleware' => 
          array (
            'name' => 'middleware',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'callable',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 728,
            'endLine' => 728,
            'startColumn' => 44,
            'endColumn' => 63,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Add new response middleware the client handler stack.
 *
 * @param  callable  $middleware
 * @return $this
 */',
        'startLine' => 728,
        'endLine' => 733,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'withAttributes' => 
      array (
        'name' => 'withAttributes',
        'parameters' => 
        array (
          'attributes' => 
          array (
            'name' => 'attributes',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 741,
            'endLine' => 741,
            'startColumn' => 36,
            'endColumn' => 46,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Set arbitrary attributes to store with the request.
 *
 * @param  array<array-key, mixed>  $attributes
 * @return $this
 */',
        'startLine' => 741,
        'endLine' => 746,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'beforeSending' => 
      array (
        'name' => 'beforeSending',
        'parameters' => 
        array (
          'callback' => 
          array (
            'name' => 'callback',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 754,
            'endLine' => 754,
            'startColumn' => 35,
            'endColumn' => 43,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Add a new "before sending" callback to the request.
 *
 * @param  callable  $callback
 * @return $this
 */',
        'startLine' => 754,
        'endLine' => 759,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'afterResponse' => 
      array (
        'name' => 'afterResponse',
        'parameters' => 
        array (
          'callback' => 
          array (
            'name' => 'callback',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'callable',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 767,
            'endLine' => 767,
            'startColumn' => 35,
            'endColumn' => 52,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Add a new callback to execute after the response is built.
 *
 * @param  (callable(\\Illuminate\\Http\\Client\\Response, \\Illuminate\\Http\\Client\\Request): \\Illuminate\\Http\\Client\\Response|null)  $callback
 * @return $this
 */',
        'startLine' => 767,
        'endLine' => 772,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'throw' => 
      array (
        'name' => 'throw',
        'parameters' => 
        array (
          'callback' => 
          array (
            'name' => 'callback',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 780,
                'endLine' => 780,
                'startTokenPos' => 2177,
                'startFilePos' => 18046,
                'endTokenPos' => 2177,
                'endFilePos' => 18049,
              ),
            ),
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionUnionType',
              'data' => 
              array (
                'types' => 
                array (
                  0 => 
                  array (
                    'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                    'data' => 
                    array (
                      'name' => 'callable',
                      'isIdentifier' => true,
                    ),
                  ),
                  1 => 
                  array (
                    'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                    'data' => 
                    array (
                      'name' => 'null',
                      'isIdentifier' => true,
                    ),
                  ),
                ),
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 780,
            'endLine' => 780,
            'startColumn' => 27,
            'endColumn' => 52,
            'parameterIndex' => 0,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Throw an exception if a server or client error occurs.
 *
 * @param  callable|null  $callback
 * @return $this
 */',
        'startLine' => 780,
        'endLine' => 785,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'throwIf' => 
      array (
        'name' => 'throwIf',
        'parameters' => 
        array (
          'condition' => 
          array (
            'name' => 'condition',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 793,
            'endLine' => 793,
            'startColumn' => 29,
            'endColumn' => 38,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Throw an exception if a server or client error occurred and the given condition evaluates to true.
 *
 * @param  callable|bool  $condition
 * @return $this
 */',
        'startLine' => 793,
        'endLine' => 800,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => true,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'throwUnless' => 
      array (
        'name' => 'throwUnless',
        'parameters' => 
        array (
          'condition' => 
          array (
            'name' => 'condition',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 808,
            'endLine' => 808,
            'startColumn' => 33,
            'endColumn' => 42,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Throw an exception if a server or client error occurred and the given condition evaluates to false.
 *
 * @param  callable|bool  $condition
 * @return $this
 */',
        'startLine' => 808,
        'endLine' => 811,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'dump' => 
      array (
        'name' => 'dump',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Dump the request before sending.
 *
 * @return $this
 */',
        'startLine' => 818,
        'endLine' => 827,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => true,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'dd' => 
      array (
        'name' => 'dd',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Dump the request before sending and end the script.
 *
 * @return $this
 */',
        'startLine' => 834,
        'endLine' => 845,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => true,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'get' => 
      array (
        'name' => 'get',
        'parameters' => 
        array (
          'url' => 
          array (
            'name' => 'url',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 858,
            'endLine' => 858,
            'startColumn' => 25,
            'endColumn' => 35,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'query' => 
          array (
            'name' => 'query',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 858,
                'endLine' => 858,
                'startTokenPos' => 2498,
                'startFilePos' => 20158,
                'endTokenPos' => 2498,
                'endFilePos' => 20161,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 858,
            'endLine' => 858,
            'startColumn' => 38,
            'endColumn' => 50,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Issue a GET request to the given URL.
 *
 * @param  string  $url
 * @param  array|string|null  $query
 * @return \\Illuminate\\Http\\Client\\Response|\\GuzzleHttp\\Promise\\PromiseInterface
 *
 * @phpstan-return (TAsync is false ?  \\Illuminate\\Http\\Client\\Response : \\GuzzleHttp\\Promise\\PromiseInterface)
 *
 * @throws \\Illuminate\\Http\\Client\\ConnectionException
 */',
        'startLine' => 858,
        'endLine' => 863,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => true,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'head' => 
      array (
        'name' => 'head',
        'parameters' => 
        array (
          'url' => 
          array (
            'name' => 'url',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 876,
            'endLine' => 876,
            'startColumn' => 26,
            'endColumn' => 36,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'query' => 
          array (
            'name' => 'query',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 876,
                'endLine' => 876,
                'startTokenPos' => 2562,
                'startFilePos' => 20750,
                'endTokenPos' => 2562,
                'endFilePos' => 20753,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 876,
            'endLine' => 876,
            'startColumn' => 39,
            'endColumn' => 51,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Issue a HEAD request to the given URL.
 *
 * @param  string  $url
 * @param  array|string|null  $query
 * @return \\Illuminate\\Http\\Client\\Response|\\GuzzleHttp\\Promise\\PromiseInterface
 *
 * @phpstan-return (TAsync is false ?  \\Illuminate\\Http\\Client\\Response : \\GuzzleHttp\\Promise\\PromiseInterface)
 *
 * @throws \\Illuminate\\Http\\Client\\ConnectionException
 */',
        'startLine' => 876,
        'endLine' => 881,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => true,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'post' => 
      array (
        'name' => 'post',
        'parameters' => 
        array (
          'url' => 
          array (
            'name' => 'url',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 894,
            'endLine' => 894,
            'startColumn' => 26,
            'endColumn' => 36,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'data' => 
          array (
            'name' => 'data',
            'default' => 
            array (
              'code' => '[]',
              'attributes' => 
              array (
                'startLine' => 894,
                'endLine' => 894,
                'startTokenPos' => 2626,
                'startFilePos' => 21387,
                'endTokenPos' => 2627,
                'endFilePos' => 21388,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 894,
            'endLine' => 894,
            'startColumn' => 39,
            'endColumn' => 48,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Issue a POST request to the given URL.
 *
 * @param  string  $url
 * @param  array|\\JsonSerializable|\\Illuminate\\Contracts\\Support\\Arrayable  $data
 * @return \\Illuminate\\Http\\Client\\Response|\\GuzzleHttp\\Promise\\PromiseInterface
 *
 * @phpstan-return (TAsync is false ?  \\Illuminate\\Http\\Client\\Response : \\GuzzleHttp\\Promise\\PromiseInterface)
 *
 * @throws \\Illuminate\\Http\\Client\\ConnectionException
 */',
        'startLine' => 894,
        'endLine' => 899,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'patch' => 
      array (
        'name' => 'patch',
        'parameters' => 
        array (
          'url' => 
          array (
            'name' => 'url',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 912,
            'endLine' => 912,
            'startColumn' => 27,
            'endColumn' => 37,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'data' => 
          array (
            'name' => 'data',
            'default' => 
            array (
              'code' => '[]',
              'attributes' => 
              array (
                'startLine' => 912,
                'endLine' => 912,
                'startTokenPos' => 2678,
                'startFilePos' => 22004,
                'endTokenPos' => 2679,
                'endFilePos' => 22005,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 912,
            'endLine' => 912,
            'startColumn' => 40,
            'endColumn' => 49,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Issue a PATCH request to the given URL.
 *
 * @param  string  $url
 * @param  array|\\JsonSerializable|\\Illuminate\\Contracts\\Support\\Arrayable  $data
 * @return \\Illuminate\\Http\\Client\\Response|\\GuzzleHttp\\Promise\\PromiseInterface
 *
 * @phpstan-return (TAsync is false ?  \\Illuminate\\Http\\Client\\Response : \\GuzzleHttp\\Promise\\PromiseInterface)
 *
 * @throws \\Illuminate\\Http\\Client\\ConnectionException
 */',
        'startLine' => 912,
        'endLine' => 917,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'put' => 
      array (
        'name' => 'put',
        'parameters' => 
        array (
          'url' => 
          array (
            'name' => 'url',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 930,
            'endLine' => 930,
            'startColumn' => 25,
            'endColumn' => 35,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'data' => 
          array (
            'name' => 'data',
            'default' => 
            array (
              'code' => '[]',
              'attributes' => 
              array (
                'startLine' => 930,
                'endLine' => 930,
                'startTokenPos' => 2730,
                'startFilePos' => 22618,
                'endTokenPos' => 2731,
                'endFilePos' => 22619,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 930,
            'endLine' => 930,
            'startColumn' => 38,
            'endColumn' => 47,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Issue a PUT request to the given URL.
 *
 * @param  string  $url
 * @param  array|\\JsonSerializable|\\Illuminate\\Contracts\\Support\\Arrayable  $data
 * @return \\Illuminate\\Http\\Client\\Response|\\GuzzleHttp\\Promise\\PromiseInterface
 *
 * @phpstan-return (TAsync is false ?  \\Illuminate\\Http\\Client\\Response : \\GuzzleHttp\\Promise\\PromiseInterface)
 *
 * @throws \\Illuminate\\Http\\Client\\ConnectionException
 */',
        'startLine' => 930,
        'endLine' => 935,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'delete' => 
      array (
        'name' => 'delete',
        'parameters' => 
        array (
          'url' => 
          array (
            'name' => 'url',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 948,
            'endLine' => 948,
            'startColumn' => 28,
            'endColumn' => 38,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'data' => 
          array (
            'name' => 'data',
            'default' => 
            array (
              'code' => '[]',
              'attributes' => 
              array (
                'startLine' => 948,
                'endLine' => 948,
                'startTokenPos' => 2782,
                'startFilePos' => 23236,
                'endTokenPos' => 2783,
                'endFilePos' => 23237,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 948,
            'endLine' => 948,
            'startColumn' => 41,
            'endColumn' => 50,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Issue a DELETE request to the given URL.
 *
 * @param  string  $url
 * @param  array|\\JsonSerializable|\\Illuminate\\Contracts\\Support\\Arrayable  $data
 * @return \\Illuminate\\Http\\Client\\Response|\\GuzzleHttp\\Promise\\PromiseInterface
 *
 * @phpstan-return (TAsync is false ?  \\Illuminate\\Http\\Client\\Response : \\GuzzleHttp\\Promise\\PromiseInterface)
 *
 * @throws \\Illuminate\\Http\\Client\\ConnectionException
 */',
        'startLine' => 948,
        'endLine' => 953,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'pool' => 
      array (
        'name' => 'pool',
        'parameters' => 
        array (
          'callback' => 
          array (
            'name' => 'callback',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'callable',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 962,
            'endLine' => 962,
            'startColumn' => 26,
            'endColumn' => 43,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'concurrency' => 
          array (
            'name' => 'concurrency',
            'default' => 
            array (
              'code' => '0',
              'attributes' => 
              array (
                'startLine' => 962,
                'endLine' => 962,
                'startTokenPos' => 2849,
                'startFilePos' => 23718,
                'endTokenPos' => 2849,
                'endFilePos' => 23718,
              ),
            ),
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionUnionType',
              'data' => 
              array (
                'types' => 
                array (
                  0 => 
                  array (
                    'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                    'data' => 
                    array (
                      'name' => 'int',
                      'isIdentifier' => true,
                    ),
                  ),
                  1 => 
                  array (
                    'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                    'data' => 
                    array (
                      'name' => 'null',
                      'isIdentifier' => true,
                    ),
                  ),
                ),
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 962,
            'endLine' => 962,
            'startColumn' => 46,
            'endColumn' => 66,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Send a pool of asynchronous requests concurrently.
 *
 * @param  (callable(\\Illuminate\\Http\\Client\\Pool): mixed)  $callback
 * @param  non-negative-int|null  $concurrency
 * @return array<array-key, \\Illuminate\\Http\\Client\\Response|\\Throwable>
 */',
        'startLine' => 962,
        'endLine' => 1006,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => true,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'batch' => 
      array (
        'name' => 'batch',
        'parameters' => 
        array (
          'callback' => 
          array (
            'name' => 'callback',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'callable',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1014,
            'endLine' => 1014,
            'startColumn' => 27,
            'endColumn' => 44,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'Illuminate\\Http\\Client\\Batch',
            'isIdentifier' => false,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Send a pool of asynchronous requests concurrently, with callbacks for introspection.
 *
 * @param  callable  $callback
 * @return \\Illuminate\\Http\\Client\\Batch
 */',
        'startLine' => 1014,
        'endLine' => 1017,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'send' => 
      array (
        'name' => 'send',
        'parameters' => 
        array (
          'method' => 
          array (
            'name' => 'method',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1032,
            'endLine' => 1032,
            'startColumn' => 26,
            'endColumn' => 39,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'url' => 
          array (
            'name' => 'url',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1032,
            'endLine' => 1032,
            'startColumn' => 42,
            'endColumn' => 52,
            'parameterIndex' => 1,
            'isOptional' => false,
          ),
          'options' => 
          array (
            'name' => 'options',
            'default' => 
            array (
              'code' => '[]',
              'attributes' => 
              array (
                'startLine' => 1032,
                'endLine' => 1032,
                'startTokenPos' => 3309,
                'startFilePos' => 26065,
                'endTokenPos' => 3310,
                'endFilePos' => 26066,
              ),
            ),
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1032,
            'endLine' => 1032,
            'startColumn' => 55,
            'endColumn' => 73,
            'parameterIndex' => 2,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Send the request to the given URL.
 *
 * @param  string  $method
 * @param  string  $url
 * @param  array  $options
 * @return \\Illuminate\\Http\\Client\\Response|\\Illuminate\\Http\\Client\\Promises\\LazyPromise
 *
 * @phpstan-return (TAsync is false ? \\Illuminate\\Http\\Client\\Response : \\Illuminate\\Http\\Client\\Promises\\LazyPromise)
 *
 * @throws \\Exception
 * @throws \\Illuminate\\Http\\Client\\ConnectionException
 */',
        'startLine' => 1032,
        'endLine' => 1112,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'expandUrlParameters' => 
      array (
        'name' => 'expandUrlParameters',
        'parameters' => 
        array (
          'url' => 
          array (
            'name' => 'url',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1120,
            'endLine' => 1120,
            'startColumn' => 44,
            'endColumn' => 54,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Substitute the URL parameters in the given URL.
 *
 * @param  string  $url
 * @return string
 */',
        'startLine' => 1120,
        'endLine' => 1123,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'parseHttpOptions' => 
      array (
        'name' => 'parseHttpOptions',
        'parameters' => 
        array (
          'options' => 
          array (
            'name' => 'options',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1131,
            'endLine' => 1131,
            'startColumn' => 41,
            'endColumn' => 54,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Parse the given HTTP options and set the appropriate additional options.
 *
 * @param  array  $options
 * @return array
 */',
        'startLine' => 1131,
        'endLine' => 1158,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'parseMultipartBodyFormat' => 
      array (
        'name' => 'parseMultipartBodyFormat',
        'parameters' => 
        array (
          'data' => 
          array (
            'name' => 'data',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1166,
            'endLine' => 1166,
            'startColumn' => 49,
            'endColumn' => 59,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Parse multi-part form data.
 *
 * @param  array  $data
 * @return array|array[]
 */',
        'startLine' => 1166,
        'endLine' => 1179,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'makePromise' => 
      array (
        'name' => 'makePromise',
        'parameters' => 
        array (
          'method' => 
          array (
            'name' => 'method',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1190,
            'endLine' => 1190,
            'startColumn' => 36,
            'endColumn' => 49,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'url' => 
          array (
            'name' => 'url',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1190,
            'endLine' => 1190,
            'startColumn' => 52,
            'endColumn' => 62,
            'parameterIndex' => 1,
            'isOptional' => false,
          ),
          'options' => 
          array (
            'name' => 'options',
            'default' => 
            array (
              'code' => '[]',
              'attributes' => 
              array (
                'startLine' => 1190,
                'endLine' => 1190,
                'startTokenPos' => 4427,
                'startFilePos' => 31640,
                'endTokenPos' => 4428,
                'endFilePos' => 31641,
              ),
            ),
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1190,
            'endLine' => 1190,
            'startColumn' => 65,
            'endColumn' => 83,
            'parameterIndex' => 2,
            'isOptional' => true,
          ),
          'attempt' => 
          array (
            'name' => 'attempt',
            'default' => 
            array (
              'code' => '1',
              'attributes' => 
              array (
                'startLine' => 1190,
                'endLine' => 1190,
                'startTokenPos' => 4437,
                'startFilePos' => 31659,
                'endTokenPos' => 4437,
                'endFilePos' => 31659,
              ),
            ),
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'int',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1190,
            'endLine' => 1190,
            'startColumn' => 86,
            'endColumn' => 101,
            'parameterIndex' => 3,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Send an asynchronous request to the given URL.
 *
 * @param  string  $method
 * @param  string  $url
 * @param  array  $options
 * @param  int  $attempt
 * @return \\GuzzleHttp\\Promise\\PromiseInterface
 */',
        'startLine' => 1190,
        'endLine' => 1222,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'handlePromiseResponse' => 
      array (
        'name' => 'handlePromiseResponse',
        'parameters' => 
        array (
          'response' => 
          array (
            'name' => 'response',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionUnionType',
              'data' => 
              array (
                'types' => 
                array (
                  0 => 
                  array (
                    'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                    'data' => 
                    array (
                      'name' => 'Illuminate\\Http\\Client\\Response',
                      'isIdentifier' => false,
                    ),
                  ),
                  1 => 
                  array (
                    'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                    'data' => 
                    array (
                      'name' => 'Throwable',
                      'isIdentifier' => false,
                    ),
                  ),
                ),
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1234,
            'endLine' => 1234,
            'startColumn' => 46,
            'endColumn' => 73,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'method' => 
          array (
            'name' => 'method',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1234,
            'endLine' => 1234,
            'startColumn' => 76,
            'endColumn' => 82,
            'parameterIndex' => 1,
            'isOptional' => false,
          ),
          'url' => 
          array (
            'name' => 'url',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1234,
            'endLine' => 1234,
            'startColumn' => 85,
            'endColumn' => 88,
            'parameterIndex' => 2,
            'isOptional' => false,
          ),
          'options' => 
          array (
            'name' => 'options',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1234,
            'endLine' => 1234,
            'startColumn' => 91,
            'endColumn' => 98,
            'parameterIndex' => 3,
            'isOptional' => false,
          ),
          'attempt' => 
          array (
            'name' => 'attempt',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1234,
            'endLine' => 1234,
            'startColumn' => 101,
            'endColumn' => 108,
            'parameterIndex' => 4,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Handle the response of an asynchronous request.
 *
 * @param  \\Illuminate\\Http\\Client\\Response|\\Throwable  $response
 * @param  string  $method
 * @param  string  $url
 * @param  array  $options
 * @param  int  $attempt
 * @return mixed
 */',
        'startLine' => 1234,
        'endLine' => 1277,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'getMaximumAttempts' => 
      array (
        'name' => 'getMaximumAttempts',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Get the maximum number of attempts for the request.
 *
 * @return int
 */',
        'startLine' => 1284,
        'endLine' => 1289,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'retryDelayInMilliseconds' => 
      array (
        'name' => 'retryDelayInMilliseconds',
        'parameters' => 
        array (
          'attempt' => 
          array (
            'name' => 'attempt',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1298,
            'endLine' => 1298,
            'startColumn' => 49,
            'endColumn' => 56,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'exception' => 
          array (
            'name' => 'exception',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1298,
            'endLine' => 1298,
            'startColumn' => 59,
            'endColumn' => 68,
            'parameterIndex' => 1,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Get the delay in milliseconds before the next retry attempt.
 *
 * @param  int  $attempt
 * @param  mixed  $exception
 * @return int|float
 */',
        'startLine' => 1298,
        'endLine' => 1303,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'sendRequest' => 
      array (
        'name' => 'sendRequest',
        'parameters' => 
        array (
          'method' => 
          array (
            'name' => 'method',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1315,
            'endLine' => 1315,
            'startColumn' => 36,
            'endColumn' => 49,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'url' => 
          array (
            'name' => 'url',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1315,
            'endLine' => 1315,
            'startColumn' => 52,
            'endColumn' => 62,
            'parameterIndex' => 1,
            'isOptional' => false,
          ),
          'options' => 
          array (
            'name' => 'options',
            'default' => 
            array (
              'code' => '[]',
              'attributes' => 
              array (
                'startLine' => 1315,
                'endLine' => 1315,
                'startTokenPos' => 5253,
                'startFilePos' => 36050,
                'endTokenPos' => 5254,
                'endFilePos' => 36051,
              ),
            ),
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1315,
            'endLine' => 1315,
            'startColumn' => 65,
            'endColumn' => 83,
            'parameterIndex' => 2,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Send a request either synchronously or asynchronously.
 *
 * @param  string  $method
 * @param  string  $url
 * @param  array  $options
 * @return \\Psr\\Http\\Message\\MessageInterface|\\GuzzleHttp\\Promise\\PromiseInterface
 *
 * @throws \\Exception
 */',
        'startLine' => 1315,
        'endLine' => 1341,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'parseRequestData' => 
      array (
        'name' => 'parseRequestData',
        'parameters' => 
        array (
          'method' => 
          array (
            'name' => 'method',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1351,
            'endLine' => 1351,
            'startColumn' => 41,
            'endColumn' => 47,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'url' => 
          array (
            'name' => 'url',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1351,
            'endLine' => 1351,
            'startColumn' => 50,
            'endColumn' => 53,
            'parameterIndex' => 1,
            'isOptional' => false,
          ),
          'options' => 
          array (
            'name' => 'options',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1351,
            'endLine' => 1351,
            'startColumn' => 56,
            'endColumn' => 69,
            'parameterIndex' => 2,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Get the request data as an array so that we can attach it to the request for convenient assertions.
 *
 * @param  string  $method
 * @param  string  $url
 * @param  array  $options
 * @return array
 */',
        'startLine' => 1351,
        'endLine' => 1380,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'normalizeRequestOptions' => 
      array (
        'name' => 'normalizeRequestOptions',
        'parameters' => 
        array (
          'options' => 
          array (
            'name' => 'options',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1388,
            'endLine' => 1388,
            'startColumn' => 48,
            'endColumn' => 61,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Normalize the given request options.
 *
 * @param  array  $options
 * @return array
 */',
        'startLine' => 1388,
        'endLine' => 1423,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'normalizeHeaderValues' => 
      array (
        'name' => 'normalizeHeaderValues',
        'parameters' => 
        array (
          'headers' => 
          array (
            'name' => 'headers',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1431,
            'endLine' => 1431,
            'startColumn' => 46,
            'endColumn' => 59,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'array',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Normalize the given header values.
 *
 * @param  array  $headers
 * @return array
 */',
        'startLine' => 1431,
        'endLine' => 1438,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'normalizeHeaderValue' => 
      array (
        'name' => 'normalizeHeaderValue',
        'parameters' => 
        array (
          'value' => 
          array (
            'name' => 'value',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1448,
            'endLine' => 1448,
            'startColumn' => 45,
            'endColumn' => 50,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionUnionType',
          'data' => 
          array (
            'types' => 
            array (
              0 => 
              array (
                'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                'data' => 
                array (
                  'name' => 'string',
                  'isIdentifier' => true,
                ),
              ),
              1 => 
              array (
                'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                'data' => 
                array (
                  'name' => 'array',
                  'isIdentifier' => true,
                ),
              ),
            ),
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Normalize the given header value.
 *
 * @param  mixed  $value
 * @return string|array
 *
 * @throws \\InvalidArgumentException
 */',
        'startLine' => 1448,
        'endLine' => 1473,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'normalizeNonFiniteFloatValues' => 
      array (
        'name' => 'normalizeNonFiniteFloatValues',
        'parameters' => 
        array (
          'values' => 
          array (
            'name' => 'values',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1481,
            'endLine' => 1481,
            'startColumn' => 54,
            'endColumn' => 66,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'array',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Normalize non-finite floats within a nested array.
 *
 * @param  array  $values
 * @return array
 */',
        'startLine' => 1481,
        'endLine' => 1492,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'normalizeMultipartOption' => 
      array (
        'name' => 'normalizeMultipartOption',
        'parameters' => 
        array (
          'multipart' => 
          array (
            'name' => 'multipart',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1500,
            'endLine' => 1500,
            'startColumn' => 49,
            'endColumn' => 64,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'array',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Normalize the given multipart option.
 *
 * @param  array  $multipart
 * @return array
 */',
        'startLine' => 1500,
        'endLine' => 1529,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'normalizeMultipartHeaders' => 
      array (
        'name' => 'normalizeMultipartHeaders',
        'parameters' => 
        array (
          'multipart' => 
          array (
            'name' => 'multipart',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1539,
            'endLine' => 1539,
            'startColumn' => 50,
            'endColumn' => 65,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'array',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Normalize the given multipart headers.
 *
 * @param  array  $multipart
 * @return array
 *
 * @throws \\InvalidArgumentException
 */',
        'startLine' => 1539,
        'endLine' => 1556,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'normalizeRequestOptionValue' => 
      array (
        'name' => 'normalizeRequestOptionValue',
        'parameters' => 
        array (
          'value' => 
          array (
            'name' => 'value',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1564,
            'endLine' => 1564,
            'startColumn' => 52,
            'endColumn' => 57,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Normalize the given request option value.
 *
 * @param  mixed  $value
 * @return mixed
 */',
        'startLine' => 1564,
        'endLine' => 1571,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'normalizeScalarString' => 
      array (
        'name' => 'normalizeScalarString',
        'parameters' => 
        array (
          'value' => 
          array (
            'name' => 'value',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1579,
            'endLine' => 1579,
            'startColumn' => 46,
            'endColumn' => 51,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'string',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Normalize a scalar to a string without triggering PHP 8.5 non-finite float warnings.
 *
 * @param  scalar  $value
 * @return string
 */',
        'startLine' => 1579,
        'endLine' => 1590,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'ensureValidRequestBody' => 
      array (
        'name' => 'ensureValidRequestBody',
        'parameters' => 
        array (
          'body' => 
          array (
            'name' => 'body',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1600,
            'endLine' => 1600,
            'startColumn' => 47,
            'endColumn' => 51,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'void',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Ensure the given request body can be passed to Guzzle.
 *
 * @param  mixed  $body
 * @return void
 *
 * @throws \\InvalidArgumentException
 */',
        'startLine' => 1600,
        'endLine' => 1605,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'populateResponse' => 
      array (
        'name' => 'populateResponse',
        'parameters' => 
        array (
          'response' => 
          array (
            'name' => 'response',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'Illuminate\\Http\\Client\\Response',
                'isIdentifier' => false,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1613,
            'endLine' => 1613,
            'startColumn' => 41,
            'endColumn' => 58,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Populate the given response with additional data.
 *
 * @param  \\Illuminate\\Http\\Client\\Response  $response
 * @return \\Illuminate\\Http\\Client\\Response
 */',
        'startLine' => 1613,
        'endLine' => 1620,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'buildClient' => 
      array (
        'name' => 'buildClient',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Build the Guzzle client.
 *
 * @return \\GuzzleHttp\\Client
 */',
        'startLine' => 1627,
        'endLine' => 1630,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'requestsReusableClient' => 
      array (
        'name' => 'requestsReusableClient',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Determine if a reusable client is required.
 *
 * @return bool
 */',
        'startLine' => 1637,
        'endLine' => 1640,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'getReusableClient' => 
      array (
        'name' => 'getReusableClient',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Retrieve a reusable Guzzle client.
 *
 * @return \\GuzzleHttp\\Client
 */',
        'startLine' => 1647,
        'endLine' => 1650,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'createClient' => 
      array (
        'name' => 'createClient',
        'parameters' => 
        array (
          'handlerStack' => 
          array (
            'name' => 'handlerStack',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1658,
            'endLine' => 1658,
            'startColumn' => 34,
            'endColumn' => 46,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Create new Guzzle client.
 *
 * @param  \\GuzzleHttp\\HandlerStack  $handlerStack
 * @return \\GuzzleHttp\\Client
 */',
        'startLine' => 1658,
        'endLine' => 1664,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'buildHandlerStack' => 
      array (
        'name' => 'buildHandlerStack',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Build the Guzzle client handler stack.
 *
 * @return \\GuzzleHttp\\HandlerStack
 */',
        'startLine' => 1671,
        'endLine' => 1674,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'pushHandlers' => 
      array (
        'name' => 'pushHandlers',
        'parameters' => 
        array (
          'handlerStack' => 
          array (
            'name' => 'handlerStack',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1682,
            'endLine' => 1682,
            'startColumn' => 34,
            'endColumn' => 46,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Add the necessary handlers to the given handler stack.
 *
 * @param  \\GuzzleHttp\\HandlerStack  $handlerStack
 * @return \\GuzzleHttp\\HandlerStack
 */',
        'startLine' => 1682,
        'endLine' => 1693,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'buildBeforeSendingHandler' => 
      array (
        'name' => 'buildBeforeSendingHandler',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Build the before sending handler.
 *
 * @return \\Closure
 */',
        'startLine' => 1700,
        'endLine' => 1707,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'buildRecorderHandler' => 
      array (
        'name' => 'buildRecorderHandler',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Build the recorder handler.
 *
 * @return \\Closure
 */',
        'startLine' => 1714,
        'endLine' => 1732,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'buildStubHandler' => 
      array (
        'name' => 'buildStubHandler',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Build the stub handler.
 *
 * @return \\Closure
 *
 * @throws \\Illuminate\\Http\\Client\\Exceptions\\StrayRequestException
 */',
        'startLine' => 1741,
        'endLine' => 1775,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'sinkStubHandler' => 
      array (
        'name' => 'sinkStubHandler',
        'parameters' => 
        array (
          'sink' => 
          array (
            'name' => 'sink',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1783,
            'endLine' => 1783,
            'startColumn' => 40,
            'endColumn' => 44,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Get the sink stub handler callback.
 *
 * @param  string  $sink
 * @return \\Closure
 */',
        'startLine' => 1783,
        'endLine' => 1797,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'runBeforeSendingCallbacks' => 
      array (
        'name' => 'runBeforeSendingCallbacks',
        'parameters' => 
        array (
          'request' => 
          array (
            'name' => 'request',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1806,
            'endLine' => 1806,
            'startColumn' => 47,
            'endColumn' => 54,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'options' => 
          array (
            'name' => 'options',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1806,
            'endLine' => 1806,
            'startColumn' => 57,
            'endColumn' => 70,
            'parameterIndex' => 1,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Execute the "before sending" callbacks.
 *
 * @param  \\Psr\\Http\\Message\\RequestInterface  $request
 * @param  array  $options
 * @return \\Psr\\Http\\Message\\RequestInterface
 */',
        'startLine' => 1806,
        'endLine' => 1826,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'mergeOptions' => 
      array (
        'name' => 'mergeOptions',
        'parameters' => 
        array (
          'options' => 
          array (
            'name' => 'options',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => true,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1834,
            'endLine' => 1834,
            'startColumn' => 34,
            'endColumn' => 44,
            'parameterIndex' => 0,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Replace the given options with the current request options.
 *
 * @param  array  ...$options
 * @return array
 */',
        'startLine' => 1834,
        'endLine' => 1840,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => true,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'newResponse' => 
      array (
        'name' => 'newResponse',
        'parameters' => 
        array (
          'response' => 
          array (
            'name' => 'response',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1848,
            'endLine' => 1848,
            'startColumn' => 36,
            'endColumn' => 44,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Create a new response instance using the given PSR response.
 *
 * @param  \\Psr\\Http\\Message\\MessageInterface  $response
 * @return Response
 */',
        'startLine' => 1848,
        'endLine' => 1859,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'runAfterResponseCallbacks' => 
      array (
        'name' => 'runAfterResponseCallbacks',
        'parameters' => 
        array (
          'response' => 
          array (
            'name' => 'response',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'Illuminate\\Http\\Client\\Response',
                'isIdentifier' => false,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1867,
            'endLine' => 1867,
            'startColumn' => 50,
            'endColumn' => 67,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Execute the "after response" callbacks.
 *
 * @param  \\Illuminate\\Http\\Client\\Response  $response
 * @return \\Illuminate\\Http\\Client\\Response
 */',
        'startLine' => 1867,
        'endLine' => 1878,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'stub' => 
      array (
        'name' => 'stub',
        'parameters' => 
        array (
          'callback' => 
          array (
            'name' => 'callback',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1886,
            'endLine' => 1886,
            'startColumn' => 26,
            'endColumn' => 34,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Register a stub callable that will intercept requests and be able to return stub responses.
 *
 * @param  callable  $callback
 * @return $this
 */',
        'startLine' => 1886,
        'endLine' => 1891,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'preventStrayRequests' => 
      array (
        'name' => 'preventStrayRequests',
        'parameters' => 
        array (
          'prevent' => 
          array (
            'name' => 'prevent',
            'default' => 
            array (
              'code' => 'true',
              'attributes' => 
              array (
                'startLine' => 1899,
                'endLine' => 1899,
                'startTokenPos' => 8282,
                'startFilePos' => 53584,
                'endTokenPos' => 8282,
                'endFilePos' => 53587,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1899,
            'endLine' => 1899,
            'startColumn' => 42,
            'endColumn' => 56,
            'parameterIndex' => 0,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Indicate that an exception should be thrown if any request is not faked.
 *
 * @param  bool  $prevent
 * @return $this
 */',
        'startLine' => 1899,
        'endLine' => 1904,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'allowStrayRequests' => 
      array (
        'name' => 'allowStrayRequests',
        'parameters' => 
        array (
          'only' => 
          array (
            'name' => 'only',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1912,
            'endLine' => 1912,
            'startColumn' => 40,
            'endColumn' => 50,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Allow stray, unfaked requests entirely, or optionally allow only specific URLs.
 *
 * @param  array<int, string>  $only
 * @return $this
 */',
        'startLine' => 1912,
        'endLine' => 1917,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'isAllowedRequestUrl' => 
      array (
        'name' => 'isAllowedRequestUrl',
        'parameters' => 
        array (
          'url' => 
          array (
            'name' => 'url',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1925,
            'endLine' => 1925,
            'startColumn' => 41,
            'endColumn' => 44,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Determine if the given URL is allowed as a stray request.
 *
 * @param  string  $url
 * @return bool
 */',
        'startLine' => 1925,
        'endLine' => 1938,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'async' => 
      array (
        'name' => 'async',
        'parameters' => 
        array (
          'async' => 
          array (
            'name' => 'async',
            'default' => 
            array (
              'code' => 'true',
              'attributes' => 
              array (
                'startLine' => 1950,
                'endLine' => 1950,
                'startTokenPos' => 8429,
                'startFilePos' => 54688,
                'endTokenPos' => 8429,
                'endFilePos' => 54691,
              ),
            ),
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'bool',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1950,
            'endLine' => 1950,
            'startColumn' => 27,
            'endColumn' => 44,
            'parameterIndex' => 0,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Toggle asynchronicity in requests.
 *
 * @template T of bool = true
 *
 * @param  T  $async
 * @return self<T>
 *
 * @phpstan-self-out self<T>
 */',
        'startLine' => 1950,
        'endLine' => 1955,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'getPromise' => 
      array (
        'name' => 'getPromise',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Retrieve the pending request promise.
 *
 * @return \\GuzzleHttp\\Promise\\PromiseInterface|null
 */',
        'startLine' => 1962,
        'endLine' => 1965,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'dispatchRequestSendingEvent' => 
      array (
        'name' => 'dispatchRequestSendingEvent',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Dispatch the RequestSending event if a dispatcher is available.
 *
 * @return void
 */',
        'startLine' => 1972,
        'endLine' => 1977,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'dispatchResponseReceivedEvent' => 
      array (
        'name' => 'dispatchResponseReceivedEvent',
        'parameters' => 
        array (
          'response' => 
          array (
            'name' => 'response',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'Illuminate\\Http\\Client\\Response',
                'isIdentifier' => false,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 1985,
            'endLine' => 1985,
            'startColumn' => 54,
            'endColumn' => 71,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Dispatch the ResponseReceived event if a dispatcher is available.
 *
 * @param  \\Illuminate\\Http\\Client\\Response  $response
 * @return void
 */',
        'startLine' => 1985,
        'endLine' => 1992,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'dispatchConnectionFailedEvent' => 
      array (
        'name' => 'dispatchConnectionFailedEvent',
        'parameters' => 
        array (
          'request' => 
          array (
            'name' => 'request',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'Illuminate\\Http\\Client\\Request',
                'isIdentifier' => false,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 2001,
            'endLine' => 2001,
            'startColumn' => 54,
            'endColumn' => 69,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'exception' => 
          array (
            'name' => 'exception',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'Illuminate\\Http\\Client\\ConnectionException',
                'isIdentifier' => false,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 2001,
            'endLine' => 2001,
            'startColumn' => 72,
            'endColumn' => 101,
            'parameterIndex' => 1,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Dispatch the ConnectionFailed event if a dispatcher is available.
 *
 * @param  \\Illuminate\\Http\\Client\\Request  $request
 * @param  \\Illuminate\\Http\\Client\\ConnectionException  $exception
 * @return void
 */',
        'startLine' => 2001,
        'endLine' => 2006,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'truncateExceptionsAt' => 
      array (
        'name' => 'truncateExceptionsAt',
        'parameters' => 
        array (
          'length' => 
          array (
            'name' => 'length',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'int',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 2014,
            'endLine' => 2014,
            'startColumn' => 42,
            'endColumn' => 52,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Indicate that request exceptions should be truncated to the given length.
 *
 * @param  int<1, max>  $length
 * @return $this
 */',
        'startLine' => 2014,
        'endLine' => 2019,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'dontTruncateExceptions' => 
      array (
        'name' => 'dontTruncateExceptions',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Indicate that request exceptions should not be truncated.
 *
 * @return $this
 */',
        'startLine' => 2026,
        'endLine' => 2031,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'marshalConnectionException' => 
      array (
        'name' => 'marshalConnectionException',
        'parameters' => 
        array (
          'e' => 
          array (
            'name' => 'e',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'GuzzleHttp\\Exception\\ConnectException',
                'isIdentifier' => false,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 2041,
            'endLine' => 2041,
            'startColumn' => 51,
            'endColumn' => 69,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Handle the given connection exception.
 *
 * @param  \\GuzzleHttp\\Exception\\ConnectException  $e
 * @return void
 *
 * @throws \\Illuminate\\Http\\Client\\ConnectionException
 */',
        'startLine' => 2041,
        'endLine' => 2054,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'marshalRequestExceptionWithoutResponse' => 
      array (
        'name' => 'marshalRequestExceptionWithoutResponse',
        'parameters' => 
        array (
          'e' => 
          array (
            'name' => 'e',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'GuzzleHttp\\Exception\\RequestException',
                'isIdentifier' => false,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 2064,
            'endLine' => 2064,
            'startColumn' => 63,
            'endColumn' => 81,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Handle the given request exception.
 *
 * @param  \\GuzzleHttp\\Exception\\RequestException  $e
 * @return void
 *
 * @throws \\Illuminate\\Http\\Client\\ConnectionException
 */',
        'startLine' => 2064,
        'endLine' => 2077,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'marshalRequestExceptionWithResponse' => 
      array (
        'name' => 'marshalRequestExceptionWithResponse',
        'parameters' => 
        array (
          'e' => 
          array (
            'name' => 'e',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'GuzzleHttp\\Exception\\RequestException',
                'isIdentifier' => false,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 2088,
            'endLine' => 2088,
            'startColumn' => 60,
            'endColumn' => 78,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Handle the given request exception.
 *
 * @param  \\GuzzleHttp\\Exception\\RequestException  $e
 * @return void
 *
 * @throws \\Illuminate\\Http\\Client\\RequestException
 * @throws \\Illuminate\\Http\\Client\\ConnectionException
 */',
        'startLine' => 2088,
        'endLine' => 2098,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'setClient' => 
      array (
        'name' => 'setClient',
        'parameters' => 
        array (
          'client' => 
          array (
            'name' => 'client',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'GuzzleHttp\\Client',
                'isIdentifier' => false,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 2106,
            'endLine' => 2106,
            'startColumn' => 31,
            'endColumn' => 44,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Set the client instance.
 *
 * @param  \\GuzzleHttp\\Client  $client
 * @return $this
 */',
        'startLine' => 2106,
        'endLine' => 2111,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'setHandler' => 
      array (
        'name' => 'setHandler',
        'parameters' => 
        array (
          'handler' => 
          array (
            'name' => 'handler',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 2119,
            'endLine' => 2119,
            'startColumn' => 32,
            'endColumn' => 39,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Create a new client instance using the given handler.
 *
 * @param  callable  $handler
 * @return $this
 */',
        'startLine' => 2119,
        'endLine' => 2124,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
      'getOptions' => 
      array (
        'name' => 'getOptions',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Get the pending request options.
 *
 * @return array
 */',
        'startLine' => 2131,
        'endLine' => 2134,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Http\\Client',
        'declaringClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'implementingClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'currentClassName' => 'Illuminate\\Http\\Client\\PendingRequest',
        'aliasName' => NULL,
      ),
    ),
    'traitsData' => 
    array (
      'aliases' => 
      array (
      ),
      'modifiers' => 
      array (
      ),
      'precedences' => 
      array (
      ),
      'hashes' => 
      array (
      ),
    ),
  ),
));
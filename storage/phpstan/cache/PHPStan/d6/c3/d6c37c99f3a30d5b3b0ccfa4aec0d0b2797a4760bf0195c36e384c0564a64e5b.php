<?php declare(strict_types = 1);

// odsl-/var/www/html/app/Models/WeeklyReport.php-PHPStan\BetterReflection\Reflection\ReflectionClass-App\Models\WeeklyReport
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-6.70.0.1-8.5.7-8397ae63d75ceb58557c8bedd75fe71398d3749333e1b1da534570e9553ef401',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'App\\Models\\WeeklyReport',
        'filename' => '/var/www/html/app/Models/WeeklyReport.php',
      ),
    ),
    'namespace' => 'App\\Models',
    'name' => 'App\\Models\\WeeklyReport',
    'shortName' => 'WeeklyReport',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 0,
    'docComment' => NULL,
    'attributes' => 
    array (
    ),
    'startLine' => 12,
    'endLine' => 127,
    'startColumn' => 1,
    'endColumn' => 1,
    'parentClassName' => 'Illuminate\\Database\\Eloquent\\Model',
    'implementsClassNames' => 
    array (
    ),
    'traitClassNames' => 
    array (
      0 => 'Illuminate\\Database\\Eloquent\\Factories\\HasFactory',
      1 => 'Spatie\\Activitylog\\Models\\Concerns\\LogsActivity',
    ),
    'immediateConstants' => 
    array (
    ),
    'immediateProperties' => 
    array (
      'fillable' => 
      array (
        'declaringClassName' => 'App\\Models\\WeeklyReport',
        'implementingClassName' => 'App\\Models\\WeeklyReport',
        'name' => 'fillable',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => '[\'employee_id\', \'department\', \'week\', \'objectives\', \'activities\', \'achievements\', \'difficulties\', \'next_actions\', \'executive_summary\', \'pptx_file\', \'status\', \'submitted_at\', \'validated_at\', \'validated_by\', \'rejected_at\', \'rejected_by\', \'rejection_reason\', \'generated_at\']',
          'attributes' => 
          array (
            'startLine' => 17,
            'endLine' => 40,
            'startTokenPos' => 63,
            'startFilePos' => 408,
            'endTokenPos' => 119,
            'endFilePos' => 833,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 17,
        'endLine' => 40,
        'startColumn' => 5,
        'endColumn' => 6,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'casts' => 
      array (
        'declaringClassName' => 'App\\Models\\WeeklyReport',
        'implementingClassName' => 'App\\Models\\WeeklyReport',
        'name' => 'casts',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => '[\'status\' => \\App\\Enums\\ReportStatus::class, \'submitted_at\' => \'datetime\', \'validated_at\' => \'datetime\', \'rejected_at\' => \'datetime\', \'generated_at\' => \'datetime\']',
          'attributes' => 
          array (
            'startLine' => 42,
            'endLine' => 49,
            'startTokenPos' => 128,
            'startFilePos' => 860,
            'endTokenPos' => 167,
            'endFilePos' => 1059,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 42,
        'endLine' => 49,
        'startColumn' => 5,
        'endColumn' => 6,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'with' => 
      array (
        'declaringClassName' => 'App\\Models\\WeeklyReport',
        'implementingClassName' => 'App\\Models\\WeeklyReport',
        'name' => 'with',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => '[\'employee\', \'validator\', \'rejector\']',
          'attributes' => 
          array (
            'startLine' => 51,
            'endLine' => 55,
            'startTokenPos' => 176,
            'startFilePos' => 1085,
            'endTokenPos' => 187,
            'endFilePos' => 1152,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 51,
        'endLine' => 55,
        'startColumn' => 5,
        'endColumn' => 6,
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
      'getActivitylogOptions' => 
      array (
        'name' => 'getActivitylogOptions',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'Spatie\\Activitylog\\Support\\LogOptions',
            'isIdentifier' => false,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => NULL,
        'startLine' => 57,
        'endLine' => 74,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'App\\Models',
        'declaringClassName' => 'App\\Models\\WeeklyReport',
        'implementingClassName' => 'App\\Models\\WeeklyReport',
        'currentClassName' => 'App\\Models\\WeeklyReport',
        'aliasName' => NULL,
      ),
      'employee' => 
      array (
        'name' => 'employee',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'Illuminate\\Database\\Eloquent\\Relations\\BelongsTo',
            'isIdentifier' => false,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => NULL,
        'startLine' => 82,
        'endLine' => 85,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'App\\Models',
        'declaringClassName' => 'App\\Models\\WeeklyReport',
        'implementingClassName' => 'App\\Models\\WeeklyReport',
        'currentClassName' => 'App\\Models\\WeeklyReport',
        'aliasName' => NULL,
      ),
      'validator' => 
      array (
        'name' => 'validator',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'Illuminate\\Database\\Eloquent\\Relations\\BelongsTo',
            'isIdentifier' => false,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => NULL,
        'startLine' => 87,
        'endLine' => 90,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'App\\Models',
        'declaringClassName' => 'App\\Models\\WeeklyReport',
        'implementingClassName' => 'App\\Models\\WeeklyReport',
        'currentClassName' => 'App\\Models\\WeeklyReport',
        'aliasName' => NULL,
      ),
      'rejector' => 
      array (
        'name' => 'rejector',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'Illuminate\\Database\\Eloquent\\Relations\\BelongsTo',
            'isIdentifier' => false,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => NULL,
        'startLine' => 92,
        'endLine' => 95,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'App\\Models',
        'declaringClassName' => 'App\\Models\\WeeklyReport',
        'implementingClassName' => 'App\\Models\\WeeklyReport',
        'currentClassName' => 'App\\Models\\WeeklyReport',
        'aliasName' => NULL,
      ),
      'isDraft' => 
      array (
        'name' => 'isDraft',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'bool',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => NULL,
        'startLine' => 103,
        'endLine' => 106,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'App\\Models',
        'declaringClassName' => 'App\\Models\\WeeklyReport',
        'implementingClassName' => 'App\\Models\\WeeklyReport',
        'currentClassName' => 'App\\Models\\WeeklyReport',
        'aliasName' => NULL,
      ),
      'isSubmitted' => 
      array (
        'name' => 'isSubmitted',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'bool',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => NULL,
        'startLine' => 108,
        'endLine' => 111,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'App\\Models',
        'declaringClassName' => 'App\\Models\\WeeklyReport',
        'implementingClassName' => 'App\\Models\\WeeklyReport',
        'currentClassName' => 'App\\Models\\WeeklyReport',
        'aliasName' => NULL,
      ),
      'isManagerApproved' => 
      array (
        'name' => 'isManagerApproved',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'bool',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => NULL,
        'startLine' => 113,
        'endLine' => 116,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'App\\Models',
        'declaringClassName' => 'App\\Models\\WeeklyReport',
        'implementingClassName' => 'App\\Models\\WeeklyReport',
        'currentClassName' => 'App\\Models\\WeeklyReport',
        'aliasName' => NULL,
      ),
      'isGenerated' => 
      array (
        'name' => 'isGenerated',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'bool',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => NULL,
        'startLine' => 118,
        'endLine' => 121,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'App\\Models',
        'declaringClassName' => 'App\\Models\\WeeklyReport',
        'implementingClassName' => 'App\\Models\\WeeklyReport',
        'currentClassName' => 'App\\Models\\WeeklyReport',
        'aliasName' => NULL,
      ),
      'isRejected' => 
      array (
        'name' => 'isRejected',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'bool',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => NULL,
        'startLine' => 123,
        'endLine' => 126,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'App\\Models',
        'declaringClassName' => 'App\\Models\\WeeklyReport',
        'implementingClassName' => 'App\\Models\\WeeklyReport',
        'currentClassName' => 'App\\Models\\WeeklyReport',
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
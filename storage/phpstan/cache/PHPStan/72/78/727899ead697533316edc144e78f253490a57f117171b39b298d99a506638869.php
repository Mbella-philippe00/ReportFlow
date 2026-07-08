<?php declare(strict_types = 1);

// ftm-/var/www/html/vendor/filament/filament/src/Resources/Pages/CreateRecord.php
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v5-2.3.2',
   'data' => 
  array (
    0 => 
    array (
      '036d3b70938a5954b56890002b507bb9' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => NULL,
         'templatePhpDocNodes' => 
        array (
          'TModel' => 
          array (
            0 => '@template',
            1 => 
            \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
               'name' => 'TModel',
               'bound' => 
              \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                 'name' => 'Model',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
               'default' => 
              \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                 'name' => 'Model',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
               'lowerBound' => NULL,
               'description' => '',
               'attributes' => 
              array (
                'startLine' => 2,
                'endLine' => 2,
              ),
            )),
          ),
        ),
         'parent' => NULL,
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
      '8e274ad6d9993ab30eb8e691a78f7d9a' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Pages\\Concerns',
         'uses' => 
        array (
          'closure' => 'Closure',
          'filament' => 'Filament\\Facades\\Filament',
          'db' => 'Illuminate\\Support\\Facades\\DB',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => NULL,
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => NULL,
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
         'traitData' => 
        array (
          0 => '/var/www/html/vendor/filament/filament/src/Resources/Pages/CreateRecord.php',
          1 => 'Filament\\Resources\\Pages\\CreateRecord',
          2 => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          3 => NULL,
          4 => NULL,
        ),
      )),
      'dd6b4071f059e9960957dedff5dd2dec' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Pages\\Concerns',
         'uses' => 
        array (
          'closure' => 'Closure',
          'filament' => 'Filament\\Facades\\Filament',
          'db' => 'Illuminate\\Support\\Facades\\DB',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'hasDatabaseTransactions',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => NULL,
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
         'traitData' => 
        array (
          0 => '/var/www/html/vendor/filament/filament/src/Resources/Pages/CreateRecord.php',
          1 => 'Filament\\Resources\\Pages\\CreateRecord',
          2 => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          3 => NULL,
          4 => NULL,
        ),
      )),
      '7663f745c0eaddabc13770739bc8043b' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Pages\\Concerns',
         'uses' => 
        array (
          'closure' => 'Closure',
          'filament' => 'Filament\\Facades\\Filament',
          'db' => 'Illuminate\\Support\\Facades\\DB',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'beginDatabaseTransaction',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => NULL,
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
         'traitData' => 
        array (
          0 => '/var/www/html/vendor/filament/filament/src/Resources/Pages/CreateRecord.php',
          1 => 'Filament\\Resources\\Pages\\CreateRecord',
          2 => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          3 => NULL,
          4 => NULL,
        ),
      )),
      'e7df2d2fa989d893e07bea920d77e393' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Pages\\Concerns',
         'uses' => 
        array (
          'closure' => 'Closure',
          'filament' => 'Filament\\Facades\\Filament',
          'db' => 'Illuminate\\Support\\Facades\\DB',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'commitDatabaseTransaction',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => NULL,
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
         'traitData' => 
        array (
          0 => '/var/www/html/vendor/filament/filament/src/Resources/Pages/CreateRecord.php',
          1 => 'Filament\\Resources\\Pages\\CreateRecord',
          2 => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          3 => NULL,
          4 => NULL,
        ),
      )),
      'eaaab928d81fe42cecdd0b6764aff1d7' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Pages\\Concerns',
         'uses' => 
        array (
          'closure' => 'Closure',
          'filament' => 'Filament\\Facades\\Filament',
          'db' => 'Illuminate\\Support\\Facades\\DB',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'rollBackDatabaseTransaction',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => NULL,
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
         'traitData' => 
        array (
          0 => '/var/www/html/vendor/filament/filament/src/Resources/Pages/CreateRecord.php',
          1 => 'Filament\\Resources\\Pages\\CreateRecord',
          2 => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          3 => NULL,
          4 => NULL,
        ),
      )),
      'c0c4ffa5cc8709f782bd61d646bca430' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Pages\\Concerns',
         'uses' => 
        array (
          'closure' => 'Closure',
          'filament' => 'Filament\\Facades\\Filament',
          'db' => 'Illuminate\\Support\\Facades\\DB',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'wrapInDatabaseTransaction',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => NULL,
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
         'traitData' => 
        array (
          0 => '/var/www/html/vendor/filament/filament/src/Resources/Pages/CreateRecord.php',
          1 => 'Filament\\Resources\\Pages\\CreateRecord',
          2 => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          3 => NULL,
          4 => NULL,
        ),
      )),
      '0e33122a5c9378c7c5b4af484a666376' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Pages\\Concerns',
         'uses' => 
        array (
          'filament' => 'Filament\\Facades\\Filament',
          'locked' => 'Livewire\\Attributes\\Locked',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => NULL,
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => NULL,
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
         'traitData' => 
        array (
          0 => '/var/www/html/vendor/filament/filament/src/Resources/Pages/CreateRecord.php',
          1 => 'Filament\\Resources\\Pages\\CreateRecord',
          2 => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          3 => NULL,
          4 => NULL,
        ),
      )),
      'a0c5e28245ab27646ee76c171c83c6ff' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Pages\\Concerns',
         'uses' => 
        array (
          'filament' => 'Filament\\Facades\\Filament',
          'locked' => 'Livewire\\Attributes\\Locked',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'mountHasUnsavedDataChangesAlert',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => NULL,
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
         'traitData' => 
        array (
          0 => '/var/www/html/vendor/filament/filament/src/Resources/Pages/CreateRecord.php',
          1 => 'Filament\\Resources\\Pages\\CreateRecord',
          2 => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          3 => NULL,
          4 => NULL,
        ),
      )),
      'ff9b2c8808b64d696add8752707525a8' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Pages\\Concerns',
         'uses' => 
        array (
          'filament' => 'Filament\\Facades\\Filament',
          'locked' => 'Livewire\\Attributes\\Locked',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'rememberData',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => NULL,
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
         'traitData' => 
        array (
          0 => '/var/www/html/vendor/filament/filament/src/Resources/Pages/CreateRecord.php',
          1 => 'Filament\\Resources\\Pages\\CreateRecord',
          2 => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          3 => NULL,
          4 => NULL,
        ),
      )),
      'c8f3456d346eb2377a6d5f4c4e6a1521' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Pages\\Concerns',
         'uses' => 
        array (
          'filament' => 'Filament\\Facades\\Filament',
          'locked' => 'Livewire\\Attributes\\Locked',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'hasUnsavedDataChangesAlert',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => NULL,
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
         'traitData' => 
        array (
          0 => '/var/www/html/vendor/filament/filament/src/Resources/Pages/CreateRecord.php',
          1 => 'Filament\\Resources\\Pages\\CreateRecord',
          2 => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          3 => NULL,
          4 => NULL,
        ),
      )),
      'b2ee9d5b1c3193fb6a9289f8f3eed7ed' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'getBreadcrumb',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => 
        \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
           'namespace' => 'Filament\\Resources\\Pages',
           'uses' => 
          array (
            'action' => 'Filament\\Actions\\Action',
            'actiongroup' => 'Filament\\Actions\\ActionGroup',
            'filament' => 'Filament\\Facades\\Filament',
            'notification' => 'Filament\\Notifications\\Notification',
            'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
            'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
            'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
            'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
            'actions' => 'Filament\\Schemas\\Components\\Actions',
            'component' => 'Filament\\Schemas\\Components\\Component',
            'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
            'form' => 'Filament\\Schemas\\Components\\Form',
            'group' => 'Filament\\Schemas\\Components\\Group',
            'schema' => 'Filament\\Schemas\\Schema',
            'halt' => 'Filament\\Support\\Exceptions\\Halt',
            'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
            'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
            'model' => 'Illuminate\\Database\\Eloquent\\Model',
            'event' => 'Illuminate\\Support\\Facades\\Event',
            'js' => 'Illuminate\\Support\\Js',
            'locked' => 'Livewire\\Attributes\\Locked',
            'throwable' => 'Throwable',
          ),
           'className' => 'Filament\\Resources\\Pages\\CreateRecord',
           'functionName' => NULL,
           'templatePhpDocNodes' => 
          array (
            'TModel' => 
            array (
              0 => '@template',
              1 => 
              \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
                 'name' => 'TModel',
                 'bound' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'default' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'lowerBound' => NULL,
                 'description' => '',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
            ),
          ),
           'parent' => NULL,
           'typeAliasesMap' => 
          array (
          ),
           'bypassTypeAliases' => false,
           'constUses' => 
          array (
          ),
           'typeAliasClassName' => NULL,
           'traitData' => NULL,
        )),
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
      '1d38e93ef5acd8b7257d2e9c6e700980' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'mount',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => 
        \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
           'namespace' => 'Filament\\Resources\\Pages',
           'uses' => 
          array (
            'action' => 'Filament\\Actions\\Action',
            'actiongroup' => 'Filament\\Actions\\ActionGroup',
            'filament' => 'Filament\\Facades\\Filament',
            'notification' => 'Filament\\Notifications\\Notification',
            'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
            'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
            'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
            'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
            'actions' => 'Filament\\Schemas\\Components\\Actions',
            'component' => 'Filament\\Schemas\\Components\\Component',
            'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
            'form' => 'Filament\\Schemas\\Components\\Form',
            'group' => 'Filament\\Schemas\\Components\\Group',
            'schema' => 'Filament\\Schemas\\Schema',
            'halt' => 'Filament\\Support\\Exceptions\\Halt',
            'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
            'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
            'model' => 'Illuminate\\Database\\Eloquent\\Model',
            'event' => 'Illuminate\\Support\\Facades\\Event',
            'js' => 'Illuminate\\Support\\Js',
            'locked' => 'Livewire\\Attributes\\Locked',
            'throwable' => 'Throwable',
          ),
           'className' => 'Filament\\Resources\\Pages\\CreateRecord',
           'functionName' => NULL,
           'templatePhpDocNodes' => 
          array (
            'TModel' => 
            array (
              0 => '@template',
              1 => 
              \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
                 'name' => 'TModel',
                 'bound' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'default' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'lowerBound' => NULL,
                 'description' => '',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
            ),
          ),
           'parent' => NULL,
           'typeAliasesMap' => 
          array (
          ),
           'bypassTypeAliases' => false,
           'constUses' => 
          array (
          ),
           'typeAliasClassName' => NULL,
           'traitData' => NULL,
        )),
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
      'f62a1602ea5170e7901f1291ded1f359' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'authorizeAccess',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => 
        \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
           'namespace' => 'Filament\\Resources\\Pages',
           'uses' => 
          array (
            'action' => 'Filament\\Actions\\Action',
            'actiongroup' => 'Filament\\Actions\\ActionGroup',
            'filament' => 'Filament\\Facades\\Filament',
            'notification' => 'Filament\\Notifications\\Notification',
            'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
            'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
            'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
            'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
            'actions' => 'Filament\\Schemas\\Components\\Actions',
            'component' => 'Filament\\Schemas\\Components\\Component',
            'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
            'form' => 'Filament\\Schemas\\Components\\Form',
            'group' => 'Filament\\Schemas\\Components\\Group',
            'schema' => 'Filament\\Schemas\\Schema',
            'halt' => 'Filament\\Support\\Exceptions\\Halt',
            'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
            'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
            'model' => 'Illuminate\\Database\\Eloquent\\Model',
            'event' => 'Illuminate\\Support\\Facades\\Event',
            'js' => 'Illuminate\\Support\\Js',
            'locked' => 'Livewire\\Attributes\\Locked',
            'throwable' => 'Throwable',
          ),
           'className' => 'Filament\\Resources\\Pages\\CreateRecord',
           'functionName' => NULL,
           'templatePhpDocNodes' => 
          array (
            'TModel' => 
            array (
              0 => '@template',
              1 => 
              \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
                 'name' => 'TModel',
                 'bound' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'default' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'lowerBound' => NULL,
                 'description' => '',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
            ),
          ),
           'parent' => NULL,
           'typeAliasesMap' => 
          array (
          ),
           'bypassTypeAliases' => false,
           'constUses' => 
          array (
          ),
           'typeAliasClassName' => NULL,
           'traitData' => NULL,
        )),
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
      '12ae664201af8784eb29d0cc875a0069' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'hydrate',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => 
        \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
           'namespace' => 'Filament\\Resources\\Pages',
           'uses' => 
          array (
            'action' => 'Filament\\Actions\\Action',
            'actiongroup' => 'Filament\\Actions\\ActionGroup',
            'filament' => 'Filament\\Facades\\Filament',
            'notification' => 'Filament\\Notifications\\Notification',
            'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
            'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
            'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
            'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
            'actions' => 'Filament\\Schemas\\Components\\Actions',
            'component' => 'Filament\\Schemas\\Components\\Component',
            'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
            'form' => 'Filament\\Schemas\\Components\\Form',
            'group' => 'Filament\\Schemas\\Components\\Group',
            'schema' => 'Filament\\Schemas\\Schema',
            'halt' => 'Filament\\Support\\Exceptions\\Halt',
            'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
            'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
            'model' => 'Illuminate\\Database\\Eloquent\\Model',
            'event' => 'Illuminate\\Support\\Facades\\Event',
            'js' => 'Illuminate\\Support\\Js',
            'locked' => 'Livewire\\Attributes\\Locked',
            'throwable' => 'Throwable',
          ),
           'className' => 'Filament\\Resources\\Pages\\CreateRecord',
           'functionName' => NULL,
           'templatePhpDocNodes' => 
          array (
            'TModel' => 
            array (
              0 => '@template',
              1 => 
              \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
                 'name' => 'TModel',
                 'bound' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'default' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'lowerBound' => NULL,
                 'description' => '',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
            ),
          ),
           'parent' => NULL,
           'typeAliasesMap' => 
          array (
          ),
           'bypassTypeAliases' => false,
           'constUses' => 
          array (
          ),
           'typeAliasClassName' => NULL,
           'traitData' => NULL,
        )),
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
      'a94e962e862b04b29af16d99e205c685' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'fillForm',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => 
        \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
           'namespace' => 'Filament\\Resources\\Pages',
           'uses' => 
          array (
            'action' => 'Filament\\Actions\\Action',
            'actiongroup' => 'Filament\\Actions\\ActionGroup',
            'filament' => 'Filament\\Facades\\Filament',
            'notification' => 'Filament\\Notifications\\Notification',
            'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
            'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
            'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
            'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
            'actions' => 'Filament\\Schemas\\Components\\Actions',
            'component' => 'Filament\\Schemas\\Components\\Component',
            'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
            'form' => 'Filament\\Schemas\\Components\\Form',
            'group' => 'Filament\\Schemas\\Components\\Group',
            'schema' => 'Filament\\Schemas\\Schema',
            'halt' => 'Filament\\Support\\Exceptions\\Halt',
            'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
            'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
            'model' => 'Illuminate\\Database\\Eloquent\\Model',
            'event' => 'Illuminate\\Support\\Facades\\Event',
            'js' => 'Illuminate\\Support\\Js',
            'locked' => 'Livewire\\Attributes\\Locked',
            'throwable' => 'Throwable',
          ),
           'className' => 'Filament\\Resources\\Pages\\CreateRecord',
           'functionName' => NULL,
           'templatePhpDocNodes' => 
          array (
            'TModel' => 
            array (
              0 => '@template',
              1 => 
              \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
                 'name' => 'TModel',
                 'bound' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'default' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'lowerBound' => NULL,
                 'description' => '',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
            ),
          ),
           'parent' => NULL,
           'typeAliasesMap' => 
          array (
          ),
           'bypassTypeAliases' => false,
           'constUses' => 
          array (
          ),
           'typeAliasClassName' => NULL,
           'traitData' => NULL,
        )),
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
      '50f70697e8cbf113800eaf1495948278' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'create',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => 
        \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
           'namespace' => 'Filament\\Resources\\Pages',
           'uses' => 
          array (
            'action' => 'Filament\\Actions\\Action',
            'actiongroup' => 'Filament\\Actions\\ActionGroup',
            'filament' => 'Filament\\Facades\\Filament',
            'notification' => 'Filament\\Notifications\\Notification',
            'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
            'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
            'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
            'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
            'actions' => 'Filament\\Schemas\\Components\\Actions',
            'component' => 'Filament\\Schemas\\Components\\Component',
            'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
            'form' => 'Filament\\Schemas\\Components\\Form',
            'group' => 'Filament\\Schemas\\Components\\Group',
            'schema' => 'Filament\\Schemas\\Schema',
            'halt' => 'Filament\\Support\\Exceptions\\Halt',
            'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
            'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
            'model' => 'Illuminate\\Database\\Eloquent\\Model',
            'event' => 'Illuminate\\Support\\Facades\\Event',
            'js' => 'Illuminate\\Support\\Js',
            'locked' => 'Livewire\\Attributes\\Locked',
            'throwable' => 'Throwable',
          ),
           'className' => 'Filament\\Resources\\Pages\\CreateRecord',
           'functionName' => NULL,
           'templatePhpDocNodes' => 
          array (
            'TModel' => 
            array (
              0 => '@template',
              1 => 
              \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
                 'name' => 'TModel',
                 'bound' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'default' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'lowerBound' => NULL,
                 'description' => '',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
            ),
          ),
           'parent' => NULL,
           'typeAliasesMap' => 
          array (
          ),
           'bypassTypeAliases' => false,
           'constUses' => 
          array (
          ),
           'typeAliasClassName' => NULL,
           'traitData' => NULL,
        )),
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
      '145e02d57f2a24744d9d13301914bdda' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'preserveFormDataWhenCreatingAnother',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => 
        \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
           'namespace' => 'Filament\\Resources\\Pages',
           'uses' => 
          array (
            'action' => 'Filament\\Actions\\Action',
            'actiongroup' => 'Filament\\Actions\\ActionGroup',
            'filament' => 'Filament\\Facades\\Filament',
            'notification' => 'Filament\\Notifications\\Notification',
            'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
            'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
            'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
            'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
            'actions' => 'Filament\\Schemas\\Components\\Actions',
            'component' => 'Filament\\Schemas\\Components\\Component',
            'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
            'form' => 'Filament\\Schemas\\Components\\Form',
            'group' => 'Filament\\Schemas\\Components\\Group',
            'schema' => 'Filament\\Schemas\\Schema',
            'halt' => 'Filament\\Support\\Exceptions\\Halt',
            'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
            'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
            'model' => 'Illuminate\\Database\\Eloquent\\Model',
            'event' => 'Illuminate\\Support\\Facades\\Event',
            'js' => 'Illuminate\\Support\\Js',
            'locked' => 'Livewire\\Attributes\\Locked',
            'throwable' => 'Throwable',
          ),
           'className' => 'Filament\\Resources\\Pages\\CreateRecord',
           'functionName' => NULL,
           'templatePhpDocNodes' => 
          array (
            'TModel' => 
            array (
              0 => '@template',
              1 => 
              \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
                 'name' => 'TModel',
                 'bound' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'default' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'lowerBound' => NULL,
                 'description' => '',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
            ),
          ),
           'parent' => NULL,
           'typeAliasesMap' => 
          array (
          ),
           'bypassTypeAliases' => false,
           'constUses' => 
          array (
          ),
           'typeAliasClassName' => NULL,
           'traitData' => NULL,
        )),
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
      '0c17404ad343b822da184e8c723144a8' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'getCreatedNotification',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => 
        \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
           'namespace' => 'Filament\\Resources\\Pages',
           'uses' => 
          array (
            'action' => 'Filament\\Actions\\Action',
            'actiongroup' => 'Filament\\Actions\\ActionGroup',
            'filament' => 'Filament\\Facades\\Filament',
            'notification' => 'Filament\\Notifications\\Notification',
            'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
            'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
            'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
            'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
            'actions' => 'Filament\\Schemas\\Components\\Actions',
            'component' => 'Filament\\Schemas\\Components\\Component',
            'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
            'form' => 'Filament\\Schemas\\Components\\Form',
            'group' => 'Filament\\Schemas\\Components\\Group',
            'schema' => 'Filament\\Schemas\\Schema',
            'halt' => 'Filament\\Support\\Exceptions\\Halt',
            'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
            'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
            'model' => 'Illuminate\\Database\\Eloquent\\Model',
            'event' => 'Illuminate\\Support\\Facades\\Event',
            'js' => 'Illuminate\\Support\\Js',
            'locked' => 'Livewire\\Attributes\\Locked',
            'throwable' => 'Throwable',
          ),
           'className' => 'Filament\\Resources\\Pages\\CreateRecord',
           'functionName' => NULL,
           'templatePhpDocNodes' => 
          array (
            'TModel' => 
            array (
              0 => '@template',
              1 => 
              \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
                 'name' => 'TModel',
                 'bound' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'default' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'lowerBound' => NULL,
                 'description' => '',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
            ),
          ),
           'parent' => NULL,
           'typeAliasesMap' => 
          array (
          ),
           'bypassTypeAliases' => false,
           'constUses' => 
          array (
          ),
           'typeAliasClassName' => NULL,
           'traitData' => NULL,
        )),
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
      'c0c870cfa4956ffe1f0f04438bd4c1a8' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'getCreatedNotificationTitle',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => 
        \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
           'namespace' => 'Filament\\Resources\\Pages',
           'uses' => 
          array (
            'action' => 'Filament\\Actions\\Action',
            'actiongroup' => 'Filament\\Actions\\ActionGroup',
            'filament' => 'Filament\\Facades\\Filament',
            'notification' => 'Filament\\Notifications\\Notification',
            'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
            'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
            'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
            'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
            'actions' => 'Filament\\Schemas\\Components\\Actions',
            'component' => 'Filament\\Schemas\\Components\\Component',
            'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
            'form' => 'Filament\\Schemas\\Components\\Form',
            'group' => 'Filament\\Schemas\\Components\\Group',
            'schema' => 'Filament\\Schemas\\Schema',
            'halt' => 'Filament\\Support\\Exceptions\\Halt',
            'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
            'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
            'model' => 'Illuminate\\Database\\Eloquent\\Model',
            'event' => 'Illuminate\\Support\\Facades\\Event',
            'js' => 'Illuminate\\Support\\Js',
            'locked' => 'Livewire\\Attributes\\Locked',
            'throwable' => 'Throwable',
          ),
           'className' => 'Filament\\Resources\\Pages\\CreateRecord',
           'functionName' => NULL,
           'templatePhpDocNodes' => 
          array (
            'TModel' => 
            array (
              0 => '@template',
              1 => 
              \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
                 'name' => 'TModel',
                 'bound' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'default' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'lowerBound' => NULL,
                 'description' => '',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
            ),
          ),
           'parent' => NULL,
           'typeAliasesMap' => 
          array (
          ),
           'bypassTypeAliases' => false,
           'constUses' => 
          array (
          ),
           'typeAliasClassName' => NULL,
           'traitData' => NULL,
        )),
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
      '4eb7e82600aba56ba07cdacb03917c68' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'getCreatedNotificationMessage',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => 
        \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
           'namespace' => 'Filament\\Resources\\Pages',
           'uses' => 
          array (
            'action' => 'Filament\\Actions\\Action',
            'actiongroup' => 'Filament\\Actions\\ActionGroup',
            'filament' => 'Filament\\Facades\\Filament',
            'notification' => 'Filament\\Notifications\\Notification',
            'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
            'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
            'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
            'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
            'actions' => 'Filament\\Schemas\\Components\\Actions',
            'component' => 'Filament\\Schemas\\Components\\Component',
            'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
            'form' => 'Filament\\Schemas\\Components\\Form',
            'group' => 'Filament\\Schemas\\Components\\Group',
            'schema' => 'Filament\\Schemas\\Schema',
            'halt' => 'Filament\\Support\\Exceptions\\Halt',
            'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
            'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
            'model' => 'Illuminate\\Database\\Eloquent\\Model',
            'event' => 'Illuminate\\Support\\Facades\\Event',
            'js' => 'Illuminate\\Support\\Js',
            'locked' => 'Livewire\\Attributes\\Locked',
            'throwable' => 'Throwable',
          ),
           'className' => 'Filament\\Resources\\Pages\\CreateRecord',
           'functionName' => NULL,
           'templatePhpDocNodes' => 
          array (
            'TModel' => 
            array (
              0 => '@template',
              1 => 
              \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
                 'name' => 'TModel',
                 'bound' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'default' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'lowerBound' => NULL,
                 'description' => '',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
            ),
          ),
           'parent' => NULL,
           'typeAliasesMap' => 
          array (
          ),
           'bypassTypeAliases' => false,
           'constUses' => 
          array (
          ),
           'typeAliasClassName' => NULL,
           'traitData' => NULL,
        )),
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
      'd4e2e91c73911760c52ee28062d6796e' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'createAnother',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => 
        \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
           'namespace' => 'Filament\\Resources\\Pages',
           'uses' => 
          array (
            'action' => 'Filament\\Actions\\Action',
            'actiongroup' => 'Filament\\Actions\\ActionGroup',
            'filament' => 'Filament\\Facades\\Filament',
            'notification' => 'Filament\\Notifications\\Notification',
            'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
            'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
            'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
            'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
            'actions' => 'Filament\\Schemas\\Components\\Actions',
            'component' => 'Filament\\Schemas\\Components\\Component',
            'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
            'form' => 'Filament\\Schemas\\Components\\Form',
            'group' => 'Filament\\Schemas\\Components\\Group',
            'schema' => 'Filament\\Schemas\\Schema',
            'halt' => 'Filament\\Support\\Exceptions\\Halt',
            'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
            'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
            'model' => 'Illuminate\\Database\\Eloquent\\Model',
            'event' => 'Illuminate\\Support\\Facades\\Event',
            'js' => 'Illuminate\\Support\\Js',
            'locked' => 'Livewire\\Attributes\\Locked',
            'throwable' => 'Throwable',
          ),
           'className' => 'Filament\\Resources\\Pages\\CreateRecord',
           'functionName' => NULL,
           'templatePhpDocNodes' => 
          array (
            'TModel' => 
            array (
              0 => '@template',
              1 => 
              \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
                 'name' => 'TModel',
                 'bound' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'default' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'lowerBound' => NULL,
                 'description' => '',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
            ),
          ),
           'parent' => NULL,
           'typeAliasesMap' => 
          array (
          ),
           'bypassTypeAliases' => false,
           'constUses' => 
          array (
          ),
           'typeAliasClassName' => NULL,
           'traitData' => NULL,
        )),
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
      '12cc4b444cc37ee96cc70fe97385e344' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'handleRecordCreation',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => 
        \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
           'namespace' => 'Filament\\Resources\\Pages',
           'uses' => 
          array (
            'action' => 'Filament\\Actions\\Action',
            'actiongroup' => 'Filament\\Actions\\ActionGroup',
            'filament' => 'Filament\\Facades\\Filament',
            'notification' => 'Filament\\Notifications\\Notification',
            'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
            'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
            'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
            'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
            'actions' => 'Filament\\Schemas\\Components\\Actions',
            'component' => 'Filament\\Schemas\\Components\\Component',
            'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
            'form' => 'Filament\\Schemas\\Components\\Form',
            'group' => 'Filament\\Schemas\\Components\\Group',
            'schema' => 'Filament\\Schemas\\Schema',
            'halt' => 'Filament\\Support\\Exceptions\\Halt',
            'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
            'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
            'model' => 'Illuminate\\Database\\Eloquent\\Model',
            'event' => 'Illuminate\\Support\\Facades\\Event',
            'js' => 'Illuminate\\Support\\Js',
            'locked' => 'Livewire\\Attributes\\Locked',
            'throwable' => 'Throwable',
          ),
           'className' => 'Filament\\Resources\\Pages\\CreateRecord',
           'functionName' => NULL,
           'templatePhpDocNodes' => 
          array (
            'TModel' => 
            array (
              0 => '@template',
              1 => 
              \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
                 'name' => 'TModel',
                 'bound' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'default' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'lowerBound' => NULL,
                 'description' => '',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
            ),
          ),
           'parent' => NULL,
           'typeAliasesMap' => 
          array (
          ),
           'bypassTypeAliases' => false,
           'constUses' => 
          array (
          ),
           'typeAliasClassName' => NULL,
           'traitData' => NULL,
        )),
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
      '8f00dc0a369dd5494a87ccacc476b63c' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'associateRecordWithParent',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => 
        \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
           'namespace' => 'Filament\\Resources\\Pages',
           'uses' => 
          array (
            'action' => 'Filament\\Actions\\Action',
            'actiongroup' => 'Filament\\Actions\\ActionGroup',
            'filament' => 'Filament\\Facades\\Filament',
            'notification' => 'Filament\\Notifications\\Notification',
            'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
            'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
            'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
            'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
            'actions' => 'Filament\\Schemas\\Components\\Actions',
            'component' => 'Filament\\Schemas\\Components\\Component',
            'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
            'form' => 'Filament\\Schemas\\Components\\Form',
            'group' => 'Filament\\Schemas\\Components\\Group',
            'schema' => 'Filament\\Schemas\\Schema',
            'halt' => 'Filament\\Support\\Exceptions\\Halt',
            'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
            'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
            'model' => 'Illuminate\\Database\\Eloquent\\Model',
            'event' => 'Illuminate\\Support\\Facades\\Event',
            'js' => 'Illuminate\\Support\\Js',
            'locked' => 'Livewire\\Attributes\\Locked',
            'throwable' => 'Throwable',
          ),
           'className' => 'Filament\\Resources\\Pages\\CreateRecord',
           'functionName' => NULL,
           'templatePhpDocNodes' => 
          array (
            'TModel' => 
            array (
              0 => '@template',
              1 => 
              \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
                 'name' => 'TModel',
                 'bound' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'default' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'lowerBound' => NULL,
                 'description' => '',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
            ),
          ),
           'parent' => NULL,
           'typeAliasesMap' => 
          array (
          ),
           'bypassTypeAliases' => false,
           'constUses' => 
          array (
          ),
           'typeAliasClassName' => NULL,
           'traitData' => NULL,
        )),
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
      '2108a1765d15228d5a58a2141f27eb95' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'mutateFormDataBeforeCreate',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => 
        \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
           'namespace' => 'Filament\\Resources\\Pages',
           'uses' => 
          array (
            'action' => 'Filament\\Actions\\Action',
            'actiongroup' => 'Filament\\Actions\\ActionGroup',
            'filament' => 'Filament\\Facades\\Filament',
            'notification' => 'Filament\\Notifications\\Notification',
            'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
            'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
            'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
            'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
            'actions' => 'Filament\\Schemas\\Components\\Actions',
            'component' => 'Filament\\Schemas\\Components\\Component',
            'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
            'form' => 'Filament\\Schemas\\Components\\Form',
            'group' => 'Filament\\Schemas\\Components\\Group',
            'schema' => 'Filament\\Schemas\\Schema',
            'halt' => 'Filament\\Support\\Exceptions\\Halt',
            'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
            'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
            'model' => 'Illuminate\\Database\\Eloquent\\Model',
            'event' => 'Illuminate\\Support\\Facades\\Event',
            'js' => 'Illuminate\\Support\\Js',
            'locked' => 'Livewire\\Attributes\\Locked',
            'throwable' => 'Throwable',
          ),
           'className' => 'Filament\\Resources\\Pages\\CreateRecord',
           'functionName' => NULL,
           'templatePhpDocNodes' => 
          array (
            'TModel' => 
            array (
              0 => '@template',
              1 => 
              \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
                 'name' => 'TModel',
                 'bound' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'default' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'lowerBound' => NULL,
                 'description' => '',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
            ),
          ),
           'parent' => NULL,
           'typeAliasesMap' => 
          array (
          ),
           'bypassTypeAliases' => false,
           'constUses' => 
          array (
          ),
           'typeAliasClassName' => NULL,
           'traitData' => NULL,
        )),
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
      '6709ee54fab686aa592b21a1d7bbc054' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'getFormActions',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => 
        \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
           'namespace' => 'Filament\\Resources\\Pages',
           'uses' => 
          array (
            'action' => 'Filament\\Actions\\Action',
            'actiongroup' => 'Filament\\Actions\\ActionGroup',
            'filament' => 'Filament\\Facades\\Filament',
            'notification' => 'Filament\\Notifications\\Notification',
            'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
            'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
            'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
            'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
            'actions' => 'Filament\\Schemas\\Components\\Actions',
            'component' => 'Filament\\Schemas\\Components\\Component',
            'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
            'form' => 'Filament\\Schemas\\Components\\Form',
            'group' => 'Filament\\Schemas\\Components\\Group',
            'schema' => 'Filament\\Schemas\\Schema',
            'halt' => 'Filament\\Support\\Exceptions\\Halt',
            'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
            'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
            'model' => 'Illuminate\\Database\\Eloquent\\Model',
            'event' => 'Illuminate\\Support\\Facades\\Event',
            'js' => 'Illuminate\\Support\\Js',
            'locked' => 'Livewire\\Attributes\\Locked',
            'throwable' => 'Throwable',
          ),
           'className' => 'Filament\\Resources\\Pages\\CreateRecord',
           'functionName' => NULL,
           'templatePhpDocNodes' => 
          array (
            'TModel' => 
            array (
              0 => '@template',
              1 => 
              \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
                 'name' => 'TModel',
                 'bound' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'default' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'lowerBound' => NULL,
                 'description' => '',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
            ),
          ),
           'parent' => NULL,
           'typeAliasesMap' => 
          array (
          ),
           'bypassTypeAliases' => false,
           'constUses' => 
          array (
          ),
           'typeAliasClassName' => NULL,
           'traitData' => NULL,
        )),
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
      '1bfff4953211ec2802e98cb63cf97ac1' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'getCreateFormAction',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => 
        \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
           'namespace' => 'Filament\\Resources\\Pages',
           'uses' => 
          array (
            'action' => 'Filament\\Actions\\Action',
            'actiongroup' => 'Filament\\Actions\\ActionGroup',
            'filament' => 'Filament\\Facades\\Filament',
            'notification' => 'Filament\\Notifications\\Notification',
            'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
            'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
            'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
            'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
            'actions' => 'Filament\\Schemas\\Components\\Actions',
            'component' => 'Filament\\Schemas\\Components\\Component',
            'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
            'form' => 'Filament\\Schemas\\Components\\Form',
            'group' => 'Filament\\Schemas\\Components\\Group',
            'schema' => 'Filament\\Schemas\\Schema',
            'halt' => 'Filament\\Support\\Exceptions\\Halt',
            'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
            'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
            'model' => 'Illuminate\\Database\\Eloquent\\Model',
            'event' => 'Illuminate\\Support\\Facades\\Event',
            'js' => 'Illuminate\\Support\\Js',
            'locked' => 'Livewire\\Attributes\\Locked',
            'throwable' => 'Throwable',
          ),
           'className' => 'Filament\\Resources\\Pages\\CreateRecord',
           'functionName' => NULL,
           'templatePhpDocNodes' => 
          array (
            'TModel' => 
            array (
              0 => '@template',
              1 => 
              \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
                 'name' => 'TModel',
                 'bound' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'default' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'lowerBound' => NULL,
                 'description' => '',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
            ),
          ),
           'parent' => NULL,
           'typeAliasesMap' => 
          array (
          ),
           'bypassTypeAliases' => false,
           'constUses' => 
          array (
          ),
           'typeAliasClassName' => NULL,
           'traitData' => NULL,
        )),
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
      'ff28a9c2200e46faa513202eb6d0e7bf' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'getSubmitFormAction',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => 
        \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
           'namespace' => 'Filament\\Resources\\Pages',
           'uses' => 
          array (
            'action' => 'Filament\\Actions\\Action',
            'actiongroup' => 'Filament\\Actions\\ActionGroup',
            'filament' => 'Filament\\Facades\\Filament',
            'notification' => 'Filament\\Notifications\\Notification',
            'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
            'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
            'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
            'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
            'actions' => 'Filament\\Schemas\\Components\\Actions',
            'component' => 'Filament\\Schemas\\Components\\Component',
            'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
            'form' => 'Filament\\Schemas\\Components\\Form',
            'group' => 'Filament\\Schemas\\Components\\Group',
            'schema' => 'Filament\\Schemas\\Schema',
            'halt' => 'Filament\\Support\\Exceptions\\Halt',
            'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
            'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
            'model' => 'Illuminate\\Database\\Eloquent\\Model',
            'event' => 'Illuminate\\Support\\Facades\\Event',
            'js' => 'Illuminate\\Support\\Js',
            'locked' => 'Livewire\\Attributes\\Locked',
            'throwable' => 'Throwable',
          ),
           'className' => 'Filament\\Resources\\Pages\\CreateRecord',
           'functionName' => NULL,
           'templatePhpDocNodes' => 
          array (
            'TModel' => 
            array (
              0 => '@template',
              1 => 
              \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
                 'name' => 'TModel',
                 'bound' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'default' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'lowerBound' => NULL,
                 'description' => '',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
            ),
          ),
           'parent' => NULL,
           'typeAliasesMap' => 
          array (
          ),
           'bypassTypeAliases' => false,
           'constUses' => 
          array (
          ),
           'typeAliasClassName' => NULL,
           'traitData' => NULL,
        )),
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
      'bf7208b21eea1ca062257509b5abb730' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'getSubmitFormLivewireMethodName',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => 
        \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
           'namespace' => 'Filament\\Resources\\Pages',
           'uses' => 
          array (
            'action' => 'Filament\\Actions\\Action',
            'actiongroup' => 'Filament\\Actions\\ActionGroup',
            'filament' => 'Filament\\Facades\\Filament',
            'notification' => 'Filament\\Notifications\\Notification',
            'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
            'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
            'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
            'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
            'actions' => 'Filament\\Schemas\\Components\\Actions',
            'component' => 'Filament\\Schemas\\Components\\Component',
            'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
            'form' => 'Filament\\Schemas\\Components\\Form',
            'group' => 'Filament\\Schemas\\Components\\Group',
            'schema' => 'Filament\\Schemas\\Schema',
            'halt' => 'Filament\\Support\\Exceptions\\Halt',
            'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
            'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
            'model' => 'Illuminate\\Database\\Eloquent\\Model',
            'event' => 'Illuminate\\Support\\Facades\\Event',
            'js' => 'Illuminate\\Support\\Js',
            'locked' => 'Livewire\\Attributes\\Locked',
            'throwable' => 'Throwable',
          ),
           'className' => 'Filament\\Resources\\Pages\\CreateRecord',
           'functionName' => NULL,
           'templatePhpDocNodes' => 
          array (
            'TModel' => 
            array (
              0 => '@template',
              1 => 
              \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
                 'name' => 'TModel',
                 'bound' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'default' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'lowerBound' => NULL,
                 'description' => '',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
            ),
          ),
           'parent' => NULL,
           'typeAliasesMap' => 
          array (
          ),
           'bypassTypeAliases' => false,
           'constUses' => 
          array (
          ),
           'typeAliasClassName' => NULL,
           'traitData' => NULL,
        )),
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
      '1270048c244fcfec0b3b6498a027d1d5' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'getCreateAnotherFormAction',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => 
        \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
           'namespace' => 'Filament\\Resources\\Pages',
           'uses' => 
          array (
            'action' => 'Filament\\Actions\\Action',
            'actiongroup' => 'Filament\\Actions\\ActionGroup',
            'filament' => 'Filament\\Facades\\Filament',
            'notification' => 'Filament\\Notifications\\Notification',
            'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
            'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
            'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
            'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
            'actions' => 'Filament\\Schemas\\Components\\Actions',
            'component' => 'Filament\\Schemas\\Components\\Component',
            'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
            'form' => 'Filament\\Schemas\\Components\\Form',
            'group' => 'Filament\\Schemas\\Components\\Group',
            'schema' => 'Filament\\Schemas\\Schema',
            'halt' => 'Filament\\Support\\Exceptions\\Halt',
            'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
            'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
            'model' => 'Illuminate\\Database\\Eloquent\\Model',
            'event' => 'Illuminate\\Support\\Facades\\Event',
            'js' => 'Illuminate\\Support\\Js',
            'locked' => 'Livewire\\Attributes\\Locked',
            'throwable' => 'Throwable',
          ),
           'className' => 'Filament\\Resources\\Pages\\CreateRecord',
           'functionName' => NULL,
           'templatePhpDocNodes' => 
          array (
            'TModel' => 
            array (
              0 => '@template',
              1 => 
              \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
                 'name' => 'TModel',
                 'bound' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'default' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'lowerBound' => NULL,
                 'description' => '',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
            ),
          ),
           'parent' => NULL,
           'typeAliasesMap' => 
          array (
          ),
           'bypassTypeAliases' => false,
           'constUses' => 
          array (
          ),
           'typeAliasClassName' => NULL,
           'traitData' => NULL,
        )),
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
      'c93d74d75fd5fb9413b253abe833771c' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'getCancelFormAction',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => 
        \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
           'namespace' => 'Filament\\Resources\\Pages',
           'uses' => 
          array (
            'action' => 'Filament\\Actions\\Action',
            'actiongroup' => 'Filament\\Actions\\ActionGroup',
            'filament' => 'Filament\\Facades\\Filament',
            'notification' => 'Filament\\Notifications\\Notification',
            'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
            'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
            'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
            'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
            'actions' => 'Filament\\Schemas\\Components\\Actions',
            'component' => 'Filament\\Schemas\\Components\\Component',
            'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
            'form' => 'Filament\\Schemas\\Components\\Form',
            'group' => 'Filament\\Schemas\\Components\\Group',
            'schema' => 'Filament\\Schemas\\Schema',
            'halt' => 'Filament\\Support\\Exceptions\\Halt',
            'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
            'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
            'model' => 'Illuminate\\Database\\Eloquent\\Model',
            'event' => 'Illuminate\\Support\\Facades\\Event',
            'js' => 'Illuminate\\Support\\Js',
            'locked' => 'Livewire\\Attributes\\Locked',
            'throwable' => 'Throwable',
          ),
           'className' => 'Filament\\Resources\\Pages\\CreateRecord',
           'functionName' => NULL,
           'templatePhpDocNodes' => 
          array (
            'TModel' => 
            array (
              0 => '@template',
              1 => 
              \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
                 'name' => 'TModel',
                 'bound' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'default' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'lowerBound' => NULL,
                 'description' => '',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
            ),
          ),
           'parent' => NULL,
           'typeAliasesMap' => 
          array (
          ),
           'bypassTypeAliases' => false,
           'constUses' => 
          array (
          ),
           'typeAliasClassName' => NULL,
           'traitData' => NULL,
        )),
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
      'de37025cf2f4dc40d04d223a5129134e' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'getTitle',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => 
        \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
           'namespace' => 'Filament\\Resources\\Pages',
           'uses' => 
          array (
            'action' => 'Filament\\Actions\\Action',
            'actiongroup' => 'Filament\\Actions\\ActionGroup',
            'filament' => 'Filament\\Facades\\Filament',
            'notification' => 'Filament\\Notifications\\Notification',
            'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
            'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
            'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
            'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
            'actions' => 'Filament\\Schemas\\Components\\Actions',
            'component' => 'Filament\\Schemas\\Components\\Component',
            'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
            'form' => 'Filament\\Schemas\\Components\\Form',
            'group' => 'Filament\\Schemas\\Components\\Group',
            'schema' => 'Filament\\Schemas\\Schema',
            'halt' => 'Filament\\Support\\Exceptions\\Halt',
            'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
            'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
            'model' => 'Illuminate\\Database\\Eloquent\\Model',
            'event' => 'Illuminate\\Support\\Facades\\Event',
            'js' => 'Illuminate\\Support\\Js',
            'locked' => 'Livewire\\Attributes\\Locked',
            'throwable' => 'Throwable',
          ),
           'className' => 'Filament\\Resources\\Pages\\CreateRecord',
           'functionName' => NULL,
           'templatePhpDocNodes' => 
          array (
            'TModel' => 
            array (
              0 => '@template',
              1 => 
              \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
                 'name' => 'TModel',
                 'bound' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'default' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'lowerBound' => NULL,
                 'description' => '',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
            ),
          ),
           'parent' => NULL,
           'typeAliasesMap' => 
          array (
          ),
           'bypassTypeAliases' => false,
           'constUses' => 
          array (
          ),
           'typeAliasClassName' => NULL,
           'traitData' => NULL,
        )),
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
      'da571a8137c743d7e54b8c09e0e75245' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'defaultForm',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => 
        \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
           'namespace' => 'Filament\\Resources\\Pages',
           'uses' => 
          array (
            'action' => 'Filament\\Actions\\Action',
            'actiongroup' => 'Filament\\Actions\\ActionGroup',
            'filament' => 'Filament\\Facades\\Filament',
            'notification' => 'Filament\\Notifications\\Notification',
            'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
            'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
            'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
            'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
            'actions' => 'Filament\\Schemas\\Components\\Actions',
            'component' => 'Filament\\Schemas\\Components\\Component',
            'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
            'form' => 'Filament\\Schemas\\Components\\Form',
            'group' => 'Filament\\Schemas\\Components\\Group',
            'schema' => 'Filament\\Schemas\\Schema',
            'halt' => 'Filament\\Support\\Exceptions\\Halt',
            'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
            'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
            'model' => 'Illuminate\\Database\\Eloquent\\Model',
            'event' => 'Illuminate\\Support\\Facades\\Event',
            'js' => 'Illuminate\\Support\\Js',
            'locked' => 'Livewire\\Attributes\\Locked',
            'throwable' => 'Throwable',
          ),
           'className' => 'Filament\\Resources\\Pages\\CreateRecord',
           'functionName' => NULL,
           'templatePhpDocNodes' => 
          array (
            'TModel' => 
            array (
              0 => '@template',
              1 => 
              \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
                 'name' => 'TModel',
                 'bound' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'default' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'lowerBound' => NULL,
                 'description' => '',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
            ),
          ),
           'parent' => NULL,
           'typeAliasesMap' => 
          array (
          ),
           'bypassTypeAliases' => false,
           'constUses' => 
          array (
          ),
           'typeAliasClassName' => NULL,
           'traitData' => NULL,
        )),
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
      '05028306cbcb6a83dff901e065490ad1' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'form',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => 
        \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
           'namespace' => 'Filament\\Resources\\Pages',
           'uses' => 
          array (
            'action' => 'Filament\\Actions\\Action',
            'actiongroup' => 'Filament\\Actions\\ActionGroup',
            'filament' => 'Filament\\Facades\\Filament',
            'notification' => 'Filament\\Notifications\\Notification',
            'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
            'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
            'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
            'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
            'actions' => 'Filament\\Schemas\\Components\\Actions',
            'component' => 'Filament\\Schemas\\Components\\Component',
            'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
            'form' => 'Filament\\Schemas\\Components\\Form',
            'group' => 'Filament\\Schemas\\Components\\Group',
            'schema' => 'Filament\\Schemas\\Schema',
            'halt' => 'Filament\\Support\\Exceptions\\Halt',
            'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
            'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
            'model' => 'Illuminate\\Database\\Eloquent\\Model',
            'event' => 'Illuminate\\Support\\Facades\\Event',
            'js' => 'Illuminate\\Support\\Js',
            'locked' => 'Livewire\\Attributes\\Locked',
            'throwable' => 'Throwable',
          ),
           'className' => 'Filament\\Resources\\Pages\\CreateRecord',
           'functionName' => NULL,
           'templatePhpDocNodes' => 
          array (
            'TModel' => 
            array (
              0 => '@template',
              1 => 
              \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
                 'name' => 'TModel',
                 'bound' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'default' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'lowerBound' => NULL,
                 'description' => '',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
            ),
          ),
           'parent' => NULL,
           'typeAliasesMap' => 
          array (
          ),
           'bypassTypeAliases' => false,
           'constUses' => 
          array (
          ),
           'typeAliasClassName' => NULL,
           'traitData' => NULL,
        )),
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
      '6a4e02ee6c48e1b1b3a2811466f3fcc0' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'getRedirectUrl',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => 
        \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
           'namespace' => 'Filament\\Resources\\Pages',
           'uses' => 
          array (
            'action' => 'Filament\\Actions\\Action',
            'actiongroup' => 'Filament\\Actions\\ActionGroup',
            'filament' => 'Filament\\Facades\\Filament',
            'notification' => 'Filament\\Notifications\\Notification',
            'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
            'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
            'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
            'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
            'actions' => 'Filament\\Schemas\\Components\\Actions',
            'component' => 'Filament\\Schemas\\Components\\Component',
            'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
            'form' => 'Filament\\Schemas\\Components\\Form',
            'group' => 'Filament\\Schemas\\Components\\Group',
            'schema' => 'Filament\\Schemas\\Schema',
            'halt' => 'Filament\\Support\\Exceptions\\Halt',
            'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
            'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
            'model' => 'Illuminate\\Database\\Eloquent\\Model',
            'event' => 'Illuminate\\Support\\Facades\\Event',
            'js' => 'Illuminate\\Support\\Js',
            'locked' => 'Livewire\\Attributes\\Locked',
            'throwable' => 'Throwable',
          ),
           'className' => 'Filament\\Resources\\Pages\\CreateRecord',
           'functionName' => NULL,
           'templatePhpDocNodes' => 
          array (
            'TModel' => 
            array (
              0 => '@template',
              1 => 
              \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
                 'name' => 'TModel',
                 'bound' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'default' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'lowerBound' => NULL,
                 'description' => '',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
            ),
          ),
           'parent' => NULL,
           'typeAliasesMap' => 
          array (
          ),
           'bypassTypeAliases' => false,
           'constUses' => 
          array (
          ),
           'typeAliasClassName' => NULL,
           'traitData' => NULL,
        )),
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
      '0e3a1afba736d7a4fbc363984c8d2ae1' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'getRedirectUrlParameters',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => 
        \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
           'namespace' => 'Filament\\Resources\\Pages',
           'uses' => 
          array (
            'action' => 'Filament\\Actions\\Action',
            'actiongroup' => 'Filament\\Actions\\ActionGroup',
            'filament' => 'Filament\\Facades\\Filament',
            'notification' => 'Filament\\Notifications\\Notification',
            'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
            'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
            'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
            'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
            'actions' => 'Filament\\Schemas\\Components\\Actions',
            'component' => 'Filament\\Schemas\\Components\\Component',
            'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
            'form' => 'Filament\\Schemas\\Components\\Form',
            'group' => 'Filament\\Schemas\\Components\\Group',
            'schema' => 'Filament\\Schemas\\Schema',
            'halt' => 'Filament\\Support\\Exceptions\\Halt',
            'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
            'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
            'model' => 'Illuminate\\Database\\Eloquent\\Model',
            'event' => 'Illuminate\\Support\\Facades\\Event',
            'js' => 'Illuminate\\Support\\Js',
            'locked' => 'Livewire\\Attributes\\Locked',
            'throwable' => 'Throwable',
          ),
           'className' => 'Filament\\Resources\\Pages\\CreateRecord',
           'functionName' => NULL,
           'templatePhpDocNodes' => 
          array (
            'TModel' => 
            array (
              0 => '@template',
              1 => 
              \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
                 'name' => 'TModel',
                 'bound' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'default' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'lowerBound' => NULL,
                 'description' => '',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
            ),
          ),
           'parent' => NULL,
           'typeAliasesMap' => 
          array (
          ),
           'bypassTypeAliases' => false,
           'constUses' => 
          array (
          ),
           'typeAliasClassName' => NULL,
           'traitData' => NULL,
        )),
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
      '6c26270d7fe536dfae7d84d1a06acf2b' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'getMountedActionSchemaModel',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => 
        \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
           'namespace' => 'Filament\\Resources\\Pages',
           'uses' => 
          array (
            'action' => 'Filament\\Actions\\Action',
            'actiongroup' => 'Filament\\Actions\\ActionGroup',
            'filament' => 'Filament\\Facades\\Filament',
            'notification' => 'Filament\\Notifications\\Notification',
            'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
            'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
            'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
            'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
            'actions' => 'Filament\\Schemas\\Components\\Actions',
            'component' => 'Filament\\Schemas\\Components\\Component',
            'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
            'form' => 'Filament\\Schemas\\Components\\Form',
            'group' => 'Filament\\Schemas\\Components\\Group',
            'schema' => 'Filament\\Schemas\\Schema',
            'halt' => 'Filament\\Support\\Exceptions\\Halt',
            'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
            'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
            'model' => 'Illuminate\\Database\\Eloquent\\Model',
            'event' => 'Illuminate\\Support\\Facades\\Event',
            'js' => 'Illuminate\\Support\\Js',
            'locked' => 'Livewire\\Attributes\\Locked',
            'throwable' => 'Throwable',
          ),
           'className' => 'Filament\\Resources\\Pages\\CreateRecord',
           'functionName' => NULL,
           'templatePhpDocNodes' => 
          array (
            'TModel' => 
            array (
              0 => '@template',
              1 => 
              \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
                 'name' => 'TModel',
                 'bound' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'default' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'lowerBound' => NULL,
                 'description' => '',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
            ),
          ),
           'parent' => NULL,
           'typeAliasesMap' => 
          array (
          ),
           'bypassTypeAliases' => false,
           'constUses' => 
          array (
          ),
           'typeAliasClassName' => NULL,
           'traitData' => NULL,
        )),
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
      '94f980da86e879c8947aa21d62780ca5' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'canCreateAnother',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => 
        \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
           'namespace' => 'Filament\\Resources\\Pages',
           'uses' => 
          array (
            'action' => 'Filament\\Actions\\Action',
            'actiongroup' => 'Filament\\Actions\\ActionGroup',
            'filament' => 'Filament\\Facades\\Filament',
            'notification' => 'Filament\\Notifications\\Notification',
            'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
            'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
            'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
            'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
            'actions' => 'Filament\\Schemas\\Components\\Actions',
            'component' => 'Filament\\Schemas\\Components\\Component',
            'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
            'form' => 'Filament\\Schemas\\Components\\Form',
            'group' => 'Filament\\Schemas\\Components\\Group',
            'schema' => 'Filament\\Schemas\\Schema',
            'halt' => 'Filament\\Support\\Exceptions\\Halt',
            'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
            'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
            'model' => 'Illuminate\\Database\\Eloquent\\Model',
            'event' => 'Illuminate\\Support\\Facades\\Event',
            'js' => 'Illuminate\\Support\\Js',
            'locked' => 'Livewire\\Attributes\\Locked',
            'throwable' => 'Throwable',
          ),
           'className' => 'Filament\\Resources\\Pages\\CreateRecord',
           'functionName' => NULL,
           'templatePhpDocNodes' => 
          array (
            'TModel' => 
            array (
              0 => '@template',
              1 => 
              \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
                 'name' => 'TModel',
                 'bound' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'default' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'lowerBound' => NULL,
                 'description' => '',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
            ),
          ),
           'parent' => NULL,
           'typeAliasesMap' => 
          array (
          ),
           'bypassTypeAliases' => false,
           'constUses' => 
          array (
          ),
           'typeAliasClassName' => NULL,
           'traitData' => NULL,
        )),
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
      '08ab741a78be57f541b44f06d40cbb25' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'disableCreateAnother',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => 
        \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
           'namespace' => 'Filament\\Resources\\Pages',
           'uses' => 
          array (
            'action' => 'Filament\\Actions\\Action',
            'actiongroup' => 'Filament\\Actions\\ActionGroup',
            'filament' => 'Filament\\Facades\\Filament',
            'notification' => 'Filament\\Notifications\\Notification',
            'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
            'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
            'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
            'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
            'actions' => 'Filament\\Schemas\\Components\\Actions',
            'component' => 'Filament\\Schemas\\Components\\Component',
            'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
            'form' => 'Filament\\Schemas\\Components\\Form',
            'group' => 'Filament\\Schemas\\Components\\Group',
            'schema' => 'Filament\\Schemas\\Schema',
            'halt' => 'Filament\\Support\\Exceptions\\Halt',
            'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
            'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
            'model' => 'Illuminate\\Database\\Eloquent\\Model',
            'event' => 'Illuminate\\Support\\Facades\\Event',
            'js' => 'Illuminate\\Support\\Js',
            'locked' => 'Livewire\\Attributes\\Locked',
            'throwable' => 'Throwable',
          ),
           'className' => 'Filament\\Resources\\Pages\\CreateRecord',
           'functionName' => NULL,
           'templatePhpDocNodes' => 
          array (
            'TModel' => 
            array (
              0 => '@template',
              1 => 
              \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
                 'name' => 'TModel',
                 'bound' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'default' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'lowerBound' => NULL,
                 'description' => '',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
            ),
          ),
           'parent' => NULL,
           'typeAliasesMap' => 
          array (
          ),
           'bypassTypeAliases' => false,
           'constUses' => 
          array (
          ),
           'typeAliasClassName' => NULL,
           'traitData' => NULL,
        )),
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
      '0bb5047148423fe49a5e2f7c61b4df55' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'getRecord',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => 
        \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
           'namespace' => 'Filament\\Resources\\Pages',
           'uses' => 
          array (
            'action' => 'Filament\\Actions\\Action',
            'actiongroup' => 'Filament\\Actions\\ActionGroup',
            'filament' => 'Filament\\Facades\\Filament',
            'notification' => 'Filament\\Notifications\\Notification',
            'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
            'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
            'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
            'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
            'actions' => 'Filament\\Schemas\\Components\\Actions',
            'component' => 'Filament\\Schemas\\Components\\Component',
            'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
            'form' => 'Filament\\Schemas\\Components\\Form',
            'group' => 'Filament\\Schemas\\Components\\Group',
            'schema' => 'Filament\\Schemas\\Schema',
            'halt' => 'Filament\\Support\\Exceptions\\Halt',
            'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
            'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
            'model' => 'Illuminate\\Database\\Eloquent\\Model',
            'event' => 'Illuminate\\Support\\Facades\\Event',
            'js' => 'Illuminate\\Support\\Js',
            'locked' => 'Livewire\\Attributes\\Locked',
            'throwable' => 'Throwable',
          ),
           'className' => 'Filament\\Resources\\Pages\\CreateRecord',
           'functionName' => NULL,
           'templatePhpDocNodes' => 
          array (
            'TModel' => 
            array (
              0 => '@template',
              1 => 
              \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
                 'name' => 'TModel',
                 'bound' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'default' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'lowerBound' => NULL,
                 'description' => '',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
            ),
          ),
           'parent' => NULL,
           'typeAliasesMap' => 
          array (
          ),
           'bypassTypeAliases' => false,
           'constUses' => 
          array (
          ),
           'typeAliasClassName' => NULL,
           'traitData' => NULL,
        )),
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
      '4ce3cf1d2bdb60d25897371a00c6fd1b' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'content',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => 
        \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
           'namespace' => 'Filament\\Resources\\Pages',
           'uses' => 
          array (
            'action' => 'Filament\\Actions\\Action',
            'actiongroup' => 'Filament\\Actions\\ActionGroup',
            'filament' => 'Filament\\Facades\\Filament',
            'notification' => 'Filament\\Notifications\\Notification',
            'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
            'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
            'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
            'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
            'actions' => 'Filament\\Schemas\\Components\\Actions',
            'component' => 'Filament\\Schemas\\Components\\Component',
            'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
            'form' => 'Filament\\Schemas\\Components\\Form',
            'group' => 'Filament\\Schemas\\Components\\Group',
            'schema' => 'Filament\\Schemas\\Schema',
            'halt' => 'Filament\\Support\\Exceptions\\Halt',
            'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
            'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
            'model' => 'Illuminate\\Database\\Eloquent\\Model',
            'event' => 'Illuminate\\Support\\Facades\\Event',
            'js' => 'Illuminate\\Support\\Js',
            'locked' => 'Livewire\\Attributes\\Locked',
            'throwable' => 'Throwable',
          ),
           'className' => 'Filament\\Resources\\Pages\\CreateRecord',
           'functionName' => NULL,
           'templatePhpDocNodes' => 
          array (
            'TModel' => 
            array (
              0 => '@template',
              1 => 
              \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
                 'name' => 'TModel',
                 'bound' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'default' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'lowerBound' => NULL,
                 'description' => '',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
            ),
          ),
           'parent' => NULL,
           'typeAliasesMap' => 
          array (
          ),
           'bypassTypeAliases' => false,
           'constUses' => 
          array (
          ),
           'typeAliasClassName' => NULL,
           'traitData' => NULL,
        )),
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
      'd717b5cc319b7b4869c991f1f0bd446b' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'getFormContentComponent',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => 
        \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
           'namespace' => 'Filament\\Resources\\Pages',
           'uses' => 
          array (
            'action' => 'Filament\\Actions\\Action',
            'actiongroup' => 'Filament\\Actions\\ActionGroup',
            'filament' => 'Filament\\Facades\\Filament',
            'notification' => 'Filament\\Notifications\\Notification',
            'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
            'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
            'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
            'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
            'actions' => 'Filament\\Schemas\\Components\\Actions',
            'component' => 'Filament\\Schemas\\Components\\Component',
            'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
            'form' => 'Filament\\Schemas\\Components\\Form',
            'group' => 'Filament\\Schemas\\Components\\Group',
            'schema' => 'Filament\\Schemas\\Schema',
            'halt' => 'Filament\\Support\\Exceptions\\Halt',
            'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
            'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
            'model' => 'Illuminate\\Database\\Eloquent\\Model',
            'event' => 'Illuminate\\Support\\Facades\\Event',
            'js' => 'Illuminate\\Support\\Js',
            'locked' => 'Livewire\\Attributes\\Locked',
            'throwable' => 'Throwable',
          ),
           'className' => 'Filament\\Resources\\Pages\\CreateRecord',
           'functionName' => NULL,
           'templatePhpDocNodes' => 
          array (
            'TModel' => 
            array (
              0 => '@template',
              1 => 
              \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
                 'name' => 'TModel',
                 'bound' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'default' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'lowerBound' => NULL,
                 'description' => '',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
            ),
          ),
           'parent' => NULL,
           'typeAliasesMap' => 
          array (
          ),
           'bypassTypeAliases' => false,
           'constUses' => 
          array (
          ),
           'typeAliasClassName' => NULL,
           'traitData' => NULL,
        )),
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
      'a572ddf20c9d75422d438cb9d58bc82a' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'getFormActionsContentComponent',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => 
        \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
           'namespace' => 'Filament\\Resources\\Pages',
           'uses' => 
          array (
            'action' => 'Filament\\Actions\\Action',
            'actiongroup' => 'Filament\\Actions\\ActionGroup',
            'filament' => 'Filament\\Facades\\Filament',
            'notification' => 'Filament\\Notifications\\Notification',
            'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
            'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
            'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
            'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
            'actions' => 'Filament\\Schemas\\Components\\Actions',
            'component' => 'Filament\\Schemas\\Components\\Component',
            'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
            'form' => 'Filament\\Schemas\\Components\\Form',
            'group' => 'Filament\\Schemas\\Components\\Group',
            'schema' => 'Filament\\Schemas\\Schema',
            'halt' => 'Filament\\Support\\Exceptions\\Halt',
            'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
            'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
            'model' => 'Illuminate\\Database\\Eloquent\\Model',
            'event' => 'Illuminate\\Support\\Facades\\Event',
            'js' => 'Illuminate\\Support\\Js',
            'locked' => 'Livewire\\Attributes\\Locked',
            'throwable' => 'Throwable',
          ),
           'className' => 'Filament\\Resources\\Pages\\CreateRecord',
           'functionName' => NULL,
           'templatePhpDocNodes' => 
          array (
            'TModel' => 
            array (
              0 => '@template',
              1 => 
              \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
                 'name' => 'TModel',
                 'bound' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'default' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'lowerBound' => NULL,
                 'description' => '',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
            ),
          ),
           'parent' => NULL,
           'typeAliasesMap' => 
          array (
          ),
           'bypassTypeAliases' => false,
           'constUses' => 
          array (
          ),
           'typeAliasClassName' => NULL,
           'traitData' => NULL,
        )),
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
      'f04ce1f6e725f3798e58e8f4b520abd6' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'hasFormWrapper',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => 
        \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
           'namespace' => 'Filament\\Resources\\Pages',
           'uses' => 
          array (
            'action' => 'Filament\\Actions\\Action',
            'actiongroup' => 'Filament\\Actions\\ActionGroup',
            'filament' => 'Filament\\Facades\\Filament',
            'notification' => 'Filament\\Notifications\\Notification',
            'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
            'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
            'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
            'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
            'actions' => 'Filament\\Schemas\\Components\\Actions',
            'component' => 'Filament\\Schemas\\Components\\Component',
            'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
            'form' => 'Filament\\Schemas\\Components\\Form',
            'group' => 'Filament\\Schemas\\Components\\Group',
            'schema' => 'Filament\\Schemas\\Schema',
            'halt' => 'Filament\\Support\\Exceptions\\Halt',
            'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
            'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
            'model' => 'Illuminate\\Database\\Eloquent\\Model',
            'event' => 'Illuminate\\Support\\Facades\\Event',
            'js' => 'Illuminate\\Support\\Js',
            'locked' => 'Livewire\\Attributes\\Locked',
            'throwable' => 'Throwable',
          ),
           'className' => 'Filament\\Resources\\Pages\\CreateRecord',
           'functionName' => NULL,
           'templatePhpDocNodes' => 
          array (
            'TModel' => 
            array (
              0 => '@template',
              1 => 
              \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
                 'name' => 'TModel',
                 'bound' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'default' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'lowerBound' => NULL,
                 'description' => '',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
            ),
          ),
           'parent' => NULL,
           'typeAliasesMap' => 
          array (
          ),
           'bypassTypeAliases' => false,
           'constUses' => 
          array (
          ),
           'typeAliasClassName' => NULL,
           'traitData' => NULL,
        )),
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
      '10f3ea8ea3704c24390b96c87952a201' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'getPageClasses',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => 
        \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
           'namespace' => 'Filament\\Resources\\Pages',
           'uses' => 
          array (
            'action' => 'Filament\\Actions\\Action',
            'actiongroup' => 'Filament\\Actions\\ActionGroup',
            'filament' => 'Filament\\Facades\\Filament',
            'notification' => 'Filament\\Notifications\\Notification',
            'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
            'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
            'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
            'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
            'actions' => 'Filament\\Schemas\\Components\\Actions',
            'component' => 'Filament\\Schemas\\Components\\Component',
            'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
            'form' => 'Filament\\Schemas\\Components\\Form',
            'group' => 'Filament\\Schemas\\Components\\Group',
            'schema' => 'Filament\\Schemas\\Schema',
            'halt' => 'Filament\\Support\\Exceptions\\Halt',
            'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
            'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
            'model' => 'Illuminate\\Database\\Eloquent\\Model',
            'event' => 'Illuminate\\Support\\Facades\\Event',
            'js' => 'Illuminate\\Support\\Js',
            'locked' => 'Livewire\\Attributes\\Locked',
            'throwable' => 'Throwable',
          ),
           'className' => 'Filament\\Resources\\Pages\\CreateRecord',
           'functionName' => NULL,
           'templatePhpDocNodes' => 
          array (
            'TModel' => 
            array (
              0 => '@template',
              1 => 
              \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
                 'name' => 'TModel',
                 'bound' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'default' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'lowerBound' => NULL,
                 'description' => '',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
            ),
          ),
           'parent' => NULL,
           'typeAliasesMap' => 
          array (
          ),
           'bypassTypeAliases' => false,
           'constUses' => 
          array (
          ),
           'typeAliasClassName' => NULL,
           'traitData' => NULL,
        )),
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
      'c31dd002ece75d62e88795873df0b54b' => 
      \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
         'namespace' => 'Filament\\Resources\\Pages',
         'uses' => 
        array (
          'action' => 'Filament\\Actions\\Action',
          'actiongroup' => 'Filament\\Actions\\ActionGroup',
          'filament' => 'Filament\\Facades\\Filament',
          'notification' => 'Filament\\Notifications\\Notification',
          'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
          'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
          'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
          'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
          'actions' => 'Filament\\Schemas\\Components\\Actions',
          'component' => 'Filament\\Schemas\\Components\\Component',
          'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
          'form' => 'Filament\\Schemas\\Components\\Form',
          'group' => 'Filament\\Schemas\\Components\\Group',
          'schema' => 'Filament\\Schemas\\Schema',
          'halt' => 'Filament\\Support\\Exceptions\\Halt',
          'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
          'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
          'model' => 'Illuminate\\Database\\Eloquent\\Model',
          'event' => 'Illuminate\\Support\\Facades\\Event',
          'js' => 'Illuminate\\Support\\Js',
          'locked' => 'Livewire\\Attributes\\Locked',
          'throwable' => 'Throwable',
        ),
         'className' => 'Filament\\Resources\\Pages\\CreateRecord',
         'functionName' => 'hasFullWidthFormActions',
         'templatePhpDocNodes' => 
        array (
        ),
         'parent' => 
        \PHPStan\Analyser\IntermediaryNameScope::__set_state(array(
           'namespace' => 'Filament\\Resources\\Pages',
           'uses' => 
          array (
            'action' => 'Filament\\Actions\\Action',
            'actiongroup' => 'Filament\\Actions\\ActionGroup',
            'filament' => 'Filament\\Facades\\Filament',
            'notification' => 'Filament\\Notifications\\Notification',
            'canusedatabasetransactions' => 'Filament\\Pages\\Concerns\\CanUseDatabaseTransactions',
            'hasunsaveddatachangesalert' => 'Filament\\Pages\\Concerns\\HasUnsavedDataChangesAlert',
            'recordcreated' => 'Filament\\Resources\\Events\\RecordCreated',
            'recordsaved' => 'Filament\\Resources\\Events\\RecordSaved',
            'actions' => 'Filament\\Schemas\\Components\\Actions',
            'component' => 'Filament\\Schemas\\Components\\Component',
            'embeddedschema' => 'Filament\\Schemas\\Components\\EmbeddedSchema',
            'form' => 'Filament\\Schemas\\Components\\Form',
            'group' => 'Filament\\Schemas\\Components\\Group',
            'schema' => 'Filament\\Schemas\\Schema',
            'halt' => 'Filament\\Support\\Exceptions\\Halt',
            'filamentview' => 'Filament\\Support\\Facades\\FilamentView',
            'htmlable' => 'Illuminate\\Contracts\\Support\\Htmlable',
            'model' => 'Illuminate\\Database\\Eloquent\\Model',
            'event' => 'Illuminate\\Support\\Facades\\Event',
            'js' => 'Illuminate\\Support\\Js',
            'locked' => 'Livewire\\Attributes\\Locked',
            'throwable' => 'Throwable',
          ),
           'className' => 'Filament\\Resources\\Pages\\CreateRecord',
           'functionName' => NULL,
           'templatePhpDocNodes' => 
          array (
            'TModel' => 
            array (
              0 => '@template',
              1 => 
              \PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::__set_state(array(
                 'name' => 'TModel',
                 'bound' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'default' => 
                \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode::__set_state(array(
                   'name' => 'Model',
                   'attributes' => 
                  array (
                    'startLine' => 2,
                    'endLine' => 2,
                  ),
                )),
                 'lowerBound' => NULL,
                 'description' => '',
                 'attributes' => 
                array (
                  'startLine' => 2,
                  'endLine' => 2,
                ),
              )),
            ),
          ),
           'parent' => NULL,
           'typeAliasesMap' => 
          array (
          ),
           'bypassTypeAliases' => false,
           'constUses' => 
          array (
          ),
           'typeAliasClassName' => NULL,
           'traitData' => NULL,
        )),
         'typeAliasesMap' => 
        array (
        ),
         'bypassTypeAliases' => false,
         'constUses' => 
        array (
        ),
         'typeAliasClassName' => NULL,
         'traitData' => NULL,
      )),
    ),
    1 => 
    array (
      '/var/www/html/vendor/filament/filament/src/Resources/Pages/CreateRecord.php' => '7e81fe37e01dbcc69db6905c3749f2be2c904f220d81bb37052c4a5e7b0525c9',
      '/var/www/html/vendor/composer/../filament/filament/src/Pages/Concerns/CanUseDatabaseTransactions.php' => '5c27fb508b106a7faaee445dc3a2abeddbd328e9931c5dff43b5ed2643c53b8c',
      '/var/www/html/vendor/composer/../filament/filament/src/Pages/Concerns/HasUnsavedDataChangesAlert.php' => 'fdf9d481452753e6abf271d5ef7d0a07fbb2ea35b3e8383bed3b7712d0b5f78e',
    ),
  ),
));
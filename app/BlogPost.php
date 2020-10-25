<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use ZeroDaHero\LaravelWorkflow\Exceptions\DuplicateWorkflowException;
use ZeroDaHero\LaravelWorkflow\Traits\WorkflowTrait;

class BlogPost extends Model
{
    use WorkflowTrait;

    protected function initializeWorkflowTrait()
    {
        $registry = app()->make('workflow');
        $workflowName = 'straight';
        $workflowDefinition = [
                'type' => 'state_machine',
                'marking_store' => [
                    'type' => 'single_state',
                ],
                'supports' => [\App\BlogPost::class],
                'places' => [
                    'draft',
                    'review',
                    'rejected',
                    'published'
                ],
                'transitions'   => [
                    'to_review' => [
                        'from' => 'draft',
                        'to' => 'review'
                    ],
                    'publish' => [
                        'from' => 'review',
                        'to' => 'published'
                    ],
                    'reject' => [
                        'from' => 'review',
                        'to' => 'rejected'
                    ]
                ],
        ];

        // or if catching duplicates

        try {
            $registry->addFromArray($workflowName, $workflowDefinition);
        } catch (DuplicateWorkflowException $e) {
            // already loaded
        }
    }
}

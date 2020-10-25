<?php

namespace App\Http\Controllers;

use App\BlogPost;
use Illuminate\Http\Request;
use Symfony\Component\Workflow\Workflow;

class BlogPostDemoWorkflowController extends Controller
{
    public function index(Request $request)
    {
        $post = BlogPost::find(1);
        $workflow = Workflow::get($post);
        $workflow->apply($post, 'to_review');
        $workflow->save();
        dump($post->workflow_transitions());
    }
}

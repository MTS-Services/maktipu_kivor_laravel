<?php

namespace App\Livewire;

use Livewire\Component;

class LivewireExample extends Component
{
    // Example 1: Simple Usage
    public $simpleContent = '<p>Simple content</p>';

    // Example 2: With Validation
    public $articleContent = '';

    // Example 3: Multiple Editors
   
    public $details = '';

    // Example 4: Pre-filled Content
    public $existingContent = '<h2>Existing Article</h2><p>This is pre-filled content from database.</p>';

    // Example 1: Save Simple Content
    public function saveSimple()
    {
        $this->validate([
            'simpleContent' => 'required|min:10',
        ]);
        dd('simpleContent', $this->simpleContent);

        // Save logic here
        session()->flash('message', 'Simple content saved!');
    }

    // Example 2: Save Article with Validation
    public function saveArticle()
    {
        $validated = $this->validate([
            'articleContent' => 'required|min:50|max:10000',
        ], [
            'articleContent.required' => 'Article content is required.',
            'articleContent.min' => 'Article must be at least 50 characters.',
            'articleContent.max' => 'Article cannot exceed 10000 characters.',
        ]);

        // Save to database
        // Article::create(['content' => $validated['articleContent']]);
        dd('articleContent', $this->articleContent);

        session()->flash('message', 'Article saved successfully!');
    }

    // Example 3: Save Multiple Contents
    public function saveMultiple()
    {
        $this->validate([
            'description' => 'required|min:10',
            'details' => 'required|min:20',
        ]);

        dd('description', $this->description, 'details', $this->details);
        // Save logic here
        session()->flash('message', 'Multiple contents saved!');
    }

    // Example 4: Update Existing Content
    public function updateExisting()
    {
        $this->validate([
            'existingContent' => 'required|min:10',
        ]);

        dd('existingContent', $this->existingContent);
        // Update database
        // Article::find($id)->update(['content' => $this->existingContent]);

        session()->flash('message', 'Content updated successfully!');
    }


    public $content1 = '<p>First editor content</p>';
    public $content2 = '<p>Second editor content</p>';
    public $description = '';

    public function saveContent()
    {
        $this->validate([
            'content1' => 'required|min:10',
            'content2' => 'required|min:10',
            'description' => 'nullable|string',
        ]);
        dd('content1', $this->content1, 'content2', $this->content2, 'description', $this->description);

        // Save your content here
        // Example: Post::create(['content' => $this->content1]);

        session()->flash('message', 'Content saved successfully!');
    }

    public function render()
    {
        return view('livewire.livewire-example');
    }
}

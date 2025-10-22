<?php

namespace App\Livewire;

use Livewire\Component;

class TinyEditor extends Component
{
    public $value = '';
    public $editorId;
    public $placeholder = '';
    public $height = 100;
    public $disabled = false;
    
    // Advanced options
    public $plugins = 'code table lists link image media preview anchor searchreplace visualblocks fullscreen insertdatetime charmap';
    public $toolbar = 'undo redo | blocks fontsize | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table | removeformat code fullscreen';
    public $menubar = false;
    
    public function mount($value = '', $editorId = null, $placeholder = '', $height = 400, $disabled = false)
    {
        $this->value = $value;
        $this->editorId = $editorId ?? 'tinymce-' . uniqid();
        $this->placeholder = $placeholder;
        $this->height = $height;
        $this->disabled = $disabled;
    }

    public function updatedValue($value)
    {
        $this->dispatch('editor-updated-' . $this->editorId, content: $value);
    }

    public function render()
    {
        return view('livewire.tiny-editor');
    }
}